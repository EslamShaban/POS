@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('site.clients')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                <li class="breadcrumb-item "><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a></li>
                <li class="breadcrumb-item active">@lang('site.edit')</li>
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
            <form action="{{route('dashboard.clients.update', $client->id)}}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('put') }}
                <div class="form-group">
                  <label for="name">@lang('site.name')</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{$client->name}}">
                </div> 
                @for ($i = 0; $i < 2; $i++)
                  <div class="form-group">
                    <label for="phone">@lang('site.phone')</label>
                    <input type="text" class="form-control" id="phone" name="phone[]" value="{{$client->phone[$i] ?? ''}}">
                  </div> 
                @endfor

                <div class="form-group">
                  <label for="address">@lang('site.address')</label>
                  <textarea class="form-control" id="address" name="address">{{$client->address}}</textarea>
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