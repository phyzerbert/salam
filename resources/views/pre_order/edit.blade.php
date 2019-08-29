@extends('layouts.master')
@section('style')
    <link href="{{asset('master/lib/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.css')}}" rel="stylesheet">
    <script src="{{asset('master/lib/vuejs/vue.js')}}"></script>
    <script src="{{asset('master/lib/vuejs/axios.js')}}"></script>
@endsection
@section('content')
    <div class="br-mainpanel" id="app">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.home')}}</a>
                <a class="breadcrumb-item" href="#">{{__('page.purchase_order')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.edit')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-edit"></i> {{__('page.purchase_order')}}</h4>
        </div>

        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <form class="form-layout form-layout-1" action="{{route('pre_order.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="order_id" value="{{$order->id}}">
                    <div class="row mg-b-25">
                        <div class="col-md-6">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">{{__('page.date')}}: </label>
                                <input class="form-control" type="text" name="date" id="purchase_date" value="{{date('Y-m-d H:i', strtotime($order->timestamp))}}" placeholder="{{__('page.date')}}" autocomplete="off" required>
                                @error('date')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">{{__('page.reference_no')}}:</label>
                                <input class="form-control" type="text" name="reference_number" value="{{$order->reference_no}}" placeholder="{{__('page.reference_no')}}">
                                @error('reference_number')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mg-b-25">
                        <div class="col-lg-6">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">{{__('page.supplier')}}:</label>
                                <select class="form-control select2-show-search" name="supplier" data-placeholder="{{__('page.supplier')}}">
                                    <option label="{{__('page.supplier')}}"></option>
                                    @foreach ($suppliers as $item)
                                        <option value="{{$item->id}}" @if($order->supplier_id == $item->id) selected @endif>{{$item->company}}</option>
                                    @endforeach
                                </select>
                                @error('supplier')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">{{__('page.attachment')}}:</label>
                                <input type="file" name="attachment" id="file2" class="file-input-styled">
                            </div>
                        </div>
                        {{-- <div class="col-lg-3">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">{{__('page.credit_days')}}:</label>
                                <input type="number" class="form-control" name="credit_days" min="0" value="{{$order->credit_days}}">
                            </div>
                        </div> --}}
                    </div>

                    <div class="row mg-b-25">
                        <div class="col-md-12">
                            <div>
                                <h5 class="mg-t-10" style="float:left">{{__('page.order_items')}}</h5>
                                <button type="button" class="btn btn-primary btn-icon rounded-circle mg-b-10 add-product" title="{{__('page.right_ctrl_key')}}" style="float:right" @click="add_item()"><div><i class="fa fa-plus"></i></div></button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-colored table-success" id="product_table">
                                    <thead>
                                        <tr>
                                            <th>{{__('page.product_name_code')}}</th>
                                            <th>{{__('page.product_cost')}}</th>
                                            <th>{{__('page.discount')}}</th>
                                            <th>{{__('page.quantity')}}</th>
                                            <th>{{__('page.subtotal')}}</th>
                                            <th class="wd-30"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $orders = $order->orders;
                                        @endphp
                                        <tr v-for="(item,i) in order_items" :key="i">
                                            <td>
                                                <input type="hidden" name="product_id[]" class="product_id" :value="item.product_id" />
                                                <input type="text" name="product_name[]" class="form-control form-control-sm product" v-model="item.product_name_code" required />
                                            </td>
                                            <td><input type="number" class="form-control form-control-sm cost" name="cost[]" v-model="item.cost" placeholder="{{__('page.product_cost')}}" /></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm discount_string" name="discount_string[]" v-model="item.discount_string" required placeholder="{{__('page.discount')}}" />
                                                <input type="hidden" class="discount" name="discount[]" v-model="item.discount" />
                                            </td>
                                            <td><input type="number" class="form-control input-sm quantity" name="quantity[]" v-model="item.quantity" placeholder="{{__('page.quantity')}}" /></td>
                                            <td class="subtotal">
                                                @{{formatPrice(item.sub_total)}}
                                                <input type="hidden" name="subtotal[]" :value="item.sub_total" />
                                                <input type="hidden" name="item_id[]" :value="item.item_id" />
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-icon rounded-circle mg-t-3 remove-product" @click="remove(i)"><div style="width:25px;height:25px;"><i class="fa fa-times"></i></div></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">{{__('page.total')}}</td>
                                            <td class="total_discount">@{{formatPrice(total.discount)}}</td>
                                            <td class=""></td>
                                            <td colspan="2" class="total">
                                                @{{formatPrice(total.cost)}}
                                                <input type="hidden" name="grand_total" :value="grand_total">
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">{{__('page.note')}}:</label>
                                <textarea class="form-control" name="note" rows="5" placeholder="{{__('page.note')}}">{{$order->note}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-layout-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check mg-r-2"></i>{{__('page.save')}}</button>
                        <a href="{{route('pre_order.index')}}" class="btn btn-warning"><i class="fa fa-times mg-r-2"></i>{{__('page.cancel')}}</a>
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
<script src="{{asset('master/lib/styling/uniform.min.js')}}"></script>
<script>
    $(document).ready(function () {

        $("#purchase_date").datetimepicker({
            dateFormat: 'yy-mm-dd',
        });
        $(".expire_date").datepicker({
            dateFormat: 'yy-mm-dd',
        });

        $('.file-input-styled').uniform({
            fileButtonClass: 'action btn bg-primary tx-white'
        });

    });
</script>
<script src="{{ asset('js/pre_order_edit_items.js') }}"></script>
@endsection
