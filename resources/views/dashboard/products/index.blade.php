@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0 text-dark">@lang('site.products') <small></small></h1>
          </div><!-- /.col -->
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                <li class="breadcrumb-item active">@lang('site.products')</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-sm-12">
            <form action="{{route("dashboard.products.index")}}" method="GET">
                <div class="row">
                    <div class="col-sm-4 mb-2">
                        <input type="search" name="search" value="{{request()->search}}" class="form-control" placeholder="@lang('site.search')">
                    </div>
                    <div class="col-sm-4 mb-2">
                        <select name="category_id" class="form-control">
                          <option value="">@lang('site.all_categories')</option>
                          @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{request()->category_id == $category->id ? 'selected' : ""}}>{{$category->name}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('create-products'))
                            <a href="{{route('dashboard.products.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                        @else
                        
                            <a href="" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>

                        @endif
                    </div>
                </div>
            </form>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 style="float:right" class="card-title">@lang('site.products')</h3>
            </div>
            <!-- /.card-header -->
                @if($products->count() > 0)
                    <div class="card-body">
                        
                        <table class="table table-bordered table-hover">
                        <thead>                  
                            <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.decription')</th>
                            <th>@lang('site.category')</th>
                            <th>@lang('site.image')</th>
                            <th>@lang('site.purchase_price')</th>
                            <th>@lang('site.sale_price')</th>
                            <th>@lang('site.profit_percent')%</th>
                            <th>@lang('site.stock')</th>
                            <th>@lang('site.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index=>$product)
                                <tr>
                                    <td>{{$index + 1 }}</td>
                                    <td>{{$product->name }}</td>
                                    <td>{!! $product->description !!}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td><img src="{{$product->image_path}}" style="width:100px" class="img-thumbnail" alt=""></td>
                                    <td>{{$product->purchase_price }}</td>
                                    <td>{{$product->sale_price }}</td>
                                    <td>{{$product->profit_percent }}%</td>
                                    <td>{{$product->stock }}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update-products'))
                                            <a href="{{route('dashboard.products.edit', $product->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                        
                                            <a href="#" class="btn btn-sm btn-info disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>

                                        @endif
                                        @if(auth()->user()->hasPermission('delete-products'))
                                            <form action="{{route('dashboard.products.destroy', $product->id)}}" method="POST" style="display:inline-block">
                                                {{ csrf_field() }}
                                                {{method_field('delete')}}
                                               
                                                <button type="submit" onclick="confirmDelete('@lang('site.edit')')" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            </form>
                                        @else
                                        
                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{$products->appends(request()->query())->links("pagination::bootstrap-4")}}
                        </ul>
                    </div>
                @else

                    <h2>@lang('site.no_data_found')</h2>
                @endif
            </div>
            <!-- /.card -->
    </div>
    <!-- /.content -->
  </div>
@endsection