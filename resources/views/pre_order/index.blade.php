@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/daterangepicker/daterangepicker.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.home')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.purchase_order')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-credit-card"></i>  {{__('page.purchase_order')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="">
                    @include('elements.pagesize')                    
                    @include('pre_order.filter')
                    @if($role == 'user')
                        <a href="{{route('pre_order.create')}}" class="btn btn-success btn-sm float-right ml-3 mg-b-5" id="btn-add"><i class="fa fa-plus mg-r-2"></i> {{__('page.add_new')}}</a>
                    @endif
                    @include('elements.keyword')
                </div>
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th style="width:40px;">#</th>
                                <th>
                                    {{__('page.date')}}
                                    <span class="sort-date float-right">
                                        @if($sort_by_date == 'desc')
                                            <i class="fa fa-angle-up"></i>
                                        @elseif($sort_by_date == 'asc')
                                            <i class="fa fa-angle-down"></i>
                                        @endif
                                    </span>
                                </th>
                                <th>{{__('page.reference_no')}}</th>
                                <th>{{__('page.supplier')}}</th>
                                <th>{{__('page.grand_total')}}</th>
                                <th>{{__('page.received')}}</th>
                                <th>{{__('page.balance')}}</th>
                                <th>{{__('page.status')}}</th>
                                <th>{{__('page.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $footer_grand_total = $footer_received = $footer_balance = 0;
                            @endphp
                            @foreach ($data as $item)
                                @php
                                    // $received = $item->payments()->sum('amount');
                                    $received = $item->purchases()->sum('grand_total');
                                    $grand_total = $item->grand_total;
                                    $balance = $grand_total - $received;
                                    $footer_grand_total += $grand_total;
                                    // $footer_paid += $received;
                                    $footer_balance += $balance;
                                @endphp
                                <tr>
                                    <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td class="timestamp">{{date('Y-m-d H:i', strtotime($item->timestamp))}}</td>
                                    <td class="reference_no">{{$item->reference_no}}</td>
                                    <td class="supplier" data-id="{{$item->supplier_id}}">{{$item->supplier->company}}</td>
                                    <td class="grand_total"> {{number_format($grand_total)}} </td>
                                    <td class="received"> {{ number_format($received) }} </td>
                                    <td class="balance" data-value="{{$balance}}"> {{number_format($balance)}} </td>
                                    <td class="status">
                                        @if ($received == 0)
                                            <span class="badge badge-danger">{{__('page.pending')}}</span>
                                        @elseif($received < $grand_total)
                                            <span class="badge badge-primary">{{__('page.partial')}}</span>
                                        @else
                                            <span class="badge badge-success">{{__('page.received')}}</span>
                                        @endif
                                    </td>
                                    <td class="py-2" align="center">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-info btn-with-icon nav-link" data-toggle="dropdown">
                                                <div class="ht-30">
                                                    <span class="icon wd-30"><i class="fa fa-send"></i></span>
                                                    <span class="pd-x-15">{{__('page.action')}}</span>
                                                </div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-header action-dropdown bd-t-1">
                                                <ul class="list-unstyled user-profile-nav">
                                                    <li><a href="{{route('pre_order.detail', $item->id)}}"><i class="icon ion-eye  "></i> {{__('page.details')}}</a></li>
                                                    <li><a href="{{route('received_order.index')}}?order_id={{$item->id}}"><i class="icon ion-cash"></i> {{__('page.received_list')}}</a></li>
                                                    <li><a href="{{route('pre_order.receive', $item->id)}}"><i class="icon ion-cash"></i> {{__('page.receive')}}</a></li>                                                    
                                                    <li><a href="{{route('pre_order.edit', $item->id)}}"><i class="icon ion-compose"></i> {{__('page.edit')}}</a></li>
                                                    <li><a href="{{route('pre_order.delete', $item->id)}}" onclick="return window.confirm('Are you sure?')"><i class="icon ion-trash-a"></i> {{__('page.delete')}}</a></li>                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">{{__('page.total')}}</td>
                                <td>{{number_format($footer_grand_total)}}</td>
                                <td>{{number_format($footer_received)}}</td>
                                <td>{{number_format($footer_balance)}}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>                
                    <div class="clearfix mt-2">
                        <div class="float-left" style="margin: 0;">
                            <p>{{__('page.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('page.items')}}</p>
                        </div>
                        <div class="float-right" style="margin: 0;">
                            {!! $data->appends([
                                'company_id' => $company_id,
                                'supplier_id' => $supplier_id,
                                'reference_no' => $reference_no,
                                'period' => $period,
                                // 'expiry_period' => $expiry_period,
                            ])->links() !!}
                        </div>
                    </div>
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
<script src="{{asset('master/lib/styling/uniform.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#payment_form input.date").datetimepicker({
            dateFormat: 'yy-mm-dd',
        });


        $('.file-input-styled').uniform({
            fileButtonClass: 'action btn bg-primary tx-white'
        });

        $("#period").dateRangePicker({
            autoClose: false,
        });

        $("#pagesize").change(function(){
            $("#pagesize_form").submit();
        });

        $("#keyword_filter").change(function(){
            $("#keyword_filter_form").submit();
        });

        $("#btn-reset").click(function(){
            $("#search_company").val('');
            $("#search_supplier").val('').change();
            $("#search_reference_no").val('');
            $("#period").val('');
        });
        var toggle = 'desc';
        if($("#search_sort_date").val() == 'desc'){
            toggle = true;
        } else {
            toggle = false;
        }


        $(".sort-date").click(function(){
            let status = $("#search_sort_date").val();
            if (status == 'asc') {
                $("#search_sort_date").val('desc');
            } else {
                $("#search_sort_date").val('asc');
            }
            $("#searchForm").submit();
        })
    });
</script>
@endsection
