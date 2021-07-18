@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>products</h1>

            <ol class="breadcrumb">
                <li class="active">products</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">products <small>{{ $products->total() }}</small>
                    </h3>

                    <form action="{{ route('products.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <p><input type="text" name="search" class="form-control"
                                          placeholder="search by product name" value="{{ request()->search }}"></p>
                                <a href="{{ route('products.index') }}" class="btn btn-default"
                                   style="color: #00A65A"><i class="glyphicon glyphicon-refresh"></i> Refresh</a>
                            </div>
                            <div class="container">
                                <div class="col-md-4">
                                    <select name="category_id" class="form-control">
                                        <option value="">Choose Category</option>
                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search
                                    </button>
                                    <a href="{{ route('products.create') }}" class="btn btn-primary"><i
                                            class="fa fa-plus"></i> Add</a>

                                </div>

                            </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                {{--                <div class="box-body">--}}

                {{--                    @if ($products->count() > 0)--}}

                {{--                        <table class="table table-hover">--}}

                {{--                            <thead>--}}
                {{--                            <tr>--}}
                {{--                                <th>#</th>--}}
                {{--                                <th>Image</th>--}}
                {{--                                <th>Name</th>--}}
                {{--                                <th>Description</th>--}}
                {{--                                <th>Category</th>--}}
                {{--                                <th>Purchase Price</th>--}}
                {{--                                <th>Sale Price</th>--}}
                {{--                                <th>Stock</th>--}}
                {{--                                <th>Discount</th>--}}
                {{--                                <th>Price After Discount</th>--}}
                {{--                                <th>Action</th>--}}
                {{--                            </tr>--}}
                {{--                            </thead>--}}

                {{--                            <tbody>--}}
                {{--                            @foreach ($products as $index=>$product)--}}
                {{--                                @if ($product->id ==  session('linked-product') )--}}
                {{--                                    <tr style="background-color: #d7c8c8">--}}
                {{--                                @else--}}
                {{--                                    <tr>--}}
                {{--                                @endif--}}
                {{--                                    <td>{{ $index + 1 }}</td>--}}
                {{--                                    <td><img src="{{ $product->image_path }}" style="width: 100px"  class="img-thumbnail" alt=""></td>--}}
                {{--                                    <td>{{ $product->name }}</td>--}}
                {{--                                    <td>{!! $product->description !!}</td>--}}
                {{--                                   @if ($product->id ==  session('linked-product'))--}}
                {{--                                    <td style="color: #cb7c00;  font-weight: bold;">{{ $product->category->name }}</td>--}}
                {{--                                   @else--}}
                {{--                                    <td>{{ $product->category->name }}</td>--}}
                {{--                                   @endif--}}
                {{--                                    <td>{{ $product->purchase_price }}</td>--}}
                {{--                                    <td>{{ $product->sale_price }}</td>--}}
                {{--                                    <td>{{ $product->stock }}</td>--}}
                {{--                                    <td>{{ $product->discount }} %</td>--}}
                {{--                                    <td>{{ $product->price_after_discount }}</td>--}}
                {{--                                    <td>--}}
                {{--                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>--}}

                {{--                                            <form action="{{ route('products.destroy', $product->id) }}" method="post" style="display: inline-block">--}}
                {{--                                                {{ csrf_field() }}--}}
                {{--                                                {{ method_field('delete') }}--}}
                {{--                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> Delete</button>--}}
                {{--                                            </form><!-- end of form -->--}}

                {{--                                    </td>--}}
                {{--                                </tr>--}}

                {{--                            @endforeach--}}
                {{--                            </tbody>--}}

                {{--                        </table><!-- end of table -->--}}

                {{--                        {{ $products->appends(request()->query())->links() }}--}}

                {{--                    @else--}}

                {{--                        <h2>No Data Found</h2>--}}

                {{--                    @endif--}}

                {{--                </div><!-- end of box body -->--}}
                <div class="box-body">
                    <div class="row">
                        @foreach ($products as $index=>$product)

                            <div class="col-sm-3 col-md-3">
                                <div class="thumbnail">
                                    {{-- <div class="btn-group" style="float: left;">
                                         <button type="button" class="btn btn-default dropdown-toggle"
                                                 data-toggle="dropdown">
                                             <span class="glyphicon glyphicon-option-vertical"></span>
                                         </button>
                                         <ul class="dropdown-menu" role="menu">
                                             <li><a style="margin: 0px;padding: 0px">
                                                     <button style="width: 100%;" class="btn-sm bg-light-blue-active"
                                                             href="{{ route('products.edit', $product->id) }}"><i
                                                             class="glyphicon glyphicon-edit"></i> Edit
                                                     </button>
                                                 </a></li>

                                             <li><a style="margin: 0px;padding: 0px;margin-top: 5px">
                                                     <form action="{{ route('products.destroy', $product->id) }}"
                                                           method="post">
                                                         {{ csrf_field() }}
                                                         {{ method_field('delete') }}
                                                         <button type="submit" class="btn-sm btn-danger"
                                                                 style="width: 100%;background-color: #d8222e; color: white ">
                                                             <i class="glyphicon glyphicon-trash"></i> Delete
                                                         </button>
                                                     </form>
                                                 </a>
                                             </li>
                                             <li class="divider"></li>
                                             <li><a style="margin: 0px;padding: 0px;margin-top: 5px">
                                                     <button href="" class="btn-sm btn-outline-secondary"
                                                             style="width: 100%;font-weight: bold"><i
                                                             class="fa fa-eye"></i> Details
                                                     </button>
                                                 </a>
                                             </li>
                                         </ul>

                                     </div>--}}
                                    <div class="thumbnail" style="max-height: 270px;height: 260px;alignment: center">
                                        <img class="" src="{{ $product->main_image_path }}" alt="img">
                                    </div>
                                    <div class="caption">
                                        <h3 style="font-weight: bold">{{ $product->name }}</h3>
                                        <small>{!! $product->short_description !!}</small>
                                        <p>
                                        <h4>
                                            <b>
                                                {{ $product->price_after_discount }}<i class="fa fa-fw fa-shekel"></i>
                                            </b>
                                            @php
                                                if($product->discount!=0)
                                                                        {
                                                                            echo "<small>
                                                                                    <del>$product->sale_price<i class='fa fa-fw fa-shekel'></i></del>
                                                                                  </small>";
                                                                        }
                                            @endphp
                                        </h4>
                                        <section>
                                            <h4><span class="label label-default"><span class="fa fa-fw fa-tags"></span> {{ $product->category->name }}</span><small style="font-weight: bold;color: #bb1515">@if($product->status==0) {{'UnPublish'}} @endif</small>

                                            </h4>
                                            <p style="background-color: #ECF0F5">

                                            <hr style="border-top: 3px solid #bab3b3"/>
                                            <a href="{{ route('products.edit', $product->id) }}"
                                               class="btn btn-primary"><i
                                                    class="glyphicon glyphicon-edit"></i></a>

                                            <form action="{{ route('products.destroy', $product->id) }}" method="post"
                                                  style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-danger delete"><i
                                                        class="glyphicon glyphicon-trash"></i></button>
                                            </form><!-- end of form -->
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-success"
                                               style="float: right"><i class="fa fa-eye"></i> Details</a>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div><!-- end of box -->
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </section><!-- end of content -->
    </div>
    </div><!-- end of content wrapper -->


@endsection
