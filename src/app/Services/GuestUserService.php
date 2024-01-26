<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Trais\FileTrait;

class GuestUserService
{
    use FileTrait;

    protected $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * ゲストユーザー取得
     *
     * @return User|null
     */
    public function getGuestUser(): ?User
    {
        return $this->userRepository->getGuestUser();
    }

    /**
     * ゲストユーザー作成
     *
     * @param array $data
     * @return User
     */
    public function createGuest(array $data): User
    {
        return $this->userRepository->createGuestUser($data);
    }
}
