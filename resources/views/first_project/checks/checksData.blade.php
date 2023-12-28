<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت | جدول داده</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('first_project.styleSheets.dataStyle')
    @include('first_project.styleSheets.styleSheets')

</head>
<body class="hold-transition sidebar-mini">
@if(Session::has('paid'))
    <script>
        alert("{{ Session::get('paid') }}");
    </script>
@endif
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

        @include('first_project.header.data.checksData_header')
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="accordionHead">
                                <form role="form" method="get" action="route('filterUsers') ">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#fillters">
                                                فیلتر ها
                                            </a>
                                        </div>
                                        <div class="collapse" id="fillters" data-bs-parent="#accordionHead">
                                            <div class="card-body">
                                                <div class="form-control">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="filterOrderId ">شماره سفارش</label>
                                                                <input type="text" class="form-control"
                                                                       id="filterOrderId"
                                                                       name="filterOrderId" placeholder="شماره سفارش"
                                                                       @if(isset($_GET['filterOrderId']))
                                                                           value="{{$_GET['filterOrderId']}}"
                                                                        @endif>
                                                            </div>
                                                            <div class="col">
                                                                <label for="filterLastName">نام محصول</label>
                                                                <input type="text" class="form-control"
                                                                       id="filterLastName"
                                                                       name="filterLastName"
                                                                       placeholder="نام محصول "
                                                                       @if(isset($_GET['filterLastName']))
                                                                           value="{{$_GET['filterLastName']}}"
                                                                        @endif>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="filterUserName">نام کاربری</label>
                                                                <input type="text" class="form-control"
                                                                       id="filterUserName"
                                                                       name="filterUserName"
                                                                       placeholder="نام کاربری"
                                                                       @if(isset($_GET['filterUserName']))
                                                                           value="{{$_GET['filterUserName']}}"
                                                                        @endif>
                                                            </div>
                                                            <div class="col">
                                                                <div class="row">

                                                                    <div class="col">
                                                                        <label for="filterOrderTotalPriceMin">قیمت</label>
                                                                        <label for="filterOrderTotalPriceMin"
                                                                               id="filterAge">از</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filterOrderTotalPriceMin" name="filterAgeMin"
                                                                               placeholder="از"
                                                                               @if(isset($_GET['filterOrderTotalPriceMin']))
                                                                                   value="{{$_GET['filterOrderTotalPriceMin']}}"
                                                                                @endif>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="filterOrderTotalPriceMax">تا</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filterOrderTotalPriceMax" name="filterOrderTotalPriceMax"
                                                                               placeholder="تا"
                                                                               @if(isset($_GET['filterOrderTotalPriceMax']))
                                                                                   value="{{$_GET['filterOrderTotalPriceMax']}}"
                                                                                @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-info">فیلتر</button>
                                                <a href="{{ route('users.index') }}">
                                                    <button type="button" class="btn btn-warning">حذف فیلتر ها</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table id="Data" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>شماره سفارش</th>
                                    <th>مبلغ فاکتور</th>
                                    <th>مشتری</th>
                                    <th>لیست محصولات</th>
                                    <th>تاریخ ثبت فاکتور</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>
                                    <th>پرداخت</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($checks as $check)
                                    @foreach($users as $user)
                                        @foreach($products as $product)
                                        @if($user->id == $check->order_id)
                                        @if($product->id == $check->order_id)
                                    <tr>
                                        <td>{{ $check->order_id}}</td>
                                        <td>{{ $check->order->total_price }}</td>

                                        <td> {{$user->user->last_name}} </td>

                                        <td>
                                            <a class="btn" data-bs-toggle="collapse"
                                               href="#collapseP{{$check->order_id}}">
                                                All products
                                            </a>
                                            <div id="collapseP{{$check->order_id}}" class="collapse"
                                                 data-bs-parent="#accordion">
                                                <div class="card-body">
                                                    <table>
                                                        @foreach($product->products as $producct)

                                                            <tr>
                                                                <td>name : {{ $producct->titel }}</td>
                                                                <td>price : {{$producct->price}}</td>
                                                                <td>count : {{$producct->pivot->count}}</td>
                                                            </tr>

                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $check->created_at}}</td>
                                        <td>
                                            <form class="" action="{{route('checks.edit',['id'=>$check->id])}}">
                                            @csrf
                                            {{--@method('PUT')--}}
                                            <input type="hidden" name="id" value="{{--{{ $user->id }}--}}">
                                            <button type="submit">
                                                <i class="fa-regular fa-pen-to-square fa-flip-horizontal"></i>
                                            </button>

                                            </form>
                                        </td>
                                        <td>
                                            <form class="" action="{{route('checks.destroy',['id'=>$check->id])}}" method="post">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Are you sure?')">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form class="" action="{{route('checks.pay',['id'=>$check->id])}}">
                                                @csrf
                                                {{--@method('PUT')--}}
                                                <input type="hidden" name="purches" value="{{--{{ $user->id }}--}}">
                                                <button type="submit">
                                                    <i class="fa-regular fa-cc-paypal"></i>
                                                </button>

                                            </form>
                                        </td>
                                    </tr>
                                        @endif
                                        @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>شماره سفارش</th>
                                    <th>مبلغ فاکتور</th>
                                    <th>مشتری</th>
                                    <th>لیست محصولات</th>
                                    <th>تاریخ ثبت فاکتور</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>
                                    <th>پرداخت</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
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
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- page script -->

<script>
    $(function () {
        $('#Data').DataTable({
            "language":
                {
                    "paginate":
                        {
                            "next": "بعدی",
                            "previous": "قبلی"
                        },
                    "search": "جست و جو : ",
                },

            "info": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "autoWidth": true
        });
    });
</script>

</body>
</html>
