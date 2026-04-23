@extends('layouts.app')

@section('title', 'Edit Prescription')

@section('body')
@php
    $isHypnotherapist = (auth()->user()?->practitioner_type ?? 'doctor') === 'hypnotherapist';
    $activeAdvices = $advices ?? collect();
    $storedAdvice = $history->advice;
    $decodedAdvice = json_decode($storedAdvice, true);
    $historyAdvices = is_array($decodedAdvice) ? $decodedAdvice : (filled($storedAdvice) ? [$storedAdvice] : []);
    $selectedAdvices = old('advice', $historyAdvices);

    if (!is_array($selectedAdvices)) {
        $selectedAdvices = [$selectedAdvices];
    }

    $selectedAdvices = array_values(array_filter($selectedAdvices, function ($value) {
        return filled($value);
    }));

    $selectedAdviceValues = collect($selectedAdvices);
    $legacySelectedAdvices = $selectedAdviceValues->filter(function ($value) use ($activeAdvices) {
        return !$activeAdvices->contains(function ($item) use ($value) {
            return $item->content === $value;
        });
    });

    $oldComplaints = old('chief_complaint');
    $complaints = is_array($oldComplaints) ? $oldComplaints : (json_decode($history->chief_complaint, true) ?: []);

    if (count($complaints) === 0) {
        $complaints = [''];
    }

    $rows = [];

    if (is_array(old('medicine_name'))) {
        $oldMedicineNames = old('medicine_name', []);
        $oldDoses = old('dose', []);
        $oldDurations = old('duration', []);

        foreach ($oldMedicineNames as $index => $medicineName) {
            $rows[] = [
                'medicine_name' => $medicineName,
                'dose' => $oldDoses[$index] ?? '',
                'duration' => $oldDurations[$index] ?? '',
            ];
        }
    } elseif ($history->prescriptions->count()) {
        foreach ($history->prescriptions as $item) {
            $rows[] = [
                'medicine_name' => $item->medicine_name,
                'dose' => $item->dose,
                'duration' => $item->duration,
            ];
        }
    }

    if (count($rows) === 0) {
        $rows[] = [
            'medicine_name' => '',
            'dose' => '',
            'duration' => '',
        ];
    }
@endphp

<div class="container-fluid">
    <div class="alert alert-info">
        Practitioner Type: <strong>{{ $isHypnotherapist ? 'Hypnotherapist' : 'Doctor' }}</strong>
    </div>

    @if($activeAdvices->isEmpty())
        <div class="alert alert-warning">
            No active advice found. Please add advice from the <strong>Advices</strong> menu before updating this prescription.
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('prescriptions.update', $history->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h4 class="mb-0">Edit Prescription</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('prescriptions.view', $history->id) }}" class="btn btn-info text-white">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="{{ route('prescriptions.all') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Patient Info</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label>Patient Name</label>
                            <input type="text" name="patient_name" class="form-control" value="{{ old('patient_name', $history->patient_name) }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $history->phone) }}">
                            </div>

                            <div class="col-3">
                                <label>Age</label>
                                <input type="text" name="age" class="form-control" value="{{ old('age', $history->age) }}">
                            </div>
                            <div class="col-3">
                                <label>Sex</label>
                                <input type="text" name="sex" class="form-control" value="{{ old('sex', $history->sex) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $history->address) }}">
                        </div>

                        <div class="mb-3 position-relative">
                            <label>Chief Complaints</label>

                            <div id="complaint-wrapper">
                                @foreach ($complaints as $complaint)
                                    <div class="complaint-group position-relative mb-2">
                                        <div class="input-group">
                                            <input type="text" name="chief_complaint[]" class="form-control complaint-input" value="{{ $complaint }}">
                                            <button type="button" class="btn btn-outline-danger remove-complaint-row">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-complaint" class="btn btn-sm btn-primary mt-2">
                                + Add Complaint
                            </button>
                        </div>

                        <div class="mb-3">
                            <label>Diagnosis</label>
                            <textarea name="diagnosis" rows="4" class="form-control">{{ old('diagnosis', $history->diagnosis) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    @if($isHypnotherapist)
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Therapy Advice</h5>
                        </div>

                        <div class="card-body">
                            <div class="mt-1">
                                <label>Advice</label>
                                <select name="advice[]" class="form-select" multiple size="6" required>
                                    @foreach($legacySelectedAdvices as $legacyAdvice)
                                        <option value="{{ $legacyAdvice }}" selected>{{ $legacyAdvice }} (current value)</option>
                                    @endforeach
                                    @foreach($activeAdvices as $adviceOption)
                                        <option value="{{ $adviceOption->content }}" {{ $selectedAdviceValues->contains($adviceOption->content) ? 'selected' : '' }}>
                                            {{ $adviceOption->content }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Use Ctrl (Windows) to select multiple advice items.</small>
                            </div>
                        </div>
                    @else
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Rx and Advice</h5>
                        </div>

                        <div class="card-body">
                            <div id="medicine-wrapper">
                                @foreach ($rows as $row)
                                    <div class="medicine-row row mb-2">
                                        <div class="col-md-4">
                                            <input type="text" name="medicine_name[]" class="form-control" placeholder="Medicine" value="{{ $row['medicine_name'] }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input type="text" name="dose[]" class="form-control" placeholder="Dose" value="{{ $row['dose'] }}">
                                        </div>

                                        <div class="col-md-3">
                                            <input type="text" name="duration[]" class="form-control" placeholder="Days" value="{{ $row['duration'] }}">
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-row">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-medicine" class="btn btn-primary mt-2">
                                + Add Medicine
                            </button>

                            <div class="mt-3">
                                <label>Advice</label>
                                <select name="advice[]" class="form-select" multiple size="6" required>
                                    @foreach($legacySelectedAdvices as $legacyAdvice)
                                        <option value="{{ $legacyAdvice }}" selected>{{ $legacyAdvice }} (current value)</option>
                                    @endforeach
                                    @foreach($activeAdvices as $adviceOption)
                                        <option value="{{ $adviceOption->content }}" {{ $selectedAdviceValues->contains($adviceOption->content) ? 'selected' : '' }}>
                                            {{ $adviceOption->content }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Use Ctrl (Windows) to select multiple advice items.</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-lg btn-success" {{ $activeAdvices->isEmpty() ? 'disabled' : '' }}>Update Prescription</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    @if(!$isHypnotherapist)
        $('#add-medicine').click(function () {
            $('#medicine-wrapper').append(`
                <div class="medicine-row row mb-2">
                    <div class="col-md-4">
                        <input type="text" name="medicine_name[]" class="form-control" placeholder="Medicine">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="dose[]" class="form-control" placeholder="Dose">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="duration[]" class="form-control" placeholder="Days">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm w-100 remove-row">Remove</button>
                    </div>
                </div>
            `);
        });

        $(document).on('click', '.remove-row', function () {
            $(this).closest('.medicine-row').remove();
        });
    @endif

    $('#add-complaint').click(function () {
        $('#complaint-wrapper').append(`
            <div class="complaint-group position-relative mb-2">
                <div class="input-group">
                    <input type="text" name="chief_complaint[]" class="form-control complaint-input">
                    <button type="button" class="btn btn-outline-danger remove-complaint-row">Remove</button>
                </div>
            </div>
        `);
    });

    $(document).on('click', '.remove-complaint-row', function () {
        let groups = $('#complaint-wrapper .complaint-group');
        if (groups.length > 1) {
            $(this).closest('.complaint-group').remove();
            return;
        }

        $(this).closest('.complaint-group').find('input').val('');
        $(this).closest('.complaint-group').find('.suggestion-box').remove();
    });

    $(document).on('keyup', '.complaint-input', function () {
        let input = $(this);
        let query = input.val();

        if (query.length < 2) {
            input.closest('.complaint-group').find('.suggestion-box').remove();
            return;
        }

        $.ajax({
            url: "{{ url('chief-complaints/search') }}",
            data: { q: query },
            success: function (data) {
                let list = `<ul class="list-group suggestion-box" style="position:absolute; width:100%; z-index:999;">`;

                data.forEach(item => {
                    list += `<li class="list-group-item suggestion-item">${item}</li>`;
                });

                list += `</ul>`;

                input.closest('.complaint-group').find('.suggestion-box').remove();
                input.closest('.complaint-group').append(list);
            }
        });
    });

    $(document).on('click', '.suggestion-item', function () {
        let value = $(this).text();
        let box = $(this).closest('.complaint-group');

        box.find('input').val(value);
        box.find('.suggestion-box').remove();
    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.complaint-group').length) {
            $('.suggestion-box').remove();
        }
    });
});
</script>
@endpush
