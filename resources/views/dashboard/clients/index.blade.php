@extends('layouts.dashboard.app')

@section('title') @lang('site.clients') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item active">
        @lang('site.clients')
    </li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ auth()->user()->hasPermission('create_clients') ? route('dashboard.clients.create') : '' }}" class="btn btn-success btn-sm text-capitalize {{ auth()->user()->hasPermission('create_clients')? '' : 'disabled' }}">
                    <i class="fa fa-plus mx-1"></i>
                    @lang('site.add')
                    @lang('site.client')
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
                        <th>@lang('site.name')</th>
                        <th>@lang('site.phone')</th>
                        <th>@lang('site.address')</th>
                        <th>@lang('site.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $index=>$client)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->address }}</td>
                        <td>
                            @if (auth()->user()->hasPermission('create_orders'))
                            <a href="{{ route('dashboard.orders.create', ['client'=>$client->id]) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> @lang('site.add_order')
                            </a>
                            @else
                            <a href="#" class="btn btn-primary btn-sm disabled">
                                <i class="fa fa-plus"></i> @lang('site.add_order')
                            </a>
                            @endif

                            @if (auth()->user()->hasPermission('update_clients'))
                            <a href="{{ route('dashboard.clients.edit', ['client'=>$client->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                            @else
                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                            @endif

                            @if (auth()->user()->hasPermission('delete_clients'))
                            <form method="post" action="{{ route('dashboard.clients.destroy', ['client'=>$client->id]) }}" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-danger btn-sm btn_delete"><i class="fa fa-trash mx-1"></i>@lang('site.delete')</button>
                            </form>
                            @else
                            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash mx-1"></i>@lang('site.delete')</button>
                            @endif

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">@lang('site.nodata')</td>
                    </tr>
                    @endforelse
                    {{ $clients->appends(request()->query())->links() }}
                </tbody>
            </table>

        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
