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
                <th>Package Name</th>
                <th>Patient Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
                <th>Comments</th>
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
            ajax: "{{ route('appointments.data') }}",
            columns: [
                { data: 'package_id', name: 'package_id' },
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'date', name: 'date' },
                { data: 'time', name: 'time' },
                { data: 'status_badge', name: 'status', orderable: false, searchable: false },
                { data: 'action', orderable: false, searchable: false },
                { data: 'comments', name: 'comments' }
            ]
        });
    });
</script>
@endpush
