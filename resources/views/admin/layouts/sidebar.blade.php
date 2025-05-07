<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

               

                <!-- Consignment Booking -->
                @if (hasAdminPermission('manage order_booking') || hasAdminPermission('manage lr_consignment') || hasAdminPermission('manage freight_bill'))
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="package"></i>
                            <span data-key="t-consignment-booking">Consignment Booking</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (hasAdminPermission('manage order_booking'))
                                <li><a href="{{ route('admin.orders.index') }}" data-key="t-order-booking">Order Booking</a></li>
                            @endif
                            @if (hasAdminPermission('manage lr_consignment'))
                                <li><a href="{{ route('admin.consignments.index') }}" data-key="t-lr">LR / Consignment Note</a></li>
                            @endif
                            @if (hasAdminPermission('manage freight_bill'))
                                <li><a href="{{ route('admin.freight-bill.index') }}" data-key="t-freight-bill">Freight Bill</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Fleet -->
                @if (hasAdminPermission('manage vehicles') || hasAdminPermission('manage maintenance') || hasAdminPermission('manage tyres'))
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="truck"></i>
                            <span data-key="t-fleet">Fleet</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (hasAdminPermission('manage vehicles'))
                                <li><a href="{{ route('admin.vehicles.index') }}" data-key="t-vehicles">Vehicles</a></li>
                            @endif
                            @if (hasAdminPermission('manage maintenance'))
                                <li><a href="{{ route('admin.maintenance.index') }}" data-key="t-maintenance">Maintenance</a></li>
                            @endif
                            @if (hasAdminPermission('manage tyres'))
                                <li><a href="{{ route('admin.tyres.index') }}" data-key="t-tyres">Tyres</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Task Management -->
                @if (hasAdminPermission('manage task_managment'))
                    <li>
                        <a href="{{ route('admin.task_management.index') }}">
                            <i data-feather="clipboard"></i>
                            <span data-key="t-task-management">Task Management</span>
                        </a>
                    </li>
                @endif

                <!-- HR -->
                @if (hasAdminPermission('manage employees') || hasAdminPermission('manage drivers') || hasAdminPermission('manage attendance') || hasAdminPermission('manage payroll'))
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-hr">HR</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (hasAdminPermission('manage employees'))
                                <li><a href="{{ route('admin.employees.index') }}" data-key="t-employees">Employees</a></li>
                            @endif
                            @if (hasAdminPermission('manage drivers'))
                                <li><a href="{{ route('admin.drivers.index') }}" data-key="t-drivers">Drivers</a></li>
                            @endif
                            @if (hasAdminPermission('manage attendance'))
                                <li><a href="{{ route('admin.attendance.index') }}" data-key="t-attendance">Attendance</a></li>
                            @endif
                            @if (hasAdminPermission('manage payroll'))
                                <li><a href="{{ route('admin.payroll.index') }}" data-key="t-payroll">Payroll</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Master -->
                @if (hasAdminPermission('manage customer') || hasAdminPermission('manage package type') || hasAdminPermission('manage destination') || hasAdminPermission('manage contract') || hasAdminPermission('manage vehicle type'))
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="database"></i>
                            <span data-key="t-master">Master</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (hasAdminPermission('manage customer'))
                                <li><a href="{{ route('admin.users.index') }}" data-key="t-customer">Customer</a></li>
                            @endif
                            @if (hasAdminPermission('manage package_type'))
                                <li><a href="{{ route('admin.packagetype.index') }}" data-key="t-tyres">Package Type</a></li>
                            @endif
                            @if (hasAdminPermission('manage destination'))
                                <li><a href="{{ route('admin.destination.index') }}" data-key="t-destination">Destination</a></li>
                            @endif
                            @if (hasAdminPermission('manage contract'))
                                <li><a href="{{ route('admin.contract.index') }}" data-key="t-Contract">Contract</a></li>
                            @endif
                            @if (hasAdminPermission('manage vehicle_type'))
                                <li><a href="{{ route('admin.vehicletype.index') }}" data-key="t-Contract">Vehicle Type</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Warehouse -->
                @if (hasAdminPermission('manage warehouse') || hasAdminPermission('manage stock'))
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="database"></i>
                            <span data-key="t-warehouse">Warehouse</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (hasAdminPermission('manage warehouse'))
                                <li><a href="{{ route('admin.warehouse.index') }}" data-key="t-warehouse-list">Warehouse List</a></li>
                            @endif
                            {{-- @if (hasAdminPermission('manage stock_transfer'))
                                <li><a href="{{ route('admin.stock.index') }}" data-key="t-stock-transfer">Stock In/Transfer/Out</a></li>
                            @endif --}}
                        </ul>
                    </li>
                @endif

                <!-- User Management -->
                @if (hasAdminPermission('manage permission') || hasAdminPermission('manage role') || hasAdminPermission('manage user'))
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="database"></i>
                            <span data-key="t-user_management">User Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (hasAdminPermission('manage permissions'))
                                <li><a href="{{ route('admin.permission.index') }}">Permissions</a></li>
                            @endif
                            @if (hasAdminPermission('manage role'))
                                <li><a href="{{ route('admin.role.index') }}">Roles</a></li>
                            @endif
                            @if (hasAdminPermission('manage users'))
                                <li><a href="{{ route('admin.user.index') }}">Users</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Settings -->
                @if (hasAdminPermission('manage settings'))
                    <li>
                        <a href="{{ route('admin.settings.index') }}">
                            <i data-feather="database"></i>
                            <span data-key="t-warehouse">Settings</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>