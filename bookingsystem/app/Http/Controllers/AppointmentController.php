<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with('customer');

        if ($request->filled('date')) {
            $query->where('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(20);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $customers = Customer::all();
        $today = date('Y-m-d');
        $now = date('H:i');
        return view('appointments.create', compact('customers', 'today', 'now'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
        ]);

        $appointmentDate = $validated['appointment_date'];
        $appointmentTime = $validated['appointment_time'];
        $requestedDatetime = strtotime("{$appointmentDate} {$appointmentTime}");

        if ($requestedDatetime < time()) {
            return back()->withInput()->with('error', 'Không thể đặt lịch trong quá khứ.');
        }

        $conflict = Appointment::where('appointment_date', $appointmentDate)
            ->where('appointment_time', $appointmentTime)
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'Khung giờ này đã có người đặt.');
        }

        $customer = Customer::firstOrCreate(
            ['name' => $validated['customer_name']],
            ['phone' => $validated['customer_phone']]
        );

        Appointment::create([
            'customer_id' => $customer->id,
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
        ]);

        return redirect('/appointments')->with('success', 'Đặt lịch thành công.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect('/appointments')->with('success', 'Hủy lịch thành công.');
    }
}
