<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ProfileController;

// Route get côté client
// Route::get('/test-email', function () {
//     try {
//         Mail::raw('Test email', function ($message) {
//             $message->to('your_test_email@example.com')
//                     ->subject('Test Email');
//         });
//         return 'Email sent successfully';
//     } catch (\Exception $e) {
//         return 'Error: ' . $e->getMessage();
//     }
// });
Route::get('/', [RoomsController::class, 'indexpage'])->name('indexpage');
Route::get('/roomlist', [RoomsController::class, 'roomlist'])->name('roomlist');
Route::get('/payment', [RoomsController::class, 'makepayment'])->name('payment');
// Route::get('/roomlist2', [RoomsController::class, 'roomlist2'])->name('roomlist2');
Route::get('/roomdetails/{id}', [RoomsController::class, 'roomdetails'])->name('roomdetails');
Route::get('payment-success', [RoomsController::class, 'paymentSucess'])->name('payment.success');
Route::get('/payment-cancel', [RoomsController::class, 'paymentCancel'])->name('payment.cancel');
Route::get('/contact', [RoomsController::class, 'contact'])->name('contact');

// Route get côté admin
Route::get('/dash', [AdminController::class, 'dashbord'])->name('dash');
Route::get('/deconnexion', [AdminController::class, 'deconnexion'])->name('deconnexion');
Route::get('/admin/RiverOfLove/addadmin', [AdminController::class, 'createadmin'])->name('createadmin');


// Route post côté client
Route::post('/reservation', [RoomsController::class, 'store'])->name('reservation');
Route::post('/sendcontact', [RoomsController::class, 'contactform'])->name('contactform');

//Route post côté admin
Route::post('/addadmin', [AdminController::class, 'addadmin'])->name('addadmin');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
