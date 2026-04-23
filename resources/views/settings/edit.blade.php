@extends('layouts.app')

@section('title', 'Settings')

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">General Settings</h4>
            </div>

            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    {!! multi_errors($errors) !!}
                    {!! success() !!}

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">Site Name <span class="required-label">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="site_name" value="{{ old('site_name', $setting->site_name) }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">Site Tagline</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="site_tagline" value="{{ old('site_tagline', $setting->site_tagline) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">Support Email</label>
                        <div class="col-lg-9">
                            <input type="email" class="form-control" name="support_email" value="{{ old('support_email', $setting->support_email) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">Support Phone</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="support_phone" value="{{ old('support_phone', $setting->support_phone) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">Office Address</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="office_address" value="{{ old('office_address', $setting->office_address) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">Footer Text</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="footer_text" value="{{ old('footer_text', $setting->footer_text) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">Facebook URL</label>
                        <div class="col-lg-9">
                            <input type="url" class="form-control" name="facebook_url" value="{{ old('facebook_url', $setting->facebook_url) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">LinkedIn URL</label>
                        <div class="col-lg-9">
                            <input type="url" class="form-control" name="linkedin_url" value="{{ old('linkedin_url', $setting->linkedin_url) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">Website Logo</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" name="admin_logo" accept=".jpg,.jpeg,.png,.webp">
                            <small class="text-muted">Recommended transparent PNG, max 2MB.</small>
                        </div>
                        <div class="col-lg-3">
                            @if($setting->admin_logo)
                                <img src="{{ asset('storage/' . $setting->admin_logo) }}" alt="Logo" class="img-fluid rounded border" style="max-height:60px;">
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 text-end">Website Favicon</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" name="admin_favicon" accept=".ico,.png,.jpg,.jpeg,.webp">
                            <small class="text-muted">ICO/PNG preferred, max 1MB.</small>
                        </div>
                        <div class="col-lg-3">
                            @if($setting->admin_favicon)
                                <img src="{{ asset('storage/' . $setting->admin_favicon) }}" alt="Favicon" class="img-fluid rounded border" style="max-height:40px;">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button class="btn btn-success" type="submit">Update Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
