<?php

namespace App\Controllers;

use Core\Controller;
use Core\SecurityDatabase;
use Core\Session; 

class UserController extends Controller
{
    private $securityDatabase;

    public function __construct()
    {
        parent::__construct();
        $this->securityDatabase = new SecurityDatabase();
    }

    public function showLogin()
    {
        $this->renderView('login');
        // $this->renderView('boutiquier_dashboard');
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = $this->securityDatabase->login($username, $password);


        if ($user) {
            Session::set('user', $user);
            $role = $user['role'];
            if ($role === 'boutiquier') {
                $this->redirect('/boutiquier_dashboard');
            } elseif ($role === 'client') {
                $this->redirect('/client_dashboard');
            }
        } else {
            $this->renderView('login', ['error' => 'Utilisateur inconnu']);
        }
    }

    private function checkAuth(){
        if(!Session::get('user')){
            $this->redirect('/');
        }
    }

    public function showBoutiquierDashboard(){
        // $this->checkAuth();
         $this->renderView('boutiquier_dashboard');
    }

    public function showClientDashboard() {
        $this->checkAuth();
        $this->renderView('client_dashboard');
    }

    public function showPaiementForm(){
        $this->renderView('paiementForm');
    }

    public function showAddDetteForm() {
        $this->renderView('ajoutDette');
    }

}