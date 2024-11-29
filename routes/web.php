<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\AssetGroupController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/home', function () {
        return view('home');
    });

    

    Route::prefix('asset_group')->group(function () {
        Route::get('', [AssetGroupController::class, 'index']);
        Route::get('/getRecords', [AssetGroupController::class, 'getRecords']);
        Route::post('/store', [AssetGroupController::class, 'store']);
        Route::get('/edit/{id}', [AssetGroupController::class, 'edit']);
        Route::post('/update', [AssetGroupController::class, 'update']);
        Route::get('/destroy/{id}', [AssetGroupController::class, 'destroy']);
    });


    Route::prefix('test')->group(function () {
        Route::get('', [TestController::class, 'index']);
        Route::get('/get_records', [TestController::class, 'show']);
        Route::post('/store', [TestController::class, 'store']);
    });

    Route::get('assignment', [AssignmentController::class, 'index']);




    //Route for Region:
    Route::prefix('region')->group(function () {
        Route::get('', [RegionController::class, 'index']);
        Route::get('/show', [RegionController::class, 'show']);
        Route::post('/store', [RegionController::class, 'store']);
        Route::get('/edit/{id}', [RegionController::class, 'edit']);
        Route::put('/update/{id}', [RegionController::class, 'update']);
        Route::get('/destroy/{id}', [RegionController::class, 'destroy']);
    });

    //Route for Province:
    Route::prefix('province')->group(function () {
        Route::get('', [ProvinceController::class, 'index']);
        Route::get('/show', [ProvinceController::class, 'show']);
        Route::post('/store', [ProvinceController::class, 'store']);
        Route::get('/edit/{id}', [ProvinceController::class, 'edit']);
        Route::put('update/{id}', [ProvinceController::class, 'update']);
        Route::get('destroy/{id}', [ProvinceController::class, 'destroy']);
    });

    //Route for City:
    Route::prefix('city')->group(function () {
        Route::get('', [CityController::class, 'index']);
        Route::get('/show', [CityController::class, 'show']);
        Route::post('/store', [CityController::class, 'store']);
        Route::get('/edit/{id}', [CityController::class, 'edit']);
        Route::put('update/{id}', [CityController::class, 'update']);
        Route::get('destroy/{id}', [CityController::class, 'destroy']);
        Route::get('getProvincesByRegion/{id}', [CityController::class, 'getProvincesByRegion']);
    });

    Route::prefix('company')->group(function(){
        Route::get('', [CompanyController::class, 'index']);
        Route::get('/show', [CompanyController::class, 'show']);
        Route::post('/store', [CompanyController::class, 'store']);
        Route::get('/edit/{id}', [CompanyController::class, 'edit']);
        Route::put('/update/{id}', [CompanyController::class, 'update']);
        Route::get('/destroy/{id}', [CompanyController::class, 'destroy']);
    });

    Route::prefix('department')->group(function(){
        Route::get('', [DepartmentController::class, 'index']);
        Route::get('/show', [DepartmentController::class, 'show']);
        Route::post('/store', [DepartmentController::class, 'store']);
        Route::get('/edit/{id}', [DepartmentController::class, 'edit']);
        Route::put('/update/{id}', [DepartmentController::class, 'update']);
        Route::get('/destroy/{id}', [DepartmentController::class, 'destroy']);
    });

    Route::prefix('employee')->group(function () {
        Route::get('', [EmployeeController::class, 'index']);
        Route::get('/show', [EmployeeController::class, 'show']);
        Route::post('/store', [EmployeeController::class, 'store']);
        Route::get('/edit/{id}', [EmployeeController::class, 'edit']);
        Route::put('update/{id}', [EmployeeController::class, 'update']);
        Route::get('destroy/{id}', [EmployeeController::class, 'destroy']);
        Route::get('getDepartmentsByCompany/{id}', [EmployeeController::class, 'getDepartmentsByCompany']);
        Route::get('/export_excel', [EmployeeController::class, 'export_excel']);
        Route::get('/print', [EmployeeController::class, 'print']);

    });

});
