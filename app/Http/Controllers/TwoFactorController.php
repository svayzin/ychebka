<?php
// app/Http/Controllers/TwoFactorController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TwoFactorCode;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class TwoFactorController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Показать форму ввода кода
     */
    public function showVerifyForm()
    {
        if (!session('two_factor:user:id')) {
            return redirect()->route('login');
        }

        $userId = session('two_factor:user:id');
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Маскируем номер телефона
        $maskedPhone = $this->maskPhone($user->phone);

        return view('auth.two-factor-verify', compact('maskedPhone'));
    }

    /**
     * Отправить новый код
     */
    public function resendCode(Request $request)
    {
        if (!session('two_factor:user:id')) {
            return response()->json([
                'success' => false,
                'message' => 'Сессия истекла'
            ], 401);
        }

        $userId = session('two_factor:user:id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден'
            ], 404);
        }

        // Rate limiting
        $throttleKey = '2fa-resend:' . $user->id;
        
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'success' => false,
                'message' => 'Слишком много запросов. Попробуйте через ' . ceil($seconds / 60) . ' минут.'
            ], 429);
        }

        try {
            // Генерируем новый код
            $codeRecord = $user->generateTwoFactorCode();
            
            // Отправляем SMS
            $message = "Код для входа в личный кабинет: " . $codeRecord->code;
            
            if (config('app.debug')) {
                $this->smsService->sendDebugSms($user->phone, $codeRecord->code);
            } else {
                $this->smsService->sendSms($user->phone, $message);
            }

            RateLimiter::hit($throttleKey, 300); // 5 минут блокировки

            return response()->json([
                'success' => true,
                'message' => 'Новый код отправлен'
            ]);

        } catch (\Exception $e) {
            \Log::error('2FA resend error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при отправке кода'
            ], 500);
        }
    }

    /**
     * Проверить код
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6|regex:/^[0-9]+$/'
        ], [
            'code.required' => 'Введите код подтверждения',
            'code.size' => 'Код должен содержать 6 цифр',
            'code.regex' => 'Код должен содержать только цифры'
        ]);

        if (!session('two_factor:user:id')) {
            return response()->json([
                'success' => false,
                'message' => 'Сессия истекла. Войдите заново.'
            ], 401);
        }

        $userId = session('two_factor:user:id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден'
            ], 404);
        }

        // Rate limiting
        $throttleKey = '2fa-verify:' . $user->id;
        
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'success' => false,
                'message' => 'Слишком много попыток. Попробуйте через ' . ceil($seconds / 60) . ' минут.'
            ], 429);
        }

        // Проверяем код
        if ($user->verifyTwoFactorCode($request->code)) {
            // Очищаем rate limiting
            RateLimiter::clear($throttleKey);
            
            // Авторизуем пользователя
            Auth::login($user);
            
            // Очищаем сессию 2FA
            session()->forget('two_factor:user:id');
            
            // Регенерируем сессию
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'redirect' => session()->pull('url.intended', route('home'))
            ]);
        }

        // Неудачная попытка
        RateLimiter::hit($throttleKey, 300);

        return response()->json([
            'success' => false,
            'message' => 'Неверный код подтверждения'
        ], 422);
    }

    /**
     * Включить двухфакторную аутентификацию для пользователя
     */
    public function enable(Request $request)
    {
        $user = Auth::user();

        if (!$user->phone) {
            return response()->json([
                'success' => false,
                'message' => 'Для включения 2FA необходимо указать номер телефона'
            ], 422);
        }

        $user->update(['two_factor_enabled' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Двухфакторная аутентификация включена'
        ]);
    }

    /**
     * Отключить двухфакторную аутентификацию
     */
    public function disable(Request $request)
    {
        $user = Auth::user();
        
        $user->update(['two_factor_enabled' => false]);
        
        // Удаляем все коды
        $user->twoFactorCodes()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Двухфакторная аутентификация отключена'
        ]);
    }

    /**
     * Маскировка номера телефона
     */
    private function maskPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return substr($phone, 0, 4) . '******' . substr($phone, -2);
        }
        return $phone;
    }
}