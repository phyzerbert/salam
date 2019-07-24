@extends('layouts.master')

@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="#">{{__('page.reports')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.product_expiry_alert')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-exclamation-circle"></i> {{__('page.product_expiry_alert')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="">
                    @include('elements.pagesize')                    
                    <form action="" method="POST" class="form-inline float-left" id="searchForm">
                        @csrf
                        <select class="form-control form-control-sm mr-sm-2 mb-2" name="product_id" id="search_product">
                            <option value="" hidden>{{__('page.select_product')}}</option>
                            @foreach ($products as $item)
                                <option value="{{$item->id}}" @if ($product_id == $item->id) selected @endif>{{$item->name}}</option>
                            @endforeach
                        </select>
                        @if($role == 'admin')
                            <select class="form-control form-control-sm mr-sm-2 mb-2" name="company_id" id="search_company">
                                <option value="" hidden>{{__('page.select_company')}}</option>
                                @foreach ($companies as $item)
                                    <option value="{{$item->id}}" @if ($company_id == $item->id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        @endif

                        <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fa fa-search"></i>&nbsp;&nbsp;{{__('page.search')}}</button>
                        <button type="button" class="btn btn-sm btn-info mb-2 ml-1" id="btn-reset"><i class="fa fa-eraser"></i>&nbsp;&nbsp;{{__('page.reset')}}</button>
                    </form>
                </div>
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th class="wd-40">#</th>
                                <th>{{__('page.image')}}</th>
                                <th>{{__('page.product_code')}}</th>
                                <th>{{__('page.product_name')}}</th>
                                <th>{{__('page.reference_no')}}</th>
                                <th>{{__('page.expiry_date')}}</th>
                                <th>{{__('page.purchase_date')}}</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)                            
                                <tr>
                                    <td class="wd-40">{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td class="image py-1 wd-60"><img src="@if($item->product->image){{asset($item->product->image)}}@else{{asset('images/no-image.png')}}@endif" class="wd-40 ht-40 rounded-circle" alt=""></td>
                                    <td>{{$item->product->code}}</td>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->orderable->reference_no}}</td>
                                    <td>{{$item->expiry_date}}</td>
                                    <td>{{$item->orderable->timestamp}}</td>                                        
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="clearfix mt-2">
                        <div class="float-left" style="margin: 0;">
                            <p>{{__('page.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('page.items')}}</p>
                        </div>
                        <div class="float-right" style="margin: 0;">
                            {!! $data->appends([])->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $("#pagesize").change(function(){
            $("#pagesize_form").submit();
        });
        $("#btn-reset").click(function(){
            $("#search_product").val('');
            $("#search_company").val('');
        });
    });
</script>
@endsection
