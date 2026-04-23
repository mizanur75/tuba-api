@extends('layouts.app')

@section('title','Edit Advice')

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Advice</h4>
            </div>
            <form method="POST" action="{{ route('advices.update', $advice->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    {!! multi_errors($errors) !!}
                    {!! success() !!}

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">
                            Advice <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="content" rows="4" required>{{ old('content', $advice->content) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-lg-3 text-end">
                            Status <span class="required-label">*</span>
                        </label>
                        <div class="col-lg-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="active" name="status" value="1" {{ old('status', $advice->status) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Active</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="deactive" name="status" value="0" {{ old('status', $advice->status) == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="deactive">Inactive</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button class="btn btn-success" type="submit">Update</button>
                    <a href="{{ route('advices.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
