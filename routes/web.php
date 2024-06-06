<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BinomeController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\filiereController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\JuryController;
use App\Http\Controllers\MemoireController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PreinscriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\recherchecontroller;
use App\Http\Controllers\RedirectionController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SoutenanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TypeDiplomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });
Route::get('/register/{vi}', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/profile/plus', [UserController::class, 'profile'])->name('profile');


Route::prefix('/recherche')->group(function(){
    Route::get('/filtre', [recherchecontroller::class, 'show'])->name('recherche.filtre');
    Route::get('/recherche', [recherchecontroller::class, 'search'])->name('recherche');
    Route::get('/filtre/resultat', [recherchecontroller::class, 'filtre'])->name('recherche.traitement');
});  

Route::get('/memoire/download/{id}', [MemoireController::class, 'download'])->name('memoire.download');
Route::get('/memoires/{memoire}/previsualiser', [MemoireController::class, 'previsualiser'])->name('memoires.previsualiser');

 
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/generate-link/{role}/{promotion}/{diplome}', [TeacherController::class, 'generateLink'])->name('generate.link');

    Route::get('/redirection', [RedirectionController::class, 'redirection'])->name('dashboard');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/student', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/teacher/{id_edit?}', [TeacherController::class, 'index'])->name('teacher.dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    Route::prefix('/notifications')->group(function () {
        // Route pour afficher les notifications non lues
        Route::get('/non-lu', [NotificationController::class, 'usernotificationNonLu'])
            ->name('notifications.non-lu');

        // Route pour afficher les notifications lues
        Route::get('/lu', [NotificationController::class, 'usernotificationLu'])
            ->name('notifications.lu');

        // Route pour afficher toutes les notifications
        Route::get('/non_lu', [NotificationController::class, 'notification'])
            ->name('notifications.all');
    });

        Route::resource('diplome',TypeDiplomeController::class);
        Route::resource('sites', SiteController::class);
        Route::resource('filieres', filiereController::class);
        Route::resource('binomes', BinomeController::class);
        Route::get('/etudiants/{filiere_id}', [EtudiantController::class,'getEtudiantsByFiliere']);


        Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
        Route::post('/etudiants/send-invitation', [InvitationController::class, 'sendInvitation'])->name('envoyer_invitation');
        Route::post('/etudiants/confirm-invitation', [InvitationController::class, 'confirmInvitation'])->name('confirmer_invitation');
        Route::post('/etudiants/annuler', [InvitationController::class, 'destroy'])->name('annlerinvitation');


        Route::resource('juries', JuryController::class);
        Route::get('/enseigant/ ', [TeacherController::class,'getteacher']);
        Route::get('user', [UserController::class, 'index'])->name('users');
        Route::get('/recherche/etudiant', [UserController::class, 'search'])->name('etudiant.recherche');
        Route::get('/recherche', [UserController::class, 'searchuser'])->name('user.recherche');

        Route::post('/promotion',[PromotionController::class,'store'])->name('promotion.store');

        Route::put('/memoires/{id}/appreciation', [MemoireController::class, 'updateAppreciation'])->name('memoires.updateAppreciation');
        Route::put('/memoires/{id}/appreciation/update', [MemoireController::class, 'updateAppreciation'])->name('memoires.appreciation.edit');
        Route::resource('memoire', MemoireController::class);
        
        Route::get('memoire/all/{page}', [MemoireController::class, 'voire'])->name('memoire.allmemoire');
        Route::post('/memoire/publier', [MemoireController::class,'publication'])->name('memoire.publier');
        Route::get('/memoire/publier/gestion',[MemoireController::class,'MemoirePublier'])->name('memoirepublier');
        Route::get('/compare/memoire/{id}', [MemoireController::class, 'compare']);

        Route::get('/preinscription', [PreinscriptionController::class, 'index'])->name('preinscription');
        Route::post('/preinscription/formulaire', [PreinscriptionController::class, 'store'])->name('preinscription.store');
        
        Route::resource('soutenances', SoutenanceController::class);
        Route::get('/soutenances/filiere/{id_filiere}', [SoutenanceController::class, 'getMemoiresByFiliere'])->name('soutenances.filiere');
        Route::get('/soutenances/binome/{id_binome}', [SoutenanceController::class, 'getBinomesByMemoire'])->name('soutenances.binome');
        Route::get('/agenda', [SoutenanceController::class, 'agenda'])->name('agenda');

});

require __DIR__.'/auth.php';
