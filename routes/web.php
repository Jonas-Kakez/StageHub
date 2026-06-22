<?php

use App\Http\Controllers\Admin\CandidatureController as AdminCandidature;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DepartementController as AdminDepartement;
use App\Http\Controllers\Admin\EntrepriseController as AdminEntreprise;
use App\Http\Controllers\Admin\EvaluationController as AdminEvaluation;
use App\Http\Controllers\Admin\EtudiantController as AdminEtudiant;
use App\Http\Controllers\Admin\OffreController as AdminOffre;
use App\Http\Controllers\Admin\RapportController as AdminRapport;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Departement\AffectationController as DeptAffectation;
use App\Http\Controllers\Departement\DashboardController as DeptDashboard;
use App\Http\Controllers\Encadreur\DashboardController as EncDashboard;
use App\Http\Controllers\Encadreur\EvaluationController as EncEvaluation;
use App\Http\Controllers\Encadreur\RapportController as EncRapport;
use App\Http\Controllers\Encadreur\StagiaireController as EncStagiaire;
use App\Http\Controllers\Entreprise\CandidatureController as EntCandidature;
use App\Http\Controllers\Entreprise\DashboardController as EntDashboard;
use App\Http\Controllers\Entreprise\OffreController as EntOffre;
use App\Http\Controllers\Entreprise\StagiaireController as EntStagiaire;
use App\Http\Controllers\Etudiant\CandidatureController as EtuCandidature;
use App\Http\Controllers\Etudiant\DashboardController as EtuDashboard;
use App\Http\Controllers\Etudiant\EvaluationController as EtuEvaluation;
use App\Http\Controllers\Etudiant\OffreController as EtuOffre;
use App\Http\Controllers\Etudiant\ProfilController as EtuProfil;
use App\Http\Controllers\Etudiant\RapportController as EtuRapport;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil.select');

Route::get('/login/{role}', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register/{role}', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/entreprises', [AdminEntreprise::class, 'index'])->name('entreprises.index');
        Route::get('/entreprises/{entreprise}', [AdminEntreprise::class, 'show'])->name('entreprises.show');
        Route::post('/entreprises/{entreprise}/valider', [AdminEntreprise::class, 'valider'])->name('entreprises.valider');
        Route::post('/entreprises/{entreprise}/refuser', [AdminEntreprise::class, 'refuser'])->name('entreprises.refuser');
        Route::get('/etudiants', [AdminEtudiant::class, 'index'])->name('etudiants.index');
        Route::get('/etudiants/{etudiant}', [AdminEtudiant::class, 'show'])->name('etudiants.show');
        Route::get('/offres', [AdminOffre::class, 'index'])->name('offres.index');
        Route::get('/offres/create', [AdminOffre::class, 'create'])->name('offres.create');
        Route::post('/offres', [AdminOffre::class, 'store'])->name('offres.store');
        Route::post('/offres/{offre}/approuver', [AdminOffre::class, 'approuver'])->name('offres.approuver');
        Route::post('/offres/{offre}/refuser', [AdminOffre::class, 'refuser'])->name('offres.refuser');
        Route::post('/offres/{offre}/desactiver', [AdminOffre::class, 'desactiver'])->name('offres.desactiver');
        Route::get('/candidatures', [AdminCandidature::class, 'index'])->name('candidatures.index');
        Route::post('/candidatures/{candidature}/transmettre', [AdminCandidature::class, 'transmettre'])->name('candidatures.transmettre');
        Route::post('/candidatures/{candidature}/refuser', [AdminCandidature::class, 'refuser'])->name('candidatures.refuser');
        Route::get('/evaluations', [AdminEvaluation::class, 'index'])->name('evaluations.index');
        Route::post('/evaluations/{evaluation}/valider', [AdminEvaluation::class, 'valider'])->name('evaluations.valider');
        Route::get('/users', [AdminUser::class, 'index'])->name('users.index');
        Route::post('/users/{user}/toggle', [AdminUser::class, 'toggleActive'])->name('users.toggle');
        Route::get('/departements', [AdminDepartement::class, 'index'])->name('departements.index');
        Route::post('/departements', [AdminDepartement::class, 'store'])->name('departements.store');
        Route::put('/departements/{departement}', [AdminDepartement::class, 'update'])->name('departements.update');
        Route::delete('/departements/{departement}', [AdminDepartement::class, 'destroy'])->name('departements.destroy');
        Route::post('/departements/{departement}/encadreurs', [AdminDepartement::class, 'storeEncadreur'])->name('departements.encadreurs.store');
        Route::get('/rapports', [AdminRapport::class, 'index'])->name('rapports.index');
    });

    Route::prefix('entreprise')->name('entreprise.')->middleware('role:entreprise')->group(function () {
        Route::get('/dashboard', [EntDashboard::class, 'index'])->name('dashboard');
        Route::get('/offres', [EntOffre::class, 'index'])->name('offres.index');
        Route::get('/offres/create', [EntOffre::class, 'create'])->name('offres.create');
        Route::post('/offres', [EntOffre::class, 'store'])->name('offres.store');
        Route::get('/offres/{offre}/edit', [EntOffre::class, 'edit'])->name('offres.edit');
        Route::put('/offres/{offre}', [EntOffre::class, 'update'])->name('offres.update');
        Route::post('/offres/{offre}/desactiver', [EntOffre::class, 'desactiver'])->name('offres.desactiver');
        Route::get('/candidatures', [EntCandidature::class, 'index'])->name('candidatures.index');
        Route::post('/candidatures/{candidature}/accepter', [EntCandidature::class, 'accepter'])->name('candidatures.accepter');
        Route::post('/candidatures/{candidature}/refuser', [EntCandidature::class, 'refuser'])->name('candidatures.refuser');
        Route::get('/candidatures/{candidature}/cv', [EntCandidature::class, 'downloadCv'])->name('candidatures.cv');
        Route::get('/stagiaires', [EntStagiaire::class, 'index'])->name('stagiaires.index');
        Route::post('/candidatures/{candidature}/affecter', [EntStagiaire::class, 'affecter'])->name('stagiaires.affecter');
        Route::post('/stagiaires/{affectation}/evaluer', [EntStagiaire::class, 'evaluer'])->name('stagiaires.evaluer');
    });

    Route::prefix('etudiant')->name('etudiant.')->middleware('role:etudiant')->group(function () {
        Route::get('/dashboard', [EtuDashboard::class, 'index'])->name('dashboard');
        Route::get('/offres', [EtuOffre::class, 'index'])->name('offres.index');
        Route::get('/offres/{offre}', [EtuOffre::class, 'show'])->name('offres.show');
        Route::get('/candidatures', [EtuCandidature::class, 'index'])->name('candidatures.index');
        Route::post('/offres/{offre}/candidater', [EtuCandidature::class, 'store'])->name('candidatures.store');
        Route::get('/rapport', [EtuRapport::class, 'index'])->name('rapport.index');
        Route::post('/rapport', [EtuRapport::class, 'store'])->name('rapport.store');
        Route::get('/evaluations', [EtuEvaluation::class, 'index'])->name('evaluations.index');
        Route::get('/profil', [EtuProfil::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [EtuProfil::class, 'update'])->name('profil.update');
    });

    Route::prefix('departement')->name('departement.')->middleware('role:departement')->group(function () {
        Route::get('/dashboard', [DeptDashboard::class, 'index'])->name('dashboard');
        Route::get('/affectations', [DeptAffectation::class, 'index'])->name('affectations.index');
        Route::post('/affectations/{affectation}/encadreur', [DeptAffectation::class, 'assignEncadreur'])->name('affectations.encadreur');
    });

    Route::prefix('encadreur')->name('encadreur.')->middleware('role:encadreur')->group(function () {
        Route::get('/dashboard', [EncDashboard::class, 'index'])->name('dashboard');
        Route::get('/stagiaires', [EncStagiaire::class, 'index'])->name('stagiaires.index');
        Route::get('/rapports', [EncRapport::class, 'index'])->name('rapports.index');
        Route::get('/rapports/{rapport}/download', [EncRapport::class, 'download'])->name('rapports.download');
        Route::post('/rapports/{rapport}/commenter', [EncRapport::class, 'commenter'])->name('rapports.commenter');
        Route::get('/evaluations/{affectation}/create', [EncEvaluation::class, 'create'])->name('evaluations.create');
        Route::post('/evaluations/{affectation}', [EncEvaluation::class, 'store'])->name('evaluations.store');
    });
});
