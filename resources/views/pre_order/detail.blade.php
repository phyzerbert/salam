@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/select2/css/select2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('master/lib/imageviewer/css/jquery.verySimpleImageViewer.css')}}">
    <style>
        #image_preview {
            max-width: 600px;
            height: 600px;
        }
        .image_viewer_inner_container {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.home')}}</a>
                <a class="breadcrumb-item" href="#">{{__('page.purchase')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.details')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-info-circle"></i> {{__('page.purchase_detail')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="card card-body tx-white-8 bg-success mg-y-10 bd-0 ht-150 purchase-card">
                            <div class="row">
                                <div class="col-3">
                                    <span class="card-icon tx-70"><i class="fa fa-plug"></i></span>
                                </div>
                                <div class="col-9">
                                    <h4 class="card-title tx-white tx-medium mg-b-10">{{__('page.supplier')}}</h4>
                                    <p class="tx-16 mg-b-3">{{__('page.name')}} : @isset($order->supplier->name){{$order->supplier->name}}@endisset</p>
                                    <p class="tx-16 mg-b-3">{{__('page.email')}} : @isset($order->supplier->email){{$order->supplier->email}}@endisset</p>
                                    <p class="tx-16 mg-b-3">{{__('page.phone')}} : @isset($order->supplier->phone_number){{$order->supplier->phone_number}}@endisset</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card card-body bg-info tx-white-8 mg-y-10 bd-0 ht-150 purchase-card">
                            <div class="row">                                
                                <div class="col-3">
                                    <span class="card-icon tx-70"><i class="fa fa-file-text-o"></i></span>
                                </div>
                                <div class="col-9">
                                    <h4 class="card-title tx-white tx-medium mg-b-10">{{__('page.reference')}}</h4>
                                    <p class="tx-16 mg-b-3">{{__('page.number')}} : {{$order->reference_no}}</p>
                                    <p class="tx-16 mg-b-3">{{__('page.date')}} : {{$order->timestamp}}</p>
                                    <p class="tx-16 mg-b-3">
                                        {{__('page.attachment')}} : 
                                        @if ($order->attachment != "")
                                            <a href="#" class="attachment" data-value="{{$order->attachment}}">&nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip"></i></a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card card-body bg-teal tx-white mg-y-10 bd-0 ht-150 purchase-card">
                            <div class="row">
                                <div class="col-3">
                                    <span class="card-icon tx-70"><i class="fa fa-calendar"></i></span>
                                </div>
                                <div class="col-9">
                                    <h4 class="card-title tx-white tx-medium mg-b-10">{{__('page.created_at')}}</h4>
                                    <p class="tx-16 mg-b-3">{{__('page.created_by')}} : @isset($order->user->name){{$order->user->name}}@endisset</p>
                                    <p class="tx-16 mg-b-3">{{__('page.created_at')}} : {{$order->created_at}}</p>
                                    <p class="tx-16 mg-b-3"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mg-t-20">
                    <div class="col-md-12 table-responsive">
                        <h5>{{__('page.order_items')}}</h5>
                        <table class="table table-bordered table-colored table-info">
                            <thead>
                                <tr>
                                    <th class="wd-40">#</th>
                                    <th>{{__('page.product_code')}}</th>
                                    <th>{{__('page.product_name')}}</th>
                                    <th>{{__('page.product_cost')}}</th>
                                    <th>{{__('page.discount')}}</th>
                                    <th>{{__('page.quantity')}}</th>
                                    <th>{{__('page.subtotal')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_discount = 0;
                                    $total_amount = 0;
                                @endphp
                                @foreach ($order->items as $item)
                                    @php
                                        $discount = $item->discount;
                                        $subtotal = $item->subtotal;

                                        $total_discount += $discount;
                                        $total_amount += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>@isset($item->product->code){{$item->product->code}}@endisset</td>
                                        <td>@isset($item->product->name){{$item->product->name}}@endisset</td>
                                        <td>{{number_format($item->cost - $item->discount)}}</td>
                                        <td>
                                            @if(strpos( $item->discount_string , '%' ) !== false)
                                                {{$item->discount_string}} ({{number_format($item->discount)}})
                                            @else
                                                {{number_format($item->discount)}}
                                            @endif
                                        </td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{number_format($item->subtotal)}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="tx-bold">{{__('page.total')}} </td>
                                    <td>{{$total_discount}}</td>
                                    <td></td>
                                    <td>{{number_format($total_amount)}}</td>
                                </tr>
                            </tbody>
                            <tfoot class="tx-bold tx-black">
                                <tr>
                                    <td colspan="6" style="text-align:right">{{__('page.total_amount')}} </td>
                                    <td>{{number_format($order->grand_total)}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row mg-t-20">
                    <div class="col-md-6">
                        <h5>{{__('page.note')}}</h5>
                        <p class="mx-2">{{$order->note}}</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{route('pre_order.index')}}" class="btn btn-secondary"><i class="fa fa-credit-card"></i>  {{__('page.purchase_order')}}</a>
                        <a href="{{route('received_order.index')}}?order_id={{$order->id}}" class="btn btn-info"><i class="icon ion-cash"></i>  {{__('page.received_list')}}</a>
                    </div>
                </div>
            </div>
        </div>                
    </div>

    <div class="modal fade" id="attachModal">
        <div class="modal-dialog" style="margin-top:17vh">
            <div class="modal-content">
                <div id="image_preview"></div>
                {{-- <img src="" id="attachment" width="100%" height="600" alt=""> --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset('master/lib/imageviewer/js/jquery.verySimpleImageViewer.min.js')}}"></script>
<script src="{{asset('master/lib/select2/js/select2.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $(".attachment").click(function(e){
            e.preventDefault();
            let path = '{{asset("/")}}' + $(this).data('value');
            console.log(path)
            // $("#attachment").attr('src', path);
            $("#image_preview").html('')
            $("#image_preview").verySimpleImageViewer({
                imageSource: path,
                frame: ['100%', '100%'],
                maxZoom: '900%',
                zoomFactor: '10%',
                mouse: true,
                keyboard: true,
                toolbar: true,
            });
            $("#attachModal").modal();
        });

    });
</script>
@endsection
