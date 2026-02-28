<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


   Route::resource('appointments', AppointmentController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);


});

Route::post('/notifications/read/{id}', function ($id) {

    $notification = auth()->user()
        ->notifications()
        ->where('id', $id)
        ->first();

    if ($notification) {
        $notification->markAsRead();
    }

    return response()->json(['success' => true]);
})->middleware('auth')->name('notifications.read');

Route::get('/notifications/latest', function () {

    $notifications = auth()->user()
        ->unreadNotifications
        ->map(function ($n) {
            return [
                'message' => $n->data['title']
            ];
        });

    auth()->user()->unreadNotifications->markAsRead();

    return response()->json($notifications);

})->middleware('auth');

require __DIR__.'/auth.php';
