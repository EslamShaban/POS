@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0 text-dark">@lang('site.users') <small>{{$users->total()}}</small></h1>
          </div><!-- /.col -->
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                <li class="breadcrumb-item active">@lang('site.users')</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-sm-12">
            <form action="{{route("dashboard.users.index")}}" method="GET">
                <div class="row">
                    <div class="col-sm-8 mb-2">
                        <input type="search" name="search" value="{{request()->search}}" class="form-control" placeholder="@lang('site.search')">
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('create-users'))
                            <a href="{{route('dashboard.users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
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
                <h3 style="float:right" class="card-title">@lang('site.users')</h3>
            </div>
            <!-- /.card-header -->
                @if($users->count() > 0)
                    <div class="card-body">
                        
                        <table class="table table-bordered table-hover">
                        <thead>                  
                            <tr>
                            <th>#</th>
                            <th>@lang('site.first_name')</th>
                            <th>@lang('site.last_name')</th>
                            <th>@lang('site.email')</th>
                            <th>@lang('site.image')</th>
                            <th>@lang('site.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index=>$user)
                                <tr>
                                    <td>{{$index + 1 }}</td>
                                    <td>{{$user->f_name }}</td>
                                    <td>{{$user->l_name}}</td>
                                    <td>{{$user->email }}</td>
                                    <td><img src="{{$user->image_path}}" style="width:100px" class="img-thumbnail" alt=""></td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update-users'))
                                            <a href="{{route('dashboard.users.edit', $user->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                        
                                            <a href="#" class="btn btn-sm btn-info disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>

                                        @endif
                                        @if(auth()->user()->hasPermission('delete-users'))
                                            <form action="{{route('dashboard.users.destroy', $user->id)}}" method="POST" style="display:inline-block">
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
                            {{$users->appends(request()->query())->links("pagination::bootstrap-4")}}
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