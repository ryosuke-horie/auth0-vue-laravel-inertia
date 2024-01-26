<?php

namespace App\Repositories\Token;

use App\Enums\EntityType;

interface TokenRepositoryInterface
{
    /**
     * トークン管理追加
     * @param int $entityId
     * @param EntityType $entityType
     * @param string $email
     * @param string $token
     * @return void
     */
    public function registerToken(int $entityId, EntityType $entityType, string $email, string $token): void;

    /**
     * トークン管理削除
     * @param string $token
     * @return void
     */
    public function deleteToken(string $token): void;

    /**
     * BusinessId(EntityId)取得
     * @param string $token
     * @return int $entityId
     */
    public function getBusinessIdByToken(string $token): ?int;
}
