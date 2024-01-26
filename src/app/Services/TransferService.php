<?php

namespace App\Services;

use App\Repositories\BankAccount\BankAccountRepositoryInterface;
use App\Repositories\TransferRequest\TransferRequestRepositoryInterface;
use App\Repositories\BusinessOperator\BusinessOperatorRepositoryInterface;
use App\Enums\EntityType;
use App\Models\BankAccount;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class TransferService
{
    private BankAccountRepositoryInterface $bankAccountRepositoryInterface;
    private TransferRequestRepositoryInterface $transferRequestRepositoryInterface;
    private BusinessOperatorRepositoryInterface $businessOperatorRepositoryInterface;

    public function __construct(
        BankAccountRepositoryInterface $bankAccountRepositoryInterface,
        TransferRequestRepositoryInterface $transferRequestRepositoryInterface,
        BusinessOperatorRepositoryInterface $businessOperatorRepositoryInterface
    ) {
        $this->bankAccountRepositoryInterface = $bankAccountRepositoryInterface;
        $this->transferRequestRepositoryInterface = $transferRequestRepositoryInterface;
        $this->businessOperatorRepositoryInterface = $businessOperatorRepositoryInterface;
    }

    /**
     * 振込申請情報の取得
     * @param int $businessId
     * @return array $args
     */
    public function getTranserApplication(int $businessId): array
    {
        $args = [];

        // 事業者設定情報を取得
        $businessSetting = $this->businessOperatorRepositoryInterface->getBusinessSettingByBusinessId($businessId);

        $args['settingId'] = $businessSetting->setting_id;
        $args['isAutoApply'] = $businessSetting->is_auto_apply;
        $args['autoApplyAmount'] = $businessSetting->auto_apply_amount;

        return $args;
    }

    /**
     * 振込申請情報更新
     * @param int $settingId
     * @param bool $isAutoApply
     * @param int $autoApplyAmount
     */
    public function updateTransferApplication(int $settingId, bool $isAutoApply, int $autoApplyAmount): void
    {
        $param = [
            'is_auto_apply'     => $isAutoApply,
            'auto_apply_amount' => $autoApplyAmount
        ];

        $this->businessOperatorRepositoryInterface->updateBusinessSettingBySettingId($settingId, $param);
    }

    /**
     * 口座情報の取得
     * @param EntityType $entityType
     * @param int $entityId
     */
    public function getBankAccount(EntityType $entityType, int $entityId)
    {
        return $this->bankAccountRepositoryInterface->getBankAccountByEntity($entityType, $entityId);
    }

    /**
     * 口座情報更新
     */
    public function updateAccountBank(EntityType $entityType, int $entityId, array $param)
    {
        $bankAccount = $this->bankAccountRepositoryInterface->getBankAccountByEntity($entityType, $entityId);

        if (is_null($bankAccount)) {
            $param['entity_type'] = $entityType;
            $param['entity_id'] = $entityId;
            $this->bankAccountRepositoryInterface->createBankAccount($param);
        } else {
            $this->bankAccountRepositoryInterface->updateBankAccount($bankAccount->account_id, $param);
        }
    }

    /**
     * 支払通知書情報の取得
     * @param EntityType $entityType
     * @param int $entityId
     * @return array
     */
    public function getPaymentAdvice(EntityType $entityType, int $entityId): array
    {
        $args = [];

        $paymentAdviceList = $this->transferRequestRepositoryInterface->getTransferRequestByEntity($entityType, $entityId);
        foreach ($paymentAdviceList as $key => $paymentAdvice) {
            $targetDate = Carbon::parse($paymentAdvice->updated_at);
            $args[$key]['requestId'] = $paymentAdvice->request_id;
            $args[$key]['yearMonth'] = $targetDate->format('Y年m月');
            $args[$key]['updatedAt'] = $targetDate->format('Y年m月d日');
            $args[$key]['transferAmount'] = $paymentAdvice->transfer_amount;
            $args[$key]['transactionPeriodFrom'] = Carbon::parse($paymentAdvice->transaction_period_from)->startOfMonth()->format('m月d日');
            $args[$key]['transactionPeriodTo'] = Carbon::parse($paymentAdvice->transaction_period_to)->endOfMonth()->format('m月d日');
            $args[$key]['transferRequestAmount'] = $paymentAdvice->transfer_request_amount;
            $args[$key]['paymentFee'] = floor($paymentAdvice->transfer_request_amount * ($paymentAdvice->payment_fee_rate / 100));
            $args[$key]['usageFee'] = floor($paymentAdvice->transfer_request_amount * ($paymentAdvice->usage_fee_rate / 100));
            $args[$key]['transferFeeAmount'] = $paymentAdvice->transfer_fee_amount;

            $paymentDate = $targetDate->copy()->day(15);
            while ($paymentDate->dayOfWeek === 0 || $paymentDate->dayOfWeek === 6) {
                $paymentDate->addDay();
            }
            $args[$key]['paymentDate'] = Carbon::parse($paymentDate)->format('Y年m月d日');

            $args[$key]['bankName'] = decrypt($paymentAdvice->confirm_bank_name);
            $args[$key]['branchName'] = decrypt($paymentAdvice->confirm_branch_name);
            $args[$key]['accountNumber'] = decrypt($paymentAdvice->confirm_account_number);
        }

        return $args;
    }

    /**
     * 支払通知書PDF生成
     */
    public function paymentAdvicePdf(int $requestId)
    {
        $args = [];

        // データ取得
        $transferRequest = $this->transferRequestRepositoryInterface->getTransferRequestByRequestId($requestId);
        $businessOperator = $this->businessOperatorRepositoryInterface->findByBusinessId($transferRequest->entity_id);

        $targetDate = Carbon::parse($transferRequest->updated_at);

        //お支払予定日
        $paymentDate = $targetDate->copy()->day(15);
        while ($paymentDate->dayOfWeek === 0 || $paymentDate->dayOfWeek === 6) {
            $paymentDate->addDay();
        }

        $html = view('pdf.paymentAdvice', [
            'targetDate'        => $targetDate->format('Y年m月j日'),
            'businessName'      => $businessOperator->business_name,
            'invoiceRegNum'     => $businessOperator->invoice_reg_num,
            'transferAmount'    => number_format($transferRequest->transfer_amount),
            'transferRequestAmount' => number_format($transferRequest->transfer_request_amount),
            'usageFee'          => number_format($transferRequest->transfer_request_amount * ($transferRequest->usage_fee_rate / 100)),
            'paymentFee'        => number_format($transferRequest->transfer_request_amount * ($transferRequest->payment_fee_rate / 100)),
            'transferFeeAmount' => number_format($transferRequest->transfer_fee_amount),
            'paymentDate'       => $paymentDate->format('Y年m月j日'),
            'confirmBankName'   => decrypt($transferRequest->confirm_bank_name),
            'confirmBranchName' => decrypt($transferRequest->confirm_branch_name),
            'confirmAccountNumber'  => decrypt($transferRequest->confirm_account_number),
            'transactionPeriod' =>  Carbon::parse($transferRequest->transaction_period_from)
                ->format('Y年m月d日') . '～' . Carbon::parse($transferRequest->transaction_period_to)
                ->format('Y年m月d日'),
            'noTaxAmount'       => number_format($transferRequest->transfer_amount + ($transferRequest->transfer_fee_amount * 0.1)),
            'tax'               => $transferRequest->transfer_fee_amount * 0.1,
            ])->render();

        $pdf = PDF::loadHTML($html);
        $pdf->setPaper('A4', 'landscape');

        $fileName = "paymentAdvice$requestId.pdf";
        $pdfPath = Storage::path("public/pdf/$fileName");
        $pdf->save($pdfPath);
        $args['filePath'] = config('app.url') .  Storage::url("public/pdf/$fileName");
        $args['fileName'] = $fileName;

        return $args;
    }
}
