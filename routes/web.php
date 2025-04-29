<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\Auth\RegisterController as FrontendRegisterController;
use App\Http\Controllers\Frontend\Auth\LoginController as FrontendLoginController;


use App\Http\Controllers\{
    EmployeeController, PayrollController, Auth\LoginController, AdminDashboardController, DestinationController,
    UserController, TyreController, WarehouseController, OrderController, PackageTypeController,
    ConsignmentNoteController, FreightBillController, StockTransferController, DriverController,
    AttendanceController, MaintenanceController, VehicleController, TaskManagmentController, ContractController,
    SettingsController, VehicleTypeController
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

// ✅ Frontend Pages
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
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    // Dashboard Route
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/view/{id}', [UserController::class, 'show'])->name('admin.users.view');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.delete');
    });

    // Vehicles Management
    Route::prefix('vehicles')->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('admin.vehicles.index');
        Route::get('/create', [VehicleController::class, 'create'])->name('admin.vehicles.create');
        Route::post('/store', [VehicleController::class, 'store'])->name('admin.vehicles.store');
        Route::get('/view/{id}', [VehicleController::class, 'show'])->name('admin.vehicles.view');
        Route::get('/edit/{id}', [VehicleController::class, 'edit'])->name('admin.vehicles.edit');
        Route::post('/update/{id}', [VehicleController::class, 'update'])->name('admin.vehicles.update');
        Route::delete('/delete/{id}', [VehicleController::class, 'destroy'])->name('admin.vehicles.delete');
    });

   // Tyres Management
    Route::prefix('tyres')->group(function () {
        Route::get('/', [TyreController::class, 'index'])->name('admin.tyres.index');
        Route::post('/store', [TyreController::class, 'store'])->name('admin.tyres.store');
        Route::put('/update/{id}', [TyreController::class, 'update'])->name('admin.tyres.update');
        Route::get('/delete/{id}', [TyreController::class, 'destroy'])->name('admin.tyres.delete');
       
    });
    
    // PackageTypeController
    Route::prefix('packagetype')->group(function () {
        Route::get('/', [PackageTypeController::class, 'index'])->name('admin.packagetype.index');
        Route::post('/store', [PackageTypeController::class, 'store'])->name('admin.packagetype.store');
        Route::put('/update/{id}', [PackageTypeController::class, 'update'])->name('admin.packagetype.update');
        Route::get('/delete/{id}', [PackageTypeController::class, 'destroy'])->name('admin.packagetype.delete');
       
    });

    // DestinationController
    Route::prefix('destination')->group(function () {
        Route::get('/', [DestinationController::class, 'index'])->name('admin.destination.index');
        Route::post('/store', [DestinationController::class, 'store'])->name('admin.destination.store');
        Route::put('/update/{id}', [DestinationController::class, 'update'])->name('admin.destination.update');
        Route::get('/delete/{id}', [DestinationController::class, 'destroy'])->name('admin.destination.delete');
       
    });


    // ContractController
    Route::prefix('contract')->group(function () {
        Route::get('/', [ContractController::class, 'index'])->name('admin.contract.index');
        Route::get('/view/{id}', [ContractController::class, 'show'])->name('admin.contract.view');
        Route::post('/store', [ContractController::class, 'store'])->name('admin.contract.store');
        Route::put('/update/{id}', [ContractController::class, 'update'])->name('admin.contract.update');
        Route::get('/delete/{id}', [ContractController::class, 'destroy'])->name('admin.contract.delete');
    });

    // VehicleTypeController
    Route::prefix('vehicletype')->group(function () {
        Route::get('/', [VehicleTypeController::class, 'index'])->name('admin.vehicletype.index');
        Route::post('/store', [VehicleTypeController::class, 'store'])->name('admin.vehicletype.store');
        Route::put('/update/{id}', [VehicleTypeController::class, 'update'])->name('admin.vehicletype.update');
        Route::get('/delete/{id}', [VehicleTypeController::class, 'destroy'])->name('admin.vehicletype.delete');
    }); 

    


    // SettingsController

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/store', [SettingsController::class, 'store'])->name('admin.settings.store');

    });

    


    // Warehouse Management
    Route::prefix('warehouse')->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('admin.warehouse.index');
        Route::post('/store', [WarehouseController::class, 'store'])->name('admin.warehouse.store');
        Route::put('/update/{id}', [WarehouseController::class, 'update'])->name('admin.warehouse.update');
        Route::delete('/delete/{id}', [WarehouseController::class, 'destroy'])->name('admin.warehouse.delete');
    });
        //maintenanceController
    Route::prefix('maintenance')->group(function () {
        Route::get('/', [MaintenanceController::class, 'index'])->name('admin.maintenance.index');
        Route::post('/store', [MaintenanceController::class, 'store'])->name('admin.maintenance.store');
        Route::put('/update/{id}', [MaintenanceController::class, 'update'])->name('admin.maintenance.update');
        Route::get('/delete/{id}', [MaintenanceController::class, 'destroy'])->name('admin.maintenance.delete');
    });
      
   
 Route::prefix('employees')->group( function(){
    Route::get('/', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
    Route::post('/store', [EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
    Route::get('/show/{id}', [EmployeeController::class, 'show'])->name('admin.employees.show');
    Route::get('/task/{id}', [EmployeeController::class, 'task'])->name('admin.employees.task');
    Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('admin.employees.update');
    Route::get('/delete/{id}', [EmployeeController::class, 'destroy'])->name('admin.employees.delete');
  });
    Route::prefix('drivers')->group( function(){
    Route::get('', [DriverController::class, 'index'])->name('admin.drivers.index');
    Route::get('/create', action: [DriverController::class, 'create'])->name('admin.drivers.create');
    Route::post('/store', [DriverController::class, 'store'])->name('admin.drivers.store');
    Route::get('/edit/{id}', [DriverController::class, 'edit'])->name('admin.drivers.edit');
    Route::get('/show/{id}', [DriverController::class, 'show'])->name('admin.drivers.show');
    Route::post('/update/{id}', [DriverController::class, 'update'])->name('admin.drivers.update');
    Route::get('/delete/{id}', [DriverController::class, 'destroy'])->name('admin.drivers.delete');
    });
   // attendance
    Route::prefix('attendance')->group( function(){
    Route::get('/', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::post('/update', [AttendanceController::class, 'update'])->name('admin.attendance.update');
   });

   Route::prefix('payroll')->group( function(){
   Route::get('/', [PayrollController::class, 'index'])->name('admin.payroll.index');
   Route::get('/show/{id}', [PayrollController::class, 'show'])->name('admin.payroll.show');
   });

     Route::prefix('task-managment')->group(function(){
     Route::get('/', [TaskManagmentController::class, 'index'])->name('admin.task_management.index');
     Route::post('/store', [TaskManagmentController::class, 'store'])->name('admin.task_management.store');
     Route::put('/update/{id}', [TaskManagmentController::class, 'update'])->name('admin.task_management.update');
     Route::get('/delete/{id}', [TaskManagmentController::class, 'destroy'])->name('admin.task_management.delete');
     Route::get('/search-by-date', [TaskManagmentController::class, 'searchByDate'])->name('admin.task_management.searchByDate');
     Route::get('/close-task/{id}', [TaskManagmentController::class, 'closeTask'])->name('admin.task_management.task_status');

   });
      
   // Orders Management
    Route::prefix('orders')->group(function () {
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
    Route::prefix('consignments')->group(function () {
        Route::get('/', [ConsignmentNoteController::class, 'index'])->name('admin.consignments.index');
        Route::get('/create', [ConsignmentNoteController::class, 'create'])->name('admin.consignments.create');
        Route::post('/store', [ConsignmentNoteController::class, 'store'])->name('admin.consignments.store');
        Route::get('/edit/{order_id}', [ConsignmentNoteController::class, 'edit'])->name('admin.consignments.edit');
        Route::get('/view/{id}', [ConsignmentNoteController::class, 'show'])->name('admin.consignments.view');
        Route::get('/documents/{id}', [ConsignmentNoteController::class, 'docView'])->name('admin.consignments.documents');
        Route::post('/update/{order_id}', [ConsignmentNoteController::class, 'update'])->name('admin.consignments.update');
        Route::delete('/delete/{order_id}', [ConsignmentNoteController::class, 'destroy'])->name('admin.consignments.delete');
    });

    // Freight Bill Management
    Route::prefix('freight-bill')->group(function () {
        Route::get('/', [FreightBillController::class, 'index'])->name('admin.freight-bill.index');
        Route::get('/create', [FreightBillController::class, 'create'])->name('admin.freight-bill.create');
        Route::post('/store', [FreightBillController::class, 'store'])->name('admin.freight-bill.store');
        Route::put('/update/{id}', [FreightBillController::class, 'update'])->name('admin.freight-bill.update');
        Route::delete('/delete/{id}', [FreightBillController::class, 'destroy'])->name('admin.freight-bill.delete');
        
    });

    Route::get('/stock-transfer/index', [StockTransferController::class, 'index'])->name('admin.stock.index');
    // Route::post('/get-contract-rate', [ContractController::class, 'getRate'])->name('get.contract.rate');
    Route::post('/get-rate', [ContractController::class, 'getRate']);


    
});

