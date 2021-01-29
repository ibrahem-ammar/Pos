@extends('layouts.dashboard.app')

@section('title') @lang('site.add') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">
        @lang('site.users')
    </a></li>
    <li class="breadcrumb-item active">@lang('site.add')</li>
@endsection

@section('content')
@include('partials._errors')
<form role="form" method="POST" action="{{ route('dashboard.users.store') }}" enctype="multipart/form-data">
    @csrf
    @method('post')
    <div class="form-group">
        <label for="first_name">@lang('site.first_name')</label>
        <input type="text" class="form-control" value="{{ old('first_name') }}" id="first_name" placeholder="@lang('site.first_name')" name="first_name">
    </div>
    <div class="form-group">
        <label for="last_name">@lang('site.last_name')</label>
        <input type="text" class="form-control" value="{{ old('last_name') }}" id="last_name" placeholder="@lang('site.last_name')" name="last_name">
    </div>
    <div class="form-group">
        <label for="email">@lang('site.email')</label>
        <input type="email" class="form-control" value="{{ old('emali') }}" id="email" placeholder="@lang('site.email')" name="email">
    </div>
    {{-- <div class="form-group">
        <label for="image">@lang('site.user') @lang('site.image')</label>
        <input type="file" id="image" name="image">

    </div> --}}
    <div class="form-group">
        <label for="password">@lang('site.password')</label>
        <input type="password" class="form-control" value="{{ old('password') }}" id="password" placeholder="@lang('site.password')" name="password">
    </div>
    <div class="form-group">
        <label for="password_confirmation">@lang('site.password_confirmation')</label>
        <input type="password" class="form-control" value="{{ old('password_confirmation') }}" id="password_confirmation" placeholder="@lang('site.password_confirmation')" name="password_confirmation">
    </div>
    <?php   $models = ['users','categories','products','clients','orders'];
            $crud = ['create','read','edit','delete']; ?>
    <div class="form-group">
        <label>@lang('site.permissions')</label>
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    @foreach ($models as $index=>$model)
                    <li class="nav-item">
                        <a class="nav-link {{ $index==0? 'active' : '' }}" id="{{ $model . '-tab' }}" data-toggle="pill" href="{{ '#' . $model }}" role="tab" aria-controls="{{ $model }}" aria-selected="{{ $index==0? 'true' : 'false' }}">@lang('site.' . $model)</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    @foreach ($models as $index=>$model)
                    <div class="tab-pane fade {{ $index==0? 'show active' : '' }}" id="{{ $model . '' }}" role="tabpanel" aria-labelledby="{{ $model . '-tab' }}">
                        <ol class="breadcrumb">
                            @foreach ($crud as $permission)
                            <li class="breadcrumb-item">
                                <label for="{{ $permission . '_' . $model }}">
                                <input type="checkbox" name="permissions[]" id="{{ $permission . '_' . $model }}" value="{{ $permission . '_' . $model }}">@lang('site.' . $permission)</label>
                            </li>
                            @endforeach
                        </ol>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>@lang('site.add')</button>
    </div>
</form>
@endsection
