@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Products</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('products.index') }}"> products</a></li>
                <li class="active">edit</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">Edit</h3>
                </div><!-- end of box header -->
                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" PLACEHOLDER="name of product" required>
                        </div>
                        <div class="form-group">
                            <label>Categories</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Choose Category --</option>
                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}" {{ $product->category->id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Short Description</label>
                            <input type="text" name="short_description" class="form-control"
                                   value="{{ $product->short_description }}" required placeholder="short description">
                        </div>
                        <div class="form-group">
                            <label>Long Description</label>
                            <textarea name="long_description" class="form-control ckeditor"
                                      required>{{$product->long_description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" min="0" class="form-control" value="{{ $product->stock }}" placeholder="stock" required>
                        </div>
                        <div class="form-group">
                            <label>Purchase price</label>
                            <input type="number" name="purchase_price" min="0" step="0.01" class="form-control"
                                   value="{{ $product->purchase_price }}" placeholder="purchase price" required>
                        </div>
                        <div class="form-group">
                            <label>Sale price</label>
                            <input type="number" name="sale_price" min="0" step="0.01" class="form-control"
                                   value="{{ $product->sale_price }}" placeholder="sale price" required>
                        </div>
                        <div class="form-group">
                            <label>Discount</label>
                            <input type="number" name="discount" min="0" max="100.00" class="form-control"
                                   value="{{$product->discount}}" placeholder="discount">
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Main Image</label>
                                <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" name="main_image" id="imgInp">
                                    </span>
                                </span>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <img src="{{ $product->main_image_path }}" id='img-upload'/>
                            </div>
                        </div>
                        <br/>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>Additional Images</label>
                                <div class="row">
                                        <div class="col-md-3 imgUp">
                                            <div class="imagePreview"></div>
                                            <label class="btn btn-primary btn-primary-upload">Upload
                                                <input type="file" name="images[]" class="uploadFile img "
                                                       value=""
                                                       style="width: 0px;height: 0px;overflow: hidden;">
                                            </label>
                                            <i class="fa fa-times del"></i>
                                        </div>
                                    <i class="fa fa-plus imgAdd"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="radio" name="status" value="1" @if($product->status==1) checked @endif> Publish
                            </label>
                            <label>
                                <input type="radio" name="status" value="0" @if($product->status==0) checked @endif> UnPublish
                            </label>
                        </div>

                        <div class=" form-group">
                                <button type="submit" class="btn btn-primary" style="width: 120px;"><i class="fa fa-plus"></i> Update
                                </button>
                            </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
