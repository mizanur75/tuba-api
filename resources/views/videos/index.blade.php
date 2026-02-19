@extends('layouts.app')

@section('title','Videos')

@section('body')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Video</h4>
            </div>
            <form method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data">
              @csrf

              <div class="card-body">
                  {!! multi_errors($errors) !!}
                  {!! success() !!}

                  <!-- Title -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Title <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                          <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                      </div>
                  </div>

                  <!-- Video -->
                  <div class="form-group row">
                      <label class="col-lg-3 text-end">
                          Video <span class="required-label">*</span>
                      </label>
                      <div class="col-lg-4">
                          <input type="file" class="form-control" name="video" required>
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
        <h4 class="card-title">All Video</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            id="basic-datatables"
            class="display table table-striped table-hover"
          >
            <thead>
              <tr>
                <th>Title</th>
                <th>Video</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $d)
                <tr>
                    <td>{{$d->title}}</td>
                    <td>{{$d->video}}</td>
                    <td>
                        <a class="btn btn-padding btn-sm btn-info" href="{{route('videos.edit', $d->id)}}">Edit</a> 
                        <form action="{{route('videos.destroy', $d->id)}}" method="post"
                            style="display: inline;"
                            onsubmit="return confirm('Are you Sure? Want to delete')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-padding btn-sm btn-danger" type="submit"> Delete </button>
                        </form>
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
