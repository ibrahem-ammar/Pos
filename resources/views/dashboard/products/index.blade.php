@extends('layouts.dashboard.app')

@section('title') @lang('site.products') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item active">
        @lang('site.products')
    </li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ auth()->user()->hasPermission('create_products') ? route('dashboard.products.create') : '' }}" class="btn btn-success btn-sm text-capitalize {{ auth()->user()->hasPermission('create_products')? '' : 'disabled' }}">
                    <i class="fa fa-plus mx-1"></i>
                    @lang('site.add')
                    @lang('site.product')
                </a>
                <div class="card-tools">
                    <form role="form" action="{{ route('dashboard.products.index') }}" method="get">
                        @csrf
                        <div class="input-group input-group-sm" style="width: 300px;">

                            <input type="text" name="search" class="form-control float-right" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            <select name="category_id" class="form-control">
                                <option value="">categories</option>
                                @forelse ($categories as $category)
                                <option value="{{$category->id}}" {{request()->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                @empty
                                <option value="">no categories</option>
                                @endforelse
                            </select>
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
                        <th>@lang('site.description')</th>
                        <th>@lang('site.category')</th>
                        {{-- <th>@lang('site.image')</th> --}}
                        <th>@lang('site.purchase_price')</th>
                        <th>@lang('site.sale_price')</th>
                        <th>@lang('site.profit_percent')%</th>
                        <th>@lang('site.stock')</th>
                        <th>@lang('site.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $index=>$product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{!! $product->description !!}</td>
                        <td>{{ $product->category->name }}</td>
                        {{-- <td>{{ $product->image }}</td> --}}
                        <td>{{ $product->purchase_price }}</td>
                        <td>{{ $product->sale_price }}</td>
                        <td>{{ $product->profit_percent . '%' }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if (auth()->user()->hasPermission('update_products'))
                            <a href="{{ route('dashboard.products.edit', ['product'=>$product->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                            @else
                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                            @endif
                            @if (auth()->user()->hasPermission('delete_products'))
                            <form method="post" action="{{ route('dashboard.products.destroy', ['product'=>$product->id]) }}" class="d-inline-block">
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
                    <tr class="text-center text-capitalize">
                        <th colspan="7">@lang('site.nodata')</th>
                    </tr>
                    @endforelse
                    {{ $products->appends(request()->query())->links() }}
                </tbody>
            </table>

        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
