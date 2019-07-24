@extends('layouts.master')

@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.home')}}</a>
                <a class="breadcrumb-item" href="#">{{__('page.product')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.list')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-cubes"></i> {{__('page.product_management')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="">
                    @include('elements.pagesize')
                    @include('product.filter')
                    <a href="{{route('product.create')}}" class="btn btn-success btn-sm float-right tx-white mg-b-5" id="btn-add"><i class="fa fa-plus mg-r-2"></i> Add New</a>                    
                </div>
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th style="width:30px;">#</th>
                                <th>{{__('page.product_code')}}</th>
                                <th>{{__('page.product_name')}}</th>
                                <th>{{__('page.category')}}</th>
                                <th>{{__('page.product_cost')}}</th>
                                <th>{{__('page.product_price')}}</th>
                                <th>{{__('page.quantity')}}</th>
                                <th>{{__('page.product_unit')}}</th>
                                <th>{{__('page.alert_quantity')}}</th>
                                <th>{{__('page.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                            @php
                                $quantity = $item->store_products()->sum('quantity');
                            @endphp
                                <tr>
                                    <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td class="code">{{$item->code}}</td>
                                    <td class="name">{{$item->name}}</td>
                                    <td class="category">{{$item->category->name}}</td>
                                    <td class="cost">{{number_format($item->cost)}}</td>
                                    <td class="price">{{number_format($item->price)}}</td>
                                    <td class="quantity">{{$quantity}}</td>
                                    <td class="unit">{{$item->unit}}</td>
                                    <td class="alert_quantity">{{$item->alert_quantity}}</td>
                                    <td class="py-2 dropdown" align="center">
                                        <a href="#" class="btn btn-info btn-with-icon nav-link" data-toggle="dropdown">
                                            <div class="ht-30">
                                                <span class="icon wd-30"><i class="fa fa-send"></i></span>
                                                <span class="pd-x-15">Action</span>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-header action-dropdown pd-l-5 pd-r-5 bd-t-1" style="min-width:9rem">
                                            <ul class="list-unstyled user-profile-nav">
                                                <li><a href="{{route('product.detail', $item->id)}}"><i class="icon ion-eye  "></i> {{__('page.details')}}</a></li>
                                                {{-- <li><a href="{{route('product.duplicate', $item->id)}}"><i class="icon ion-ios-photos-outline"></i> {{__('page.duplicated')}}</a></li> --}}                                                
                                                <li><a href="{{route('product.edit', $item->id)}}"><i class="icon ion-compose"></i> {{__('page.edit')}}</a></li>
                                                <li><a href="{{route('product.delete', $item->id)}}" onclick="return window.confirm('Are you sure?')"><i class="icon ion-trash-a"></i> {{__('page.delete')}}</a></li>                                                
                                            </ul>
                                        </div>                                        
                                    </td>
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
        $("#btn-reset").click(function(){
            $("#search_code").val('');
            $("#search_name").val('');
            $("#search_category").val('');
        });
    });
</script>
@endsection
