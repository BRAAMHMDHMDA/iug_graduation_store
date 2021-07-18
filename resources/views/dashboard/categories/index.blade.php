@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>Categories</h1>

            <ol class="breadcrumb">
                <li class="active">categories</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">


                    <form action="{{ route('categories.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <p><input type="text" name="search" class="form-control"
                                          placeholder="search by category name" value="{{ request()->search }}">
                                </p>  <a href="{{ route('categories.index') }}" class="btn btn-default"
                                         style="color: #00A65A"><i class="glyphicon glyphicon-refresh"></i> Refresh</a>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search
                                </button>
                                <a href="{{ route('categories.create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i> Add Category</a>
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($categories->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                {{--                                <th>@lang('site.products_count')</th>--}}
                                {{--                                <th>@lang('site.related_products')</th>--}}
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($categories as $index=>$category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td style="width: 250px" ><img class="img-thumbnail" src="{{ $category->image_path }}" style="max-width: 100px" alt="img"></td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <a href="{{ url('products?category_id='. $category->id) }}"><button class="btn btn-sm"><i class="glyphicon glyphicon-new-window"></i> Linked Products</button></a>
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                           class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="post"
                                              style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i
                                                    class="fa fa-trash"></i> Delete
                                            </button>
                                        </form><!-- end of form -->

                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                                                {{ $categories->appends(request()->query())->links() }}

                    @else

                        <h2>No Data Found</h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
