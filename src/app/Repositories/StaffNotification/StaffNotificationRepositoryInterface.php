<?php

namespace App\Repositories\StaffNotification;

interface StaffNotificationRepositoryInterface
{
    public function createStaffNotification(int $staffId): void;
}
