<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ChiefComplaint;
use App\Models\History;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AppointmentController extends Controller
{
    public function data(Request $request)
    {
        $query = Appointment::with('package')
            ->where('status', 0)
            ->orderByRaw("date = ? DESC", [Carbon::today()->toDateString()])
            ->orderBy('date', 'ASC')
            ->orderBy('time', 'ASC')
            ->get();

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

                if ($row->status == 0) {
                    return '
                        <a href="' . route('appointments.show', $row->id) . '" 
                        class="btn btn-sm btn-primary" title="Create Prescription">
                        <i class="fas fa-notes-medical"></i>
                        </a>
                    ';
                } else {
                    return '
                        <a href="' . route('prescription.print', $row->id) . '" 
                        target="_blank"
                        class="btn btn-sm btn-success" title="Print Prescription">
                        <i class="fas fa-print"></i>
                        </a>
                    ';
                }
            })
            ->filterColumn('package_id', function ($query, $keyword) {
                $query->whereHas('package', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
    public function prescriptions(Request $request)
    {
        if ($request->ajax()) {
            $query = History::with('package') // ✅ eager load
                ->where('status', 1)
                ->orderBy('id', 'DESC');

            return DataTables::of($query)

                ->editColumn('package_id', function ($row) {
                    return $row->package->name ?? "No Package";
                })

                ->addColumn('status_badge', function ($row) {
                    return $row->status == 0
                        ? '<span class="badge bg-warning">Pending</span>'
                        : '<span class="badge bg-success">Completed</span>';
                })

                ->addColumn('action', function ($row) {

                    if ($row->status == 0) {
                        return '
                    <a href="' . route('appointments.show', $row->appointment_id) . '" 
                       class="btn btn-sm btn-primary" title="Create Prescription">
                       <i class="fas fa-notes-medical"></i>
                    </a>
                ';
                    } else {
                        return '
                    <a href="' . route('prescription.print', $row->id) . '" 
                       target="_blank"
                       class="btn btn-sm btn-success" title="Print Prescription">
                       <i class="fas fa-print"></i>
                    </a>
                ';
                    }
                })
                ->editColumn('chief_complaint', function ($row) {
                    $complaints = json_decode($row->chief_complaint, true);
                    return implode(', ', $complaints ?? []);
                })

                ->filterColumn('package_id', function ($query, $keyword) {
                    $query->whereHas('package', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })

                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }


        return view('prescriptions.all');
    }
    public function index()
    {
        return view('appointments.index');
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


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // ✅ Clean input (remove empty)
            $complaints = array_filter($request->chief_complaint);

            $finalComplaints = [];

            foreach ($complaints as $name) {

                $name = trim($name);

                if (!$name) continue;

                // ✅ Check if exists
                $exists = ChiefComplaint::where('name', $name)->first();

                if (!$exists) {
                    // ✅ Insert if not exists
                    ChiefComplaint::create([
                        'name' => $name
                    ]);
                }

                // ✅ Keep for history JSON
                $finalComplaints[] = $name;
            }

            // ✅ Save History
            $history = History::create([
                'package_id' => $request->package_id,
                'appointment_id' => $request->appointment_id,
                'patient_name' => $request->patient_name,
                'sex' => $request->sex,
                'age' => $request->age,
                'address' => $request->address,
                'phone' => $request->phone,
                'chief_complaint' => json_encode(array_values($finalComplaints)),
                'diagnosis' => $request->diagnosis,
                'advice' => $request->advice,
                'status' => 1,
            ]);

            // ✅ Save Medicines
            if ($request->medicine_name) {
                foreach ($request->medicine_name as $key => $medicine) {

                    if (!$medicine) continue;

                    \App\Models\Prescription::create([
                        'history_id' => $history->id,
                        'medicine_name' => $medicine,
                        'dose' => $request->dose[$key] ?? null,
                        'duration' => $request->duration[$key] ?? null,
                    ]);
                }
            }

            Appointment::where('id', $request->appointment_id)
                ->update(['status' => 1]);

            DB::commit();

            return redirect()->route('appointments.index')
                ->with('success', 'Prescription Saved Successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function print($id)
    {
        $history = History::with('prescriptions')->findOrFail($id);
        return view('prescriptions.print', compact('history'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return view('prescriptions.create', compact('appointment'));
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

    public function searchComplaint(Request $request)
    {
        $term = strtolower($request->q);

        $data = \App\Models\ChiefComplaint::whereRaw('LOWER(name) LIKE ?', ["%{$term}%"])
            ->orderBy('name', 'ASC')
            ->limit(10)
            ->pluck('name');

        return response()->json($data);
    }
}
