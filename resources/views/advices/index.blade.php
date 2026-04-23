@extends('layouts.app')

@section('title','Advices')

@section('body')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Advice</h4>
            </div>
            <form method="POST" action="{{ route('advices.store') }}">
                @csrf

                <div class="card-body">
                    {!! multi_errors($errors) !!}
                    {!! success() !!}

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">
                            Advice <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="content" rows="4" required>{{ old('content') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-lg-3 text-end">
                            Status <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="active" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Active</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="deactive" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
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
        <h4 class="card-title">All Advice</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            id="basic-datatables"
            class="display table table-striped table-hover"
          >
            <thead>
              <tr>
                <th>SL</th>
                <th>Advice</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($advices as $key => $d)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $d->content }}</td>
                    <td>{{ $d->status == 0 ? 'Inactive':'Active' }}</td>
                    <td>
                        <a class="btn btn-padding btn-sm btn-info" href="{{ route('advices.edit', $d->id) }}">Edit</a>
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
