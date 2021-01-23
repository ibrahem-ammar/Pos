@extends('layouts.dashboard.app')

@section('title') @lang('site.users') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item active">
        @lang('site.users')
    </li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ auth()->user()->hasPermission('create_users') ? route('dashboard.users.create') : '' }}" class="btn btn-success btn-sm text-capitalize {{ auth()->user()->hasPermission('create_users')? '' : 'disabled' }}">
                    <i class="fa fa-plus mx-1"></i>
                    @lang('site.add')
                    @lang('site.user')
                </a>
                <div class="card-tools">
                    <form role="form" action="" method="get">
                        @csrf
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('site.first_name')</th>
                        <th>@lang('site.last_name')</th>
                        <th>@lang('site.email')</th>
                        {{-- <th>@lang('site.image')</th> --}}
                        <th>@lang('site.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index=>$user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        {{-- <td><img src="{{ $user->image_path }}" alt="user image" width="50"></td> --}}
                        <td>
                            @if (auth()->user()->hasPermission('update_users'))
                            <a href="{{ route('dashboard.users.edit', ['user'=>$user->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                            @else
                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                            @endif
                            @if (auth()->user()->hasPermission('delete_users'))
                            <form method="post" action="{{ route('dashboard.users.destroy', ['user'=>$user->id]) }}" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash mx-1"></i>@lang('site.delete')</button>
                            </form>
                            @else
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash mx-1"></i>@lang('site.delete')</button>
                            @endif

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">@lang('site.nodata')</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->appends(request()->query())->links() }}
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
