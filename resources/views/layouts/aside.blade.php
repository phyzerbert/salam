@php
    $page = config('site.page');
    $role = Auth::user()->role->slug;
@endphp
<div class="br-logo"><a href="{{route('home')}}" class="mx-auto"><span>{{config('app.name')}}</span></a></div>
<div class="br-sideleft overflow-y-auto">
    <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
    <div class="br-sideleft-menu">
        @if ($role != 'buyer')
            
            <a href="{{route('home')}}" class="br-menu-link @if($page == 'home') active show-sub @endif">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                    <span class="menu-item-label op-lg-0-force d-lg-none op-lg-0-force d-lg-none">{{__('page.dashboard')}}</span>
                </div>
            </a>

            {{-- Purchase --}}
            @php
                $purchase_items = ['purchase', 'purchase_list', 'purchase_create'];
            @endphp

            <a href="#" class="br-menu-link @if($page == in_array($page, $purchase_items)) active show-sub @endif">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-log-in tx-24"></i>
                    <span class="menu-item-label op-lg-0-force d-lg-none">{{__('page.purchases')}}</span>
                    <i class="menu-item-arrow op-lg-0-force d-lg-none fa fa-angle-down"></i>
                </div>
            </a>
            <ul class="br-menu-sub nav flex-column">
                <li class="nav-item"><a href="{{route('purchase.index')}}" class="nav-link @if($page == 'purchase_list') active @endif">{{__('page.purchases_list')}}</a></li>
                @if($role == 'user')
                    <li class="nav-item"><a href="{{route('purchase.create')}}" class="nav-link @if($page == 'purchase_create') active @endif">{{__('page.add_purchase')}}</a></li>
                @endif
            </ul>

            {{-- Sale --}}
            @php
                $sale_items = ['sale', 'sale_list', 'sale_create'];
            @endphp

            <a href="#" class="br-menu-link @if($page == in_array($page, $sale_items)) active show-sub @endif">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-log-out tx-24"></i>
                    <span class="menu-item-label op-lg-0-force d-lg-none">{{__('page.sales')}}</span>
                    <i class="menu-item-arrow op-lg-0-force d-lg-none fa fa-angle-down"></i>
                </div>
            </a>
            <ul class="br-menu-sub nav flex-column">
                <li class="nav-item"><a href="{{route('sale.index')}}" class="nav-link @if($page == 'sale_list') active @endif">{{__('page.sales_list')}}</a></li>
                @if($role == 'user')
                    <li class="nav-item"><a href="{{route('sale.create')}}" class="nav-link @if($page == 'sale_create') active @endif">{{__('page.add_sale')}}</a></li>
                @endif
            </ul>
        
            <a href="{{route('product.index')}}" class="br-menu-link @if($page == 'product') active @endif">
                <div class="br-menu-item">
                    <i class="menu-item-icon fa fa-cube tx-22"></i>
                    <span class="menu-item-label op-lg-0-force d-lg-none">{{__('page.product')}}</span>
                </div>
            </a>
                
        @endif
            {{-- Pre Order --}}
            @php
                $pre_order_items = ['pre_order', 'pre_order_list', 'pre_order_create'];
            @endphp

            <a href="#" class="br-menu-link @if($page == in_array($page, $pre_order_items)) active show-sub @endif">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-clipboard tx-24"></i>
                    <span class="menu-item-label op-lg-0-force d-lg-none">{{__('page.purchase_orders')}}</span>
                    <i class="menu-item-arrow op-lg-0-force d-lg-none fa fa-angle-down"></i>
                </div>
            </a>
            <ul class="br-menu-sub nav flex-column">
                <li class="nav-item"><a href="{{route('pre_order.index')}}" class="nav-link @if($page == 'pre_order_list') active @endif">{{__('page.purchase_orders')}}</a></li>
                @if($role == 'user' || $role == 'buyer')
                    <li class="nav-item"><a href="{{route('pre_order.create')}}" class="nav-link @if($page == 'pre_order_create') active @endif">{{__('page.add_purchase_order')}}</a></li>
                @endif
            </ul>

            <a href="{{route('received_order.index')}}" class="br-menu-link @if($page == 'received_order') active @endif">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
                    <span class="menu-item-label op-lg-0-force d-lg-none">{{__('page.received_orders')}}</span>
                </div>
            </a>
        @if($role != 'buyer')
            @php
                $report_items = [
                    'overview_chart', 
                    'company_chart', 
                    'store_chart', 
                    'product_quantity_alert', 
                    'product_expiry_alert', 
                    'products_report', 
                    'categories_report', 
                    'sales_report', 
                    'purchases_report', 
                    'daily_sales', 
                    'monthly_sales', 
                    'payments_report', 
                    'customers_report', 
                    'suppliers_report', 
                    'users_report',
                ];
            @endphp

            <a href="#" class="br-menu-link @if($page == in_array($page, $report_items)) active show-sub @endif">
                <div class="br-menu-item">
                    <i class="menu-item-icon fa fa-file-text-o tx-24"></i>
                    <span class="menu-item-label op-lg-0-force d-lg-none">{{__('page.reports')}}</span>
                    <i class="menu-item-arrow op-lg-0-force d-lg-none fa fa-angle-down"></i>
                </div>
            </a>
            <ul class="br-menu-sub nav flex-column">
                <li class="nav-item"><a href="{{route('report.overview_chart')}}" class="nav-link @if($page == 'overview_chart') active @endif">{{__('page.overview_chart')}}</a></li>
                <li class="nav-item"><a href="{{route('report.company_chart')}}" class="nav-link @if($page == 'company_chart') active @endif">{{__('page.company_chart')}}</a></li>
                <li class="nav-item"><a href="{{route('report.store_chart')}}" class="nav-link @if($page == 'store_chart') active @endif">{{__('page.store_chart')}}</a></li>
                <li class="nav-item"><a href="{{route('report.product_quantity_alert')}}" class="nav-link @if($page == 'product_quantity_alert') active @endif">{{__('page.product_quantity_alert')}}</a></li>
                <li class="nav-item"><a href="{{route('report.product_expiry_alert')}}" class="nav-link @if($page == 'product_expiry_alert') active @endif">{{__('page.product_expiry_alert')}}</a></li>
                <li class="nav-item"><a href="{{route('report.expired_purchases_report')}}" class="nav-link @if($page == 'expired_purchases_report') active @endif">{{__('page.expired_purchases_report')}}</a></li>
                <li class="nav-item"><a href="{{route('report.products_report')}}" class="nav-link @if($page == 'products_report') active @endif">{{__('page.product_report')}}</a></li>
                <li class="nav-item"><a href="{{route('report.categories_report')}}" class="nav-link @if($page == 'categories_report') active @endif">{{__('page.category_report')}}</a></li>
                <li class="nav-item"><a href="{{route('report.sales_report')}}" class="nav-link @if($page == 'sales_report') active @endif">{{__('page.sales_report')}}</a></li>
                <li class="nav-item"><a href="{{route('report.purchases_report')}}" class="nav-link @if($page == 'purchases_report') active @endif">{{__('page.purchases_report')}}</a></li>
                {{-- <li class="nav-item"><a href="#" class="nav-link @if($page == 'daily_sales') active @endif">Daily Sales</a></li>
                <li class="nav-item"><a href="#" class="nav-link @if($page == 'monthly_sales') active @endif">Monthly Sales</a></li> --}}
                <li class="nav-item"><a href="{{route('report.payments_report')}}" class="nav-link @if($page == 'payments_report') active @endif">{{__('page.payments_report')}}</a></li>
                <li class="nav-item"><a href="{{route('report.income_report')}}" class="nav-link @if($page == 'income_report') active @endif">{{__('page.income_report')}}</a></li>
                <li class="nav-item"><a href="{{route('report.customers_report')}}" class="nav-link @if($page == 'customers_report') active @endif">{{__('page.customers_report')}}</a></li>
                <li class="nav-item"><a href="{{route('report.suppliers_report')}}" class="nav-link @if($page == 'suppliers_report') active @endif">{{__('page.suppliers_report')}}</a></li>
                <li class="nav-item"><a href="{{route('report.users_report')}}" class="nav-link @if($page == 'users_report') active @endif">{{__('page.users_report')}}</a></li>
            </ul>

            @php
                $people_items = ['user', 'customer', 'supplier'];
            @endphp
            <a href="#" class="br-menu-link @if($page == in_array($page, $people_items)) active show-sub @endif">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-person-stalker tx-24"></i>
                    <span class="menu-item-label op-lg-0-force d-lg-none">{{__('page.people')}}</span>
                    <i class="menu-item-arrow op-lg-0-force d-lg-none fa fa-angle-down"></i>
                </div>
            </a>
            <ul class="br-menu-sub nav flex-column">
                @if($role == 'admin')
                    <li class="nav-item"><a href="{{route('users.index')}}" class="nav-link @if($page == 'user') active @endif">{{__('page.user')}}</a></li>
                @endif
                <li class="nav-item"><a href="{{route('customer.index')}}" class="nav-link @if($page == 'customer') active @endif">{{__('page.customer')}}</a></li>
                <li class="nav-item"><a href="{{route('supplier.index')}}" class="nav-link @if($page == 'supplier') active @endif">{{__('page.supplier')}}</a></li>
            </ul>
            @if($role == 'admin')
            {{-- Setting --}}
            @php
                $setting_items = ['category', 'store', 'company', 'tax_rate'];
            @endphp
            <a href="#" class="br-menu-link @if($page == in_array($page, $setting_items)) active show-sub @endif">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
                    <span class="menu-item-label op-lg-0-force d-lg-none">{{__('page.setting')}}</span>
                    <i class="menu-item-arrow op-lg-0-force d-lg-none fa fa-angle-down"></i>
                </div>
            </a>
            <ul class="br-menu-sub nav flex-column">
                <li class="nav-item"><a href="{{route('category.index')}}" class="nav-link @if($page == 'category') active @endif">{{__('page.category')}}</a></li>
                <li class="nav-item"><a href="{{route('company.index')}}" class="nav-link @if($page == 'company') active @endif">{{__('page.company')}}</a></li>
                <li class="nav-item"><a href="{{route('store.index')}}" class="nav-link @if($page == 'store') active @endif">{{__('page.store')}}</a></li>
                <li class="nav-item"><a href="{{route('tax_rate.index')}}" class="nav-link @if($page == 'tax_rate') active @endif">{{__('page.tax_rate')}}</a></li>
            </ul>
            @endif            
        @endif
    </div>

    <br>
</div>