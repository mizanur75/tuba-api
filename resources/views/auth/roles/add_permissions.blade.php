@extends('layouts.app')

@section('title','Pesmission set to Roles')

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Role</h4>
                {!! multi_errors($errors) !!}
                    {!! success() !!}
            </div>

            <form method="post" action="{{ route('give_permissions_to_role', $role->id) }}" class="mt-6 space-y-6">
                @csrf                    
                <div class="card-body">
                    <div class="form-group form-show-validation row">
                        <label for="name" class="col-lg-2 col-md-2 col-sm-4 mt-sm-2 text-end">Role Name <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="text" class="form-control" value="{{$role->name}}" id="name" name="name" placeholder="Enter Username" readonly required>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="form-check">
                        <div class="row">
                            <label class="col-lg-2 col-md-2 col-sm-4 mt-sm-2 text-end">Agree <span class="required-label">*</span></label>
                    
                            @foreach($permissions as $permission)
                            
                            <div class="col-lg-2 col-md-2 col-sm-2 d-flex align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="{{$permission->id}}" name="permissions[]"  {{in_array($permission->id, $role_permission) ? 'checked' : ''}} value="{{$permission->name}}" id="{{$permission->id}}">
                                    <label class="form-check-label" for="{{$permission->id}}">{{$permission->name}}</label>
                                </div>
                            </div>
                            @endforeach
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

@endpush
