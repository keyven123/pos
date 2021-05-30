<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\CartHistoryController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ConsumedStockController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DesignationController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\VariantController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\IngredientController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PayrollController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ProductComponentController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('createVariants', [VariantController::class, 'createVariants']);
    Route::get('getAllHistory', [InventoryController::class, 'getAllHistory']);
    Route::get('getCartComputation', [InventoryController::class, 'getCartComputation']);
    Route::get('showSpecificInventory', [InventoryController::class, 'showSpecificInventory']);
    Route::get('allPermission', [PermissionController::class, 'allPermission']);
    Route::get('filterCategory', [ProductController::class, 'filterCategory']);
    Route::get('getOrders', [OrderController::class, 'getOrders']);
    Route::get('showCart', [CartHistoryController::class, 'showCart']);
    Route::post('updateCart', [CartHistoryController::class, 'updateCart']);
    Route::post('updateOrder', [OrderController::class, 'updateOrder']);
    Route::put('doneOrder/{id}', [OrderController::class, 'doneOrder']);
    Route::get('authenticate', [AuthenticationController::class ,'authenticate']);
    Route::put('updateComponentIndividual/{id}', [ProductComponentController::class ,'updateComponentIndividual']);

    Route::group(['prefix' => 'attendance'], function () {
        Route::get('getTodayAttendance', [AttendanceController::class, 'getTodayAttendance']);
        Route::get('getFirstAndLastRecord', [AttendanceController::class, 'getFirstAndLastRecord']);
        Route::get('historyTable', [AttendanceController::class, 'historyTable']);
        Route::get('getAttendanceSummary', [AttendanceController::class, 'getAttendanceSummary']);
        Route::put('resetTimeOut/{id}', [AttendanceController::class, 'resetTimeOut']);

    });
    
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('getAllData', [DashboardController::class, 'getAllData']);
        Route::get('getChartData', [DashboardController::class, 'getChartData']);
        Route::get('filterBy', [DashboardController::class, 'filterBy']);
        Route::get('getTableCarts', [DashboardController::class, 'getTableCarts']);
        Route::get('getAllInventory', [DashboardController::class, 'getAllInventory']);
        Route::get('getAllSparkLine', [DashboardController::class, 'getAllSparkLine']);
    });
    
    Route::group(['prefix' => 'employee'], function () {
        Route::get('showPayrollHistory', [EmployeeController::class, 'showPayrollHistory']);
    });

    Route::group(['prefix' => 'payroll'], function () {
        Route::get('getPayroll', [PayrollController::class, 'getPayroll']);
    });
    
    Route::apiResources([
        'product' => ProductController::class,
        'designation'=> DesignationController::class,
        'user' => UserController::class,
        'category' => CategoryController::class,
        'variant' => VariantController::class,
        'inventory' => InventoryController::class,
        'ingredient' => IngredientController::class,
        'role' => RoleController::class,
        'permission' => PermissionController::class,
        'order' => OrderController::class,
        'cart-history' => CartHistoryController::class,
        'product-component' => ProductComponentController::class,
        'consumed-stocks' => ConsumedStockController::class,
        'profile' => ProfileController::class,
        'employee' => EmployeeController::class,
        'attendance' => AttendanceController::class,
        'payroll' => PayrollController::class,
    ]);
});