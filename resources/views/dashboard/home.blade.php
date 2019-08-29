@extends('layouts.master')
@section('style')
    <link href="{{asset('master/lib/daterangepicker/daterangepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/sweet-modal/jquery.sweet-modal.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="br-mainpanel" id="app" style="opacity: 1">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.home')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.dashboard')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="tx-gray-800 mg-b-5 float-left"><i class="fa fa-dashboard"></i> {{__('page.dashboard')}}</h4>
                    @if ($role == 'admin')
                        @include('dashboard.top_filter')
                    @endif                    
                </div>                
            </div>                      
        </div>
        <div class="br-pagebody">
            <div class="row row-sm">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-teal rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="ion ion-clock tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.today_purchases')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['today_purchases']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['today_purchases']['count'])}} {{__('page.purchases')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                    <div class="bg-danger rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="fa fa-truck tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.week_purchases')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['week_purchases']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['week_purchases']['count'])}} {{__('page.purchases')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-primary rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="ion ion-calendar tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.month_purchases')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['month_purchases']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['month_purchases']['count'])}} {{__('page.purchases')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-br-primary rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.company_balance')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['company_grand_total'] - $return['overall_purchases']['total_paid'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['overall_purchases']['count'])}} {{__('page.purchases')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
            </div>
            <div class="row row-sm mt-3">
                <div class="col-sm-6 col-xl-3   ">
                    <div class="bg-teal rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="fa fa-sun-o tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.today_sales')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['today_sales']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['today_sales']['count'])}} {{__('page.sales')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                    <div class="bg-danger rounded overflow-hidden">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.week_sales')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['week_sales']['total'])}}</p>
                                <span class="tx-11 tx-roboto tx-white-6">{{number_format($return['week_sales']['count'])}} {{__('page.sales')}}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-primary rounded overflow-hidden">
                        <a href="{{route('report.expired_purchases_report').'?company_id='.$top_company.'&expiry_period='.$expiry_date}}" class="pd-25 d-flex align-items-center">
                            <i class="fa fa-exclamation-circle tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.expiries_in_5days')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$return['expired_in_5days_purchases']}}</p>
                                <p class="tx-11 tx-roboto tx-white-6"></p>
                            </div>
                        </a>
                    </div>
                </div>                
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-warning rounded overflow-hidden" id="expire_alert">
                        <div class="pd-25 d-flex align-items-center">
                            <i class="fa fa-exclamation-triangle tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-14 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">{{__('page.expired_purchases')}}</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{number_format($return['expired_purchases'])}}</p>
                                <p class="tx-11 tx-roboto tx-white-6"></p>
                            </div>
                        </div>
                    </div>
                </div><!-- col-3 -->
            </div>
            <div class="br-section-wrapper mt-3">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <h4 class="tx-primary float-left">{{__('page.overview')}}</h4>
                        <form action="" class="form-inline float-right" method="post">
                            @csrf
                            <input type="hidden" name="top_company" value="{{$top_company}}" />
                            <input type="text" class="form-control form-control-sm" name="period" id="period" style="width:250px !important" value="{{$period}}" autocomplete="off" placeholder="{{__('page.period')}}">
                            <button type="submit" class="btn btn-primary pd-y-7 mg-l-10"> <i class="fa fa-search"></i> {{__('page.search')}}</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="card card-body">                        
                        {{-- <canvas id="line_chart" style="height:400px;"></canvas> --}}
                        <div id="line_chart" style="height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script src="{{asset('master/lib/select2/js/select2.min.js')}}"></script>
<script src="{{asset('master/lib/echarts/echarts-en.js')}}"></script>
<script src="{{asset('master/lib/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
<script src="{{asset('master/lib/sweet-modal/jquery.sweet-modal.min.js')}}"></script>

<script>
    var role = "{{Auth::user()->role->slug}}";
    var legend_array = {!! json_encode([__('page.purchase'), __('page.sale'), __('page.payment')]) !!};
    var purchase = "{{__('page.purchase')}}";
    var sale = "{{__('page.sale')}}";
    var payment = "{{__('page.payment')}}";
        
    // console.log(legend_array);
    var Chart_overview = function() {

        var dashboard_chart = function() {
            if (typeof echarts == 'undefined') {
                console.warn('Warning - echarts.min.js is not loaded.');
                return;
            }

            // Define elements
            var area_basic_element = document.getElementById('line_chart');

            if (area_basic_element) {

                var area_basic = echarts.init(area_basic_element);

                area_basic.setOption({

                    color: ['#2ec7c9','#5ab1ef','#ff0000','#d87a80','#b6a2de'],

                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 13
                    },

                    animationDuration: 750,

                    grid: {
                        left: 0,
                        right: 40,
                        top: 35,
                        bottom: 0,
                        containLabel: true
                    },

                    
                    legend: {
                        data: [purchase, sale, payment],
                        itemHeight: 8,
                        itemGap: 20
                    },

                    tooltip: {
                        trigger: 'axis',
                        backgroundColor: 'rgba(0,0,0,0.75)',
                        padding: [10, 15],
                        textStyle: {
                            fontSize: 13,
                            fontFamily: 'Roboto, sans-serif'
                        }
                    },

                    xAxis: [{
                        type: 'category',
                        boundaryGap: false,
                        data: {!! json_encode($key_array) !!},
                        axisLabel: {
                            color: '#333'
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: '#eee',
                                type: 'dashed'
                            }
                        }
                    }],

                    yAxis: [{
                        type: 'value',
                        axisLabel: {
                            color: '#333'
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: '#eee'
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                            }
                        }
                    }],

                    series: [
                        {
                            name: purchase,
                            type: 'line',
                            data: {!! json_encode($purchase_array) !!},
                            areaStyle: {
                                normal: {
                                    opacity: 0.25
                                }
                            },
                            smooth: true,
                            symbolSize: 7,
                            itemStyle: {
                                normal: {
                                    borderWidth: 2
                                }
                            }
                        },
                        {
                            name: sale,
                            type: 'line',
                            smooth: true,
                            symbolSize: 7,
                            itemStyle: {
                                normal: {
                                    borderWidth: 2
                                }
                            },
                            areaStyle: {
                                normal: {
                                    opacity: 0.25
                                }
                            },
                            data: {!! json_encode($sale_array) !!}
                        },
                        {
                            name: payment,
                            type: 'line',
                            smooth: true,
                            symbolSize: 7,
                            itemStyle: {
                                normal: {
                                    borderWidth: 2
                                }
                            },
                            areaStyle: {
                                normal: {
                                    opacity: 0.25
                                }
                            },
                            data: {!! json_encode($payment_array) !!}
                        }
                    ]
                });
            }

            // Resize function
            var triggerChartResize = function() {
                area_basic_element && area_basic.resize();
            };

            // On sidebar width change
            $(document).on('click', '.sidebar-control', function() {
                setTimeout(function () {
                    triggerChartResize();
                }, 0);
            });

            // On window resize
            var resizeCharts;
            window.onresize = function () {
                clearTimeout(resizeCharts);
                resizeCharts = setTimeout(function () {
                    triggerChartResize();
                }, 200);
            };
        };

        return {
            init: function() {
                dashboard_chart();
            }
        }
    }();

    document.addEventListener('DOMContentLoaded', function() {
        Chart_overview.init();
    });

</script>
<script>
    $(document).ready(function () {
        $("#period").dateRangePicker();
        $("#top_company_filter").change(function(){
            $("#top_filter_form").submit();
        });

        $("#expire_alert").click(function(){
            $.sweetModal({
                content: '{{$return['expired_purchases']}} purchases is expired.',
                icon: $.sweetModal.ICON_WARNING
            });
        });
    });
</script>
@endsection
