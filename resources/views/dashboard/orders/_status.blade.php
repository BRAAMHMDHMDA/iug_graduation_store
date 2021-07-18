<div id="print-area">
    <form action="{{ route('orders.update', $order->id) }}" method="post" >
        {{ csrf_field() }}{{ method_field('put') }}
        <div class="form-group">
            <select class="form-control" name="new_status">
                <option @if($order->status =='pending') selected @endif value="pending">Pending</option>
                <option @if($order->status =='in_delivery') selected @endif value="in_delivery">In-Delivery</option>
                <option @if($order->status =='delivery_completed') selected @endif value="delivery_completed">Delivery Completed</option>
                <option @if($order->status =='cancelled') selected @endif value="cancelled">Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Save changes</button>
    </form>

</div>

