<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BinomeController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\filiereController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\JuryController;
use App\Http\Controllers\MemoireController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\recherchecontroller;
use App\Http\Controllers\RedirectionController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SoutenaceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });
Route::prefix('/recherche')->group(function(){
    Route::get('/filtre', [recherchecontroller::class, 'show'])->name('recherche.filtre');
    Route::get('/recherche', [recherchecontroller::class, 'search'])->name('recherche');
    Route::post('/filtre/resultat', [recherchecontroller::class, 'filtre'])->name('recherche.traitement');
});  

Route::resource('sites', SiteController::class);
Route::resource('filieres', filiereController::class);
Route::resource('binomes', BinomeController::class);
Route::get('/etudiants/{filiere_id}', [EtudiantController::class,'getEtudiantsByFiliere']);


Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
Route::post('/etudiants/send-invitation', [InvitationController::class, 'sendInvitation'])->name('envoyer_invitation');
Route::post('/etudiants/confirm-invitation', [InvitationController::class, 'confirmInvitation'])->name('confirmer_invitation');


Route::resource('juries', JuryController::class);
Route::get('/enseigant/ ', [TeacherController::class,'getteacher']);
Route::get('register/{role}/{promotion}', [RegisteredUserController::class, 'create']);
Route::get('user', [UserController::class, 'index'])->name('users');
Route::post('/promotion',[PromotionController::class,'store'])->name('promotion.store');

Route::put('/memoires/{id}/appreciation', [MemoireController::class, 'updateAppreciation'])->name('memoires.updateAppreciation');
Route::get('/memoires/{memoire}/previsualiser', [MemoireController::class, 'previsualiser'])->name('memoires.previsualiser');
Route::resource('memoire', MemoireController::class);
Route::get('/memoire/download/{id}', [MemoireController::class, 'download'])->name('memoire.download');
Route::get('memoire/all', [MemoireController::class, 'voire'])->name('memoire.allmemoire');
Route::post('/memoire/publier', [MemoireController::class,'publication'])->name('memoire.publier');

Route::resource('soutenances', SoutenaceController::class);
Route::get('/soutenances/filiere/{id_filiere}', [SoutenaceController::class, 'getMemoiresByFiliere'])->name('soutenances.filiere');
Route::get('/agenda', [SoutenaceController::class, 'agenda'])->name('agenda');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/redirection', [RedirectionController::class, 'redirection'])->name('dashboard');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/student', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
