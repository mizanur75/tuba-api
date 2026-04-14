@extends('layouts.app')

@section('title','Appointments')

@section('body')    

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">All Step</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            id="basic-datatables"
            class="display table table-striped table-hover"
          >
            <thead>
                <tr>
                    <th>Package</th>
                    <th>Patient Name</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Chief Complaint</th>
                    <th>Diagnosis</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#basic-datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('prescriptions.all') }}", // ✅ FIXED

            columns: [
                { data: 'package_id', name: 'package_id' },
                { data: 'patient_name', name: 'patient_name' },
                { data: 'sex', name: 'sex' },
                { data: 'age', name: 'age' },
                { data: 'phone', name: 'phone' },
                { data: 'chief_complaint', name: 'chief_complaint' },
                { data: 'diagnosis', name: 'diagnosis' },
                { data: 'status_badge', orderable: false, searchable: false },
                { data: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
