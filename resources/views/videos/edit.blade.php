@extends('layouts.app')

@section('title','Edit Video')

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Video</h4>
            </div>
            <form method="POST" action="{{ route('videos.update', $video->id) }}" enctype="multipart/form-data">
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
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="title" value="{{ old('title', $video->title) }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 text-end">
                            Sub Title <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="subTitle" value="{{ old('subTitle', $video->subTitle) }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 text-end">
                            Short Description <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="shortDescription" value="{{ old('shortDescription', $video->shortDescription) }}" required>
                        </div>
                    </div>

                    <!-- Video -->
                    <div class="form-group row">
                        <label class="col-lg-3 text-end">
                            Video <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4">
                            <input type="file" class="form-control" name="video">
                            
                            @if($video->video)
                                <div class="mt-2">
                                    <video width="250" controls>
                                        <source src="{{ asset('storage/'.$video->video) }}" type="video/mp4">
                                    </video>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group row">
                        <label class="col-lg-3 text-end">
                            Status <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="active" name="status" value="1" {{ old('status', $video->status) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Active</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="deactive" name="status" value="0" {{ old('status', $video->status) == 0 ? 'checked' : '' }}>
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

