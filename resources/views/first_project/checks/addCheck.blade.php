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
            <div class="container-fluid">
                <form role="form" method="post" action="{{route('checks.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="order_id">اسم سفارش</label>
                            <select name="order_id" class="form-control" onchange="updateTotalPrice(this)">
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}" data-total-price="{{ $order->total_price }}">
                                        {{ $order->title }}
                                    </option>
                                @endforeach
                            </select>


                            <div class="form-group">
                                <label for="total_pay">مبلغ فاکتور</label>
                                <input type="text" class="form-control" id="total_price" name="total_price" readonly>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- /.card -->


    <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('first_project.footer.main_footer')

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('first_project.scripts')
<script>
    function updateTotalPrice(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var totalPrice = selectedOption.getAttribute('data-total-price');
        document.getElementById('total_price').value = totalPrice;
    }
</script>

</body>

</html>
