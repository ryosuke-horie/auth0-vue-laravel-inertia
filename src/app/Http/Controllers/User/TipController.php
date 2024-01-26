<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserTipService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TipController extends Controller
{
    private UserTipService $userTipService;

    public function __construct(UserTipService $userTipService)
    {
        $this->userTipService = $userTipService;
    }

    public function index(): Response
    {
        $userId = Auth::guard('user')->user()->user_id;
        $args = $this->userTipService->list($userId);
        return Inertia::render('User/Tip/Index', $args);
    }

    public function show(int $tipId): Response
    {
        $args = $this->userTipService->show($tipId);
        return Inertia::render('User/Tip/Show', $args);
    }
}
