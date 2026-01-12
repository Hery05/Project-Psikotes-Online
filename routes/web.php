<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH TERPUSAT
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\UnifiedAuthController;

/*
|--------------------------------------------------------------------------
| HRD CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\HRD\DashboardController;
use App\Http\Controllers\HRD\CategoryController;
use App\Http\Controllers\HRD\QuestionController;
use App\Http\Controllers\HRD\CandidateController;
use App\Http\Controllers\HRD\ReportController;

/*
|--------------------------------------------------------------------------
| KANDIDAT CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Kandidat\TestController;
use App\Models\CandidateProgress;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH (SATU PINTU)
|--------------------------------------------------------------------------
*/
Route::get('/login', [UnifiedAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UnifiedAuthController::class, 'login']);
Route::get('/logout', [UnifiedAuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| HRD ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('hrd.auth')
    ->prefix('hrd')
    ->name('hrd.')
    ->group(function () {

        /* ================= DASHBOARD ================= */
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /* ================= KATEGORI ================= */
        Route::resource('categories', CategoryController::class);

        /* ================= SOAL PER KATEGORI ================= */

        // daftar soal per kategori
        Route::get(
            'categories/{category}/questions',
            [QuestionController::class, 'index']
        )->name('questions.index');

        // pilih tipe soal
        Route::get(
            'categories/{category}/questions/choose',
            [QuestionController::class, 'chooseType']
        )->name('questions.choose');

        // form soal pilihan ganda
        Route::get(
            'categories/{category}/questions/create-choice',
            [QuestionController::class, 'createChoice']
        )->name('questions.createChoice');

        // form soal uraian
        Route::get(
            'categories/{category}/questions/create-essay',
            [QuestionController::class, 'createEssay']
        )->name('questions.createEssay');

        // simpan soal (choice / essay)
        Route::post(
            'categories/{category}/questions',
            [QuestionController::class, 'store']
        )->name('questions.store');

        /* ================= SOAL (BY ID) ================= */

        // edit
        Route::get(
            'questions/{question}/edit',
            [QuestionController::class, 'edit']
        )->name('questions.edit');

        // update
        Route::put(
            'questions/{question}',
            [QuestionController::class, 'update']
        )->name('questions.update');

        // hapus
        Route::delete(
            'questions/{question}',
            [QuestionController::class, 'destroy']
        )->name('questions.destroy');

        // preview soal
        Route::get(
            'questions/{question}/preview',
            [QuestionController::class, 'preview']
        )->name('questions.preview');

        /* ================= KANDIDAT (HRD VIEW) ================= */

        Route::get('/candidates', [CandidateController::class, 'index'])
            ->name('candidates.index');

        Route::get('/candidates/create', [CandidateController::class, 'create'])
            ->name('candidates.create');

        Route::post('/candidates', [CandidateController::class, 'store'])
            ->name('candidates.store');

        /* ================= LAPORAN ================= */
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/{candidate}', [ReportController::class, 'show'])
            ->name('reports.show');

        Route::post('/reports/{candidate}/update-essay-scores', [ReportController::class, 'updateEssayScores'])
            ->name('reports.updateEssayScores');

        Route::get('/reports/{candidate}/edit-essay/{category}', [ReportController::class, 'editEssay'])
            ->name('reports.editEssay');

        // Report PDF
        Route::get(
            '/reports/{candidate}/pdf',
            [ReportController::class, 'exportPdf']
        )->name('reports.pdf');
    });

/*
|--------------------------------------------------------------------------
| KANDIDAT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('candidate.auth')
    ->prefix('candidate')
    ->name('candidate.')
    ->group(function () {

        /* ================= DASHBOARD ================= */
        Route::get('/dashboard', [TestController::class, 'index'])
            ->name('dashboard');


        /* ================= TEST FLOW ================= */
        Route::get('/test', [TestController::class, 'index'])
            ->name('test.index');

        Route::post('/test/start/{category}', [TestController::class, 'start'])
            ->name('test.start');

        Route::get('/test/{category}/{page}', [TestController::class, 'show'])
            ->name('test.show');

        Route::post('/test/{category}', [TestController::class, 'submit'])
            ->name('test.submit');

        Route::post('/test/next', [TestController::class, 'next'])
            ->name('candidate.test.next');
        /* ================= AUTOSAVE ================= */
        Route::post('/test/autosave', [TestController::class, 'autosave'])
            ->name('autosave');

        /* ================= CHEAT DETECTION ================= */
        Route::post('/test/cheat-track', [TestController::class, 'trackCheat'])
            ->name('test.cheat');
    });
