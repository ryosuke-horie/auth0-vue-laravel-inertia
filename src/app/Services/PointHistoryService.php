<?php

namespace App\Services;

use App\Domain\PointHistory\PointHistoryList;
use App\Enums\EntityType;
use App\Repositories\Staff\StaffRepositoryInterface;

class PointHistoryService
{
    private $staffRepository;

    public function __construct(StaffRepositoryInterface $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    public function list(EntityType $entityType, int $entityId)
    {
        $pointHistoryList = new PointHistoryList($entityType, $entityId);

        $staff = $this->staffRepository->findByStaffId($entityId);

        $args = [
            'pointHistories' => $pointHistoryList->getList(),
            'points'         => $staff->points
        ];

        return $args;
    }
}
