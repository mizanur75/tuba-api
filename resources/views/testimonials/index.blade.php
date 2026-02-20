@extends('layouts.app')

@section('title','Testimonials')

@section('body')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Step</h4>
            </div>
            <form method="POST" action="{{ route('testimonials.store') }}" enctype="multipart/form-data">
              @csrf

              <div class="card-body">
                  {!! multi_errors($errors) !!}
                  {!! success() !!}

                  <!-- Title -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Name <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-9">
                          <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Quote <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-9">
                          <textarea class="form-control" name="quotes" value="{{ old('quotes') }}" required></textarea>
                      </div>
                  </div>

                  <!-- Status -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Status <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="active" name="status" value="1">
                              <label class="form-check-label" for="active">Active</label>
                          </div>

                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="deactive" name="status" value="0">
                              <label class="form-check-label" for="deactive">Inactive</label>
                          </div>
                      </div>
                  </div>

              </div>

              <div class="card-action">
                  <button class="btn btn-success" type="submit">Save</button>
              </div>
          </form>

        </div>
    </div>
</div>

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
                <th>Name</th>
                <th>Quote</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($testimonials as $d)
                <tr>
                    <td>{{$d->name}}</td>
                    <td>{{$d->quotes}}</td>
                    <td>{{$d->status == 0 ? 'Deactive':'Active'}}</td>
                    <td>
                        <a class="btn btn-padding btn-sm btn-info" href="{{route('testimonials.edit', $d->id)}}">Edit</a> 
                        {{-- <form action="{{route('testimonials.destroy', $d->id)}}" method="post"
                            style="display: inline;"
                            onsubmit="return confirm('Are you Sure? Want to delete')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-padding btn-sm btn-danger" type="submit"> Delete </button>
                        </form> --}}
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $("#basic-datatables").DataTable({});
</script>
@endpush
