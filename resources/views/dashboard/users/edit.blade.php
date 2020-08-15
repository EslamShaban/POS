@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('site.users')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                <li class="breadcrumb-item "><a href="{{route('dashboard.users.index')}}">@lang('site.users')</a></li>
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
            <form action="{{route('dashboard.users.update', $user->id)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('put') }}
                    <div class="form-group">
                        <label for="fname">@lang('site.first_name')</label>
                        <input type="text" class="form-control" id="first_name" name="f_name" value="{{$user->f_name}}">
                    </div>
                    <div class="form-group">
                        <label for="lname">@lang('site.last_name')</label>
                        <input type="text" class="form-control" id="last_name" name="l_name" value="{{$user->l_name}}">
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('site.email')</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                    </div>
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
                      <img src="{{$user->image_path}}" class="imgPreview img-thumbnail" style="width:100px" alt="" >
                  </div>
                    <div class="form-group">

                            <label>@lang('site.permission')</label>
                       
                            @php
                                $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                $permissions = ['create', 'read', 'update', 'delete']
                            @endphp

                            <ul class="nav nav-pills ml-auto p-2">
                              @foreach ($models as $index=>$model)
                              
                                <li class="nav-item"><a class="nav-link {{$index == 0 ? 'active' : ''}}" href="#{{$model}}" data-toggle="tab">@lang('site.' . $model)</a></li>

                              @endforeach
                            </ul>
                    
                            <div class="tab-content">

                                @foreach ($models as $index=>$model)
                                
                                  <div class="tab-pane {{$index == 0 ? 'active' : ''}}" id="{{$model}}">
                                      @foreach ($permissions as $perm)
                                      
                                        <label><input type="checkbox" name="permissions[]" {{$user->hasPermission($perm . '-' . $model)?'checked':''}} value="{{$perm  . '-' . $model}}"> @lang('site.' . $perm)</label> 

                                      @endforeach

                                  </div>

                                @endforeach

                            </div>
                            <!-- /.tab-content -->

                        </div>
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