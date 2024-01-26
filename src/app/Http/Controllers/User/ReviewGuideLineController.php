<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BusinessOperatorService;
use Inertia\Inertia;
use Inertia\Response;

class ReviewGuideLineController extends Controller
{
    /**
     * 口コミガイドライン
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('User/ReviewGuideLine/Index');
    }
}
