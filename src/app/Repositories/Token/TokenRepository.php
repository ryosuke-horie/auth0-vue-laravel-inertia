<?php

namespace App\Repositories\Token;

use App\Enums\EntityType;
use App\Models\Token;
use Carbon\Carbon;

class TokenRepository implements TokenRepositoryInterface
{
    public function registerToken(int $entityId, EntityType $entityType, string $email, string $token): void
    {
        Token::create([
            'entity_id'   => $entityId,
            'entity_type' => $entityType,
            'email'       => $email,
            'token'       => $token,
            'end_at'      => Carbon::now()->addHour()
        ]);
    }

    public function deleteToken(string $token): void
    {
        Token::find($token)->delete();
    }

    public function getBusinessIdByToken(string $token): ?int
    {
        $now = Carbon::now();

        $where = [
            ['token', $token],
            ['entity_type', EntityType::BusinessOperator],
            ['end_at','>=',$now],
        ];

        $token = Token::where($where)->first();

        return !is_null($token) ? $token->entity_id : null;
    }
}
