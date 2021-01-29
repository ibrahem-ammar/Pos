@extends('layouts.dashboard.app')

@section('title') @lang('site.add') @lang('site.order') @endsection

@section('links')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
        @lang('site.dashboard')
    </a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.clients.index') }}">
        @lang('site.clients')
    </a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.orders.index') }}">
        @lang('site.orders')
    </a></li>
    <li class="breadcrumb-item active">@lang('site.add') </li>
@endsection

@section('content')
@include('partials._errors')
    <div class="row">
        <div class="col-6">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">@lang('site.categories')</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="accordion">
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->

                  @forelse ($categories as $index=>$category)
                  <div class="card card-info">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="{{'#category'.$category->id}}">
                          {{$category->name}}
                        </a>
                      </h4>
                    </div>
                    <div id="{{'category'.$category->id}}" class="panel-collapse collapse {{$index==0?'in':''}}">
                      <div class="card-body">
                          <table class="table table-hover text-nowrap">
                                <thead>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.price')</th>
                                    <th>@lang('site.stock')</th>
                                    <th>@lang('site.add')</th>
                                </thead>
                                <tbody>
                                    @forelse ($category->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->sale_price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                class="btn btn-success add_product"
                                                id="{{'product'.$product->id}}"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-stock="{{ $product->stock }}"
                                                data-sale_price="{{ $product->sale_price }}">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4">no products</td></tr>
                                    @endforelse
                              </tbody>

                          </table>
                      </div>
                    </div>
                  </div>
                  @empty
                  <div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#nocategories">
                          no categories
                        </a>
                      </h4>
                    </div>
                    <div id="nocategories" class="panel-collapse collapse in">
                      <div class="card-body">
                        no categories
                      </div>
                    </div>
                  </div>
                  @endforelse

                </div>
              </div>
              <!-- /.card-body -->
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">@lang('site.orders')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.quantity')</th>
                                <th>@lang('site.price')</th>
                                <th></th>
                            </thead>
                            <tbody class="orderd_products">

                          </tbody>
                      </table>
                      <div class="form-group">
                          <h4>total : <span class="total">0</span></h4>
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> @lang('site.add_order')</button>
                      </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('.add_product').on('click',function(){
            let name = $(this).data('name');
            let salePrice = $(this).data('sale_price');
            let id = $(this).data('id');
            let stock = $(this).data('stock');

            let html = `
            <tr>
                <td>${name}</td>
                <td><input type="number" value="1" max="${stock}" min="1" name="qunatities[]" class="form-control quantity"></td>
                <td class="price" data-price="${salePrice}">${salePrice}</td>
                <td><a href="javascript:void(0)" class="btn btn-danger delete_product" data-id="${id}"><i class="fa fa-trash"></i></a></td>
            </tr>
            `;



            $('.orderd_products').append(html);

            $(this).removeClass('btn-success add_product').addClass('btn-default disabled');

            totalPrice();
        });

        $('body').on('click','.disabled',function(e){
            e.preventDefault()
        });

        $('body').on('change keyup blur','.quantity',function(){
            let priceField = $(this).closest('tr').find('.price');
            // console.log();
            priceField.html(parseInt($(this).val()*priceField.data('price')));
            totalPrice();
        });

        $('body').on('click','.delete_product',function(){
            $('#product'+$(this).data('id')).removeClass('btn-default disabled').addClass('btn-success add_product');
            $(this).closest('tr').remove();
            totalPrice();
        });

        function totalPrice(){
            price = 0;
            $('.price').each(function(){
                price += parseInt($(this).html());
            });
            $('.total').html(price);
        }

    });
</script>
@endsection
