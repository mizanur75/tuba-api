@extends('layouts.app')

@section('title','Edit Step')

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Step</h4>
            </div>
            <form method="POST" action="{{ route('steps.update', $step->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                  {!! multi_errors($errors) !!}
                  {!! success() !!}

                  <!-- Title -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Title <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-9">
                          <input type="text" class="form-control" name="title" value="{{ old('title', $step->title) }}" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Description <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-9">
                          <textarea class="form-control" name="description" required>{{ old('description', $step->description) }}</textarea>
                      </div>
                  </div>

                  <!-- Status -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Status <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="active" name="status" value="1" {{ old('status', $step->status) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Active</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="deactive" name="status" value="0" {{ old('status', $step->status) == 0 ? 'checked' : '' }}>
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

