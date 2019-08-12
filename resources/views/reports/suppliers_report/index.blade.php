@extends('layouts.master')
@section('style')
    <link href="{{asset('master/lib/datatables/jquery.dataTables.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.report')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.suppliers_report')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-user-circle"></i> {{__('page.suppliers_report')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover" id="supplier_table">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th class="wd-40">#</th>
                                <th>{{__('page.company')}}</th>
                                <th>{{__('page.name')}}</th>
                                <th>{{__('page.phone')}}</th>
                                <th>{{__('page.email_address')}}</th>
                                <th style="width:120px;">{{__('page.total_purchases')}}</th>
                                <th style="width:120px !important;">{{__('page.total_amount')}}</th>
                                <th>{{__('page.paid')}}</th>
                                <th>{{__('page.balance')}}</th>
                                <th>{{__('page.action')}}</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @php
                                $footer_total_purchases = $footer_total_amount = $footer_paid = 0;
                            @endphp                               
                            @foreach ($data as $item)
                                @php
                                    $purchases_array = $item->purchases()->pluck('id');
                                    $total_purchases = $item->purchases()->count();
                                    // $mod_total_amount = \App\Models\Order::whereIn('orderable_id', $purchases_array)->where('orderable_type', "App\Models\Purchase");
                                    $mod_total_amount = $item->purchases();
                                    $mod_paid = \App\Models\Payment::whereIn('paymentable_id', $purchases_array)->where('paymentable_type', "App\Models\Purchase");

                                    if($company_id != ''){
                                        $company = \App\Models\Company::find($company_id);
                                        $company_purchases = $company->purchases()->pluck('id');

                                        $mod_total_amount = $mod_total_amount->where('company_id', $company_id);
                                        $mod_paid = $mod_paid->whereIn('paymentable_id', $company_purchases);
                                    }

                                    $total_amount = $mod_total_amount->sum('grand_total');
                                    $paid = $mod_paid->sum('amount');  

                                    $footer_total_purchases += $total_purchases;
                                    $footer_total_amount += $total_amount;
                                    $footer_paid += $paid;
                                @endphp                              
                                <tr>
                                    <td class="wd-40">{{ $loop->index + 1 }}</td>
                                    <td>{{$item->company}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->phone_number}}</td>
                                    <td>{{$item->email}}</td>
                                    <td style="width:120px !important;">{{number_format($total_purchases)}}</td>
                                    <td style="width:120px !important;">{{number_format($total_amount)}}</td>                                        
                                    <td>{{number_format($paid)}}</td>
                                    <td>{{number_format($total_amount - $paid)}}</td>                                      
                                    <td>
                                        <a href="{{route('report.suppliers_report.purchases', $item->id)}}" class="badge badge-primary">{{__('page.view_reports')}}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">{{__('page.total')}}</td>
                                <td>{{number_format($footer_total_purchases)}}</td>
                                <td>{{number_format($footer_total_amount)}}</td>
                                <td>{{number_format($footer_paid)}}</td>
                                <td>{{number_format($footer_total_amount - $footer_paid)}}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>                
    </div>
@endsection

@section('script')
<script src="{{asset('master/lib/datatables/jquery.dataTables.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#supplier_table').DataTable({
            responsive: true,
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });
        $(".dataTables_length select").addClass("form-control-sm");
        $("#btn-reset").click(function(){
            $("#search_name").val('');
            $("#search_company").val('');
            $("#search_supplier_company").val('');
            $("#search_phone").val('');
        });

    });
    $("#pagesize").change(function(){
        $("#pagesize_form").submit();
    });
</script>
@endsection
