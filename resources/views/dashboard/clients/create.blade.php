@extends('layouts.dashboard.app')

@section('title') @lang('site.add') @lang('site.client') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.clients.index') }}">
        @lang('site.clients')
    </a></li>
    <li class="breadcrumb-item active">@lang('site.add') </li>
@endsection

@section('content')
@include('partials._errors')
<form role="form" method="POST" action="{{ route('dashboard.clients.store') }}">
    @csrf
    @method('post')

    <div class="form-group">
        <label for="name">@lang('site.name')</label>
        <input type="text" id="name" value="{{ old('name') }}" class="form-control" placeholder="client name" name="name">
    </div>

    <div class="form-group">
        <label for="phone">@lang('site.phone')</label>
        <input type="text" id="phone" value="{{ old('phone') }}" class="form-control" placeholder="client phone" name="phone">
    </div>

    <div class="form-group">
        <label for="address">@lang('site.address')</label>
        <input type="text" id="address" value="{{ old('address') }}" class="form-control" placeholder="client address" name="address">
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>@lang('site.add')</button>
    </div>
</form>
@endsection
