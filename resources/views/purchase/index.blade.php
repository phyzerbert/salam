@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/daterangepicker/daterangepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-toggles/toggles-full.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.home')}}</a>
                <a class="breadcrumb-item" href="#">{{__('page.purchase')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.list')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-credit-card"></i>  {{__('page.purchases_list')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="">
                    @include('elements.pagesize')                    
                    @include('purchase.filter')
                    @if($role == 'user')
                        <a href="{{route('purchase.create')}}" class="btn btn-success btn-sm float-right ml-3 mg-b-5" id="btn-add"><i class="fa fa-plus mg-r-2"></i> {{__('page.add_new')}}</a>
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
                                    <div class="toggle-wrapper float-right">
                                        <div class="toggle toggle-light success"></div>
                                    </div>
                                </th>
                                <th>{{__('page.reference_no')}}</th>
                                <th>{{__('page.supplier')}}</th>
                                <th>{{__('page.purchase_status')}}</th>
                                <th>{{__('page.grand_total')}}</th>
                                <th>{{__('page.paid')}}</th>
                                <th>{{__('page.balance')}}</th>
                                <th>{{__('page.payment_status')}}</th>
                                <th>{{__('page.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $footer_grand_total = $footer_paid = 0;
                            @endphp
                            @foreach ($data as $item)
                                @php
                                    $paid = $item->payments()->sum('amount');
                                    $grand_total = $item->grand_total;
                                    $footer_grand_total += $grand_total;
                                    $footer_paid += $paid;
                                @endphp
                                <tr>
                                    <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td class="timestamp">{{date('Y-m-d H:i', strtotime($item->timestamp))}}</td>
                                    <td class="reference_no">{{$item->reference_no}}</td>
                                    <td class="supplier" data-id="{{$item->supplier_id}}">{{$item->supplier->company}}</td>
                                    <td class="status">
                                        @if ($item->status == 1)
                                            <span class="badge badge-success">{{__('page.received')}}</span>
                                        @elseif($item->status == 0)
                                            <span class="badge badge-primary">{{__('page.pending')}}</span>
                                        @endif
                                    </td>
                                    <td class="grand_total"> {{number_format($grand_total)}} </td>
                                    <td class="paid"> {{ number_format($paid) }} </td>
                                    <td class="balance" data-value="{{$grand_total - $paid}}"> {{number_format($grand_total - $paid)}} </td>
                                    <td>
                                        @if ($paid == 0)
                                            <span class="badge badge-danger">{{__('page.pending')}}</span>
                                        @elseif($paid < $grand_total)
                                            <span class="badge badge-primary">{{__('page.partial')}}</span>
                                        @else
                                            <span class="badge badge-success">{{__('page.paid')}}</span>
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
                                                    <li><a href="{{route('purchase.detail', $item->id)}}"><i class="icon ion-eye  "></i> {{__('page.details')}}</a></li>
                                                    <li><a href="{{route('payment.index', ['purchase', $item->id])}}"><i class="icon ion-cash"></i> {{__('page.payment_list')}}</a></li>
                                                    <li><a href="#" data-id="{{$item->id}}" class="btn-add-payment"><i class="icon ion-cash"></i> {{__('page.add_payment')}}</a></li>                                                    
                                                    <li><a href="{{route('purchase.edit', $item->id)}}"><i class="icon ion-compose"></i> {{__('page.edit')}}</a></li>
                                                    <li><a href="{{route('purchase.delete', $item->id)}}" onclick="return window.confirm('Are you sure?')"><i class="icon ion-trash-a"></i> {{__('page.delete')}}</a></li>                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">{{__('page.total')}}</td>
                                <td>{{number_format($footer_grand_total)}}</td>
                                <td>{{number_format($footer_paid)}}</td>
                                <td>{{number_format($footer_grand_total - $footer_paid)}}</td>
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
                                'store_id' => $store_id,
                                'supplier_id' => $supplier_id,
                                'reference_no' => $reference_no,
                                'period' => $period,
                                'expiry_period' => $expiry_period,
                            ])->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="paymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('page.add_payment')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('payment.create')}}" id="payment_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="type" name="type" value="purchase" />
                    <input type="hidden" class="paymentable_id" name="paymentable_id" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('page.date')}}</label>
                            <input class="form-control date" type="text" name="date" autocomplete="off" value="{{date('Y-m-d H:i')}}" placeholder="{{__('page.date')}}">
                        </div>                        
                        <div class="form-group">
                            <label class="control-label">{{__('page.reference_no')}}</label>
                            <input class="form-control reference_no" type="text" name="reference_no" required placeholder="{{__('page.reference_no')}}">
                        </div>                                                
                        <div class="form-group">
                            <label class="control-label">{{__('page.amount')}}</label>
                            <input class="form-control amount" type="text" name="amount" required placeholder="{{__('page.amount')}}">
                        </div>                                               
                        <div class="form-group">
                            <label class="control-label">{{__('page.attachment')}}</label>
                            <input type="file" name="attachment" id="file2" class="file-input-styled">
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('page.note')}}</label>
                            <textarea class="form-control note" type="text" name="note" placeholder="{{__('page.note')}}"></textarea>
                        </div> 
                    </div>    
                    <div class="modal-footer">
                        <button type="submit" id="btn_create" class="btn btn-primary btn-submit"><i class="fa fa-check mg-r-10"></i>&nbsp;{{__('page.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mg-r-10"></i>&nbsp;{{__('page.close')}}</button>
                    </div>
                </form>
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
<script src="{{asset('master/lib/jquery-toggles/toggles.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#payment_form input.date").datetimepicker({
            dateFormat: 'yy-mm-dd',
        });
        
        $(".btn-add-payment").click(function(){
            // $("#payment_form input.form-control").val('');
            let id = $(this).data('id');
            let balance = $(this).parents('tr').find('.balance').data('value');
            $("#payment_form .paymentable_id").val(id);
            $("#payment_form .amount").val(balance);
            $("#paymentModal").modal();
        });

        $('.file-input-styled').uniform({
            fileButtonClass: 'action btn bg-primary tx-white'
        });

        // $(".btn-edit").click(function(){
        //     let id = $(this).data("id");
        //     let name = $(this).parents('tr').find(".name").text().trim();
        //     $("#edit_form input.form-control").val('');
        //     $("#editModal .id").val(id);
        //     $("#editModal .name").val(name);
        //     $("#editModal").modal();
        // });
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
            $("#search_store").val('');
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

        $('.toggle').toggles({
          on: toggle,
          height: 20,
          text: {
                on: '&#8679;', // text for the ON position
                off: '&#8681;' // and off
            },
        });

        $('.toggle').on('toggle', function(e, active) {
            if (active) {
                console.log('Toggle is now ON!');
                $("#search_sort_date").val('desc');
            } else {
                console.log('Toggle is now OFF!');
                $("#search_sort_date").val('asc');
            }
            $("#searchForm").submit();
        });

    });
</script>
@endsection
