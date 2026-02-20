@extends('layouts.app')

@section('title','Edit About')

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit About</h4>
            </div>

            <form method="POST" action="{{ route('about.update', $about->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">

                    {!! multi_errors($errors) !!}
                    {!! success() !!}

                    {{-- PART 1 --}}
                    <h5 class="mb-3">Portion 1</h5>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">
                            Title <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-9">
                            <input type="text"
                                   class="form-control"
                                   name="title1"
                                   value="{{ old('title1', $about->title1) }}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-lg-3 text-end">
                            Description <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-9">
                            <textarea class="form-control"
                                      name="description1"
                                      rows="4"
                                      required>{{ old('description1', $about->description1) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-lg-3 text-end">Image</label>
                        <div class="col-lg-4">
                            <input type="file" class="form-control" name="image1">
                        </div>

                        @if($about->image1)
                        <div class="col-lg-3">
                            <img src="{{ asset('storage/'.$about->image1) }}"
                                 width="100"
                                 class="img-thumbnail">
                        </div>
                        @endif
                    </div>


                    {{-- PART 2 --}}
                    <h5 class="mt-4 mb-3">Portion 2</h5>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">
                            Title <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-9">
                            <input type="text"
                                   class="form-control"
                                   name="title2"
                                   value="{{ old('title2', $about->title2) }}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-lg-3 text-end">
                            Description <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-9">
                            <textarea class="form-control"
                                      name="description2"
                                      rows="4"
                                      required>{{ old('description2', $about->description2) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-lg-3 text-end">Image</label>
                        <div class="col-lg-4">
                            <input type="file" class="form-control" name="image2">
                        </div>

                        @if($about->image2)
                        <div class="col-lg-3">
                            <img src="{{ asset('storage/'.$about->image2) }}"
                                 width="100"
                                 class="img-thumbnail">
                        </div>
                        @endif
                    </div>


                    {{-- STATUS --}}
                    <div class="form-group row mt-4">
                        <label class="col-lg-3 text-end">
                            Status <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status"
                                       value="1"
                                       {{ old('status', $about->status) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Active</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status"
                                       value="0"
                                       {{ old('status', $about->status) == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Inactive</label>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="card-action">
                    <button class="btn btn-success" type="submit">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection