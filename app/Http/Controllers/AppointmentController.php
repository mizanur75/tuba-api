<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Advice;
use App\Models\ChiefComplaint;
use App\Models\History;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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
            // ->filterColumn('package_id', function ($query, $keyword) {
            //     $query->whereHas('package', function ($q) use ($keyword) {
            //         $q->where('name', 'like', "%{$keyword}%");
            //     });
            // })

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
                    return '
                    <a href="' . route('prescriptions.view', $row->id) . '"
                       class="btn btn-sm btn-info" title="View Prescription">
                       <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . route('prescriptions.edit', $row->id) . '"
                       class="btn btn-sm btn-primary" title="Edit Prescription">
                       <i class="fas fa-edit"></i>
                    </a>
                    <a href="' . route('prescription.print', $row->id) . '"
                       target="_blank"
                       class="btn btn-sm btn-success" title="Print Prescription">
                       <i class="fas fa-print"></i>
                    </a>
                ';
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
        $user = Auth::user();
        $practitionerType = $user?->practitioner_type === 'hypnotherapist' ? 'hypnotherapist' : 'doctor';

        $request->validate([
            'appointment_id' => 'required|integer',
            'package_id' => 'required|integer',
            'patient_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'age' => 'nullable|string|max:50',
            'sex' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'chief_complaint' => 'nullable|array',
            'chief_complaint.*' => 'nullable|string|max:255',
            'diagnosis' => 'nullable|string',
            'advice' => 'required|array|min:1',
            'advice.*' => [
                'required',
                'string',
                'distinct',
                Rule::exists('advices', 'content')->where(function ($query) {
                    $query->where('status', 1);
                }),
            ],
            'medicine_name' => 'nullable|array',
            'medicine_name.*' => 'nullable|string|max:255',
            'dose' => 'nullable|array',
            'dose.*' => 'nullable|string|max:255',
            'duration' => 'nullable|array',
            'duration.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            // ✅ Clean input (remove empty)
            $complaints = array_filter($request->chief_complaint ?? []);

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

            $selectedAdvices = collect($request->advice ?? [])
                ->map(function ($item) {
                    return trim((string) $item);
                })
                ->filter()
                ->unique()
                ->values()
                ->all();

            // ✅ Save History
            $history = History::create([
                'package_id' => $request->package_id,
                'appointment_id' => $request->appointment_id,
                'practitioner_user_id' => $user?->id,
                'practitioner_type' => $practitionerType,
                'patient_name' => $request->patient_name,
                'sex' => $request->sex,
                'age' => $request->age,
                'address' => $request->address,
                'phone' => $request->phone,
                'chief_complaint' => json_encode(array_values($finalComplaints)),
                'diagnosis' => $request->diagnosis,
                'advice' => json_encode($selectedAdvices),
                'status' => 1,
            ]);

            // ✅ Save medicines only for doctor role.
            if ($practitionerType === 'doctor' && $request->medicine_name) {
                foreach ($request->medicine_name as $key => $medicine) {

                    if (!$medicine) {
                        continue;
                    }

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

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function print($id)
    {
        $history = History::with(['prescriptions', 'practitioner'])->findOrFail($id);
        return view('prescriptions.print', compact('history'));
    }

    public function viewPrescription(History $history)
    {
        $history->load(['package', 'prescriptions', 'practitioner']);

        return view('prescriptions.view', compact('history'));
    }

    public function editPrescription(History $history)
    {
        $history->load(['package', 'prescriptions', 'practitioner']);

        $advices = Advice::where('status', 1)
            ->orderBy('id', 'DESC')
            ->get();

        return view('prescriptions.edit', compact('history', 'advices'));
    }

    public function updatePrescription(Request $request, History $history)
    {
        $user = Auth::user();
        $practitionerType = $user?->practitioner_type === 'hypnotherapist' ? 'hypnotherapist' : 'doctor';

        $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'age' => 'nullable|string|max:50',
            'sex' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'chief_complaint' => 'nullable|array',
            'chief_complaint.*' => 'nullable|string|max:255',
            'diagnosis' => 'nullable|string',
            'advice' => 'required|array|min:1',
            'advice.*' => [
                'required',
                'string',
                'distinct',
                Rule::exists('advices', 'content')->where(function ($query) {
                    $query->where('status', 1);
                }),
            ],
            'medicine_name' => 'nullable|array',
            'medicine_name.*' => 'nullable|string|max:255',
            'dose' => 'nullable|array',
            'dose.*' => 'nullable|string|max:255',
            'duration' => 'nullable|array',
            'duration.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $complaints = array_filter($request->chief_complaint ?? []);
            $finalComplaints = [];

            foreach ($complaints as $name) {
                $name = trim($name);

                if (!$name) {
                    continue;
                }

                ChiefComplaint::firstOrCreate([
                    'name' => $name,
                ]);

                $finalComplaints[] = $name;
            }

            $selectedAdvices = collect($request->advice ?? [])
                ->map(function ($item) {
                    return trim((string) $item);
                })
                ->filter()
                ->unique()
                ->values()
                ->all();

            $history->update([
                'practitioner_user_id' => $user?->id,
                'practitioner_type' => $practitionerType,
                'patient_name' => $request->patient_name,
                'phone' => $request->phone,
                'age' => $request->age,
                'sex' => $request->sex,
                'address' => $request->address,
                'chief_complaint' => json_encode(array_values($finalComplaints)),
                'diagnosis' => $request->diagnosis,
                'advice' => json_encode($selectedAdvices),
            ]);

            $history->prescriptions()->delete();

            if ($practitionerType === 'doctor' && $request->medicine_name) {
                foreach ($request->medicine_name as $key => $medicine) {
                    $medicine = trim((string) $medicine);

                    if (!$medicine) {
                        continue;
                    }

                    Prescription::create([
                        'history_id' => $history->id,
                        'medicine_name' => $medicine,
                        'dose' => $request->dose[$key] ?? null,
                        'duration' => $request->duration[$key] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('prescriptions.all')
                ->with('success', 'Prescription updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $advices = Advice::where('status', 1)
            ->orderBy('id', 'DESC')
            ->get();

        return view('prescriptions.create', compact('appointment', 'advices'));
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
