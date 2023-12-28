<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت | داشبورد اول</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('first_project.styleSheets.styleSheets')
    <link rel="stylesheet" href="{{asset('persenalCss/app.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    @include('first_project.navbar.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        @include('first_project.Sidebar.Sidebar')
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        @include('first_project.header.adding.addCheck_header')
        <!-- /.content-header -->
        <!-- Main row -->
        <section class="content">
            <!-- form start -->
{{--            @dd($check)--}}

@foreach($checks as $check)
            <div class="container-fluid">
                <form role="form" method="post" action="{{route('checks.update',['id' => $check->id]) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="order_number">شماره سفارش</label>
                            <input type="number" class="form-control" id="order_number" name="order_id"
                                   placeholder="{{$check->id}}" value="{{$check->id}}">
                            <div class="form-group">
                                <label for="total_pay">مبلغ فاکتور</label>
                                <input type="number" class="form-control" id="total_pay" name="total_pay"
                                       placeholder="{{$check->order->total_price}}" value="{{$check->total_price}}" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                </form>
            </div>
            @endforeach
        </section>
    </div>
    <!-- /.card -->


    <!-- /.row (main row) -->
</div><!-- /.container-fluid -->

<!-- /.content -->

<!-- /.content-wrapper -->

@include('first_project.footer.main_footer')

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- ./wrapper -->
@include('first_project.scripts')
</body>

</html>
