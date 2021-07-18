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


                    <form action="{{ route('customers.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                          placeholder="search by phone number" value="{{ request()->search }}">

                            </div>


                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search
                                </button>
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($customers->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Phone Number</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($customers as $index=>$customer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td style="width: 250px" ><img class="img-thumbnail" src="{{ $customer->image_path }}" style="max-width: 100px" alt="img"></td>
                                    <td>{{ $customer->phone_number }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>
{{--                                        <a href="{{ url('products?category_id='. $customer->id) }}"><button class="btn btn-sm"><i class="glyphicon glyphicon-new-window"></i> Linked Products</button></a>--}}

                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="post"
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

                        {{ $customers->appends(request()->query())->links() }}

                    @else

                        <h2>No Data Found</h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
