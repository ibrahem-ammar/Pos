@extends('layouts.dashboard.app')

@section('title') @lang('site.edit') @lang('site.category') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">
        @lang('site.categories')
    </a></li>
    <li class="breadcrumb-item active">@lang('site.edit') </li>
@endsection

@section('content')
@include('partials._errors')
<form role="form" method="POST" action="{{ route('dashboard.categories.update',['category'=>$category->id]) }}">
    @csrf
    @method('put')

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
                        <input type="text" class="form-control" value="{{ old($local.'.name',$category->translate($local)->name) }}" id="{{'name_' . $local}}" placeholder=" @lang('site.category') @lang('site.name')" name="{{$local}}[name]">
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fa fa-edit mr-1"></i>@lang('site.update')</button>
    </div>
</form>
@endsection
