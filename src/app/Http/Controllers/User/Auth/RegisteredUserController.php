<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('User/Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // リクエストデータにbirthdateを追加
        $date = Carbon::createFromDate($request->year, $request->month, $request->day)->toDateString();
        $request->merge(['birthdate' => $date]);

        // バリデーション
        $validator = Validator::make($request->all(), [
            'nickname' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . now()->year,
            'month' => 'required|integer|min:1|max:12',
            'day' => 'required|integer|min:1|max:31',
            'birthdate' => 'required|date|before_or_equal:today',
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // email_hash に対するカスタムバリデーション
        $validator->after(function ($validator) use ($request) {
            // emailがnullの場合は処理をスキップ
            if (is_null($request->email)) {
                return;
            }

            $emailLowerHash = hash('sha256', $this->normalizeEmail($request->email));
            if (User::where('email_hash', $emailLowerHash)->exists()) {
                $validator->errors()->add('email', '指定されたメールアドレスはすでに存在します。');
            }
        });

        // バリデーションエラーがあればリダイレクト
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'nickname' => $request->nickname,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::USER_HOME);
    }

    /**
     * リクエストのメールアドレスを小文字にする
     *
     * @param String $email
     * @return String
     */
    private function normalizeEmail(string $email): string
    {
        $parts = explode('@', $email);

        if (count($parts) == 2) {
            $localPart = strtolower($parts[0]);
            $domainPart = strtolower($parts[1]);
            $email = $localPart . '@' . $domainPart;
        }

        return $email;
    }
}
