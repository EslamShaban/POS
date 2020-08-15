@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('site.dashboard')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">@lang('site.dashboard')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$categories_count}}</h3>

                <p>@lang('site.categories')</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{route('dashboard.categories.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$products_count}}</h3>

                <p>@lang('site.products')</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('dashboard.products.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$clients_count}}</h3>

                <p>@lang('site.clients')</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('dashboard.clients.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$users_count}}</h3>

                <p>@lang('site.users')</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('dashboard.users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- Main row -->
        <div class="row">
            <!-- solid sales graph -->
            <div class="col-lg-12 card bg-gradient-info">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Sales Graph
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="line-chart" style=""></div>              
              </div>
              <!-- /.card-body -->
            </div>

        </div>
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

    <!-- /.content -->
  </div>

@endsection

@push('scripts')


    <script>

      var line = new Morris.Line({

        element: 'line-chart',
        resize: true,
        data : [
          @foreach($sales_data as $data)
            {
              ym: "{{$data->year}}-{{$data->month}}", sum: "{{$data->sum}}"
            },
          
          @endforeach
        ],

        xkey: 'ym',
        ykeys:['sum'],
        labels: ['@lang('site.total')'],
        lineWidth: 2,
        hideHover: 'auto',
        gridStrokeWidth: 0.4,
        pointSize: 4,
        gridTextFamily: 'open Sans',
        gridTextSize:10,
        pointFillColors: ['#ffffff'],
        pointStrokeColors: ['white'],
        lineColors: ['white'],
        gridTextColor: ['white'],
        goalLineColors: ['red']
      });
    </script>
    
@endpush

