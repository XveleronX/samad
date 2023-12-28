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

        @include('first_project.header.data.ordersData_header')
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{--<div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>--}}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="container">
                                <table id="Data" class="table table-bordered table-striped">
                                    @if(auth()->user()->role == 'user')
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>اسم سفارش</th>
                                            <th>مشتری</th>
                                            <th>لیست محصولات</th>
                                            <th>قیمت کل</th>
                                            <th>ویرایش</th>
                                            <th>حذف</th>
                                            <th>پرداخت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($temp = 0)
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{$order->id}}</td>
                                                <td>{{$order->title}}</td>
                                                <td>
                                                    <a class="btn" data-bs-toggle="collapse"
                                                       href="#collapseC{{$order->user_id}}{{$temp}}">
                                                        {{$order->user_id}}
                                                    </a>
                                                    <div id="collapseC{{$order->user_id}}{{$temp++}}"
                                                         class="collapse"
                                                         data-bs-parent="#accordion">
                                                        <div class="card-body">
                                                            <table>
                                                                <tr>
                                                                    <th>{{$order->user->first_name}} {{$order->user->last_name}}</th>
                                                                    <th>{{$order->user->email}}</th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn" data-bs-toggle="collapse"
                                                       href="#collapseP{{$order->id}}">
                                                        All products
                                                    </a>
                                                    <div id="collapseP{{$order->id}}" class="collapse"
                                                         data-bs-parent="#accordion">
                                                        <div class="card-body">
                                                            <table>
                                                                @foreach($order->products as $product)

                                                                    <tr>
                                                                        <td>name : {{ $product->titel }}</td>
                                                                        <td>price : {{$product->price}}</td>
                                                                        <td>count : {{$product->pivot->count}}</td>
                                                                    </tr>

                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $order->total_price }}</td>

                                                <td>
                                                    <form class="" action="{{route('orders.edit',['id'=>$order->id])}}"
                                                          method="get">
                                                        <button type="submit">
                                                            <i class="fa-regular fa-pen-to-square fa-flip-horizontal"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form class="" action="{{route('orders.destroy',['id'=>$order->id])}}"
                                                          method="post">
                                                        @csrf
                                                        <button type="submit" onclick="return confirm('Are you sure?')">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form class="" action="{{route('checks.pay',['id'=>$order->id])}}">
                                                        @csrf
                                                        {{--@method('PUT')--}}
                                                        <input type="hidden" name="purches" value="{{--{{ $user->id }}--}}">
                                                        <button type="submit">
                                                            <i class="fa-regular fa-cc-paypal"></i>
                                                        </button>

                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    @elseif(auth()->user()->role == 'seller')
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>اسم سفارش</th>
                                            <th>مشتری</th>
                                            <th>لیست محصولات</th>
                                            <th>قیمت کل</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($temp = 0)
                                        @foreach ($orders as $order)
                                            @foreach($ids as $id)
                                                @if($id->order_id == $order->id)
                                            <tr>
                                                <td>{{$order->id}}</td>
                                                <td>{{$order->title}}</td>
                                                <td>
                                                    <a class="btn" data-bs-toggle="collapse"
                                                       href="#collapseC{{$order->user_id}}{{$temp}}">
                                                        {{$order->user_id}}
                                                    </a>
                                                    <div id="collapseC{{$order->user_id}}{{$temp++}}"
                                                         class="collapse"
                                                         data-bs-parent="#accordion">
                                                        <div class="card-body">
                                                            <table>
                                                                <tr>
                                                                    <th>{{$order->user->first_name}} {{$order->user->last_name}}</th>
                                                                    <th>{{$order->user->email}}</th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn" data-bs-toggle="collapse"
                                                       href="#collapseP{{$order->id}}">
                                                        All products
                                                    </a>
                                                    <div id="collapseP{{$order->id}}" class="collapse"
                                                         data-bs-parent="#accordion">
                                                        <div class="card-body">
                                                            <table>
                                                                @foreach($order->products as $product)

                                                                    <tr>
                                                                        <td>name : {{ $product->titel }}</td>
                                                                        <td>price : {{$product->price}}</td>
                                                                        <td>count : {{$product->pivot->count}}</td>
                                                                    </tr>

                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $order->total_price }}</td>

                                                {{--<td>
                                                    <form class="" action="{{route('orders.edit',['id'=>$order->id])}}"
                                                          method="get">
                                                        <button type="submit">
                                                            <i class="fa-regular fa-pen-to-square fa-flip-horizontal"></i>
                                                        </button>
                                                    </form>
                                                </td>--}}
                                                {{--<td>
                                                    <form class="" action="{{route('orders.destroy',['id'=>$order->id])}}"
                                                          method="post">
                                                        @csrf
                                                        <button type="submit" onclick="return confirm('Are you sure?')">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </td>--}}
                                            </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    @elseif(auth()->user()->role == 'admin')
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>اسم سفارش</th>
                                            <th>مشتری</th>
                                            <th>لیست محصولات</th>
                                            <th>قیمت کل</th>
                                            <th>پرداخت</th>
                                            <th>ویرایش</th>
                                            <th>حذف</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($temp = 0)
                                        @foreach ($orders as $order)
                                            @foreach($statuses as $status)
                                                @if($status->order_id == $order->id)
                                            <tr>
                                                <td>{{$order->id}}</td>
                                                <td>{{$order->title}}</td>
                                                <td>
                                                    <a class="btn" data-bs-toggle="collapse"
                                                       href="#collapseC{{$order->user_id}}{{$temp}}">
                                                        {{$order->user_id}}
                                                    </a>
                                                    <div id="collapseC{{$order->user_id}}{{$temp++}}"
                                                         class="collapse"
                                                         data-bs-parent="#accordion">
                                                        <div class="card-body">
                                                            <table>
                                                                <tr>
                                                                    <th>{{$order->user->first_name}} {{$order->user->last_name}}</th>
                                                                    <th>{{$order->user->email}}</th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn" data-bs-toggle="collapse"
                                                       href="#collapseP{{$order->id}}">
                                                        All products
                                                    </a>
                                                    <div id="collapseP{{$order->id}}" class="collapse"
                                                         data-bs-parent="#accordion">
                                                        <div class="card-body">
                                                            <table>
                                                                @foreach($order->products as $product)

                                                                    <tr>
                                                                        <td>name : {{ $product->titel }}</td>
                                                                        <td>price : {{$product->price}}</td>
                                                                        <td>count : {{$product->pivot->count}}</td>
                                                                    </tr>

                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $order->total_price }}</td>
                                                @if($status->pay_status == 'paid')
                                                <td>✔</td>
                                                @else
                                                <td>❌</td>
                                                @endif
                                                <td>
                                                    <form class="" action="{{route('orders.edit',['id'=>$order->id])}}"
                                                          method="get">
                                                        <button type="submit">
                                                            <i class="fa-regular fa-pen-to-square fa-flip-horizontal"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form class="" action="{{route('orders.destroy',['id'=>$order->id])}}"
                                                          method="post">
                                                        @csrf
                                                        <button type="submit" onclick="return confirm('Are you sure?')">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    @endif

                                    {{--<tfoot>
                                    <tr>
                                        <th>مشتری</th>

                                        <th>لیست محصولات</th>
                                        <th>قیمت کل</th>

                                        <th>ویرایش</th>
                                        <th>حذف</th>
                                    </tr>
                                    </tfoot>--}}
                                </table>
                            </div>
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
