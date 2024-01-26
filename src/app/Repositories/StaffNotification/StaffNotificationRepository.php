<?php

namespace App\Repositories\StaffNotification;

use App\Models\StaffNotification;

class StaffNotificationRepository implements StaffNotificationRepositoryInterface
{
    public function createStaffNotification(int $staffId): void
    {
        StaffNotification::create([
            'staff_id' => $staffId,
            'is_message_notified' => false,
            'token' => null,
        ]);
    }
}
