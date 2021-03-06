@extends('layouts.dashboard.app')

@section('style')

<style type="text/css">
    @keyframes ldio-zgkzab1htcp {
    0% { transform: translate(-50%,-50%) rotate(0deg); }
    100% { transform: translate(-50%,-50%) rotate(360deg); }
    }
    .ldio-zgkzab1htcp div {
    position: absolute;
    width: 60px;
    height: 60px;
    border: 10px solid #0f3cdf;
    border-top-color: transparent;
    border-radius: 50%;
    }
    .ldio-zgkzab1htcp div {
    animation: ldio-zgkzab1htcp 1s linear infinite;
    top: 50px;
    left: 50px
    }
    .loadingio-spinner-rolling-d4ss5er88kn {
    width: 100px;
    height: 100px;
    display: none;
    overflow: hidden;
    background: #ffffff;
    margin:auto;
    }
    .ldio-zgkzab1htcp {
    width: 100%;
    height: 100%;
    position: relative;
    transform: translateZ(0) scale(1);
    backface-visibility: hidden;
    transform-origin: 0 0; /* see note above */
    }
    .ldio-zgkzab1htcp div { box-sizing: content-box; }
    /* generated by https://loading.io/ */
</style>
{{-- <link rel="stylesheet" href="{{ asset('printThis/css/normalize.css') }}">
<link rel="stylesheet" href="{{ asset('printThis/css/skeleton.css') }}"> --}}
@endsection

@section('title') @lang('site.orders') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.clients.index') }}">
        @lang('site.clients')
    </a></li>
    <li class="breadcrumb-item">
        @lang('site.orders')
    </li>
@endsection

@section('content')
@include('partials._errors')
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('site.orders')</h3>
                    <div class="card-tools">
                        <form role="form" action="{{ route('dashboard.orders.index') }}" method="get">
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
                            <th>@lang('site.client_name')</th>
                            <th>@lang('site.price')</th>
                            <th>@lang('site.created_at')</th>
                            <th>@lang('site.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $index=>$order)
                        <tr>
                            <td>{{ $order->client->name }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>

                                <button class="btn btn-primary btn-sm show-products" data-url="{{ route('dashboard.orders.show',$order->id) }}"> <i class="fa fa-bars mx-1"></i>@lang('site.show')</button>

                                @if (auth()->user()->hasPermission('update_orders'))
                                <a href="{{ route('dashboard.orders.edit', ['order'=>$order->id,'client'=>$order->client->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                                @else
                                <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit mx-1"></i>@lang('site.edit')</a>
                                @endif
                                @if (auth()->user()->hasPermission('delete_orders'))
                                <form method="post" action="{{ route('dashboard.orders.destroy', ['order'=>$order->id]) }}" class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm btn_delete"><i class="fa fa-trash mx-1"></i>@lang('site.delete')</button>
                                </form>
                                @else
                                <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash mx-1"></i>@lang('site.delete')</button>
                                @endif

                            </td>
                        </tr>
                        @empty
                        {{-- <tr>
                            <td colspan="4">@lang('site.nodata')</td>
                        </tr> --}}
                        @endforelse
                        {{ $orders->appends(request()->query())->links() }}
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">@lang('site.products')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="loadingio-spinner-rolling-d4ss5er88kn">
                        <div class="ldio-zgkzab1htcp"><div>   </div>
                        </div>
                    </div>
                    <div id="order-products-list">

                    </div>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>

@endsection

@section('script')
<script src="{{ asset('printThis/printThis.js') }}"></script>
    <script>
        //list all order products
        $(document).ready(function () {
            $('.show-products').on('click',function() {
                // console.log($(this).data('url'))
                $('#order-products-list').empty();

                $('.loadingio-spinner-rolling-d4ss5er88kn').css('display','block');

                let url = $(this).data('url');

                $.ajax({
                    url : url,
                    method : 'get',
                    success : function (data) {
                        $('.loadingio-spinner-rolling-d4ss5er88kn').css('display','none');

                        $('#order-products-list').append(data);
                        // console.log(data);
                    }
                });
            });
            //print all products
            $(document).on('click','.print',function () {
                $('table.order-products').printThis();
            });
        });
    </script>
@endsection


