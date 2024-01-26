<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SignupController extends Controller
{
    /**
     * 無料会員登録画面を表示
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('User/Signup/index');
    }
}
