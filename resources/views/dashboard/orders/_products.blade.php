<div id="print-area" class="table-responsive">
    <table class="table table-hover">
        <thead>                  
            <tr>
                <th>#</th>
                <th>@lang('site.name')</th>
                <th>@lang('site.quantity')</th>
                <th>@lang('site.price')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index=>$product)
                <tr>
                    <td>{{$index + 1 }}</td>
                    <td>{{$product->name }}</td>
                    <td>{{$product->pivot->quantity }}</td>
                    <td>{{ number_format($order->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h4>
        @lang('site.total') : <span>{{ number_format($order->total_price, 2) }}</span>
    </h4>
</div>

