<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\TableReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableBookingController extends Controller
{
    public function tables()
    {
        return response()->json(
            Table::where('active', true)->orderBy('number')->get()
        );
    }

    public function availability(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'buffer_minutes' => 'nullable|integer|min:0|max:120',
        ]);

        $buffer = (int)($data['buffer_minutes'] ?? 0);

        $time = Carbon::parse($data['date'].' '.$data['time']);
        $windowStart = (clone $time)->subMinutes($buffer);
        $windowEnd = (clone $time)->addMinutes($buffer);

        $busyTableIds = TableReservation::query()
            ->where('cancelled', false)
            ->where('start_at', '<=', $windowEnd)
            ->where('end_at', '>', $windowStart)
            ->pluck('table_id')
            ->unique()
            ->values();

        return response()->json([
            'busy_table_ids' => $busyTableIds,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'guest_name' => 'required|string|max:255|min:2',
            'guest_phone' => 'required|string|max:32',
            'guest_email' => 'nullable|email|max:255',
            'guests_count' => 'required|integer|min:1|max:4',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        $table = Table::findOrFail($data['table_id']);
        $startAt = Carbon::parse($data['start_at']);
        if ($startAt->isPast()) {
            return response()->json(['message' => 'Нельзя забронировать столик на прошедшее время'], 422);
        }

        $table = Table::findOrFail($data['table_id']);

        // проверяем вместимость
        if ($data['guests_count'] < $table->seats_min || $data['guests_count'] > $table->seats_max) {
            return response()->json(['message' => 'Неверное количество гостей для этого столика'], 422);
        }

        $bufferMinutes = 15;
        $start = Carbon::parse($data['start_at'])->subMinutes($bufferMinutes);
        $end = Carbon::parse($data['end_at'])->addMinutes($bufferMinutes);

        $conflict = TableReservation::query()
            ->where('table_id', $table->id)
            ->where('cancelled', false)
            ->where('start_at', '<', $end)
            ->where('end_at', '>', $start)
            ->exists();

        if ($conflict) {
            return response()->json(['message' => 'Столик занят на выбранное время'], 409);
        }

        $depositTotal = $data['guests_count'] * $table->deposit_per_person;

        $reservation = TableReservation::create([
            'table_id' => $table->id,
            'user_id' => Auth::id(),
            'guest_name' => $data['guest_name'],
            'guest_phone' => $data['guest_phone'],
            'guest_email' => $data['guest_email'] ?? null,
            'guests_count' => $data['guests_count'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
            'deposit_total' => $depositTotal,
            'cancelled' => false,
        ]);

        return response()->json([
            'id' => $reservation->id,
            'deposit_total' => $depositTotal,
        ], 201);
    }

    public function userIndex()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Для просмотра бронирований необходимо войти в систему');
        }
        $reservations = TableReservation::with('table')
            ->where('user_id', Auth::id())
            ->orderBy('start_at', 'desc')
            ->paginate(10);
        return view('reservation.table-index', compact('reservations'));
    }
}