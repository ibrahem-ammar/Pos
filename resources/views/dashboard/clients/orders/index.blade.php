@extends('layouts.dashboard.app')

@section('title') @lang('site.categories') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item active">
        @lang('site.categories')
    </li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ auth()->user()->hasPermission('create_categories') ? route('dashboard.categories.create') : '' }}" class="btn btn-success btn-sm text-capitalize {{ auth()->user()->hasPermission('create_categories')? '' : 'disabled' }}">
                    <i class="fa fa-plus mx-1"></i>
                    @lang('site.add')
                    @lang('site.category')
                </a>
                <div class="card-tools">
                    <form role="form" action="{{ route('dashboard.categories.index') }}" method="get">
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
                        <th>@lang('site.products_count')</th>
                        <th>@lang('site.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index=>$category)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><a href="{{ route('dashboard.products.index', ['category_id'=>$category->id]) }}">{{ $category->name }}</a></td>
                        <td>{{ $category->products->count() . ' products' }}</td>
                        <td>
                            @if (auth()->user()->hasPermission('update_categories'))
                            <a href="{{ route('dashboard.categories.edit', ['category'=>$category->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                            @else
                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                            @endif
                            @if (auth()->user()->hasPermission('delete_categories'))
                            <form method="post" action="{{ route('dashboard.categories.destroy', ['category'=>$category->id]) }}" class="d-inline-block">
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
                    <tr>
                        <td colspan="5">{{ $categories->appends(request()->query())->links() }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
