@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>Orders
                <small>{{ $orders->total() }} orders</small>
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> dashboard</a></li>
                <li class="active">orders</li>
            </ol>
        </section>

        <section class="content">

            <div class="row">

                <div class="col-md-8">

                    <div class="box box-primary">

                        <div class="box-header">

                            <h3 class="box-title" style="margin-bottom: 10px">orders</h3>

                            <form action="{{ route('orders.index') }}" method="get">

                                <div class="row">

                                    <div class="col-md-8">
                                        <input type="text" name="search" class="form-control" placeholder="search by customer name" value="{{ request()->search }}">
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> search</button>
                                    </div>

                                </div><!-- end of row -->

                            </form><!-- end of form -->

                        </div><!-- end of box header -->

                        @if ($orders->count() > 0)

                            <div class="box-body table-responsive">

                                <table class="table table-hover">
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>

                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->customer->name }}</td>
                                            <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                            <td>
                                                @if($order->status=='pending') <span class="label label-warning">Pending</span>
                                                @elseif($order->status =='in_delivery')<span class="label label-primary">in_delivery</span>
                                                @elseif($order->status =='delivery_completed')<span class="label label-success">Delivery Completed</span>
                                                @elseif($order->status =='cancelled')<span class="label label-danger">Cancelled</span>
                                                @endif
                                            </td>

                                            <td>
                                                <button class="btn bg-navy btn-sm order-products"
                                                        data-url="{{ route('orders.products', $order->id) }}"
                                                        data-method="get"
                                                >
                                                    <i class="fa fa-list"></i>
                                                    Show
                                                </button>

{{--                                                <form action="{{ route('orders.destroy', $order->id) }}" method="post" style="display: inline-block;">--}}
{{--                                                    {{ csrf_field() }}--}}
{{--                                                    {{ method_field('delete') }}--}}
{{--                                                    <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button>--}}
{{--                                                </form>--}}

                                                @if($order->status != 'delivery_completed')
                                                    <button class="btn btn-info btn-sm order-show"
                                                            data-url="{{ route('orders.show_status', $order->id) }}"
                                                            data-method="get"
                                                    >
                                                        <i class="fa fa-edit"></i>
                                                        update status
                                                    </button>
                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                </table><!-- end of table -->

                                {{ $orders->appends(request()->query())->links() }}

                            </div>

                        @else

                            <div class="box-body">
                                <h3>No Orders</h3>
                            </div>

                        @endif

                    </div><!-- end of box -->

                </div><!-- end of col -->

                <div class="col-md-4">

                    <div class="box box-primary">

                        <div class="box-header">
                            <h3 class="box-title" style="margin-bottom: 10px">Show Products</h3>
                        </div><!-- end of box header -->

                        <div class="box-body">

                            <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                                <div class="loader"></div>
                                <p style="margin-top: 10px">Loading</p>
                            </div>

                            <div id="order-product-list">

                            </div><!-- end of order product list -->

                        </div><!-- end of box body -->

                    </div><!-- end of box -->

                </div><!-- end of col -->
                <div class="col-md-4">

                    <div class="box box-primary">

                        <div class="box-header">
                            <h3 class="box-title" style="margin-bottom: 10px">Edit Status</h3>
                        </div><!-- end of box header -->

                        <div class="box-body">

                            <div style="display: none; flex-direction: column; align-items: center;" id="loading2">
                                <div class="loader"></div>
                                <p style="margin-top: 10px">Loading</p>
                            </div>

                            <div id="order-show">

                            </div><!-- end of order product list -->

                        </div><!-- end of box body -->

                    </div><!-- end of box -->

                </div><!-- end of col -->

            </div><!-- end of row -->

        </section><!-- end of content section -->

    </div><!-- end of content wrapper -->

@endsection
