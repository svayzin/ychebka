<?php
// app/Services/SmsService.php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Отправка SMS через SMSC.ru
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function sendSms($phone, $message)
    {
        // Для SMSC.ru
        $login = env('SMSC_LOGIN');
        $password = env('SMSC_PASSWORD');
        $sender = env('SMSC_SENDER', 'Restaurant');
        
        $url = "https://smsc.ru/sys/send.php";
        
        $params = [
            'login' => $login,
            'psw' => $password,
            'phones' => $phone,
            'mes' => $message,
            'sender' => $sender,
            'charset' => 'utf-8'
        ];
        
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            
            if ($error) {
                Log::error('SMS sending error: ' . $error);
                return false;
            }
            
            Log::info('SMS sent to ' . $phone . ': ' . $response);
            return true;
            
        } catch (\Exception $e) {
            Log::error('SMS service error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Альтернативный метод для отладки - просто логирует код
     *
     * @param string $phone
     * @param string $code
     * @return bool
     */
    public function sendDebugSms($phone, $code)
    {
        Log::info('2FA Code for ' . $phone . ': ' . $code);
        return true;
    }

    /**
     * Отправка SMS через другой провайдер (пример)
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function sendSmsAlternative($phone, $message)
    {
        // Пример для другого провайдера
        // Можно добавить поддержку разных SMS-шлюзов
        
        return false;
    }
}