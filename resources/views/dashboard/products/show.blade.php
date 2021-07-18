@extends('layouts.dashboard.app')

@section('content')

    <style>

        .show {
            width: 600px;
            height: 400px;
        }

        .small-img {
            width: 350px;
            height: 70px;
            margin-top: 10px;
            position: relative;
            left: 25px;
        }

        .small-img .icon-left, .small-img .icon-right {
            width: 12px;
            height: 24px;
            cursor: pointer;
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto 0;
        }

        .small-img .icon-left {
            transform: rotate(180deg)
        }

        .small-img .icon-right {
            right: 0;
        }

        .small-img .icon-left:hover, .small-img .icon-right:hover {
            opacity: .5;
        }

        .small-container {
            width: 310px;
            height: 70px;
            overflow: hidden;
            position: absolute;
            left: 0;
            right: 0;
            margin: 0 auto;
        }

        .small-container div {
            width: 800%;
            position: relative;
        }

        .small-container .show-small-img {
            width: 70px;
            height: 70px;
            margin-right: 6px;
            cursor: pointer;
            float: left;
        }

        .small-container .show-small-img:last-of-type {
            margin-right: 0;
        }

    </style>
    <div class="content-wrapper">
        <section class="content-header">

            <h1>{{$product->name}}</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('products.index') }}"> products</a></li>
                <li class="active">show</li>
            </ol>
        </section>
        <section class="content">


            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-info-circle"></i> Basic
                            Info</a></li>
                    <li><a href="#tab_2" data-toggle="tab"><i class="glyphicon glyphicon-usd"></i> Prices</a></li>
                    <li><a href="#tab_3" data-toggle="tab"> <i class="glyphicon glyphicon-picture"></i> Gallery</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="box box-solid">
                            <div class="box-body">
                                <dl class="dl-horizontal">
                                    <dt>Name |</dt>
                                    <dd>{{$product->name}}</dd>
                                    <br/>
                                    <dt>Category |</dt>
                                    <dd>{{$product->category->name}}</dd>
                                    <br/>
                                    <dt>Stock |</dt>
                                    <dd>{{$product->stock}}</dd>
                                    <br/>
                                    <dt>Short Description |</dt>
                                    <dd>{{$product->short_description}}</dd>
                                    <br/>
                                    <dt>Long Description |</dt>
                                    <dd>{!! $product->long_description !!}</dd>
                                    <br/>
                                    <dt>Status |</dt>
                                    <dd>
                                        @if($product->status == "1"){{ "Publish" }}
                                        @else {{"UnPublish"}}
                                        @endif
                                    </dd>
{{--                                    <br/>--}}
{{--                                    <dt>colors |</dt>--}}
{{--                                    <dd>--}}
{{--                                        <li>red</li>--}}
{{--                                        <li>white</li>--}}
{{--                                    </dd>--}}

                                </dl>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="box box-solid">
                            <div class="box-body">
                                <dl class="dl-horizontal">
                                    <dt>Purchase Price |</dt>
                                    <dd>{{$product->purchase_price}}<small><i
                                                class="fa fa-fw fa-shekel"></i></small></dd>
                                    <br/>
                                    <dt>Sale Price |</dt>
                                    <dd>{{$product->sale_price}}<small><i class="fa fa-fw fa-shekel"></i></small>
                                    </dd>
                                    <br/>
                                    <dt>Discount Value |</dt>
                                    <dd>{{$product->discount}}<small><i class="fa fa-fw fa-shekel"></i></small></dd>
                                    <br/>
                                    <dt>Price After Discount |</dt>
                                    <dd>{{$product->price_after_discount}}<small><i
                                                class="fa fa-fw fa-shekel"></i></small>
                                    </dd>
                                    <br/>
                                    <hr style="border-top: 3px solid #bab3b3;width: 30%;float: left"/>
                                    <hr style="border-top: 3px solid #ffffff;"/>

                                    <dt>Net profit |</dt>
                                    <dd>{{$product->net_profit}}<small><i class="fa fa-fw fa-shekel"></i></small>
                                    </dd>


                                </dl>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        <div class="row container">
                            <div class="col-md-6">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Slider Photos</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                <li data-target="#carousel-example-generic" data-slide-to="0"
                                                    class="active"></li>
                                                <li data-target="#carousel-example-generic" data-slide-to="1"
                                                    class=""></li>
                                                <li data-target="#carousel-example-generic" data-slide-to="2"
                                                    class=""></li>
                                                <li data-target="#carousel-example-generic" data-slide-to="3"
                                                    class=""></li>
                                                <li data-target="#carousel-example-generic" data-slide-to="4"
                                                    class=""></li>
                                                <li data-target="#carousel-example-generic" data-slide-to="5"
                                                    class=""></li>
                                                <li data-target="#carousel-example-generic" data-slide-to="6"
                                                    class=""></li>
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="item active">
                                                    <img
                                                        src="{{ $product->main_image_path }}"
                                                        alt="Main picture">
                                                    <div class="carousel-caption">
                                                        Main picture
                                                    </div>
                                                </div>
                                                @foreach($product->extra_images_path as $image)
                                                     <div class="item" style="height: 255px">
                                                         <img src="{{$image}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a class="left carousel-control" href="#carousel-example-generic"
                                               data-slide="prev">
                                                <span class="fa fa-angle-left" style=""></span>
                                            </a>
                                            <a class="right carousel-control" href="#carousel-example-generic"
                                               data-slide="next">
                                                <span class="fa fa-angle-right"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </section>
    </div>

@endsection
