<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class LoginMethodController extends Controller
{
    /**
     * ログイン方法選択画面を表示
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('User/LoginMethod/index');
    }
}
