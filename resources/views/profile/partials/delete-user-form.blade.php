<section>
    <header class="mb-3">
        <h5 class="mb-1">Delete Account</h5>
        <p class="text-muted mb-0">Once your account is deleted, all related data will be permanently removed.</p>
    </header>

    <div class="alert alert-warning">
        This action cannot be undone. Please confirm with your current password.
    </div>

    <form method="post" action="{{ route('profile.destroy') }}" class="row g-3" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
        @csrf
        @method('delete')

        <div class="col-md-6">
            <label for="delete_password" class="form-label">Password</label>
            <input id="delete_password" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Enter your current password" required>
            @error('password', 'userDeletion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-danger">Delete Account</button>
        </div>
    </form>
</section>
