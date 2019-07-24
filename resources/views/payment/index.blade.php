@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.home')}}</a>
                <a class="breadcrumb-item" href="#">{{__('page.payment')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.list')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-money"></i> {{__('page.payment_management')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                {{-- <div class="">
                    <button type="button" class="btn btn-success btn-sm float-right mg-b-5" id="btn-add"><i class="icon ion-person-add mg-r-2"></i> Add New</button>
                </div> --}}
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th style="width:40px;">#</th>
                                <th>{{__('page.date')}}</th>
                                <th>{{__('page.reference_no')}}</th>
                                <th>{{__('page.amount')}}</th> 
                                <th>{{__('page.note')}}</th>
                                <th>{{__('page.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="date">{{date('Y-m-d H:i', strtotime($item->timestamp))}}</td>
                                    <td class="reference_no">{{$item->reference_no}}</td>
                                    <td class="amount">{{$item->amount}}</td>
                                    <td class="" data-path="{{$item->attachment}}">
                                        <span class="tx-info note">{{$item->note}}</span>&nbsp;
                                        @if($item->attachment != "")
                                            <a href="{{asset($item->attachment)}}" download><i class="fa fa-paperclip"></i></a>
                                        @endif
                                    </td>
                                    <td class="py-1">
                                        <a href="#" class="btn btn-primary btn-icon rounded-circle mg-r-5 btn-edit" data-id="{{$item->id}}"><div><i class="fa fa-edit"></i></div></a>
                                        <a href="{{route('payment.delete', $item->id)}}" class="btn btn-danger btn-icon rounded-circle mg-r-5" data-id="{{$item->id}}" onclick="return window.confirm('{{__('page.are_you_sure')}}')"><div><i class="fa fa-trash-o"></i></div></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>                
    </div>

    <!-- The Modal -->
    
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('page.edit_payment')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('payment.edit')}}" id="edit_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" class="id">
                    <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label">{{__('page.date')}}</label>
                                <input class="form-control date" type="text" name="date" autocomplete="off" value="{{date('Y-m-d H:i')}}" placeholder="{{__('page.date')}}">
                            </div>                        
                            <div class="form-group">
                                <label class="control-label">{{__('page.reference_no')}}</label>
                                <input class="form-control reference_no" type="text" name="reference_no" placeholder="{{__('page.reference_number')}}">
                            </div>                                                
                            <div class="form-group">
                                <label class="control-label">{{__('page.amount')}}</label>
                                <input class="form-control amount" type="text" name="amount" placeholder="{{__('page.amount')}}">
                            </div>                                               
                            <div class="form-group">
                                <label class="control-label">{{__('page.attachment')}}</label>
                                <label class="custom-file wd-100p">
                                    <input type="file" name="attachment" id="file2" class="custom-file-input">
                                    <span class="custom-file-control custom-file-control-primary"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__('page.note')}}</label>
                                <textarea class="form-control note" type="text" name="note" placeholder="{{__('page.note')}}"></textarea>
                            </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="submit" id="btn_update" class="btn btn-primary btn-submit"><i class="fa fa-check mg-r-10"></i>&nbsp;{{__('page.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mg-r-10"></i>&nbsp;{{__('page.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset('master/lib/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.js')}}"></script>
<script>
    $(document).ready(function () {
        
        // $("#btn-add").click(function(){
        //     $("#create_form input.form-control").val('');
        //     $("#create_form .invalid-feedback strong").text('');
        //     $("#addModal").modal();
        // });

        $("#edit_form input.date").datetimepicker({
            dateFormat: 'yy-mm-dd',
        });

        $(".btn-edit").click(function(){
            let id = $(this).data("id");
            let date = $(this).parents('tr').find(".date").text().trim();
            let reference_no = $(this).parents('tr').find(".reference_no").text().trim();
            let amount = $(this).parents('tr').find(".amount").text().trim();
            let note = $(this).parents('tr').find(".note").text().trim();
            $("#editModal input.form-control").val('');
            $("#editModal .id").val(id);
            $("#editModal .date").val(date);
            $("#editModal .reference_no").val(reference_no);
            $("#editModal .amount").val(amount);
            $("#editModal .note").val(note);
            $("#editModal").modal();
        });

    });
</script>
@endsection
