@extends('layouts.app')

@section('title','Create Prescription')

@section('body')

<div class="container-fluid">
    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <input type="hidden" value="{{$appointment->id}}" name="appointment_id">
        <input type="hidden" value="{{$appointment->package_id}}" name="package_id">

        <div class="row">

            <!-- LEFT SIDE -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5>Patient Info</h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label>Patient Name</label>
                            <input type="text" value="{{$appointment->name}}" name="patient_name" class="form-control">
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label>Phone</label>
                                <input type="text" value="{{$appointment->phone}}" name="phone" class="form-control">
                            </div>

                            <div class="col-3">
                                <label>Age</label>
                                <input type="text" value="{{$appointment->age}}" name="age" class="form-control">
                            </div>
                            <div class="col-3">
                                <label>Sex</label>
                                <input type="text" value="{{$appointment->sex}}" name="sex" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" value="{{$appointment->address}}" name="address" class="form-control">
                        </div>

                        <!-- Chief Complaint -->
                        <div class="mb-3 position-relative">
                            <label>Chief Complaints</label>

                            <div id="complaint-wrapper">
                                <div class="complaint-group position-relative mb-2">
                                    <input type="text" name="chief_complaint[]" class="form-control complaint-input">
                                </div>
                            </div>

                            <button type="button" id="add-complaint" class="btn btn-sm btn-primary mt-2">
                                + Add Complaint
                            </button>
                        </div>

                        <div class="mb-3">
                            <label>Diagnosis</label>
                            <textarea name="diagnosis" rows="4" class="form-control"></textarea>
                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5>Medicine Advice</h5>
                    </div>

                    <div class="card-body">

                        <div id="medicine-wrapper">

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
                                    <button type="button" class="btn btn-danger remove-row">X</button>
                                </div>
                            </div>

                        </div>

                        <button type="button" id="add-medicine" class="btn btn-primary mt-2">
                            + Add Medicine
                        </button>

                        <div class="mt-3">
                            <label>Advice</label>
                            <textarea name="advice" rows="3" class="form-control"></textarea>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="text-center mt-4">
            <button class="btn btn-lg btn-success">Save Prescription</button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function(){

    // ===============================
    // ADD MEDICINE
    // ===============================
    $('#add-medicine').click(function(){
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
                    <button type="button" class="btn btn-danger remove-row">X</button>
                </div>
            </div>
        `);
    });

    $(document).on('click', '.remove-row', function(){
        $(this).closest('.medicine-row').remove();
    });

    // ===============================
    // ADD COMPLAINT FIELD
    // ===============================
    $('#add-complaint').click(function(){
        $('#complaint-wrapper').append(`
            <div class="complaint-group position-relative mb-2">
                <input type="text" name="chief_complaint[]" class="form-control complaint-input">
            </div>
        `);
    });

    // ===============================
    // AUTOCOMPLETE
    // ===============================
    $(document).on('keyup', '.complaint-input', function(){

        let input = $(this);
        let query = input.val();

        if(query.length < 2){
            input.closest('.complaint-group').find('.suggestion-box').remove();
            return;
        }

        $.ajax({
            url: "{{ url('chief-complaints/search') }}",
            data: { q: query },
            success: function(data){

                let list = `<ul class="list-group suggestion-box" 
                                style="position:absolute; width:100%; z-index:999;">`;

                data.forEach(item => {
                    list += `<li class="list-group-item suggestion-item">${item}</li>`;
                });

                list += `</ul>`;

                input.closest('.complaint-group').find('.suggestion-box').remove();
                input.after(list);
            }
        });

    });

    // ===============================
    // SELECT SUGGESTION
    // ===============================
    $(document).on('click', '.suggestion-item', function(){
        let value = $(this).text();
        let box = $(this).closest('.complaint-group');

        box.find('input').val(value);
        box.find('.suggestion-box').remove();
    });

    // ===============================
    // CLICK OUTSIDE CLOSE
    // ===============================
    $(document).click(function(e){
        if(!$(e.target).closest('.complaint-group').length){
            $('.suggestion-box').remove();
        }
    });

});
</script>
@endpush