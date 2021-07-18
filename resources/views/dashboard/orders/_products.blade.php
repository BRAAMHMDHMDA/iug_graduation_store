<div id="print-area">
    <table class="table table-hover table-bordered">

        <thead>
        <tr>
            <th>name</th>
            <th>quantity</th>
            <th>price</th>
        </tr>
        </thead>

        <tbody>
        @php $total_price = 0; @endphp

        @foreach ($products as $product)
            @php
                    $total_price =+ ($product->order_products->quantity * $product->order_products->price) + $total_price;
            @endphp

            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->order_products->quantity }}</td>
                <td>{{ number_format($product->order_products->quantity * $product->order_products->price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3>Total | <span>{{ number_format($total_price, 2) }}</span></h3>

</div>

<button class="btn btn-block btn-primary  print-btn"><i class="fa fa-print"></i> Print</button>
