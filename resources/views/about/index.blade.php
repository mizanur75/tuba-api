@extends('layouts.app')

@section('title','About')

@section('body')

@if(empty($about))
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add About</h4>
            </div>
            <form method="POST" action="{{ route('about.store') }}" enctype="multipart/form-data">
              @csrf

              <div class="card-body">
                  {!! multi_errors($errors) !!}
                  {!! success() !!}
                    <h5 class="mb-3">Portion 1</h5>
                  <!-- Title -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Title <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-9">
                          <input type="text" class="form-control" name="title1" value="{{ old('title1') }}" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Description <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-9">
                          <textarea class="form-control" name="description1" value="{{ old('description1') }}" required></textarea>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Image <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                          <input type="file" class="form-control" name="image1" value="{{ old('image1') }}" required>
                      </div>
                  </div>

                  <h5 class="mb-3">Portion 2</h5>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Title <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-9">
                          <input type="text" class="form-control" name="title2" value="{{ old('title2') }}" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Description <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-9">
                          <textarea class="form-control" name="description2" value="{{ old('description2') }}" required></textarea>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Image <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                          <input type="file" class="form-control" name="image2" value="{{ old('image2') }}" required>
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
@endif

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">About</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            id="basic-datatables"
            class="display table table-striped table-hover"
          >
            <thead>
              <tr>
                <th>Title (1)</th>
                <th>Description (1)</th>
                <th>Image (1)</th>
                <th>Title (2)</th>
                <th>Description (2)</th>
                <th>Image (2)</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($about as $d)
                <tr>
                    <td>{{$d->title1}}</td>
                    <td>{{$d->description1}}</td>
                    <td><img class="img img-sm w-50" src="{{asset('storage/'.$d->image1)}}" alt=""></td>
                    <td>{{$d->title2}}</td>
                    <td>{{$d->description2}}</td>
                    <td><img class="img img-sm w-50" src="{{asset('storage/'.$d->image2)}}" alt=""></td>
                    <td>{{$d->status == 0 ? 'Deactive':'Active'}}</td>
                    <td>
                        <a class="btn btn-padding btn-sm btn-info" href="{{route('about.edit', $d->id)}}">Edit</a> 
                        {{-- <form action="{{route('about.destroy', $d->id)}}" method="post"
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
