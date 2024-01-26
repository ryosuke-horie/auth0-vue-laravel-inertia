<?php

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SignupController;
use App\Http\Controllers\User\LoginMethodController;
use App\Http\Controllers\User\GuestLoginController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\BusinessOperatorController;
use App\Http\Controllers\User\StaffController;
use App\Http\Controllers\User\FavoriteStaffController;
use App\Http\Controllers\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\Auth\ConfirmablePasswordController;
use App\Http\Controllers\User\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\User\Auth\EmailVerificationPromptController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\PasswordController;
use App\Http\Controllers\User\Auth\PasswordResetLinkController;
use App\Http\Controllers\User\Auth\RegisteredUserController;
use App\Http\Controllers\User\Auth\VerifyEmailController;
use App\Http\Controllers\User\MypageController;
use App\Http\Controllers\User\PaymentInfoController;
use App\Http\Controllers\User\TipController;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Laravel\Cashier\Http\Controllers\PaymentController;
use Auth0\Laravel\Controllers\{LoginController, LogoutController, CallbackController};
use Inertia\Inertia;

Route::prefix('user')->name('user.')->group(function () {


    // Auth0
    Route::group(['middleware' => ['guard:auth0-session']], static function (): void {
        Route::get('/sns-login', LoginController::class)->name('sns-login');
        Route::get('/sns-logout', LogoutController::class)->name('sns-logout');
        Route::get('/callback', CallbackController::class)->name('callback');
    });

    // ゲストルーティング
    Route::middleware('user.guest:user')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');

        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');

        // チアペイ無料会員登録画面
        Route::get('signup', [SignupController::class, 'index'])->name('signup');

        // ログイン方法の選択画面
        Route::get('login-method', [LoginMethodController::class, 'index'])->name('login-method');
        Route::post('guest-login', [GuestLoginController::class, 'guestLogin'])->name('guest-login');
    });

    Route::middleware('user:user')->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // マイページ
        Route::get('mypage', [MypageController::class, 'index'])
            ->middleware(['verified'])->name('mypage.index');

        // 支払い情報
        Route::prefix('payment-info')->name('payment-info.')->group(function () {
            Route::get('/', [PaymentInfoController::class, 'show'])->name('show');
            // 登録表示
            Route::get('/create', [PaymentInfoController::class, 'create'])->name('create');
            // 確認表示
            Route::post('/confirm', [PaymentInfoController::class, 'confirm'])->name('confirm');
        });

        // お知らせ
        Route::prefix('notification')->name('notification.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::get('/{notificationId}', [NotificationController::class, 'show'])->name('show');
        });

        // 事業者
        Route::prefix('business-operator')->name('business-operator.')->group(function () {
            // 一覧表示
            Route::get('/', [BusinessOperatorController::class, 'index'])->name('index');
            // 詳細表示
            Route::get('/{businessId}', [BusinessOperatorController::class, 'show'])->name('show');
            // 口コミ登録
            Route::get('/{businessId}/review', [BusinessOperatorController::class, 'createReview'])->name('create-review');
            Route::post('/{businessId}/review', [BusinessOperatorController::class, 'storeReview'])->name('store-review');

            // スタッフ一覧
            Route::get('/{businessId}/staff', [StaffController::class, 'index'])->name('staff.index');
            // スタッフ詳細
            Route::get('/{businessId}/staff/{staffId}', [StaffController::class, 'show'])->name('staff.show');
            // スタッフへのチップ
            Route::post('/{businessId}/staff/{staffId}', [StaffController::class, 'userTipStore'])->name('staff.userTip.store');
        });

        // 投げ銭
        Route::prefix('tips')->name('tips.')->group(function () {
            Route::get('/', [TipController::class, 'index'])->name('index');
            Route::middleware('user.tipId')->group(function () {
                Route::get('/{tipId}', [TipController::class, 'show'])->name('show');
            });
        });

        // お気に入りスタッフ
        Route::prefix('favorite-staff')->name('favorite-staff.')->group(function () {
            // 一覧表示
            Route::get('/', [FavoriteStaffController::class, 'index'])->name('index');
        });

        // Stripe自動生成されるルーティング（必要ない可能性大）
        // Route::prefix('stripe')->name('stripe.')->group(function () {
        //     // 支払い情報登録
        //     Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment');
        //     Route::post('/webhook', [WebhookController::class, 'handleWebhook'])->name('webhook');
        // });
    });
});
