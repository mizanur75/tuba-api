<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xxl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Users List') }}
                            </h2>
                            <h1><a href="{{route('users.create')}}">Add User</a></h1>
                            @if(Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('success') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @endif	
                            @if($errors->any())
                            <div class="col-md-12">
                                @foreach($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ $error }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </header>
                    
                        <div>
                            <table class="table">
                                <tr>
                                    <th>#SL</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($data as $d)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{$d->name}}</td>
                                    <td>{{$d->email}}</td>
                                    <td>
                                        @if(!empty($d->getRoleNames()))
                                            @foreach($d->getRoleNames() as $roleName)
                                                <label for="" class="badge bg-success">{{$roleName}}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('users.edit', $d->id)}}">Edit</a> 
                                        <form action="{{route('users.destroy', $d->id)}}" method="post"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you Sure? Want to delete')">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button class="btn btn-padding btn-sm btn-danger" type="submit"> Delete
                                            </x-danger-button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </section>                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
