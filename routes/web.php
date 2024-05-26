<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// CLIENT
Route::get('/welcome',[\App\Http\Controllers\Controller::class,'showall']) ->name('welcome');
Route::get('/pitch_information/{pitch_id}', [\App\Http\Controllers\Controller::class,'pitch_detail'])->name('pitch.details');
Route::post('/choosetime/add', [\App\Http\Controllers\Controller::class, 'addTimeFrame'])->name('choosetime.add');
Route::post('/pitch/select', [\App\Http\Controllers\Controller::class, 'selectPitch'])->name('pitch.select');
Route::post('/pitch/delete', [\App\Http\Controllers\Controller::class, 'deletePitch'])->name('pitch.delete');

// In routes/web.php
Route::post('/booking/offline',  [\App\Http\Controllers\Controller::class,'Process_booking_orders_when_paying_offline'])->name('booking.offline');
Route::post('/booking/online',  [\App\Http\Controllers\Controller::class,'Process_booking_orders_when_paying_online'])->name('booking.online');


Route::post('payment_process' , [\App\Http\Controllers\Controller::class, 'paymentvnpay'])->name('payment.process');
Route::get('schedulingform_process', [\App\Http\Controllers\Controller::class,'schedulingformProcess'])->name('schedulingform.process');
Route::get('/vnpay-return',  [\App\Http\Controllers\Controller::class,'vnpayReturn'])->name('vnpay.return');

Route::post('/page_register', [\App\Http\Controllers\Controller::class,'registerProcess'])->name('page_register');
Route::get('/pageregister',[\App\Http\Controllers\Controller::class,'view_register'])->name('pageregister');


Route::post('/page_login', [\App\Http\Controllers\Controller::class,'loginProcess'])->name('page_login');
Route::get('/pagelogin',[\App\Http\Controllers\Controller::class,'viewLogin'])->name('pagelogin');


Route::get('/customerlogout',[\App\Http\Controllers\Controller::class,'customerlogout'])->name('customer_logout');
//ADMIN MANAGER

Route::get('/login_admin', [AdminController::class, 'view_login_admin'])->name('login_admin');
Route::post('/login_admin', [AdminController::class, 'login_admin'])->name('login.admin');
Route::get('/logout_admin', [AdminController::class, 'logout_admin'])->name('logout_admin');


Route::middleware(['AuthenticateAdmin'])->group(function () {
    Route::get('/home_admin_new', [AdminController::class, 'return_back_home_admin_new'])->name('home_admin_new');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::get('edit-admin/{admin_id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('update-admin/{admin_id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('destroy-admin/{admin_id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::post('store-admin', [AdminController::class, 'store'])->name('admin.store');

    // CUSTOMER MANAGER
    Route::get('/customer', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/create', [\App\Http\Controllers\Admin\CustomerController::class, 'create'])->name('customer.create');
    Route::get('edit-customer/{customer_id}', [\App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('update-customer/{customer_id}', [\App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('customer.update');
    Route::delete('destroy-customer/{customer_id}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customer.destroy');
    Route::post('store-customer', [\App\Http\Controllers\Admin\CustomerController::class, 'store'])->name('customer.store');

   //YARD CATEGORY MANAGER
Route::get('/yard_category', [\App\Http\Controllers\Admin\YardCategoryController::class, 'index'])->name('yard_category.index');
Route::get('/yard_category/create',[\App\Http\Controllers\Admin\YardCategoryController::class,'create'])->name('yard_category.create');
Route::get('edit-yard_category/{yard_category_id}', [\App\Http\Controllers\Admin\YardCategoryController::class, 'edit'])->name('yard_category.edit');
Route::put('update-yard_category/{yard_category_id}', [\App\Http\Controllers\Admin\YardCategoryController::class, 'update'])->name('yard_category.update');
Route::delete('destroy-yard_category/{yard_category_id}', [\App\Http\Controllers\Admin\YardCategoryController::class, 'destroy'])->name('yard_category.destroy');
Route::post('store-yard_category', [\App\Http\Controllers\Admin\YardCategoryController::class, 'store'])->name('yard_category.store');

//PAYMENT METHOD MANAGER
Route::get('/payment', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment/create',[\App\Http\Controllers\Admin\PaymentController::class,'create'])->name('payment.create');
Route::get('edit-payment/{payment_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'edit'])->name('payment.edit');
Route::put('update-payment/{payment_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('payment.update');
Route::delete('destroy-payment/{payment_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'destroy'])->name('payment.destroy');
Route::post('store-payment', [\App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('payment.store');

//PAYMENT METHOD MANAGER
Route::get('/pitch',[App\Http\Controllers\Admin\PitchController::class, 'index'])->name('pitch.index');
Route::get('/pitch/create',[App\Http\Controllers\Admin\PitchController::class, 'create'])->name('pitch.create');
Route::get('edit-pitch/{pitch_id}', [App\Http\Controllers\Admin\PitchController::class, 'edit'])->name('pitch.edit');
Route::put('update-pitch/{pitch_id}', [App\Http\Controllers\Admin\PitchController::class, 'update'])->name('pitch.update');
Route::delete('destroy-pitch/{pitch_id}', [App\Http\Controllers\Admin\PitchController::class, 'destroy'])->name('pitch.destroy');
Route::post('store-pitch', [App\Http\Controllers\Admin\PitchController::class, 'store'])->name('pitch.store');

//TIME FRAME MANAGER
Route::get('/time_frame', [\App\Http\Controllers\Admin\TimeFrameController::class, 'index'])->name('time_frame.index');
Route::get('/time_frame/create',[\App\Http\Controllers\Admin\TimeFrameController::class,'create'])->name('time_frame.create');
Route::get('edit-time_frame/{time_frame}', [\App\Http\Controllers\Admin\TimeFrameController::class, 'edit'])->name('time_frame.edit');
Route::put('update-time_frame/{time_frame}', [\App\Http\Controllers\Admin\TimeFrameController::class, 'update'])->name('time_frame.update');
Route::delete('destroy-time_frame/{time_frame}', [\App\Http\Controllers\Admin\TimeFrameController::class, 'destroy'])->name('time_frame.destroy');
Route::post('store-time_frame', [\App\Http\Controllers\Admin\TimeFrameController::class, 'store'])->name('time_frame.store');

//SCHEDULING FORM MANAGER
Route::get('/scheduling_form', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'index'])->name('scheduling_form.index');
Route::get('/scheduling_form/create',[\App\Http\Controllers\Admin\SchedulingFromController::class,'create'])->name('scheduling_form.create');
Route::get('edit-scheduling_form/{scheduling_form}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'edit'])->name('scheduling_form.edit');
Route::put('update-scheduling_form/{scheduling_form}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'update'])->name('scheduling_form.update');
Route::delete('destroy-scheduling_form/{scheduling_form}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'destroy'])->name('scheduling_form.destroy');
Route::post('store-scheduling_form', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'store'])->name('scheduling_form.store');

Route::get('/add-to-cart/{id}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'addToCart'])->name('cart.add');
Route::get('/add-to-cart-time/{id}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'addToCartTime'])->name('carttime.add');
Route::get('/clear-cart', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'clear'])->name('cart.clear');
});




// Route::middleware('AuthenticateAdmin')->get('/home_admin_new', [AdminController::class, 'return_back_home_admin_new'])->name('home_admin_new');
// Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
// Route::get('/admin/create',[AdminController::class, 'create'])->name('admin.create');
// Route::get('edit-admin/{admin_id}', [AdminController::class, 'edit'])->name('admin.edit');
// Route::put('update-admin/{admin_id}', [AdminController::class, 'update'])->name('admin.update');
// Route::delete('destroy-admin/{admin_id}', [AdminController::class, 'destroy'])->name('admin.destroy');
// 

//CUSTOMER MANAGER
// Route::get('/customer', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customer.index');
// Route::get('/customer/create',[\App\Http\Controllers\Admin\CustomerController::class ,'create'])->name('customer.create');
// Route::get('edit-customer/{customer_id}', [\App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('customer.edit');
// Route::put('update-customer/{customer_id}', [\App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('customer.update');
// Route::delete('destroy-customer/{customer_id}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customer.destroy');
// Route::post('store-customer', [\App\Http\Controllers\Admin\CustomerController::class, 'store'])->name('customer.store');

// //YARD CATEGORY MANAGER
// Route::get('/yard_category', [\App\Http\Controllers\Admin\YardCategoryController::class, 'index'])->name('yard_category.index');
// Route::get('/yard_category/create',[\App\Http\Controllers\Admin\YardCategoryController::class,'create'])->name('yard_category.create');
// Route::get('edit-yard_category/{yard_category_id}', [\App\Http\Controllers\Admin\YardCategoryController::class, 'edit'])->name('yard_category.edit');
// Route::put('update-yard_category/{yard_category_id}', [\App\Http\Controllers\Admin\YardCategoryController::class, 'update'])->name('yard_category.update');
// Route::delete('destroy-yard_category/{yard_category_id}', [\App\Http\Controllers\Admin\YardCategoryController::class, 'destroy'])->name('yard_category.destroy');
// Route::post('store-yard_category', [\App\Http\Controllers\Admin\YardCategoryController::class, 'store'])->name('yard_category.store');

// //PAYMENT METHOD MANAGER
// Route::get('/payment', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payment.index');
// Route::get('/payment/create',[\App\Http\Controllers\Admin\PaymentController::class,'create'])->name('payment.create');
// Route::get('edit-payment/{payment_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'edit'])->name('payment.edit');
// Route::put('update-payment/{payment_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('payment.update');
// Route::delete('destroy-payment/{payment_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'destroy'])->name('payment.destroy');
// Route::post('store-payment', [\App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('payment.store');

// //PAYMENT METHOD MANAGER
// Route::get('/pitch',[App\Http\Controllers\Admin\PitchController::class, 'index'])->name('pitch.index');
// Route::get('/pitch/create',[App\Http\Controllers\Admin\PitchController::class, 'create'])->name('pitch.create');
// Route::get('edit-pitch/{pitch_id}', [App\Http\Controllers\Admin\PitchController::class, 'edit'])->name('pitch.edit');
// Route::put('update-pitch/{pitch_id}', [App\Http\Controllers\Admin\PitchController::class, 'update'])->name('pitch.update');
// Route::delete('destroy-pitch/{pitch_id}', [App\Http\Controllers\Admin\PitchController::class, 'destroy'])->name('pitch.destroy');
// Route::post('store-pitch', [App\Http\Controllers\Admin\PitchController::class, 'store'])->name('pitch.store');

// //TIME FRAME MANAGER
// Route::get('/time_frame', [\App\Http\Controllers\Admin\TimeFrameController::class, 'index'])->name('time_frame.index');
// Route::get('/time_frame/create',[\App\Http\Controllers\Admin\TimeFrameController::class,'create'])->name('time_frame.create');
// Route::get('edit-time_frame/{time_frame}', [\App\Http\Controllers\Admin\TimeFrameController::class, 'edit'])->name('time_frame.edit');
// Route::put('update-time_frame/{time_frame}', [\App\Http\Controllers\Admin\TimeFrameController::class, 'update'])->name('time_frame.update');
// Route::delete('destroy-time_frame/{time_frame}', [\App\Http\Controllers\Admin\TimeFrameController::class, 'destroy'])->name('time_frame.destroy');
// Route::post('store-time_frame', [\App\Http\Controllers\Admin\TimeFrameController::class, 'store'])->name('time_frame.store');

// //SCHEDULING FORM MANAGER
// Route::get('/scheduling_form', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'index'])->name('scheduling_form.index');
// Route::get('/scheduling_form/create',[\App\Http\Controllers\Admin\SchedulingFromController::class,'create'])->name('scheduling_form.create');
// Route::get('edit-scheduling_form/{scheduling_form}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'edit'])->name('scheduling_form.edit');
// Route::put('update-scheduling_form/{scheduling_form}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'update'])->name('scheduling_form.update');
// Route::delete('destroy-scheduling_form/{scheduling_form}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'destroy'])->name('scheduling_form.destroy');
// Route::post('store-scheduling_form', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'store'])->name('scheduling_form.store');

// Route::get('/add-to-cart/{id}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'addToCart'])->name('cart.add');
// Route::get('/add-to-cart-time/{id}', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'addToCartTime'])->name('carttime.add');
// Route::get('/clear-cart', [\App\Http\Controllers\Admin\SchedulingFromController::class, 'clear'])->name('cart.clear');
