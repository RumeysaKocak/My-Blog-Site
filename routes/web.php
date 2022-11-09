<?php

use App\Http\Controllers\Front\Homepage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
    Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function(){
    Route::get('giris', [\App\Http\Controllers\Back\AuthController::class,'login'])->name('login');
    Route::post('giris', [\App\Http\Controllers\Back\AuthController::class,'loginPost'])->name('login.post');
    });

    Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
    Route::get('panel', 'App\Http\Controllers\Back\Dashboard@index')->name('dashboard');
    //MAKALE ROUTE'S
    Route::get('/makaleler/silinenler', 'App\Http\Controllers\Back\ArticleController@trashed')->name('trashed.article');
    Route::resource('makaleler', 'App\Http\Controllers\Back\ArticleController');
    Route::get('/deletearticle/{id}', 'App\Http\Controllers\Back\ArticleController@delete')->name('delete.article');
    Route::get('/harddeletearticle/{id}', 'App\Http\Controllers\Back\ArticleController@harddelete')->name('hard.delete.article');
    Route::get('/recoverarticle/{id}', 'App\Http\Controllers\Back\ArticleController@recover')->name('recover.article');
    // CATEGORY ROUTE'S
    Route::get('/kategoriler', 'App\Http\Controllers\Back\CategoryController@index')->name('category.index');
    Route::post('/kategoriler/create', 'App\Http\Controllers\Back\CategoryController@create')->name('category.create');
    Route::post('/kategoriler/update', 'App\Http\Controllers\Back\CategoryController@update')->name('category.update');
    Route::post('/kategoriler/delete', 'App\Http\Controllers\Back\CategoryController@delete')->name('category.delete');
    Route::get('/kategori/getData', 'App\Http\Controllers\Back\CategoryController@getData')->name('category.getdata');

    //PAGE ROUTE
    Route::get('/sayfalar','App\Http\Controllers\Back\PageController@index')->name('page.index');
    Route::get('/sayfalar/olustur','App\Http\Controllers\Back\PageController@create')->name('page.create');
    Route::get('/sayfalar/guncelle/{id}','App\Http\Controllers\Back\PageController@update')->name('page.edit');
    Route::post('/sayfalar/guncelle/{id}','App\Http\Controllers\Back\PageController@updatePost')->name('page.edit.post');
    Route::post('/sayfalar/olustur','App\Http\Controllers\Back\PageController@post')->name('page.create.post');
    Route::get('/sayfalar/sil/{id}','App\Http\Controllers\Back\PageController@delete')->name('page.delete');
    Route::get('/sayfalar/siralama','App\Http\Controllers\Back\PageController@orders')->name('page.orders');

    //
    Route::get('/ayarlar','App\Http\Controllers\Back\ConfigController@index')->name('config.index');
    Route::get('cikis', [\App\Http\Controllers\Back\AuthController::class,'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [Homepage::class, 'index'])->name('homepage');
Route::get('sayfa',[Homepage::class,'index']);
Route::get('/iletisim', [Homepage::class,'contact'])->name('contact');
Route::post('/iletisim', [Homepage::class,'contactpost'])->name('contact.post');
Route::get('/kategori/{category}', [Homepage::class,'category'])->name('category');
Route::get('/{category}/{slug}', [Homepage::class,'single'])->name('single');
Route::get('/{sayfa}', [Homepage::class,'page'])->name('page');



