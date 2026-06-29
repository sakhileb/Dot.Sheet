<?php

use App\Http\Controllers\Auth\EcosystemAuthController;

use App\Http\Controllers\SpreadsheetController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/ecosystem', [EcosystemAuthController::class, 'handle'])->name('auth.ecosystem');

Route::get('/', function () {
    return view('welcome');
});


Route::get('shared/s/{token}', [SpreadsheetController::class, 'publicShow'])->name('spreadsheets.public');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $userId = auth()->id();
        $mySheets = \App\Models\Spreadsheet::where('owner_id', $userId)->count();
        $sharedSheets = \Illuminate\Support\Facades\DB::table('spreadsheet_user')
            ->where('user_id', $userId)->count();
        $totalCells = \App\Models\Cell::whereHas('spreadsheet', fn ($q) => $q->where('owner_id', $userId))->count();
        $aiPrompts = \App\Models\AiPrompt::where('user_id', $userId)->count();
        $recentSheets = \App\Models\Spreadsheet::where('owner_id', $userId)->latest()->limit(8)->get();
        return view('dashboard', compact('mySheets', 'sharedSheets', 'totalCells', 'aiPrompts', 'recentSheets'));
    })->name('dashboard');

    // Spreadsheet routes
    Route::resource('spreadsheets', SpreadsheetController::class);

    // Import / Export
    Route::post('spreadsheets/{spreadsheet}/import', [SpreadsheetController::class, 'import'])->name('spreadsheets.import');
    Route::get('spreadsheets/{spreadsheet}/import/batches/{batchId}', [SpreadsheetController::class, 'importBatchStatus'])->name('spreadsheets.import.batch-status');
    Route::get('spreadsheets/{spreadsheet}/export/csv',   [SpreadsheetController::class, 'exportCsv'])->name('spreadsheets.export.csv');
    Route::get('spreadsheets/{spreadsheet}/export/excel', [SpreadsheetController::class, 'exportExcel'])->name('spreadsheets.export.excel');

    // Invitations
    Route::get('spreadsheets/invitations/{token}/accept', [SpreadsheetController::class, 'acceptInvitation'])
        ->name('spreadsheets.invitations.accept');
});
