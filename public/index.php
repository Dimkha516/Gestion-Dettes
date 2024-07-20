<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once '../vendor/autoload.php';



use Core\Route;
use Core\Session;
use App\Controllers\UserController;
use App\Controllers\ClientController;

Session::start();

// Test if the class can be found
if (!class_exists(ClientController::class)) {
    die('ClientController class not found.');
}
Route::post('/login', [UserController::class, 'login']);

// Route::get('/', [UserController::class, 'showLogin']);
Route::get('/', [UserController::class, 'showBoutiquierDashboard']);
Route::get('/boutiquier_dashboard', [UserController::class, 'showBoutiquierDashboard']);
Route::get('/client_dashboard', [UserController::class, 'showClientDashboard']);
Route::get('/boutiquier_dashboard/filter', [UserController::class, 'showBoutiquierDashboardWithFilter']);
Route::get('/paiementForm', [UserController::class, 'showPaiementForm']);

Route::get("/ajoutDette", [UserController::class, 'showAddDetteForm']);

// New routes for adding client
Route::post('/add_client', [ClientController::class, 'addClient']);
Route::post('/search_client', ['App\Controllers\ClientController', 'searchClient']);

// ROUTE FOR ADD PAIEMENT:
Route::post('/addPayement', [ClientController::class, 'addPaiement']);

// SEARCH ARTICLE:
Route::post('/search_article', ['App\Controllers\ClientController', 'searchArticle']);

Route::post('/clearArticle', ['App\Controllers\ClientController', 'clearArticles']);
Route::post('/addDette', ['App\Controllers\ClientController', 'insertDette']);



Route::run();



/*

------------------AJOUT PAIEMENT: INSERER DANS TABLE PAIEMENT ET TABLE DETTESCLIENT

------------------TABLES POUR AJOUT DETTE: Dette(Ajout), DetteClient(Update), Article(Update),



// Route::post('/add_client', [ClientController::class, 'showBoutiquierDashboard']);
// Route::post('/boutiquier_dashboard', [ClientController::class, 'addClient']);
Modifier la méthode showLogin dans UserController pour remettre
la page login par défaut 
*/

/*
CONTINUER DEMAIN JEUDI 11 JUILLET: AFFICHER MSG ERREUR EN CAS DE DUPLIC DE DONNÉES DANS INSERTION TABLE
FONCTION DE RECHERCHE CLIENT PAR TÉLÉPHONE.

Call back, Middleware, Regex

*/