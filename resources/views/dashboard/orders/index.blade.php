@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0 text-dark">@lang('site.orders') <small></small></h1>
          </div><!-- /.col -->
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                <li class="breadcrumb-item active">@lang('site.orders')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 style="float:right" class="card-title">@lang('site.orders')</h3>
                </div>
                <div class="col-sm-12 mt-4" >
                    <form action="{{route("dashboard.orders.index")}}" method="GET">
                        <div class="row">
                            <div class="col-sm-8 mb-2">
                                <input type="search" name="search" value="{{request()->search}}" class="form-control" placeholder="@lang('site.search')">
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-header -->
                    @if($orders->count() > 0)
                        <div class="card-body table-responsive">
                            
                            <table class="table table-hover  ">
                            <thead>                  
                                <tr>
                                <th>#</th>
                                <th>@lang('site.client_name')</th>
                                <th>@lang('site.price')</th>
                                <th>@lang('site.status')</th>
                                <th>@lang('site.created_at')</th>
                                <th>@lang('site.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index=>$order)
                                    <tr>
                                        <td>{{$index + 1 }}</td>
                                        <td>{{$order->client->name }}</td>
                                        <td>{{ number_format($order->total_price, 2) }}</td>
                                        <td></td>
                                        <td>{{$order->created_at->toFormattedDateString() }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm order-products" data-method="get" data-url="{{route('dashboard.orders.products', $order->id)}}">
                                                <i class="fa fa-list fa-sm"></i>
                                                @lang('site.show')
                                            </button>
                                            @if(auth()->user()->hasPermission('update-orders'))
                                                <a href="{{route('dashboard.clients.orders.edit', [$order->client->id, $order->id])}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @else
                                            
                                                <a href="#" class="btn btn-sm btn-info disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
    
                                            @endif
                                            @if(auth()->user()->hasPermission('delete-orders'))
                                                <form action="{{route('dashboard.orders.destroy', $order->id)}}" method="POST" style="display:inline-block">
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
                                {{$orders->appends(request()->query())->links("pagination::bootstrap-4")}}
                            </ul>
                        </div>
                    @else
    
                        <h2>@lang('site.no_data_found')</h2>
                    @endif
                </div>
                <!-- /.card -->
          </div>
          <div class="col-md">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">@lang('site.show_products')</h3>
              </div>
              <div class="card-body">
                <div id="loading" style="display:none">
                    <div class="loader">
                    </div>
                    <p style="margin-top:-10px; text-align:center">@lang('site.loading')</p> 
                </div>
                <div id="order-product-list">
                  
                </div>
                <button class="btn btn-primary btn-block print-btn" style="display:none"><i class="fa fa-print"></i> @lang('site.print')</button>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection