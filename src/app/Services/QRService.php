<?php

namespace App\Services;

use App\Models\BusinessOperator;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Models\Staff;
use App\Repositories\BusinessOperator\BusinessOperatorRepositoryInterface;
use App\Repositories\Staff\StaffRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class QRService
{
    private StaffRepositoryInterface $staffRepositoryInterface;
    private BusinessOperatorRepositoryInterface $businessOperatorRepositoryInterface;

    public function __construct(StaffRepositoryInterface $staffRepositoryInterface, BusinessOperatorRepositoryInterface $businessOperatorRepositoryInterface)
    {
        $this->staffRepositoryInterface = $staffRepositoryInterface;
        $this->businessOperatorRepositoryInterface = $businessOperatorRepositoryInterface;
    }

    /**
     * スタッフQRコード生成
     */
    public function createStaff(array $staffIdList, int $size)
    {
        $args = [];
        $pathList = [];
        $publicFilePath = "";
        $fileName = "";

        foreach ($staffIdList as $key => $staffId) {
            $staff = $this->staffRepositoryInterface->findByStaffId($staffId);

            $url = "https://www.google.com";
            $qrCode = QrCode::format('png')->size($size)->generate($url);

            // 保存先のファイルパスを指定（storage/app/public 以下に保存）
            $key++;
            $fileName = "$key-$staff->staff_name.png";
            $publicFilePath = "public/QR/$fileName";

            // QRコードをStorageに保存
            Storage::put($publicFilePath, $qrCode);

            $filePath = Storage::path($publicFilePath);

            array_push($pathList, $filePath);
        }

        // 複数ファイルの場合、ZIP化
        if (count($pathList) > 1) {
            $fileName = "QR.zip";
            $publicFilePath = "public/QR/$fileName";
            $filePath = Storage::path($publicFilePath);

            $zip = new ZipArchive();
            if ($zip->open($filePath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
                foreach ($pathList as $file) {
                    if (file_exists($file)) {
                        $zip->addFile($file, basename($file));
                    }
                }
                $zip->close();
            }

            foreach ($pathList as $path) {
                Storage::delete(str_replace("/var/www/html/storage/app/", '', $path));
            }
        }

        $args['filePath'] = config('app.url') .  Storage::url($publicFilePath);
        $args['fileName'] = $fileName;

        return $args;
    }

    /**
     * ショップQRコード生成
     */
    public function createBusinessOperator(int $businessId, bool $isMulti, bool $isAbroad, int $size, ?int $firstDeskNumber, ?int $secondDeskNumber)
    {
        $args = [];
        $pathList = [];
        $publicFilePath = "";
        $fileName = "";
        $businessName = $this->businessOperatorRepositoryInterface->findByBusinessId($businessId)->business_name;

        // 海外用あとで設定
        // $abroad = false;
        // if ($isAbroad) {
        //     $abroad = true;
        // }

        if ($isMulti) {
            // 複数QRの作成
            for ($i = $firstDeskNumber; $i < $secondDeskNumber; $i++) {
                $url = "https://www.google.com/$i";
                $qrCode = QrCode::format('png')->size($size)->generate($url);

                // 保存先のファイルパスを指定（storage/app/public 以下に保存）
                $fileName = "$i-$businessName.png";
                $publicFilePath = "public/QR/$fileName";

                // QRコードをStorageに保存
                Storage::put($publicFilePath, $qrCode);

                $filePath = Storage::path($publicFilePath);

                array_push($pathList, $filePath);
            }

            // Zipにまとめる
            $fileName = "QR.zip";
            $publicFilePath = "public/QR/$fileName";
            $filePath = Storage::path($publicFilePath);

            $zip = new ZipArchive();
            if ($zip->open($filePath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
                foreach ($pathList as $file) {
                    if (file_exists($file)) {
                        $zip->addFile($file, basename($file));
                    }
                }
                $zip->close();
            }

            foreach ($pathList as $path) {
                Storage::delete(str_replace("/var/www/html/storage/app/", '', $path));
            }
        } else {
            // 単一QRの生成
            if (is_null($firstDeskNumber)) {
                // ショップ自体のQR生成
                $url = "https://www.google.com/tantaiShop";
                $qrCode = QrCode::format('png')->size($size)->generate($url);

                // 保存先のファイルパスを指定（storage/app/public 以下に保存）
                $fileName = "$businessName.png";
                $publicFilePath = "public/QR/$fileName";

                // QRコードをStorageに保存
                Storage::put($publicFilePath, $qrCode);

                $filePath = Storage::path($publicFilePath);
            } else {
                // 卓番単体のQR生成
                $url = "https://www.google.com/tantaiTakuban";
                $qrCode = QrCode::format('png')->size($size)->generate($url);

                // 保存先のファイルパスを指定（storage/app/public 以下に保存）
                $fileName = "$firstDeskNumber-$businessName.png";
                $publicFilePath = "public/QR/$fileName";

                // QRコードをStorageに保存
                Storage::put($publicFilePath, $qrCode);

                $filePath = Storage::path($publicFilePath);
            }
        }

        $args['filePath'] = config('app.url') .  Storage::url($publicFilePath);
        $args['fileName'] = $fileName;

        return $args;
    }


    /**
     * QRコードファイル削除
     */
    public function deleteFile(string $filePath)
    {
        return Storage::delete($filePath);
    }
}
