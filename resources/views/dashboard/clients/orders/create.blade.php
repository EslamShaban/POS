@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('site.add_order')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                <li class="breadcrumb-item "><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a></li>
                <li class="breadcrumb-item active">@lang('site.add_order')</li>
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
          <div class="col-md">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">@lang('site.categories')</h3>
              </div>
              <div class="card-body">
                @foreach ($categories as $category)

                  <div class="card-group">
                    <div class="card ">
                      <div class="card-header" style="background-color:#d1ecf1;">
                        <h4 class="card-title">
                          <a style="color:#58a2c3" data-toggle="collapse" href="#{{str_replace(' ', '-', $category->name)}}">{{$category->name}}</a>
                        </h4>
                      </div>
                      <div id="{{str_replace(' ', '-', $category->name)}}" class="card-collapse collapse">
                        <div class="card-body">
                          @if($category->products->count() > 0)
                            <table class="table table-hover">
                              <tr>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.stock')</th>
                                <th>@lang('site.price')</th>
                                <th>@lang('site.add')</th>
                              </tr>
                              @foreach($category->products as $product)
                                <tr>
                                  <td>{{$product->name}}</td>
                                  <td>{{$product->stock}}</td>
                                  <td>{{number_format($product->sale_price, 2)}}</td>
                                  <td>
                                    <a 
                                    href="" 
                                    id="product-{{$product->id}}" 
                                    data-name="{{$product->name}}" 
                                    data-id="{{$product->id}}" 
                                    data-price="{{$product->sale_price}}" 
                                    class="btn btn-success btn-sm add-product-btn"
                                    ><i class="fa fa-plus"></i></a>
                                  </td>
                                </tr>
                              @endforeach
                            </table>
                            @else 
                             <h5>@lang('site.no_data_found')</h5>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                    
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">@lang('site.orders')</h3>
              </div>
              <div class="card-body">
                <form action="{{route('dashboard.clients.orders.store', $client->id)}}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('post') }}
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>@lang('site.product')</th>
                        <th>@lang('site.quantity')</th>
                        <th>@lang('site.price')</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody class="order-list">

                    </tbody>
                  </table>
                  <h4>
                    @lang('site.total') : <span class="total-price">0</span>
                  </h4>
                  <button class="btn btn-primary btn-block disabled" id="add-order-form-btn"><i class="fa fa-plus"></i> @lang('site.add_order')</button>
                </form>
              </div>
            </div>
            @if($client->orders->count() > 0)
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">@lang('site.previous_orders')</h3>
              </div>
              <div class="card-body">

                  @foreach ($client->orders as $order)

                  <div class="card-group">
                    <div class="card ">
                      <div class="card-header" style="background-color:#d1ecf1;">
                        <h4 class="card-title">
                          <a style="color:#58a2c3" data-toggle="collapse" href="#{{'product-id' . $order->id}}">{{$order->created_at->toFormattedDateString()}}</a>
                        </h4>
                      </div>
                      <div id="{{'product-id' . $order->id}}" class="card-collapse collapse">
                        <div class="card-body">

                          <ul class="list-group">
                            @foreach($order->products as $product)
                              <li class="list-group-item">{{$product->name}}</li>
                            @endforeach
                          </ul>

                        </div>
                      </div>
                    </div>
                  </div>
                    
                @endforeach
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection