<?php

use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);


//-------------------
//予約追加(19)
Route::get('/admin/reservations/create', [MovieController::class, 'adminreservecreate'])->name('adminreservecreate');

//一覧表示
Route::get('/admin/movies', [MovieController::class, 'getMovies'])->name('index2');
//新規登録
Route::get('/admin/movies/create', [MovieController::class, 'createMovies']);
//保存
Route::post('/admin/movies/store', [MovieController::class, 'store']);
//編集
Route::get('/admin/movies/{id}/edit/', [MovieController::class, 'edit'])->name('edit');
//更新
Route::patch('/admin/movies/{id}/update', [MovieController::class, 'update'])->name('update');
//削除
Route::delete('/admin/movies/{id}/destroy', [MovieController::class, 'destroy'])->name('destroy');
//スケジュール作成
Route::get('/admin/movies/{id}/schedules/create', [MovieController::class, 'createSchedule'])->name('createSchedule');
//スケジュール保存
Route::post('/admin/movies/{id}/schedules/store', [MovieController::class, 'storeSchedule']);
//スケジュール編集
Route::get('/admin/schedules/{id}/edit/', [MovieController::class, 'editSchedule'])->name('editSchedule');
//スケジュール削除
Route::delete('/admin/schedules/{id}/destroy', [MovieController::class, 'destroySchedule'])->name('destroySchedule');
//スケジュール更新
Route::patch('/admin/schedules/{id}/update', [MovieController::class, 'updateSchedule'])->name('updateSchedule');
//詳細
Route::get('/admin/movies/{id}/', [MovieController::class, 'admindetail'])->name('admindetail');
Route::get('/admin/schedules/{id}', [MovieController::class, 'adminSchedule'])->name('adminSchedule');

//管理者座席編集
Route::get('/admin/reservations/{id}/edit', [MovieController::class, 'admineditSheet'])->name('admineditSheet');
//管理者座席削除
Route::delete('/admin/reservations/{id}', [MovieController::class, 'admindestroySheet'])->name('admindestroySheet');
//管理者予約更新
Route::patch('/admin/reservations/{id}', [MovieController::class, 'sheetupdate'])->name('sheetupdate');
//予約一覧(19)
Route::get('/admin/reservations/', [MovieController::class, 'adminreserve'])->name('adminreserve');
//管理者座席保存
Route::post('/admin/reservations/', [MovieController::class, 'adminstoresheet'])->name('adminstoresheet');

//スケジュール一覧
Route::get('/admin/schedules/', [MovieController::class, 'listSchedule'])->name('listSchedule');


//-------------------
//一覧表示
Route::get('/movies', [MovieController::class, 'ListMovies'])->name('list');
//座席一覧
Route::get('/sheets', [MovieController::class, 'ListSheets'])->name('sheet');
//座席予約
Route::get('/movies/{m_id}/schedules/{s_id}/sheets', [MovieController::class, 'reserve'])->name('reserve');
Route::get('/movies/{m_id}/schedules/{s_id}/reservations/create', [MovieController::class, 'reserveCreate'])->name('reservecreate');
//詳細
Route::get('/movies/{id}/', [MovieController::class, 'detail'])->name('detail');
//座席保存
Route::post('/reservations/store', [MovieController::class, 'storesheet'])->name('storesheet');

