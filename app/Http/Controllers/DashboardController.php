<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use App\Models\Appointment;
use App\Models\History;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $rangeStart = $today->copy()->subDays(6)->startOfDay();
        $rangeEnd = $today->copy()->endOfDay();

        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 0)->count();
        $processedAppointments = Appointment::where('status', 1)->count();

        $totalPrescriptions = History::count();
        $todayAppointments = Appointment::whereDate('created_at', $today)->count();
        $todayPrescriptions = History::whereDate('created_at', $today)->count();
        $scheduledToday = Appointment::where('date', $today->toDateString())->count();

        $activePackages = Package::where('status', 1)->count();
        $activeAdvices = Advice::where('status', 1)->count();

        $totalPractitioners = User::count();
        $doctorCount = User::where('practitioner_type', 'doctor')->count();
        $hypnotherapistCount = User::where('practitioner_type', 'hypnotherapist')->count();

        $completionRate = $totalAppointments > 0
            ? round(($totalPrescriptions / $totalAppointments) * 100, 1)
            : 0;

        $pendingRate = $totalAppointments > 0
            ? round(($pendingAppointments / $totalAppointments) * 100, 1)
            : 0;

        $dayKeys = collect(range(6, 0))->map(function ($offset) use ($today) {
            return $today->copy()->subDays($offset)->toDateString();
        });

        $dayLabels = $dayKeys->map(function ($day) {
            return Carbon::parse($day)->format('d M');
        })->values();

        $appointmentCounts = Appointment::selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->whereBetween('created_at', [$rangeStart, $rangeEnd])
            ->groupBy('day')
            ->pluck('total', 'day');

        $prescriptionCounts = History::selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->whereBetween('created_at', [$rangeStart, $rangeEnd])
            ->groupBy('day')
            ->pluck('total', 'day');

        $appointmentSeries = $dayKeys->map(function ($day) use ($appointmentCounts) {
            return (int) ($appointmentCounts[$day] ?? 0);
        })->values();

        $prescriptionSeries = $dayKeys->map(function ($day) use ($prescriptionCounts) {
            return (int) ($prescriptionCounts[$day] ?? 0);
        })->values();

        $packagePerformance = Appointment::select('package_id', DB::raw('COUNT(*) as total'))
            ->with('package:id,name')
            ->groupBy('package_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($row) use ($totalAppointments) {
                $share = $totalAppointments > 0
                    ? round(($row->total / $totalAppointments) * 100, 1)
                    : 0;

                return [
                    'name' => $row->package->name ?? 'Unknown Package',
                    'total' => (int) $row->total,
                    'share' => $share,
                ];
            });

        $recentAppointments = Appointment::with('package:id,name')
            ->latest()
            ->limit(6)
            ->get();

        $recentPrescriptions = History::with(['package:id,name', 'practitioner:id,name,practitioner_type'])
            ->latest()
            ->limit(6)
            ->get();

        return view('dashboard', [
            'totalAppointments' => $totalAppointments,
            'pendingAppointments' => $pendingAppointments,
            'processedAppointments' => $processedAppointments,
            'totalPrescriptions' => $totalPrescriptions,
            'todayAppointments' => $todayAppointments,
            'todayPrescriptions' => $todayPrescriptions,
            'scheduledToday' => $scheduledToday,
            'activePackages' => $activePackages,
            'activeAdvices' => $activeAdvices,
            'totalPractitioners' => $totalPractitioners,
            'doctorCount' => $doctorCount,
            'hypnotherapistCount' => $hypnotherapistCount,
            'completionRate' => $completionRate,
            'pendingRate' => $pendingRate,
            'dayLabels' => $dayLabels,
            'appointmentSeries' => $appointmentSeries,
            'prescriptionSeries' => $prescriptionSeries,
            'packagePerformance' => $packagePerformance,
            'recentAppointments' => $recentAppointments,
            'recentPrescriptions' => $recentPrescriptions,
        ]);
    }
}
