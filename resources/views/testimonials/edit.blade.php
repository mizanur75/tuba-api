@extends('layouts.app')

@section('title','Edit Testimonial')

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Testimonial</h4>
            </div>
            <form method="POST" action="{{ route('testimonials.update', $testimonial->id) }}" enctype="multipart/form-data">
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
                      <div class="col-lg-9">
                          <input type="text" class="form-control" name="name" value="{{ old('name', $testimonial->name) }}" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Quote <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-9">
                          <textarea class="form-control" name="quotes" required>{{ old('quotes', $testimonial->quotes) }}</textarea>
                      </div>
                  </div>

                  <!-- Status -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Status <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="active" name="status" value="1" {{ old('status', $testimonial->status) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Active</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="deactive" name="status" value="0" {{ old('status', $testimonial->status) == 0 ? 'checked' : '' }}>
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

