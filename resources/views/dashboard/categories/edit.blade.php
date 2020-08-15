@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('site.categories')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                <li class="breadcrumb-item "><a href="{{route('dashboard.categories.index')}}">@lang('site.categories')</a></li>
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
            <h3 class="card-title">@lang('site.edit')</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->


          @include('partials._errors')

          <div class="card-body">
            <form action="{{route('dashboard.categories.update', $category->id)}}" method="post" >
                  {{ csrf_field() }}
                  {{ method_field('put') }}

                    @foreach (config('translatable.locales') as $locale)
                      <div class="form-group">
                        <label for="name">@lang('site.' . $locale . '.name')</label>
                        <input type="text" class="form-control" id="name" name="{{$locale}}[name]" value="{{$category->translate($locale)->name}}">
                      </div> 
                    @endforeach
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