<?php

namespace App\Controllers;

use Core\Controller;
use Core\Validator;
use Core\SecurityDatabase;

// use DateTime;

class ClientController extends Controller
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = new SecurityDatabase();
    }

    // TEST MODIFICATION ADDCLIENT:
    public function showBoutiquierDashboard()
    {
        $this->renderView('boutiquier_dashboard');
    }


    // LITTLE GOOD!
    public function addClient()
    {

        $validator = new Validator();

        $rules = [
            'nom_complet' => 'required',
            'login' => 'required|unique:client,login',
            'telephone' => 'required|unique:client,telephone',
            'photo' => 'required|image'
        ];

        if ($validator->validateAddClient($_POST, $rules) && isset($_FILES['photo'])) {
            $nomComplet = $_POST['nom_complet'];
            $login = $_POST['login'];
            $telephone = $_POST['telephone'];
            $photo = $_FILES['photo'];


            // Handle photo upload
            // $photoPath = '/uploads/' . basename($photo['name']);
            $uploadDir = __DIR__ . '/uploads/..';
            $photoPath = $uploadDir . basename($photo['name']);
            //  move_uploaded_file($photo['tmp_name'], __DIR__ . '/..' . $photoPath); 
            if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
                $this->renderView('boutiquier_dashboard', ['errors' => ['photo' => ['Failed to upload photo.']]]);
                return;
            }


            // Insert client into database
            $this->db->query("INSERT INTO Client2 (nom_complet, login, telephone, photo) VALUES (?, ?, ?, ?)", [$nomComplet, $login, $telephone, $photoPath]);

            // Get the ID of the newly inserted client
            // $clientId = $this->db->lastInsertId();Nafy

            // Insert into dette table
            // $date = (new DateTime())->format('Y-m-d');
            // $this->db->query("INSERT INTO dette (date, total, montantVerse, montantRestant, client_id) VALUES (?, 0, 0, 0, ?)", [$date, $clientId]);

            // Redirect or show success message
            $this->renderView('boutiquier_dashboard', ['success' => 'Client ajouté avec succès.']);
            // $this->redirect('/boutiquier_dashboard');
        } else {
            // $this->redirect('/');
            $this->renderView('boutiquier_dashboard', ['errors' => $validator->errors()]);
        }
    }

    public function searchClient()
    {
        // session_start();
        $_SESSION['client'] = '';
        $_SESSION['totalMontant'] = '';
        $_SESSION['totalVerse'] = '';
        $_SESSION['totalRestant'] = '';

        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $telephone = $_POST['phone'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
            // Pour POST, récupérer le téléphone à partir de l'entrée de l'utilisateur
            $telephone = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['phone'] : (isset($_GET['phone']) ? $_GET['phone'] : '');

            $searchError = 'Client non trouvé';

            // Recherche du client par téléphone
            $clientStmt = $this->db->query("SELECT * FROM Client2 WHERE telephone = ?", [$telephone]);
            $clientResult = $clientStmt->fetch(\PDO::FETCH_ASSOC);


            //  LE IF DE $clientResult juste ici: 

            if ($clientResult) {
                if (isset($_SESSION['client'])) {
                    $_SESSION['client'] = $clientResult;
                }


                $client = $clientResult;
                $clientId = $client['id'];

                // Récupération du filtre sélectionné
                $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
                $filterQuery = '';
                $filterParams = [$clientId];

                // Appliquer le filtre
                if ($filter === 'solded') {
                    $filterQuery = " AND montantRestant = 0";
                } elseif ($filter === 'notsolded') {
                    $filterQuery = " AND montantRestant > 0";
                }


                // pagination:
                // $itemsPerPage = 1;
                // $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                // $offset = ($currentPage - 1) * $itemsPerPage;

                // RECUPÉRATION DES DETTES DU CLIENT PAR SON ID AVEC FILTRE:
                $detteStmt = $this->db->query("SELECT * FROM Dette WHERE client_id = ? AND montantRestant > 0" . $filterQuery, $filterParams);
                $detteResult = $detteStmt->fetchAll(\PDO::FETCH_ASSOC);


                // RECUPÉRATION DES DETTES DU CLIENT DANS LA TABLE DETTESCLIENT:
                $dettesClientStmt = $this->db->query("SELECT * FROM DettesClient WHERE client_id = $clientId");
                $dettesClientResult = $dettesClientStmt->fetchAll(\PDO::FETCH_ASSOC);


                // RECUPÉRATION DES PAIEMENTS DU CLIENT PAR SON ID:
                $paiementStmt = $this->db->query("SELECT * FROM Paiement2 WHERE client_id = ?", [$clientId]);
                $paiementResult = $paiementStmt->fetchAll(\PDO::FETCH_ASSOC);


                // Récupération du nombre total de dettes pour la pagination
                $totalStmt = $this->db->query("SELECT COUNT(*) as total FROM Dette WHERE client_id = ?", [$clientId]);
                $totalResult = $totalStmt->fetch(\PDO::FETCH_ASSOC);
                $totalItems = $totalResult['total'];



                $totalMontant = array_sum(array_column($dettesClientResult, 'montantTotal'));
                $_SESSION['totalMontant'] = $totalMontant;
                //

                $totalVerse = array_sum(array_column($dettesClientResult, 'montantVerse'));
                $_SESSION['totalVerse'] = $totalVerse;
                // 

                $totalRestant = array_sum(array_column($dettesClientResult, 'montantRestant'));
                $_SESSION['totalRestant'] = $totalRestant;
                // 



                if ($detteResult) {
                    $dette = $detteResult;
                    $totalMontant = 0;
                    foreach ($dette as $det) {
                        $totalMontant += $det['montantTotal'];
                    }
                } else {
                    $dette = ['total' => 0, 'motantVerse' => 0, 'montantRestant' => 0];
                }

                $this->renderView('boutiquier_dashboard', [
                    'client' => $client,
                    'clientId' => $clientId,
                    'dette' => $detteResult,
                    'totalMontant' => $totalMontant,
                    'totalVerse' => $totalVerse,
                    'totalRestant' => $totalRestant,
                    'phone' => $telephone, // Ajout du téléphone pour préserver l'état de la recherche
                    'paiements' => $paiementResult,
                    'filter' => $filter // Ajout du filtre pour la vue
                ]);
            } else {
                $this->renderView('boutiquier_dashboard', [
                    'searchError' => $searchError,
                    // var_dump('Errur')
                ]);
            }
        }
    }


    public function addPaiement()
    {

        $data = [
            'montantPaye' => $_POST['montantPaye']
        ];
        $rules = [
            'montantPaye' => 'required|positive_number|max_amount'
        ];

        $validator = new Validator();

        if ($validator->validateAddPaiement($data, $rules)) {
            $client = $_SESSION['client'];
            $clientId = $client['id'];
            $montantPaye = $_POST['montantPaye'];

            // RECUPÉRATION DES PAIEMENTS DU CLIENT PAR SON ID:
            $paiementStmt = $this->db->query("SELECT * FROM Paiement2 WHERE client_id = ?", [$clientId]);
            $paiementResult = $paiementStmt->fetchAll(\PDO::FETCH_ASSOC);

            // RECUPÉRATION DE LA LIGNE DE DETTE DU CLIENT:
            $dettesStmt = $this->db->query("SELECT * FROM DettesClient WHERE client_id = ?", [$clientId]);
            $dettesResult = $dettesStmt->fetchAll(\PDO::FETCH_ASSOC);


            // UPDATE DES MONTANTS RESTANT ET VERSE:
            $updateSql = "
                UPDATE DettesClient
                SET montantVerse = montantVerse + :montantPaye,
                    montantRestant = montantRestant - :montantPaye
                WHERE client_id = :clientId 
            ";

            $updateStmt = $this->db->query($updateSql, [
                ':montantPaye' => $montantPaye,
                ':clientId' => $clientId
            ]);

            $_SESSION['totalVerse'] = $_SESSION['totalVerse'] + $montantPaye;
            $_SESSION['totalRestant'] = $_SESSION['totalRestant'] - $montantPaye;

            // AJOUT DU PAIEMENT DANS LA TABLE PAIEMENT:
            $this->db->query("INSERT INTO Paiement2 (montant, client_id) VALUES ($montantPaye, $clientId)");

            $this->renderView('paiementForm', [
                'montantPaye' => $montantPaye,
            ]);

            echo "Paiement enregistré avec succès";
        } else {
            $this->renderView('paiementForm');
            echo "Erreur de validation !";
        }

    }


    public function searchArticle()
    {

        // if($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD' === 'GET']){
        $searchArticleError = 'AUCUN PRODUIT CHOISI';
        $quantityError = 'La quantité doit être supérieure à 0 !';
        $stockError = 'Vous avez dépassé la quantité du stock disponible';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reference = $_POST['reference'];
            $quantite = $_POST['quantite'];
            // $article = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['article'] : (isset($_GET['article']) ? $_GET['article'] : '');

            $articleStmt = $this->db->query("SELECT * FROM Article WHERE reference = ?", [$reference]);
            $articleResult = $articleStmt->fetch(\PDO::FETCH_ASSOC);
            $stockArticle = $articleResult['qteStock'];
            


            if ($articleResult && $quantite > 0 && $quantite <= $stockArticle) {
                // if ($articleResult && $quantite) {
                // $articles = $articleResult;
                // var_dump($articles['libelle']);
                $libelle = $articleResult['libelle'];
                $prix = $articleResult['prix'];
                $montant = $articleResult['prix'] * $quantite;

                $article = [
                    'libelle' => $libelle,
                    'prix' => $prix,
                    'quantite' => $quantite,
                    'montant' => $montant
                ];
                $_SESSION['searchArticleError'] = null;
                $_SESSION['quantityError'] = null;
                $_SESSION['stockError'] = null;






                if (!isset($_SESSION['articles'])) {
                    $_SESSION['articles'] = [];
                }
                // var_dump($_SESSION['articles']);
                $_SESSION['articles'][] = $article;


            } else {
                if (!$articleResult) {
                    $_SESSION['searchArticleError'] = $searchArticleError;
                }
                elseif ($quantite < 0) {
                    $_SESSION['quantityError'] = $quantityError;
                    $_SESSION['stockError'] = null;
                }
                elseif($quantite > $stockArticle){
                    $_SESSION['stockError'] = $stockError;
                    $_SESSION['quantityError'] = null;
                }
            }

        }
        $this->renderView('ajoutDette', [
            'articles' => $_SESSION['articles'] ?? [],
            'searchArticleError' => $_SESSION['searchArticleError'] ?? null,
            'quantityError' => $_SESSION['quantityError'] ?? null,
            'stockError' => $_SESSION['stockError'] ?? null
            // 'articles' => $articles,
            // 'reference' => $reference,
            // 'libelle' => $libelle,
            // 'prix' => $prix,
            // 'quantite' => $quantite,
            // 'montant' => $montant
        ]);
        // 
        // else {
        //     $this->renderView('ajoutDette', [
        //         'searchArticleError' => $searchArticleError
        //     ]);
        // }

    }

    public function clearArticles()
    {
        // if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'clear_articles') {
        unset($_SESSION['articles']);
        unset($_SESSION['searchArticleError']);
        // }

        $this->renderView('ajoutDette', [
            'articles' => $_SESSION['articles'] ?? [],
            'searchArticleError' => $_SESSION['searchArticleError'] ?? null
        ]);
    }

    public function insertDette()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Calculer le montant total
            $montantTotal = 0;
            if (isset($_SESSION['articles']) && is_array($_SESSION['articles'])) {
                foreach ($_SESSION['articles'] as $article) {
                    $montantTotal += $article['quantite'] * $article['prix'];
                }
            }

            // Définir les autres champs:
            $montantVerse = 0;
            $montantRestant = $montantTotal;
            $client = $_SESSION['client'];
            $clientId = $client['id'] ?? null; // Assurez-vous que client_id est bien stocké dans la session

            if ($clientId !== null && $montantTotal > 0) {

                //---------------INSERTION DE LA DETTE DANS LA TABLE DETTES:
                $this->db->query("INSERT INTO Dette (montantTotal, montantVerse, montantRestant, client_id) VALUES (?, ?, ?, ?)", [$montantTotal, $montantVerse, $montantRestant, $clientId]);



                //-----------------------UPDATE TABLE DETTE CLIENT:  


                //------------------------UPDATE TABLE PRODUITS: 


                // Réinitialiser les articles dans la session
                unset($_SESSION['articles']);
                $insertSuccess = 'Dette enregitrée avec succès !';
                $this->renderView('ajoutDette', [
                    'insertSuccess' => $insertSuccess
                ]);
            } else {
                // Gérer l'erreur si clientId ou montantTotal est invalide
                $insertError = 'Erreur lors de l\'insertion de la dette. Veuillez vérifier les données.';
                $this->renderView('ajoutDette', [
                    'articles' => $_SESSION['articles'] ?? [],
                    'searchArticleError' => $_SESSION['searchArticleError'] ?? null,
                    'insertError' => $insertError
                ]);
            }
        }
    }


}

































// if($clientResult){
//     $client = $clientResult;
//     $clientId = $client['id'];

//     $detteStmt = $this->db->query("SELECT * FROM Dette WHERE client_id = ?", [$clientId]);
//     $detteResult = $detteStmt->fetch(\PDO::FETCH_ASSOC);

//     if($detteResult){
//         $dette = $detteResult;
//     } else{
//         $dette = ['total' => 0, 'motantVerse' => 0, 'montantRestant' => 0];
//     }
//     $this->renderView('boutiquier_dashboard', ['client' => $client, 'dette' => $dette]);
// }


// public function addClient() {
//     $validator = new Validator();

//     $rules = [
//         'nom_complet' => 'required',
//         'login' => 'required|unique:client,login',
//         'telephone' => 'required|unique:client,telephone',
//         'photo' => 'required|image'
//     ];

//     if ($validator->validateAddClient($_POST, $rules) && isset($_FILES['photo'])) {
//         $nom_Complet = $_POST['nom_complet'];
//         $login = $_POST['login'];
//         $telephone = $_POST['telephone'];
//         $photo = $_FILES['photo'];

//         // Handle photo upload
//         $photoPath = '/uploads/' . basename($photo['name']);
//         move_uploaded_file($photo['tmp_name'], __DIR__ . '/..' . $photoPath);

//         // Insert client into database
//         $this->db->query("INSERT INTO Client(nom_complet, login, telephone, photo) VALUES (?, ?, ?, ?)", [$nom_Complet, $login, $telephone, $photoPath]);

//         // Get the ID of the newly inserted client
//         $clientId = $this->db->lastInsertId(); 

//         // Insert into dette table
//         $date = (new DateTime())->format('Y-m-d');
//         $this->db->query("INSERT INTO dette (date, total, montantVerse, montantRestant, client_id) VALUES (?, 0, 0, 0, ?)", [$date, $clientId]);

//         // Redirect or show success message
//         $this->renderView('boutiquier_dashboard', ['success' => 'Client ajouté avec succès.']);
//     } else {
//         $this->renderView('boutiquier_dashboard', ['errors' => $validator->errors()]);
//     }
// }


/*
Maintenant nous allons ajouter une nouvelle fonctionnalité: Recherche de client par téléphone.
Dans la page boutiquier_dashboard j'ai un formulaire avec un champ de type texte sur lequel on
effectue la recherche de client par téléphone. Si le client est trouvé on affiche son nom dans une balise h2 
et en même temps on recupère les infos du client dans la table dette en utilisant sa clé étrangère dans cette table 
pour afficher la somme de ses dettes, le total versé et le montant restant. Si le client n'est pas trouvé on return une
erreur et on affiche client non trouvé.    
*/