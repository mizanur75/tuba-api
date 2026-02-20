@extends('layouts.app')

@section('title','Edit Package')

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Package</h4>
            </div>
            <form method="POST" action="{{ route('packages.update', $package->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                  {!! multi_errors($errors) !!}
                  {!! success() !!}

                  <!-- Title -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Name <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                          <input type="text" class="form-control" name="name" value="{{ old('name', $package->name) }}" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Description <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                          <textarea class="form-control" name="description" required>{{ old('description', $package->description) }}</textarea>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Price <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                          <input type="text" class="form-control" name="price" value="{{ old('price', $package->price) }}" required>
                      </div>
                  </div>

                  <!-- Status -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Status <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="active" name="status" value="1" {{ old('status', $package->status) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Active</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="deactive" name="status" value="0" {{ old('status', $package->status) == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="deactive">Inactive</label>
                            </div>
                      </div>
                  </div>

              </div>

                <div class="card-action">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $("#basic-datatables").DataTable({});
</script>
@endpush

