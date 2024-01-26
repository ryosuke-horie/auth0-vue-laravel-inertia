<?php

declare(strict_types=1);

namespace App\Trais;

use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    /**
     * 画像・動画の拡張子チェック
     * @param string $extension
     * @return bool
     */
    public function checkFileType(string $extension): bool
    {
        return $this->checkImageFileType($extension) || $this->checkVideoFileType($extension);
    }

    /**
     * 画像の拡張子チェック
     * @param string $extension
     * @return bool
     */
    public function checkImageFileType(string $extension): bool
    {
        return in_array($extension, ['jpg','jpeg','png'], true);
    }

    /**
     * 動画の拡張子チェック
     * @param string $extension
     * @return bool
     */
    public function checkVideoFileType(string $extension): bool
    {
        return in_array($extension, ['mp4'], true);
    }

    public function saveFile(string $fileName, string $fileType)
    {
    }

    /**
     * File削除
     *
     * @param string $fileName
     * @param string $fileType
     * @return void
     */
    public function deleteFile(string $fileName, string $fileType): void
    {
        Storage::disk('public')->delete('images/test/' . $fileName . '.' . $fileType);
    }

    /**
     * File URL取得
     *
     * @param string $fileName
     * @param string $fileType
     * @return string
     */
    public function getFileUrl(?string $fileName, ?string $fileType): ?string
    {
        if (is_null($fileName) || is_null($fileType)) {
            return null;
        }

        return config('app.url') . Storage::url('images/test/' . $fileName . '.' . $fileType);
    }

    /**
     *
     */
    public function getFileType(?string $fileType): ?string
    {
        switch ($fileType) {
            case 'jpg':
            case 'jpeg':
            case 'png':
                return 'image';
            case 'mp4':
                return 'video';
            default:
                return null;
        }
    }
}
