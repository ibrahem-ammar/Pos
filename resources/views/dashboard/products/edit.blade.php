@extends('layouts.dashboard.app')

@section('title') @lang('site.edit') @lang('site.product') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">
        @lang('site.products')
    </a></li>
    <li class="breadcrumb-item active">@lang('site.edit') </li>
@endsection

@section('content')
@include('partials._errors')
<form role="form" method="POST" action="{{ route('dashboard.products.update',['product'=>$product->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="form-group">
        <label for="categories">@lang('site.categories')</label>
        <select name="category_id" id="categories" class="form-control">
            @forelse ($categories as $category)
            <option value="{{ $category->id }}" {{old('category_id',$product->category_id)==$category->id?'selected':''}}>{{ $category->name }}</option>
            @empty
            <option value="">no categories yet</option>
            @endforelse
        </select>
    </div>

    <div class="form-group">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    @foreach (config('translatable.locales') as $index=>$local)
                    <li class="nav-item">
                        <a class="nav-link text-capitalize {{ $index==0? 'active' : '' }}" id="{{ $local . '-tab' }}" data-toggle="pill" href="{{ '#' . $local }}" role="tab" aria-controls="{{ $local }}" aria-selected="{{ $index==0? 'true' : 'false' }}">@lang('site.' . $local)</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    @foreach (config('translatable.locales') as $index=>$local)
                    <div class="tab-pane fade {{ $index==0? 'show active' : '' }}" id="{{ $local }}" role="tabpanel" aria-labelledby="{{ $local . '-tab' }}">
                        <input type="text" class="form-control mb-2" value="{{ old($local.'.name',$product->translate($local)->name) }}" id="{{'name_' . $local}}" placeholder=" @lang('site.product') @lang('site.name')" name="{{$local}}[name]">
                        {{-- <input type="text" class="form-control mt-2" value="{{ old($local.,$product->local'.description') }}" id="{{'description_' . $local}}" placeholder=" @lang('site.product') @lang('site.description')" name="{{$local}}[description]"> --}}
                        <textarea name="{{$local}}[description]" class="form-control mt-2 ckeditor" id="{{'name_' . $local}}" cols="30" rows="5" >{{ old($local.'.description',$product->translate($local)->description) }}</textarea>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="form-group">
        <label for="purchase_price">@lang('site.purchase_price')</label>
        <input type="number" name="purchase_price" value="{{ old('purchase_price',$product->purchase_price) }}" class="form-control" placeholder="0">
    </div>

    <div class="form-group">
        <label for="sale_price">@lang('site.sale_price')</label>
        <input type="number" name="sale_price" value="{{ old('sale_price',$product->sale_price) }}" class="form-control" placeholder="0">
    </div>

    <div class="form-group">
        <label for="stock">@lang('site.stock')</label>
        <input type="number" name="stock" value="{{ old('stock',$product->stock) }}" class="form-control" placeholder="0">
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>@lang('site.edit')</button>
    </div>
</form>
@endsection

@section('script')
    <script src="{{ asset('admin_files/plugins/ckeditor/ckeditor.js') }}"></script>
@endsection
