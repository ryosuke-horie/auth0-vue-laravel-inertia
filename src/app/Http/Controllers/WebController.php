<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WebController extends Controller
{
    /**
     * ユーザー側LPページ
     */
    public function welcome(): Response
    {
        return Inertia::render('Web/Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    /**
     * 管理者側LPページ
     */
    public function owner(): Response
    {
        return Inertia::render('Web/Owner', []);
    }

    /**
     * よくある質問ページ
     */
    public function faq(): Response
    {
        return Inertia::render('Web/Faq', []);
    }

    /**
     * プライバシーポリシーページ
     */
    public function privacy(): Response
    {
        return Inertia::render('Web/Privacy', []);
    }

    /**
     * 利用規約ページ
     */
    public function term(): Response
    {
        return Inertia::render('Web/Term', []);
    }

    /**
     * 特定商取引法に基づく表記
     */
    public function law(): Response
    {
        return Inertia::render('Web/Law', []);
    }

    /**
     * 404ページ
     */
    public function notFound(): Response
    {
        return Inertia::render('Web/NotFound', []);
    }
}
