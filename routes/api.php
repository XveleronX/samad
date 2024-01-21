<?php


use App\Http\Controllers\CheckController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthorizeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return redirect()->route('login_view');
});


Route::get('/auth/{provider}/redirect', [AuthorizeController::class , 'redirect'])->name('redirect.provider');
Route::get('/auth/{provider}/callback', [AuthorizeController::class , 'callback'])->name('callback.provider');

Route::get('/login', [AuthorizeController::class , 'login_view'])->name('login_view');
Route::post('/auth/login', [AuthorizeController::class , 'login'])->name('login');

Route::get('/register', [AuthorizeController::class , 'register_view'])->name('register_view');
Route::any('/auth/register', [AuthorizeController::class , 'register'])->name('register');

/*Route::middleware(['auth:sanctum'])->group(function (){*/
/*Route::middleware(['Sellers_Status'])->group(function (){*/


    Route::any('/logout' , [AuthorizeController::class , 'logout'])->name('logout');

    Route::get('/workplace', function () {
        return view('first_project.workplace');
    })->name('workplace');

//users
    Route::get('/send/email' , [MailController::class , 'index'])->name('email.index');
    Route::post('/users/{id}/upload' , [UserController::class, 'image'])->name('users.image')/*->middleware('roles:admin,user,seller')*/;
    Route::get('/users/filter', [UserController::class, 'filter'])->name('users.filter')->middleware('roles:admin');
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('roles:admin');
    Route::get('/sellers', [UserController::class, 'sellers_index'])->name('sellers.index')->middleware('roles:admin');
    Route::get('/sellers/notaccepted', [UserController::class, 'sellers_notaccepted'])->name('sellers.notaccepted')->middleware('roles:admin');
    Route::any('/sellers/{id}/accept', [UserController::class, 'accept_seller'])->name('sellers.accept')->middleware('roles:admin');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('roles:admin');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('roles:admin');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('roles:admin,user,seller');
    Route::any('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('roles:admin,user,seller');
    Route::post('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy')->middleware('roles:admin');


    //products
    Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter')->middleware('roles:admin,seller');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('roles:seller,admin');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('roles:seller,admin');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('roles:seller,admin');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('roles:seller,admin');
    Route::any('/products/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('roles:seller,admin');
    Route::post('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('roles:seller,admin');

    //orders
    Route::get('/orders/filter', [OrderController::class, 'filter'])->name('orders.filter')->middleware('roles:admin,user');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('roles:seller,admin,user');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create')->middleware('roles:user,admin');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('roles:user,admin');
    Route::middleware(['pay_status'])->group(function (){
        Route::get('/orders/{id}/edit', [OrderController::class, 'edit'] )->name('orders.edit')->middleware('roles:user,admin');
        Route::any('/orders/{id}', [OrderController::class, 'update'])->name('orders.update')->middleware('roles:user,admin');
        Route::post('/orders/{id}/delete', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('roles:user,admin');
    });
    //factor
    Route::get('/checks', [CheckController::class, 'index'])->name('checks.index')->middleware('roles:admin');
    Route::get('/checks/create', [CheckController::class, 'create'])->name('checks.create')->middleware('roles:admin');
    Route::post('/checks', [CheckController::class, 'store'])->name('checks.store')->middleware('roles:admin');
    Route::get('/checks/{id}/edit', [CheckController::class, 'edit'])->name('checks.edit')->middleware('roles:admin');
    Route::any('/checks/{id}', [CheckController::class, 'update'])->name('checks.update')->middleware('roles:admin');
    Route::post('/checks/{id}/delete', [CheckController::class, 'destroy'])->name('checks.destroy')->middleware('roles:admin');
    Route::any('/checks/{id}/pay' , [CheckController::class, 'pay'])->name('checks.pay')->middleware('roles:user,admin');
/*});*/
/*});*/
