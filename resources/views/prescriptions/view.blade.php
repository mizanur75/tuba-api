@extends('layouts.app')

@section('title', 'View Prescription')

@section('body')
@php
    $complaints = json_decode($history->chief_complaint, true) ?: [];
    $practitioner = $history->practitioner;
    $isDoctorPrescription = ($history->practitioner_type ?? 'doctor') === 'doctor';
    $decodedAdvice = json_decode($history->advice ?? '', true);
    $adviceList = is_array($decodedAdvice) ? $decodedAdvice : (filled($history->advice) ? [$history->advice] : []);
@endphp

<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h4 class="mb-0">Prescription Details</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('prescriptions.edit', $history->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('prescription.print', $history->id) }}" target="_blank" class="btn btn-success">
                <i class="fas fa-print"></i> Print
            </a>
            <a href="{{ route('prescriptions.all') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Patient Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Name:</strong> {{ $history->patient_name }}</p>
                    <p class="mb-2"><strong>Phone:</strong> {{ $history->phone ?: '-' }}</p>
                    <p class="mb-2"><strong>Age:</strong> {{ $history->age ?: '-' }}</p>
                    <p class="mb-2"><strong>Sex:</strong> {{ $history->sex ?: '-' }}</p>
                    <p class="mb-0"><strong>Address:</strong> {{ $history->address ?: '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Practitioner Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Name:</strong> {{ $practitioner->name ?? '-' }}</p>
                    <p class="mb-2"><strong>Type:</strong> {{ ucfirst($history->practitioner_type ?? 'doctor') }}</p>
                    <p class="mb-2"><strong>Qualification:</strong> {{ $practitioner?->qualification ?: '-' }}</p>
                    <p class="mb-2"><strong>Specialization:</strong> {{ $practitioner?->specialization ?: '-' }}</p>
                    <p class="mb-2"><strong>Registration No:</strong> {{ $practitioner?->registration_no ?: '-' }}</p>
                    <p class="mb-0"><strong>Phone:</strong> {{ $practitioner?->phone ?: '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Clinical Notes</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Package:</strong> {{ $history->package->name ?? '-' }}</p>
                    <p class="mb-2"><strong>Chief Complaint:</strong> {{ count($complaints) ? implode(', ', $complaints) : '-' }}</p>
                    <p class="mb-2"><strong>Diagnosis:</strong> {{ $history->diagnosis ?: '-' }}</p>
                    <p class="mb-0"><strong>Advice:</strong> {{ count($adviceList) ? implode(', ', $adviceList) : '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($isDoctorPrescription)
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Rx Medicines</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 45%;">Medicine</th>
                                <th style="width: 25%;">Dose</th>
                                <th style="width: 25%;">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history->prescriptions as $medicine)
                                <tr>
                                    <td>{{ $medicine->medicine_name }}</td>
                                    <td>{{ $medicine->dose ?: '-' }}</td>
                                    <td>{{ $medicine->duration ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No medicines added.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
