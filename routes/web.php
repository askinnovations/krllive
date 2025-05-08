<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\Auth\RegisterController as FrontendRegisterController;
use App\Http\Controllers\Frontend\Auth\LoginController as FrontendLoginController;
use App\Http\Controllers\Backend\Auth\LoginController as BackendLoginController;




use App\Http\Controllers\Backend\{
    EmployeeController, PayrollController, AdminDashboardController, DestinationController,
    UserController, TyreController, WarehouseController, OrderController, PackageTypeController,
    ConsignmentNoteController, FreightBillController, StockTransferController, DriverController,
    AttendanceController, MaintenanceController, VehicleController, TaskManagmentController, ContractController,
    SettingsController, VehicleTypeController,RoleController,PermissionController,TestController,GroupController,ledgerMasterController,ledgerController,AccountsReceivableController,AccountsPayableController,
    ProfitLossController,BalanceSheetController,CashFlowController,VoucherController
};

// 🌐 Frontend Routes Group (user side)
Route::prefix('user')->name('user.')->group(function () {

    // 👤 Register
    Route::get('/register', [FrontendRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [FrontendRegisterController::class, 'register']);

    // 🔐 Login
    Route::get('/login', [FrontendLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [FrontendLoginController::class, 'login']);

    // 🚪 Logout
    Route::post('/logout', [FrontendLoginController::class, 'logout'])->name('logout');

    // 📊 Protected Routes (Login Required)
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('/update', [DashboardController::class, 'updateProfile'])->name('update');
        Route::get('/order-details/{order_id}', [DashboardController::class, 'OrderDetails'])->name('order-details');

    });
});


Route::get('/', [HomeController::class, 'index'])->name('front.index');
Route::get('/about', [HomeController::class, 'about'])->name('front.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('front.contact');
Route::get('/terms', [HomeController::class, 'terms'])->name('front.terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('front.privacy');
Route::post('/save-order', [HomeController::class, 'saveOrder'])->name('order.save');
// 📄 User Profile



// Authentication Routes
Route::prefix('admin')->group(function () {

    // Login & Logout Routes
    Route::get('/login', [BackendLoginController::class, 'showLoginForm'])->middleware('admin.guest')->name('admin.login');
    Route::post('/login', [BackendLoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [BackendLoginController::class, 'logout'])->name('admin.logout');

    // Dashboard Route
    Route::get('/dashboard', [AdminDashboardController::class, 'index']) ->middleware('auth.admin')->name('admin.dashboard');

    // User Management
    Route::prefix('users')->middleware('auth.admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/view/{id}', [UserController::class, 'show'])->name('admin.users.view');
        // Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.delete');
    });

    // Vehicles Management
    Route::prefix('vehicles')->middleware('auth.admin')->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('admin.vehicles.index');
        Route::get('/create', [VehicleController::class, 'create'])->name('admin.vehicles.create');
        Route::post('/store', [VehicleController::class, 'store'])->name('admin.vehicles.store');
        Route::get('/view/{id}', [VehicleController::class, 'show'])->name('admin.vehicles.view');
        Route::get('/edit/{id}', [VehicleController::class, 'edit'])->name('admin.vehicles.edit');
        Route::post('/update/{id}', [VehicleController::class, 'update'])->name('admin.vehicles.update');
        Route::delete('/delete/{id}', [VehicleController::class, 'destroy'])->name('admin.vehicles.delete');
    });

   // Tyres Management
    Route::prefix('tyres')->middleware('auth.admin')->group(function () {
        Route::get('/', [TyreController::class, 'index'])->name('admin.tyres.index');
        Route::post('/store', [TyreController::class, 'store'])->name('admin.tyres.store');
        Route::put('/update/{id}', [TyreController::class, 'update'])->name('admin.tyres.update');
        Route::get('/delete/{id}', [TyreController::class, 'destroy'])->name('admin.tyres.delete');
       
    });
    
    // PackageTypeController
    Route::prefix('packagetype')->middleware('auth.admin')->group(function () {
        Route::get('/', [PackageTypeController::class, 'index'])->name('admin.packagetype.index');
        Route::post('/store', [PackageTypeController::class, 'store'])->name('admin.packagetype.store');
        Route::put('/update/{id}', [PackageTypeController::class, 'update'])->name('admin.packagetype.update');
        Route::get('/delete/{id}', [PackageTypeController::class, 'destroy'])->name('admin.packagetype.delete');
       
    });

    // DestinationController
    Route::prefix('destination')->middleware('auth.admin')->group(function () {
        Route::get('/', [DestinationController::class, 'index'])->name('admin.destination.index');
        Route::post('/store', [DestinationController::class, 'store'])->name('admin.destination.store');
        Route::put('/update/{id}', [DestinationController::class, 'update'])->name('admin.destination.update');
        Route::get('/delete/{id}', [DestinationController::class, 'destroy'])->name('admin.destination.delete');
       
    });


    // ContractController
    Route::prefix('contract')->middleware('auth.admin')->group(function () {
        Route::get('/', [ContractController::class, 'index'])->name('admin.contract.index');
        Route::get('/view/{id}', [ContractController::class, 'show'])->name('admin.contract.view');
        Route::post('/store', [ContractController::class, 'store'])->name('admin.contract.store');
        Route::put('/update/{id}', [ContractController::class, 'update'])->name('admin.contract.update');
        Route::get('/delete/{id}', [ContractController::class, 'destroy'])->name('admin.contract.delete');
    });
    Route::post('/get-rate', [ContractController::class, 'getRate']);


    // VehicleTypeController
    Route::prefix('vehicletype')->middleware('auth.admin')->group(function () {
        Route::get('/', [VehicleTypeController::class, 'index'])->name('admin.vehicletype.index');
        Route::post('/store', [VehicleTypeController::class, 'store'])->name('admin.vehicletype.store');
        Route::put('/update/{id}', [VehicleTypeController::class, 'update'])->name('admin.vehicletype.update');
        Route::get('/delete/{id}', [VehicleTypeController::class, 'destroy'])->name('admin.vehicletype.delete');
    }); 

    // SettingsController

    Route::prefix('settings')->middleware('auth.admin')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/store', [SettingsController::class, 'store'])->name('admin.settings.store');

    });


    // Warehouse Management
    Route::prefix('warehouse')->middleware('auth.admin')->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('admin.warehouse.index');
        Route::post('/store', [WarehouseController::class, 'store'])->name('admin.warehouse.store');
        Route::put('/update/{id}', [WarehouseController::class, 'update'])->name('admin.warehouse.update');
        Route::delete('/delete/{id}', [WarehouseController::class, 'destroy'])->name('admin.warehouse.delete');
    });
        //maintenanceController
    Route::prefix('maintenance')->middleware('auth.admin')->group(function () {
        Route::get('/', [MaintenanceController::class, 'index'])->name('admin.maintenance.index');
        Route::post('/store', [MaintenanceController::class, 'store'])->name('admin.maintenance.store');
        Route::put('/update/{id}', [MaintenanceController::class, 'update'])->name('admin.maintenance.update');
        Route::get('/delete/{id}', [MaintenanceController::class, 'destroy'])->name('admin.maintenance.delete');
    });
  

   
    Route::prefix('employees')->middleware('auth.admin')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])
            ->name('admin.employees.index');
    
        Route::get('/create', [EmployeeController::class, 'create'])
            ->name('admin.employees.create');
    
        Route::post('/store', [EmployeeController::class, 'store'])
            ->name('admin.employees.store');
    
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])
            ->name('admin.employees.edit');
    
        Route::post('/update/{id}', [EmployeeController::class, 'update'])
            ->name('admin.employees.update');
    
        Route::get('/show/{id}', [EmployeeController::class, 'show'])
            ->name('admin.employees.show');
    
        Route::get('/task/{id}', [EmployeeController::class, 'task'])
            ->name('admin.employees.task');
    
        Route::get('/delete/{id}', [EmployeeController::class, 'destroy'])
            ->name('admin.employees.delete');
    });
    
    Route::prefix('drivers')->middleware('auth.admin')->group( function(){
    Route::get('', [DriverController::class, 'index'])->name('admin.drivers.index');
    Route::get('/create', action: [DriverController::class, 'create'])->name('admin.drivers.create');
    Route::post('/store', [DriverController::class, 'store'])->name('admin.drivers.store');
    Route::get('/edit/{id}', [DriverController::class, 'edit'])->name('admin.drivers.edit');
    Route::get('/show/{id}', [DriverController::class, 'show'])->name('admin.drivers.show');
    Route::post('/update/{id}', [DriverController::class, 'update'])->name('admin.drivers.update');
    Route::get('/delete/{id}', [DriverController::class, 'destroy'])->name('admin.drivers.delete');
    });
   // attendance
    Route::prefix('attendance')->middleware('auth.admin')->group( function(){
    Route::get('/', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::post('/update', [AttendanceController::class, 'update'])->name('admin.attendance.update');
   });

   Route::prefix('payroll')->middleware('auth.admin')->group( function(){
   Route::get('/', [PayrollController::class, 'index'])->name('admin.payroll.index');
   Route::get('/show/{id}', [PayrollController::class, 'show'])->name('admin.payroll.show');
   });

     Route::prefix('task-managment')->middleware('auth.admin')->group(function(){
     Route::get('/', [TaskManagmentController::class, 'index'])->name('admin.task_management.index');
     Route::post('/store', [TaskManagmentController::class, 'store'])->name('admin.task_management.store');
     Route::put('/update/{id}', [TaskManagmentController::class, 'update'])->name('admin.task_management.update');
     Route::get('/delete/{id}', [TaskManagmentController::class, 'destroy'])->name('admin.task_management.delete');
     Route::get('/search-by-date', [TaskManagmentController::class, 'searchByDate'])->name('admin.task_management.searchByDate');
     Route::get('/close-task/{id}', [TaskManagmentController::class, 'closeTask'])->name('admin.task_management.task_status');

   });
      
 
    Route::prefix('orders')->middleware('auth.admin')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');        
        Route::get('/create', [OrderController::class, 'create'])->name('admin.orders.create');
        Route::post('/store', [OrderController::class, 'store'])->name('admin.orders.store');
        Route::get('/edit/{order_id}', [OrderController::class, 'edit'])->name('admin.orders.edit');
        Route::get('/view/{order_id}', [OrderController::class, 'show'])->name('admin.orders.view');
        Route::get('/documents/{order_id}', [OrderController::class, 'docView'])->name('admin.orders.documents');
        Route::post('/update/{order_id}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::delete('/delete/{order_id}', [OrderController::class, 'destroy'])->name('admin.orders.delete');
    });
   
    
    
    
    // Consignment Management
    Route::prefix('consignments')->middleware('auth.admin')->group(function () {
        Route::get('/', [ConsignmentNoteController::class, 'index'])->name('admin.consignments.index');
        Route::get('/create', [ConsignmentNoteController::class, 'create'])->name('admin.consignments.create');
        Route::post('/store', [ConsignmentNoteController::class, 'store'])->name('admin.consignments.store');
        Route::get('/edit/{order_id}', [ConsignmentNoteController::class, 'edit'])->name('admin.consignments.edit');
        Route::get('/view/{id}', [ConsignmentNoteController::class, 'show'])->name('admin.consignments.view');
        Route::get('/documents/{id}', [ConsignmentNoteController::class, 'docView'])->name('admin.consignments.documents');
        Route::post('/update/{order_id}', [ConsignmentNoteController::class, 'update'])->name('admin.consignments.update');
        Route::get('/delete/{order_id}', [ConsignmentNoteController::class, 'destroy'])->name('admin.consignments.delete');
    });

    // Freight Bill Management
    Route::prefix('freight-bill')->middleware('auth.admin')->group(function () {
        Route::get('/', [FreightBillController::class, 'index'])->name('admin.freight-bill.index');
        Route::get('/create', [FreightBillController::class, 'create'])->name('admin.freight-bill.create');
        Route::post('/store', [FreightBillController::class, 'store'])->name('admin.freight-bill.store');
        Route::get('/view/{id}', [FreightBillController::class, 'show'])->name('admin.freight-bill.view');
        Route::get('/edit-by-number/{freight_bill_number}', [FreightBillController::class, 'editByNumber'])->name('admin.freight-bill.edit');
        Route::put('/update/{freight_bill_number}', [FreightBillController::class, 'update'])->name('admin.freight-bill.update');
        Route::get('/delete/{id}', [FreightBillController::class, 'destroy'])->name('admin.freight-bill.delete');
    });

   
  
Route::prefix('role')->middleware('auth.admin')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('admin.role.index');
    Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create');
    Route::post('/store', [RoleController::class, 'store'])->name('admin.role.store');
    Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('admin.role.delete');
    Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
    Route::post('/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
}); 
Route::prefix('permissions')->middleware('auth.admin')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('admin.permission.index');
    Route::get('/create', [PermissionController::class, 'create'])->name('admin.permission.create');
    Route::post('/store', [PermissionController::class, 'store'])->name('admin.permission.store');
    Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('admin.permission.edit');
    Route::post('/update/{id}', [PermissionController::class, 'update'])->name('admin.permission.update');
    Route::get('/delete/{id}', [PermissionController::class, 'destroy'])->name('admin.permission.delete');
}); 

Route::prefix('user')->middleware('auth.admin')->group(function () {
    Route::get('/', [TestController::class, 'index'])->name('admin.user.index');
    Route::get('/create', [TestController::class, 'create'])->name('admin.user.create');
    Route::post('/stote', [TestController::class, 'store'])->name('admin.user.store'); 
    Route::get('/edit/{id}', [TestController::class, 'edit'])->name('admin.user.edit');
    Route::post('/update/{id}', [TestController::class, 'update'])->name('admin.user.update');
    Route::get('/delete/{id}', [TestController::class, 'destroy'])->name('admin.user.delete');

});
 Route::get('/stock-transfer/index', [StockTransferController::class, 'index'])->name('admin.stock.index');
        


//  new routes
    // voucher
    Route::prefix('voucher')->group(function () {
        Route::get('/', [VoucherController::class, 'index'])->name('admin.voucher.index');
        Route::get('/create', [VoucherController::class, 'create'])->name('admin.voucher.create');
    });

    // Group
    Route::prefix('group')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('admin.group.index');
        Route::get('/create', [GroupController::class, 'create'])->name('admin.group.create');
    });

    // ledger-master
    Route::prefix('ledger_master')->group(function () {
        Route::get('/', [ledgerMasterController::class, 'index'])->name('admin.ledger_master.index');
        Route::get('/create', [ledgerMasterController::class, 'create'])->name('admin.ledger_master.create');
    });

    // Ledgers
    Route::prefix('ledger')->group(function () {
        Route::get('/', [ledgerController::class, 'index'])->name('admin.ledger.index');
        Route::get('/create', [ledgerController::class, 'create'])->name('admin.ledger.create');
    });

    // accounts-receivable
    Route::prefix('accounts_receivable')->group(function () {
        Route::get('/', [AccountsReceivableController::class, 'index'])->name('admin.accounts_receivable.index');
        Route::get('/create', [AccountsReceivableController::class, 'create'])->name('admin.accounts_receivable.create');
    });

    // accounts-payable
    Route::prefix('accounts_payable')->group(function () {
        Route::get('/', [AccountsPayableController::class, 'index'])->name('admin.accounts_payable.index');
        Route::get('/create', [AccountsPayableController::class, 'create'])->name('admin.accounts_payable.create');
    });
    
    // profit-loss
    Route::prefix('profit_loss')->group(function () {
        Route::get('/', [ProfitLossController::class, 'index'])->name('admin.profit_loss.index');
        Route::get('/create', [ProfitLossController::class, 'create'])->name('admin.profit_loss.create');
    });
    
    // balance-sheet
    Route::prefix('balance_sheet')->group(function () {
        Route::get('/', [BalanceSheetController::class, 'index'])->name('admin.balance_sheet.index');
        Route::get('/create', [BalanceSheetController::class, 'create'])->name('admin.balance_sheet.create');
    });

    // cash-flow
    Route::prefix('cash_flow')->group(function () {
        Route::get('/', [CashFlowController::class, 'index'])->name('admin.cash_flow.index');
        Route::get('/create', [CashFlowController::class, 'create'])->name('admin.cash_flow.create');
    });
});

