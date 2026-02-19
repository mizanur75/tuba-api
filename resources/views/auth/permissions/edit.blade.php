@extends('layouts.app')

@section('title','Edit Permission')

@section('body')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Permission</h4>
                </div>
                <form method="post" action="{{ route('permissions.update', $permission->id) }}">
                    @csrf
                    @method('put')
            
                    <div class="card-body">
                        <div class="form-group form-show-validation row">
                            <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Permission Name <span class="required-label">*</span></label>
                            <div class="col-lg-4 col-md-9 col-sm-8">
                                <input type="text" class="form-control" value="{{$permission->name}}" id="name" name="name" placeholder="Enter Username" required>
                            </div>
                        </div>
                    </div>
            
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-success" type="submit"> {{ __('Update') }} </button>
                            </div>                                      
                        </div>
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
