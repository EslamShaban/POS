@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('site.products')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                <li class="breadcrumb-item "><a href="{{route('dashboard.products.index')}}">@lang('site.products')</a></li>
                <li class="breadcrumb-item active">@lang('site.add')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      
        <div class="card card-primary">
          <div class="card-header">
            <h3  class="card-title">@lang('site.edit')</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->


          @include('partials._errors')

          <div class="card-body">
            <form action="{{route('dashboard.products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{ method_field('put') }}
                  <div class="form-group">
                    <label for="categories">@lang('site.categories')</label>
                    <select id="categories" name="category_id" class="form-control">
                      <option value="">@lang('site.all_categories')</option>
                      @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : ""}}>{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div> 
                  @foreach (config('translatable.locales') as $locale)
                      <div class="form-group">
                        <label for="name">@lang('site.' . $locale . '.name')</label>
                        <input type="text" class="form-control" id="name" name="{{$locale}}[name]" value="{{$product->name}}">
                      </div> 
                      <div class="form-group">
                        <label for="description">@lang('site.' . $locale . '.description')</label>
                        <textarea class="form-control ckeditor" id="description" name="{{$locale}}[description]">{{$product->description}}</textarea>
                      </div> 
                  @endforeach
                  <div class="form-group">
                    <label for="exampleInputFile">@lang('site.image')</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input image" name="image" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <img src="{{$product->image_path}}" class="imgPreview img-thumbnail" style="width:100px" alt="" >
                </div>
                <div class="form-group">
                  <label for="purchasePrice">@lang('site.purchase_price')</label>
                  <input type="number" class="form-control" step="0.01" id="purchasePrice" name="purchase_price" value="{{$product->purchase_price}}">
                </div> 
                <div class="form-group">
                  <label for="salePrice">@lang('site.sale_price')</label>
                  <input type="number" class="form-control" step="0.01" id="salePrice" name="sale_price" value="{{$product->sale_price}}">
                </div> 
                <div class="form-group">
                  <label for="stock">@lang('site.stock')</label>
                  <input type="number" class="form-control" id="stock" name="stock" value="{{$product->stock}}">
                </div> 
              </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
  
      </section>
    <!-- /.content -->
  </div>
@endsection