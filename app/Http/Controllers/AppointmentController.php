<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AppointmentController extends Controller
{
    public function data(Request $request)
    {
        $query = Appointment::with('package')
            ->orderBy('id', 'DESC')
            ->orderByRaw('status = 0 DESC');

        return DataTables::of($query)

            ->editColumn('package_id', function ($row) {
                return $row->package->name ?? "No Package";
            })

            ->addColumn('status_badge', function ($row) {
                return $row->status == 0
                    ? '<span class="badge bg-warning">Pending</span>'
                    : '<span class="badge bg-success">Active</span>';
            })

            ->addColumn('action', function ($row) {
                return '
                <a href="' . route('appointments.edit', $row->id) . '" 
                   class="btn btn-sm btn-info">
                   <i class="fas fa-pencil"></i>
                </a>
            ';
            })
            ->filterColumn('package_id', function ($query, $keyword) {
                $query->whereHas('package', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
    public function index()
    {
        $appointments = Appointment::orderBy('id', 'DESC')->orderByRaw('status = 0 DESC')->get();
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}