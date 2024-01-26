<?php

namespace App\Http\Controllers\User;

use App\Enums\EntityType;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(
        NotificationService $notificationService,
    ) {
        $this->notificationService = $notificationService;
    }

    public function index(): Response
    {
        $userId = Auth::guard('user')->user()->user_id;
        $list = $this->notificationService->list(EntityType::User, $userId);

        return Inertia::render('User/Notification/Index', [
            'notifications' => $list->getList(),
        ]);
    }

    public function show(int $notificationId, Request $request): Response
    {
        return Inertia::render('User/Notification/Show', []);
    }
}
