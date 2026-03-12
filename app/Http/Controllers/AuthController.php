<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordResetToken;
use App\Models\PasswordResetCode;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected $redirectTo = '/';
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->middleware('guest')->except('logout');
        $this->smsService = $smsService;
    }

    /**
     * Показать форму входа
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Показать форму регистрации
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    // ============= МЕТОДЫ ДЛЯ ВОССТАНОВЛЕНИЯ ПАРОЛЯ ЧЕРЕЗ КОД =============

    /**
     * Показать форму ввода email для восстановления
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Отправить код подтверждения на email
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Пожалуйста, введите email',
            'email.email' => 'Введите корректный email',
            'email.exists' => 'Пользователь с таким email не найден',
        ]);

        try {
            // Генерируем 6-значный код
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Удаляем старые коды для этого email
            PasswordResetCode::where('email', $request->email)->delete();
            
            // Сохраняем новый код
            PasswordResetCode::create([
                'email' => $request->email,
                'code' => $code,
                'created_at' => now(),
                'expires_at' => now()->addMinutes(15),
                'used' => false
            ]);

            // ОТПРАВКА EMAIL С КОДОМ
            $this->sendCodeByEmail($request->email, $code);

            // Сохраняем email в сессии для следующего шага
            session(['reset_email' => $request->email]);

            return redirect()->route('password.verify')
                ->with('success', 'Код подтверждения отправлен на ваш email');

        } catch (\Exception $e) {
            \Log::error('Send reset code error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Ошибка при отправке кода. Попробуйте позже.']);
        }
    }

    /**
     * Отправка кода на email
     */
    private function sendCodeByEmail($email, $code)
    {
        try {
            $subject = 'Код восстановления пароля - Созвездие вкусов';
            
            $message = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #1a1a1a; border-radius: 10px; }
                        .header { text-align: center; padding: 20px; border-bottom: 2px solid #AD1C43; }
                        .header h1 { color: #AD1C43; font-family: 'Yeseva One', serif; margin: 0; }
                        .content { padding: 30px 20px; text-align: center; }
                        .code { font-size: 48px; font-weight: bold; color: #AD1C43; letter-spacing: 10px; margin: 30px 0; }
                        .footer { text-align: center; padding: 20px; color: #b0b0b0; font-size: 14px; border-top: 1px solid #333; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>Созвездие вкусов</h1>
                        </div>
                        <div class='content'>
                            <h2 style='color: #fff;'>Восстановление пароля</h2>
                            <p style='color: #b0b0b0; font-size: 16px;'>Используйте этот код для восстановления пароля:</p>
                            <div class='code'>$code</div>
                            <p style='color: #b0b0b0;'>Код действителен в течение 15 минут</p>
                            <p style='color: #b0b0b0;'>Если вы не запрашивали восстановление пароля, просто проигнорируйте это письмо.</p>
                        </div>
                        <div class='footer'>
                            <p>© 2024 Созвездие вкусов. Все права защищены.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: " . env('MAIL_FROM_ADDRESS') . "\r\n";

            mail($email, $subject, $message, $headers);
            
        } catch (\Exception $e) {
            \Log::error('Email send error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Показать форму ввода кода
     */
    public function showVerifyCodeForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.forgot');
        }
        
        return view('auth.verify-code');
    }

    /**
     * Проверить код
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ], [
            'code.required' => 'Введите код подтверждения',
            'code.size' => 'Код должен содержать 6 цифр',
        ]);

        $email = session('reset_email');
        
        if (!$email) {
            return redirect()->route('password.forgot')
                ->withErrors(['error' => 'Сессия истекла. Начните заново.']);
        }

        // Ищем действующий код
        $resetCode = PasswordResetCode::where('email', $email)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$resetCode || $resetCode->code !== $request->code) {
            return back()->withErrors(['code' => 'Неверный код или код истек']);
        }

        // Помечаем код как использованный
        $resetCode->update(['used' => true]);

        // Помечаем в сессии, что код подтвержден
        session(['code_verified' => true]);

        return redirect()->route('password.new');
    }

    /**
     * Показать форму нового пароля
     */
    public function showNewPasswordForm()
    {
        if (!session('reset_email') || !session('code_verified')) {
            return redirect()->route('password.forgot');
        }
        
        return view('auth.new-password');
    }

    /**
     * Установить новый пароль
     */
    public function resetPassword(Request $request)
    {
        if (!session('reset_email') || !session('code_verified')) {
            return redirect()->route('password.forgot')
                ->withErrors(['error' => 'Сессия истекла. Начните заново.']);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Введите новый пароль',
            'password.min' => 'Пароль должен быть не менее 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        try {
            $email = session('reset_email');
            $user = User::where('email', $email)->first();

            if (!$user) {
                return redirect()->route('password.forgot')
                    ->withErrors(['error' => 'Пользователь не найден']);
            }

            // Обновляем пароль
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Очищаем сессию
            session()->forget(['reset_email', 'code_verified']);

            return redirect()->route('login')
                ->with('success', 'Пароль успешно изменен. Теперь вы можете войти.');

        } catch (\Exception $e) {
            \Log::error('Reset password error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ошибка при сбросе пароля']);
        }
    }

    // ============= ОСТАЛЬНЫЕ МЕТОДЫ =============

    /**
     * Отправить код восстановления на телефон (ваш существующий метод)
     */
    public function sendResetCodePhone(Request $request)
    {
        // Rate limiting для предотвращения спама
        $throttleKey = 'reset-code|' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'success' => false,
                'field_errors' => [
                    'phone' => ['Слишком много запросов. Попробуйте через ' . ceil($seconds / 60) . ' минут.']
                ]
            ], 429);
        }
        
        $validator = Validator::make($request->all(), [
            'phone' => [
                'required',
                'string',
                'regex:/^[\+\d\s\-\(\)]+$/',
                function ($attribute, $value, $fail) {
                    $normalized = preg_replace('/[^\d+]/', '', $value);
                    
                    if (strlen($normalized) < 10) {
                        $fail('Номер телефона слишком короткий.');
                    }
                    
                    // Проверяем, зарегистрирован ли телефон
                    $phone = $this->normalizePhone($value);
                    $user = User::where('phone', $phone)->first();
                    
                    if (!$user) {
                        $fail('Пользователь с таким номером телефона не найден.');
                    }
                }
            ]
        ], [
            'phone.required' => 'Пожалуйста, введите номер телефона',
            'phone.regex' => 'Пожалуйста, введите корректный номер телефона'
        ]);
        
        if ($validator->fails()) {
            RateLimiter::hit($throttleKey, 300);
            return response()->json([
                'success' => false,
                'field_errors' => $validator->errors()->toArray()
            ], 422);
        }
        
        try {
            // Нормализуем номер телефона
            $phone = $this->normalizePhone($request->phone);
            
            // Удаляем старые токены для этого номера
            PasswordResetToken::where('phone', $phone)
                ->where('created_at', '<', Carbon::now()->subMinutes(5))
                ->delete();
                
            // Проверяем, не отправляли ли мы уже код в последние 2 минуты
            $recentToken = PasswordResetToken::where('phone', $phone)
                ->where('created_at', '>', Carbon::now()->subMinutes(2))
                ->first();
                
            if ($recentToken) {
                return response()->json([
                    'success' => false,
                    'field_errors' => [
                        'phone' => ['Код уже отправлен. Пожалуйста, подождите 2 минуты перед повторной отправкой.']
                    ]
                ], 422);
            }
            
            // Генерируем 6-значный код
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Сохраняем токен
            PasswordResetToken::create([
                'phone' => $phone,
                'token' => Hash::make($code),
                'expires_at' => Carbon::now()->addMinutes(15),
                'used' => false
            ]);
            
            // В РЕАЛЬНОМ ПРОЕКТЕ: Отправляем SMS через API
            // $this->sendSms($phone, "Код для восстановления пароля: $code");
            
            // Для тестирования возвращаем код в ответе (в проде удалить!)
            $debugCode = config('app.debug') ? $code : null;
            
            RateLimiter::hit($throttleKey, 300);
            
            return response()->json([
                'success' => true,
                'message' => 'Код восстановления отправлен на ваш телефон' . 
                           (config('app.debug') ? ' (код: ' . $code . ')' : ''),
                'debug_code' => $debugCode,
                'phone' => $this->maskPhone($phone)
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Send reset code error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'field_errors' => [
                    'general' => ['Произошла ошибка при отправке кода. Пожалуйста, попробуйте позже.']
                ]
            ], 500);
        }
    }

    /**
     * Показать форму ввода кода (для телефона)
     */
    public function showResetCodeForm(Request $request)
    {
        $phone = $request->query('phone');
        
        if (!$phone) {
            return redirect()->route('password.forgot');
        }
        
        return view('auth.reset-code', compact('phone'));
    }

    /**
     * Проверить код восстановления (для телефона)
     */
    public function verifyResetCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'code' => 'required|string|min:6|max:6|regex:/^[0-9]+$/'
        ], [
            'code.required' => 'Пожалуйста, введите код',
            'code.min' => 'Код должен содержать 6 цифр',
            'code.max' => 'Код должен содержать 6 цифр',
            'code.regex' => 'Код должен содержать только цифры'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'field_errors' => $validator->errors()->toArray()
            ], 422);
        }
        
        try {
            $phone = $this->normalizePhone($request->phone);
            $code = $request->code;
            
            // Ищем активный токен
            $token = PasswordResetToken::where('phone', $phone)
                ->where('used', false)
                ->where('expires_at', '>', Carbon::now())
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$token || !Hash::check($code, $token->token)) {
                return response()->json([
                    'success' => false,
                    'field_errors' => [
                        'code' => ['Неверный код. Попробуйте еще раз.']
                    ]
                ], 422);
            }
            
            // Помечаем токен как использованный
            $token->update(['used' => true]);
            
            // Создаем сессию для сброса пароля
            session([
                'reset_phone' => $phone,
                'reset_verified' => true,
                'reset_token_id' => $token->id
            ]);
            
            return response()->json([
                'success' => true,
                'redirect' => route('password.reset')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Verify reset code error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'field_errors' => [
                    'general' => ['Произошла ошибка при проверке кода. Пожалуйста, попробуйте позже.']
                ]
            ], 500);
        }
    }

    /**
     * Показать форму сброса пароля (по телефону)
     */
    public function showResetPasswordForm()
    {
        if (!session('reset_verified')) {
            return redirect()->route('password.forgot');
        }
        
        $phone = session('reset_phone');
        return view('auth.reset-password', compact('phone'));
    }

    /**
     * Сбросить пароль (по телефону)
     */
    public function resetPasswordByPhone(Request $request)
    {
        if (!session('reset_verified')) {
            return response()->json([
                'success' => false,
                'field_errors' => [
                    'general' => ['Сессия истекла. Пожалуйста, начните процесс восстановления заново.']
                ]
            ], 422);
        }
        
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:12',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                function ($attribute, $value, $fail) use ($request) {
                    $phone = $this->normalizePhone($request->phone);
                    $user = User::where('phone', $phone)->first();
                    
                    if ($user && Hash::check($value, $user->password)) {
                        $fail('Новый пароль не должен совпадать со старым.');
                    }
                }
            ],
            'password_confirmation' => 'required|string|min:12'
        ], [
            'password.required' => 'Пожалуйста, введите новый пароль',
            'password.min' => 'Пароль должен содержать минимум 12 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'password.regex' => 'Пароль должен содержать заглавные и строчные буквы, цифры и специальные символы',
            'password_confirmation.required' => 'Пожалуйста, подтвердите пароль'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'field_errors' => $validator->errors()->toArray()
            ], 422);
        }
        
        try {
            $phone = $this->normalizePhone($request->phone);
            
            // Находим пользователя
            $user = User::where('phone', $phone)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'field_errors' => [
                        'general' => ['Пользователь не найден.']
                    ]
                ], 422);
            }
            
            // Обновляем пароль
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            
            // Очищаем сессию
            session()->forget(['reset_phone', 'reset_verified', 'reset_token_id']);
            
            // Автоматически авторизуем пользователя
            Auth::login($user);
            
            return response()->json([
                'success' => true,
                'message' => 'Пароль успешно изменен!',
                'redirect' => route('home')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Reset password error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'field_errors' => [
                    'general' => ['Произошла ошибка при сбросе пароля. Пожалуйста, попробуйте позже.']
                ]
            ], 500);
        }
    }

    /**
     * Обработка входа
     */
    public function login(Request $request)
    {
        // Rate limiting для предотвращения брутфорса
        $throttleKey = strtolower($request->email) . '|' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'field_errors' => [
                        'general' => ['Слишком много попыток входа. Попробуйте через ' . ceil($seconds / 60) . ' минут.']
                    ]
                ], 429);
            }
            
            return back()
                ->withInput()
                ->withErrors(['general' => 'Слишком много попыток входа. Попробуйте через ' . ceil($seconds / 60) . ' минут.'])
                ->with('modal', 'loginModal');
        }

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:8'
            ],
        ], [
            'email.required' => 'Пожалуйста, введите ваш email',
            'email.email' => 'Пожалуйста, введите корректный email адрес',
            'email.max' => 'Email не должен превышать 255 символов',
            'password.required' => 'Пожалуйста, введите пароль',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
        ]);

        if ($validator->fails()) {
            RateLimiter::hit($throttleKey, 300);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'field_errors' => $validator->errors()->toArray(),
                    'message' => 'Пожалуйста, исправьте ошибки в форме.'
                ], 422);
            }
            
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'loginModal');
        }

        $credentials = $request->only('email', 'password');
        
        // Проверка существования пользователя
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            RateLimiter::hit($throttleKey, 300);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'field_errors' => [
                        'email' => ['Пользователь с таким email не найден.']
                    ]
                ], 422);
            }
            
            return back()
                ->withErrors(['email' => 'Пользователь с таким email не найден.'])
                ->withInput()
                ->with('modal', 'loginModal');
        }
        
        // Проверка активности аккаунта (безопасная проверка)
        if ($user->is_banned ?? false) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'field_errors' => [
                        'general' => ['Ваш аккаунт заблокирован. Обратитесь в поддержку.']
                    ]
                ], 403);
            }
            
            return back()
                ->withErrors(['general' => 'Ваш аккаунт заблокирован. Обратитесь в поддержку.'])
                ->withInput()
                ->with('modal', 'loginModal');
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            // ПРОВЕРЯЕМ, ВКЛЮЧЕНА ЛИ ДВУХФАКТОРНАЯ АУТЕНТИФИКАЦИЯ
            if ($user->two_factor_enabled) {
                // Временно разлогиниваем пользователя
                Auth::logout();
                
                // Генерируем новый код
                $codeRecord = $user->generateTwoFactorCode();
                
                // Отправляем SMS с кодом
                $message = "Код для входа в личный кабинет: " . $codeRecord->code;
                
                if (config('app.debug')) {
                    // В режиме отладки просто логируем код
                    $this->smsService->sendDebugSms($user->phone, $codeRecord->code);
                } else {
                    // В продакшене отправляем реальное SMS
                    $this->smsService->sendSms($user->phone, $message);
                }
                
                // Сохраняем ID пользователя в сессии для 2FA
                session(['two_factor:user:id' => $user->id]);
                
                // Сбрасываем rate limiter
                RateLimiter::clear($throttleKey);
                
                // Возвращаем ответ в зависимости от типа запроса
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'requires_two_factor' => true,
                        'redirect' => route('two-factor.verify'),
                        'message' => 'Требуется подтверждение по SMS'
                    ]);
                }
                
                return redirect()->route('two-factor.verify')
                    ->with('info', 'На ваш телефон отправлен код подтверждения');
            }
            
            // Если 2FA не включена, входим как обычно
            // Сброс rate limit при успешном входе
            RateLimiter::clear($throttleKey);
            
            // БЕЗОПАСНОЕ обновление пользователя
            try {
                // Проверяем, есть ли поля в базе перед обновлением
                $updateData = [];
                
                if (Schema::hasColumn('users', 'last_login_at')) {
                    $updateData['last_login_at'] = now();
                }
                
                if (Schema::hasColumn('users', 'login_ip')) {
                    $updateData['login_ip'] = $request->ip();
                }
                
                if (Schema::hasColumn('users', 'failed_login_attempts')) {
                    $updateData['failed_login_attempts'] = 0;
                }
                
                if (!empty($updateData)) {
                    $user->update($updateData);
                }
            } catch (\Exception $e) {
                \Log::error('Error updating user login info: ' . $e->getMessage());
            }
            
            $request->session()->regenerate();
            
            // Очищаем intended URL из сессии
            $request->session()->forget('url.intended');
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Добро пожаловать!',
                    'redirect' => url('/'),
                    'user' => [
                        'name' => $user->full_name,
                        'email' => $user->email
                    ]
                ]);
            }
            
            return redirect('/')->with('success', 'Добро пожаловать, ' . $user->full_name . '!');
        }

        RateLimiter::hit($throttleKey, 300);
        
        // Проверка количества неудачных попыток (безопасно)
        try {
            if (Schema::hasColumn('users', 'failed_login_attempts') && $user) {
                $user->increment('failed_login_attempts');
                $failedAttempts = $user->failed_login_attempts ?? 0;
            } else {
                $failedAttempts = 0;
            }
        } catch (\Exception $e) {
            $failedAttempts = 0;
            \Log::error('Error incrementing failed attempts: ' . $e->getMessage());
        }
        
        if (isset($user) && $failedAttempts >= 5) {
            try {
                if (Schema::hasColumn('users', 'is_banned')) {
                    $user->update(['is_banned' => true]);
                }
                $errorMessage = 'Аккаунт заблокирован из-за множества неудачных попыток входа.';
            } catch (\Exception $e) {
                $errorMessage = 'Неверный email или пароль.';
            }
        } else {
            $errorMessage = isset($user) 
                ? 'Неверный email или пароль. Осталось попыток: ' . (5 - $failedAttempts)
                : 'Неверный email или пароль.';
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'field_errors' => [
                    'password' => [$errorMessage]
                ]
            ], 422);
        }
        
        return back()
            ->withErrors(['password' => $errorMessage])
            ->withInput()
            ->with('modal', 'loginModal');
    }

    /**
     * Обработка регистрации с ужесточенными требованиями к паролю
     */
    public function register(Request $request)
    {
        // Rate limiting для регистрации
        $throttleKey = 'register|' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'field_errors' => [
                        'general' => ['Слишком много попыток регистрации. Попробуйте через ' . ceil($seconds / 60) . ' минут.']
                    ]
                ], 429);
            }
            
            return back()
                ->withInput()
                ->withErrors(['general' => 'Слишком много попыток регистрации. Попробуйте через ' . ceil($seconds / 60) . ' минут.'])
                ->with('modal', 'registerModal');
        }

        $validator = Validator::make($request->all(), [
            'full_name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[\p{Cyrillic}a-zA-Z\s\-]+$/u',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\+\d\s\-\(\)]+$/',
                function ($attribute, $value, $fail) {
                    $normalized = preg_replace('/[^\d+]/', '', $value);
                    
                    if (strlen($normalized) < 10) {
                        $fail('Номер телефона слишком короткий.');
                    }
                    
                    if (preg_match('/^(\+7|8)/', $normalized)) {
                        if (strlen($normalized) !== 12 && strlen($normalized) !== 11) {
                            $fail('Некорректный формат российского номера.');
                        }
                    }
                },
                'unique:users,phone'
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:12',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_#^+=])[A-Za-z\d@$!%*?&_#^+=]+$/',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->full_name && stripos($value, $request->full_name) !== false) {
                        $fail('Пароль не должен содержать ваше имя.');
                    }
                    
                    $email = $request->email;
                    $emailLocal = explode('@', $email)[0];
                    if ($email && stripos($value, $emailLocal) !== false) {
                        $fail('Пароль не должен содержать ваш email.');
                    }
                    
                    if (preg_match('/(12345|abcde|qwerty|password|admin)/i', $value)) {
                        $fail('Пароль слишком простой. Избегайте простых последовательностей.');
                    }
                    
                    if (preg_match('/(.)\1{3,}/', $value)) {
                        $fail('Пароль содержит слишком много повторяющихся символов.');
                    }
                    
                    // Проверка на наличие минимум двух специальных символов
                    $specialChars = preg_match_all('/[@$!%*?&_#^+=]/', $value);
                    if ($specialChars < 2) {
                        $fail('Пароль должен содержать минимум 2 специальных символа.');
                    }
                }
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:12'
            ],
            'privacy_policy' => [
                'required',
                'accepted'
            ]
        ], [
            'full_name.required' => 'Пожалуйста, введите ваше полное имя',
            'full_name.min' => 'Имя должно содержать минимум 2 символа',
            'full_name.max' => 'Имя не должно превышать 255 символов',
            'full_name.regex' => 'Имя может содержать только буквы, пробелы и дефисы',
            'email.required' => 'Пожалуйста, введите ваш email',
            'email.email' => 'Пожалуйста, введите корректный email адрес',
            'email.max' => 'Email не должен превышать 255 символов',
            'email.unique' => 'Этот email уже зарегистрирован',
            'phone.required' => 'Пожалуйста, введите ваш номер телефона',
            'phone.regex' => 'Введите корректный номер телефона',
            'phone.unique' => 'Этот номер телефона уже зарегистрирован',
            'password.required' => 'Пожалуйста, введите пароль',
            'password.min' => 'Пароль должен содержать минимум 12 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'password.regex' => 'Пароль должен содержать заглавные и строчные буквы, цифры и специальные символы (@$!%*?&_#^+=)',
            'password_confirmation.required' => 'Пожалуйста, подтвердите пароль',
            'privacy_policy.required' => 'Вы должны согласиться с политикой конфиденциальности',
            'privacy_policy.accepted' => 'Вы должны принять условия использования'
        ]);

        if ($validator->fails()) {
            RateLimiter::hit($throttleKey, 600);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'field_errors' => $validator->errors()->toArray(),
                    'message' => 'Пожалуйста, исправьте ошибки в форме.'
                ], 422);
            }
            
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'registerModal');
        }

        try {
            $userData = [
                'full_name' => trim($request->full_name),
                'email' => strtolower(trim($request->email)),
                'phone' => $this->normalizePhone($request->phone),
                'password' => Hash::make($request->password),
                'is_admin' => false,
            ];
            
            // Безопасно добавляем registration_ip если колонка есть
            if (Schema::hasColumn('users', 'registration_ip')) {
                $userData['registration_ip'] = $request->ip();
            }
            
            $user = User::create($userData);

            event(new Registered($user));
            Auth::login($user);
            RateLimiter::clear($throttleKey);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Регистрация успешно завершена!',
                    'user' => [
                        'name' => $user->full_name,
                        'email' => $user->email,
                        'requires_verification' => is_null($user->email_verified_at)
                    ]
                ]);
            }

            return redirect('/')
                ->with('success', 'Регистрация успешно завершена! Добро пожаловать, ' . $user->full_name . '!');

        } catch (\Exception $e) {
            RateLimiter::hit($throttleKey, 600);
            
            \Log::error('Registration error: ' . $e->getMessage(), [
                'email' => $request->email,
                'ip' => $request->ip()
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'field_errors' => [
                        'general' => ['Произошла ошибка при регистрации. Пожалуйста, попробуйте позже.']
                    ]
                ], 500);
            }
            
            return back()
                ->withInput()
                ->withErrors(['general' => 'Произошла ошибка при регистрации. Пожалуйста, попробуйте позже.'])
                ->with('modal', 'registerModal');
        }
    }

    /**
     * Выход из системы
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Сбрасываем 2FA верификацию при выходе
            if ($user->two_factor_enabled) {
                $user->resetTwoFactorVerification();
            }
            
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('success', 'Вы успешно вышли из системы.');
        }
        
        return redirect('/');
    }

    /**
     * Для отладки регистрации
     */
    public function testRegistration(Request $request)
    {
        if (!config('app.debug')) {
            abort(404);
        }
        
        return $this->register($request);
    }

    /**
     * Вспомогательные методы
     */
    private function normalizePhone($phone)
    {
        $normalized = preg_replace('/[^\d+]/', '', $phone);
        
        // Если номер начинается с 8, заменяем на +7
        if (preg_match('/^8/', $normalized)) {
            $normalized = '+7' . substr($normalized, 1);
        }
        
        return $normalized;
    }

    private function maskPhone($phone)
    {
        return substr($phone, 0, 4) . '******' . substr($phone, -2);
    }
}