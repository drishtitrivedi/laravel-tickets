<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

//Route::apiResource('tickets', TicketController::class); index
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');

Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');

Route::patch('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');

Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

// classify
Route::post('/tickets/{id}/classify', [TicketController::class, 'classify']);