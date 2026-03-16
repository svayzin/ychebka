<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AuthController extends Controller
{
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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

    /**
     * Обработка входа
     */
    public function login(Request $request)
    {
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

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
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

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'field_errors' => [
                    'password' => ['Неверный email или пароль.']
                ]
            ], 422);
        }
        
        return back()
            ->withErrors(['password' => 'Неверный email или пароль.'])
            ->withInput()
            ->with('modal', 'loginModal');
    }

    /**
     * Обработка регистрации с ужесточенными требованиями к паролю
     */
    public function register(Request $request)
    {
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
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
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
                'min:8',
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
                    
                    $specialChars = preg_match_all('/[@$!%*?&_#^+=]/', $value);
                    if ($specialChars < 1) {
                        $fail('Пароль должен содержать минимум 1 специальный символ (@$!%*?&_#^+=).');
                    }
                }
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:8'
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
            'email.regex' => 'Введите корректный email адрес (например: name@mail.ru)',
            'email.max' => 'Email не должен превышать 255 символов',
            'email.unique' => 'Этот email уже зарегистрирован',
            'phone.required' => 'Пожалуйста, введите ваш номер телефона',
            'phone.regex' => 'Введите корректный номер телефона',
            'phone.unique' => 'Этот номер телефона уже зарегистрирован',
            'password.required' => 'Пожалуйста, введите пароль',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'password.regex' => 'Пароль должен содержать заглавные и строчные буквы, цифры и минимум один специальный символ (@$!%*?&_#^+=)',
            'password_confirmation.required' => 'Пожалуйста, подтвердите пароль',
            'password_confirmation.min' => 'Пароль должен содержать минимум 8 символов',
            'privacy_policy.required' => 'Вы должны согласиться с политикой конфиденциальности',
            'privacy_policy.accepted' => 'Вы должны принять условия использования'
        ]);

        if ($validator->fails()) {
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