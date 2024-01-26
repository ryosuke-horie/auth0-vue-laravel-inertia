<?php

namespace App\Console\Commands;

use App\Enums\AccountType;
use App\Enums\ApplicationStatus;
use App\Enums\BusinessStatus;
use App\Enums\EntityType;
use App\Enums\Prefecture;
use App\Enums\RequestStatus;
use App\Enums\ShiftStatus;
use App\Enums\TransactionType;
use Illuminate\Console\Command;

class EnumToInertiaCommand extends Command
{
    protected $signature = 'enum_to_inertia';
    protected $description = 'A command to convert enums to JavaScript';

    // ここに変換したい Enum を追加する
    private $convertingEnums = [
        AccountType::class,
        ApplicationStatus::class,
        BusinessStatus::class,
        EntityType::class,
        Prefecture::class,
        RequestStatus::class,
        TransactionType::class,
        ShiftStatus::class,
    ];

    public function handle(): void
    {
        $jsCode = '';

        // 変換対象の Enum クラスをループ
        foreach ($this->convertingEnums as $convertingEnum) {
            // Enum クラス名を取得
            $enumName = last(explode('\\', $convertingEnum));
            // Enum クラスの cases メソッドを実行
            $cases = call_user_func($convertingEnum . '::cases');

            // JavaScript のコードを生成
            $jsCode .= 'export const ' . $enumName . ' = {' . "\n";
            foreach ($cases as $case) {
                $caseName = $case->name;
                $caseValue = $case->value;

                // getName(日本語名) メソッドが存在するかチェック
                if (method_exists($case, 'getName')) {
                    $caseDisplayName = $case->getName(); // getName() メソッドを使用
                    $jsCode .= '    "' . $caseName . '": {' . "\n";
                    $jsCode .= '        "value": ' . $caseValue . ',' . "\n";
                    $jsCode .= '        "name": "' . addslashes($caseDisplayName) . '"' . "\n";
                    $jsCode .= '    },' . "\n";
                } else {
                    // getName(日本語名) メソッドがない場合
                    $jsCode .= '    "' . $caseName . '": ' . $caseValue . ',' . "\n";
                }
            }

            $jsCode .= '} as const;' . "\n\n";

            // クラスの型定義を生成
            $jsCode .= 'export type ' . $enumName . '= typeof ' . $enumName
                . '[keyof typeof ' . $enumName . '];' . "\n";

            // 生成した JavaScript のコードを保存
            $path = resource_path('js/Enums/' . $enumName . '.ts');
            file_put_contents($path, $jsCode);

            $jsCode = '';
        }

        $this->info('Done!');
    }
}
