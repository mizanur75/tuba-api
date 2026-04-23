<section>
    <header class="mb-3">
        <h5 class="mb-1">Profile Information</h5>
        <p class="text-muted mb-0">Update your account and practitioner details.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="row g-3">
        @csrf
        @method('patch')

        <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="col-12">
                <div class="alert alert-warning mb-0">
                    <div>Your email address is unverified.</div>
                    <button form="send-verification" class="btn btn-link p-0 mt-2">Click here to re-send the verification email.</button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="text-success mt-2">A new verification link has been sent to your email address.</div>
                    @endif
                </div>
            </div>
        @endif

        <div class="col-md-6">
            <label for="practitioner_type" class="form-label">Practitioner Type</label>
            <select id="practitioner_type" name="practitioner_type" class="form-select @error('practitioner_type') is-invalid @enderror" required>
                <option value="doctor" {{ old('practitioner_type', $user->practitioner_type ?? 'doctor') === 'doctor' ? 'selected' : '' }}>Doctor</option>
                <option value="hypnotherapist" {{ old('practitioner_type', $user->practitioner_type ?? 'doctor') === 'hypnotherapist' ? 'selected' : '' }}>Hypnotherapist</option>
            </select>
            @error('practitioner_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" autocomplete="tel">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="qualification" class="form-label">Qualification</label>
            <input id="qualification" name="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" value="{{ old('qualification', $user->qualification) }}">
            @error('qualification')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="specialization" class="form-label">Specialization</label>
            <input id="specialization" name="specialization" type="text" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization', $user->specialization) }}">
            @error('specialization')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="registration_no" class="form-label">Registration No</label>
            <input id="registration_no" name="registration_no" type="text" class="form-control @error('registration_no') is-invalid @enderror" value="{{ old('registration_no', $user->registration_no) }}">
            @error('registration_no')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="chamber_address" class="form-label">Chamber Address</label>
            <input id="chamber_address" name="chamber_address" type="text" class="form-control @error('chamber_address') is-invalid @enderror" value="{{ old('chamber_address', $user->chamber_address) }}">
            @error('chamber_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label for="bio" class="form-label">Professional Bio</label>
            <textarea id="bio" name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">Save Profile</button>

            @if (session('status') === 'profile-updated')
                <span class="badge bg-success">Saved</span>
            @endif
        </div>
    </form>
</section>
