<table class="table table-hover text-nowrap order-products">
    <thead>
        <th>@lang('site.product_name')</th>
        <th>@lang('site.quantity')</th>
        <th>@lang('site.price')</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($order->products as $product)
            <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->pivot->quantity}}</td>
                <td>{{number_format($product->pivot->quantity * $product->sale_price,2)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<h4>@lang('site.total') : <span>{{ number_format($order->price,2) }}</span></h4>
<button type="button" class="btn btn-primary d-block w-100 print"><i class="fa fa-print"></i> @lang('site.print')</button>
