<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    // Показать форму бронирования
    public function create()
    {
        return view('reservation.create');
    }
    
    // Сохранить бронирование
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'phone' => 'required|string|max:20|regex:/^[\d\s\-\(\)\+]+$/',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string|in:19:00,19:30,20:00,20:30,21:00',
            'guests' => 'required|integer|min:1|max:20',
            'privacy' => 'required|accepted',
        ], [
            'name.required' => 'Пожалуйста, введите ваше имя',
            'name.min' => 'Имя должно содержать минимум 2 символа',
            'phone.required' => 'Пожалуйста, введите ваш телефон',
            'phone.regex' => 'Пожалуйста, введите корректный номер телефона',
            'date.required' => 'Пожалуйста, выберите дату',
            'date.after_or_equal' => 'Дата не может быть в прошлом',
            'time.required' => 'Пожалуйста, выберите время',
            'time.in' => 'Выберите доступное время',
            'guests.required' => 'Пожалуйста, укажите количество гостей',
            'guests.min' => 'Минимальное количество гостей: 1',
            'guests.max' => 'Максимальное количество гостей: 20',
            'privacy.required' => 'Необходимо согласие на обработку данных',
            'privacy.accepted' => 'Необходимо согласие на обработку данных',
        ]);
        
        try {
            // Проверка на дублирующую бронь
            $existingReservation = Reservation::where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->where('phone', $validated['phone'])
                ->first();
                
            if ($existingReservation) {
                return back()
                    ->withInput()
                    ->with('error', 'У вас уже есть бронь на это время. Если хотите изменить, свяжитесь с нами.');
            }
            
            // Ограничение на количество броней в одно время
            $reservationsCount = Reservation::where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->count();
                
            // Предположим, у нас максимум 5 столиков на одно время
            if ($reservationsCount >= 5) {
                return back()
                    ->withInput()
                    ->with('error', 'К сожалению, на это время все столики заняты. Пожалуйста, выберите другое время.');
            }
            
            // Создание бронирования
            $reservationData = [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'date' => $validated['date'],
                'time' => $validated['time'],
                'guests' => $validated['guests'],
                'confirmed' => false,
            ];
            
            // Добавляем user_id если пользователь авторизован
            if (Auth::check()) {
                $reservationData['user_id'] = Auth::id();
            }
            
            $reservation = Reservation::create($reservationData);
            
            // Здесь можно добавить отправку уведомлений
            // $this->sendNotification($reservation);
            
            // Запись в лог для отладки
            Log::info('Новая бронь создана', ['reservation_id' => $reservation->id]);
            
            return redirect('/')
                ->with('success', 'Столик успешно забронирован на ' . 
                       $reservation->date->format('d.m.Y') . ' в ' . $reservation->time . 
                       '! Мы свяжемся с вами для подтверждения.');
            
        } catch (\Exception $e) {
            // Логируем ошибку
            Log::error('Ошибка бронирования: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Произошла ошибка при бронировании. Пожалуйста, попробуйте позже или свяжитесь с нами по телефону.');
        }
    }
    
    // Показать список бронирований пользователя
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Для просмотра бронирований необходимо войти в систему');
        }
        
        $reservations = Reservation::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(10);
            
        return view('reservation.index', compact('reservations'));
    }
    
    // Показать конкретную бронь
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Проверка прав доступа
        if ($reservation->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }
        
        return view('reservation.show', compact('reservation'));
    }
    
    // Отменить бронирование
    public function cancel($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $reservation->delete();
        
        return redirect()->route('reservations.index')
            ->with('success', 'Бронь успешно отменена');
    }
    
    // Метод для отправки уведомлений (заглушка)
    private function sendNotification(Reservation $reservation)
    {
        // Реализация отправки email или SMS
        // Можно использовать Laravel Notifications
    }
}