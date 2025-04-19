

<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i data-feather="home"></i>
                    <span data-key="t-dashboard">Dashboard</span>
                </a>
            </li>
             <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <i data-feather="package"></i>
                    <span data-key="t-consignment-booking">Consignment Booking</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('admin.orders.index') }}" data-key="t-order-booking">Order Booking</a></li>
                    <li><a href="{{ route('admin.consignments.index') }}" data-key="t-lr">LR / Consignment Note</a></li>
                    <li><a href="{{ route('admin.freight-bill.index') }}" data-key="t-freight-bill">Freight Bill</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <i data-feather="truck"></i>
                    <span data-key="t-fleet">Fleet</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('admin.vehicles.index') }}" data-key="t-vehicles">Vehicles</a></li>
                    <li><a href="{{ route('admin.maintenance.index') }}" data-key="t-maintenance">Maintenance</a></li>
                    <li><a href="{{ route('admin.tyres.index') }}" data-key="t-tyres">Tyres</a></li>
                    <li><a href="{{ route('admin.packagetype.index') }}" data-key="t-tyres">Package Type</a></li>
                    <li><a href="{{ route('admin.destination.index') }}" data-key="t-destination">Destination</a></li>
                    <li><a href="{{ route('admin.contract.index') }}" data-key="t-Contract">Contract </a></li>
                </ul>
            </li>
                        <li>
                <a href="{{ route('admin.task_management.index') }}">
                    <i data-feather="clipboard"></i>
                    <span data-key="t-task-management">Task Management</span>
                </a>
            </li>

            
            
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <i data-feather="users"></i>
                    <span data-key="t-hr">HR</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{route('admin.employees.index')}}" data-key="t-employees">Employees</a></li>
                    <li><a href="{{route('admin.drivers.index')}}" data-key="t-drivers">Drivers</a></li>
                    <li><a href="{{route('admin.attendance.index')}}" data-key="t-attendance">Attendance</a></li>
                    <li><a href="{{route('admin.payroll.index')}}" data-key="t-payroll">Payroll</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                <i data-feather="database"></i>
                <span data-key="t-master">Master</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('admin.users.index') }}" data-key="t-customer">Customer</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                                <i data-feather="database"></i>
                                <span data-key="t-warehouse">Warehouse</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.warehouse.index') }}" data-key="t-warehouse-list">Warehouse List</a></li>
                                <li><a href="{{ route('admin.stock.index') }}" data-key="t-stock-transfer">Stock In/Transfer/Out</a>
                                </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.settings.index') }}" class="has-arrow">
                                <i data-feather="database"></i>
                                <span data-key="t-warehouse">Settings</span>
                </a>
                
            </li>

            

            
           
            
        </ul>

               
         
        </div>
        <!-- Sidebar -->
    </div>
</div>