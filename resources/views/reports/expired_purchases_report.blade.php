@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/daterangepicker/daterangepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/datatables/jquery.dataTables.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.reports')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.expired_purchases_report')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-credit-card"></i>  {{__('page.expired_purchases_report')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                {{-- <div class="">
                    @include('elements.pagesize')
                    <form action="" method="POST" class="form-inline top-search-form float-left" id="searchForm">
                        @csrf
                        @if ($role == 'admin')    
                            <select class="form-control form-control-sm mr-sm-2 mb-2" name="company_id" id="search_company">
                                <option value="" hidden>{{__('page.select_company')}}</option>
                                @foreach ($companies as $item)
                                    <option value="{{$item->id}}" @if ($company_id == $item->id) selected @endif>{{$item->name}}</option>
                                @endforeach        
                            </select>
                        @endif
                        <select class="form-control form-control-sm mr-sm-2 mb-2" name="store_id" id="search_store">
                            <option value="" hidden>{{__('page.select_store')}}</option>
                            @foreach ($stores as $item)
                                <option value="{{$item->id}}" @if ($store_id == $item->id) selected @endif>{{$item->name}}</option>
                            @endforeach        
                        </select>
                        <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="reference_no" id="search_reference_no" value="{{$reference_no}}" placeholder="{{__('page.reference_no')}}">
                        <select class="form-control form-control-sm mr-sm-2 mb-2 select2-show-search" name="supplier_id" id="search_supplier" data-placeholder="{{__('page.select_supplier')}}">
                            <option label="{{__('page.select_supplier')}}"></option>
                            @foreach ($suppliers as $item)
                                <option value="{{$item->id}}" @if ($supplier_id == $item->id) selected @endif>{{$item->name}}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control form-control-sm mx-sm-2 mb-2" name="period" id="period" autocomplete="off" value="{{$period}}" placeholder="{{__('page.purchase_date')}}">
                        <input type="text" class="form-control form-control-sm mx-sm-2 mb-2" name="expiry_date" id="expiry_date" autocomplete="off" value="{{$expiry_date}}" placeholder="{{__('page.expiry_date')}}">
                        <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fa fa-search"></i>&nbsp;&nbsp;{{__('page.search')}}</button>
                        <button type="button" class="btn btn-sm btn-info mb-2 ml-1" id="btn-reset"><i class="fa fa-eraser"></i>&nbsp;&nbsp;{{__('page.reset')}}</button>
                    </form>
                </div> --}}
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover" id="expiredTable">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th style="width:40px;">#</th>
                                <th>{{__('page.date')}}</th>
                                <th>{{__('page.expiry_date')}}</th>
                                <th>{{__('page.reference_no')}}</th>
                                <th>{{__('page.company')}}</th>
                                <th>{{__('page.store')}}</th>
                                <th>{{__('page.supplier')}}</th>
                                <th>{{__('page.product_qty')}}</th>
                                <th>{{__('page.grand_total')}}</th>
                                <th>{{__('page.paid')}}</th>
                                <th>{{__('page.balance')}}</th>
                                <th>{{__('page.purchase_status')}}</th>
                                {{-- <th>Payment Status</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_grand = $total_paid = 0;
                                $i = 0;
                            @endphp
                            @foreach ($data as $item)
                                @php
                                    $grand_total = $item->grand_total;
                                    $paid = $item->payments()->sum('amount');
                                    if($grand_total == $paid) continue;
                                    $orders = $item->orders;
                                    $product_array = array();
                                    foreach ($orders as $order) {
                                        $product_name = isset($order->product->name) ? $order->product->name : "product";
                                        $product_quantity = $order->quantity;
                                        array_push($product_array, $product_name."(".$product_quantity.")");
                                    }

                                    $total_grand += $grand_total;
                                    $total_paid += $paid;
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td class="timestamp">{{date('Y-m-d H:i', strtotime($item->timestamp))}}</td>
                                    <td class="expiry_date">{{$item->expiry_date}}</td>
                                    <td class="reference_no">{{$item->reference_no}}</td>
                                    <td class="company">{{$item->company->name}}</td>
                                    <td class="store">{{$item->store->name}}</td>
                                    <td class="supplier" data-id="{{$item->supplier_id}}">{{$item->supplier->company}}</td>
                                    <td class="product">{{implode(", ", $product_array)}}</td>
                                    <td class="grand_total"> {{number_format($grand_total)}} </td>
                                    <td class="paid"> {{ number_format($paid) }} </td>
                                    <td> {{number_format($grand_total - $paid)}} </td>
                                    <td class="status">
                                        @if ($item->status == 1)
                                            <span class="badge badge-success"><i class="fa fa-check"></i> {{__('page.received')}}</span>
                                        @elseif($item->status == 0)
                                            <span class="badge badge-danger"><i class="fa fa- exclamation-triangle"></i>{{__('page.pending')}}</span>
                                        @endif
                                    </td>
                                    {{-- <td></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">{{__('page.total')}}</td>
                                <td>{{number_format($total_grand)}}</td>
                                <td>{{number_format($total_paid)}}</td>
                                <td>{{number_format($total_grand - $total_paid)}}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>                
                    {{-- <div class="clearfix mt-2">
                        <div class="float-left" style="margin: 0;">
                            <p>{{__('page.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('page.items')}}</p>
                        </div>
                        <div class="float-right" style="margin: 0;">
                            {!! $data->appends([])->links() !!}
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>                
    </div>

@endsection

@section('script')
<script src="{{asset('master/lib/select2/js/select2.min.js')}}"></script>
<script src="{{asset('master/lib/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.js')}}"></script>
<script src="{{asset('master/lib/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
<script src="{{asset('master/lib/datatables/jquery.dataTables.js')}}"></script>
<script>
    $(document).ready(function () {

        // $("#period").dateRangePicker({
        //     autoClose: false,
        // });

        // $("#expiry_date").dateRangePicker({
        //     autoClose: false,
        // });

        // $("#pagesize").change(function(){
        //     $("#pagesize_form").submit();
        // });

        // $("#btn-reset").click(function(){
        //     $("#search_company").val('');
        //     $("#search_store").val('');
        //     $("#search_supplier").val('');
        //     $("#search_reference_no").val('');
        //     $("#period").val('');
        //     $("#expiry_date").val('');
        // });

        $('#expiredTable').DataTable({
            responsive: true,
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });
        $(".dataTables_length select").addClass("form-control-sm");

    });
</script>
@endsection
