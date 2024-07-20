// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $telephone = $_POST['phone'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
            // Pour POST, récupérer le téléphone à partir de l'entrée de l'utilisateur
            $telephone = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['phone'] : (isset($_GET['phone']) ? $_GET['phone'] : '');

            $searchError = 'Client non trouvé';

            // Recherche du client par téléphone
            $clientStmt = $this->db->query("SELECT * FROM Client2 WHERE telephone = ?", [$telephone]);
            $clientResult = $clientStmt->fetch(\PDO::FETCH_ASSOC);

if ($clientResult) {
                $client = $clientResult;
                $clientId = $client['id'];

                // VARIABLES POUR LE FILTRE PAR STATUS ET PAR DATE:
                $status = isset($_GET['status']) ? $_GET['status'] : null;
                $date = isset($_GET['date']) ? $_GET['date'] : null;

                // pagination:
                // $itemsPerPage = 1;
                // $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                // $offset = ($currentPage - 1) * $itemsPerPage;


                // VARIABLES POUR LE FILTRE PAR STATUS ET PAR DATE:
                $status = isset($_GET['status']) ? $_GET['status'] : null;
                $date = isset($_GET['date']) ? $_GET['date'] : null;

                // RECUPÉRATION DES DETTES DU CLIENT PAR SON ID:
                $detteStmt = $this->db->query("SELECT * FROM Dette WHERE client_id = ? AND montantRestant > 0", [$clientId]);
                $detteResult = $detteStmt->fetchAll(\PDO::FETCH_ASSOC);

                $params = [$clientId];

                if($status === 'solde'){
                    $detteStmt .= " AND montantRestant = 0";
                    var_dump($detteStmt);
                } elseif($status === 'nonSolde'){
                    $detteStmt .= " AND montantRestant > 0";
                    var_dump($detteStmt);
                }




                // RECUPÉRATION DES PAIEMENTS DU CLIENT PAR SON ID:
                $paiementStmt = $this->db->query("SELECT * FROM Paiement WHERE client_id = ?", [$clientId]);
                $paiementResult = $paiementStmt->fetchAll(\PDO::FETCH_ASSOC);
                // var_dump($paiementResult);



                // Récupération du nombre total de dettes pour la pagination
                $totalStmt = $this->db->query("SELECT COUNT(*) as total FROM Dette WHERE client_id = ?", [$clientId]);
                $totalResult = $totalStmt->fetch(\PDO::FETCH_ASSOC);
                $totalItems = $totalResult['total'];
                // $totalPages = ceil($totalItems / $itemsPerPage);

                $totalMontant = array_sum(array_column($detteResult, 'montantTotal'));
                $totalVerse = array_sum(array_column($detteResult, 'montantVerse'));
                $totalRestant = array_sum(array_column($detteResult, 'montantRestant'));



                if ($detteResult) {
                    $dette = $detteResult;
                    $totalMontant = 0;
                    foreach ($dette as $det) {
                        $totalMontant += $det['montantTotal'];

                    }
                } else {
                    $dette = ['total' => 0, 'motantVerse' => 0, 'montantRestant' => 0];
                    // $totalMontant = 0;
                }
                // $this->renderView('boutiquier_dashboard', ['paiements' => $paiementResult]);
                // $this->renderView('boutiquier_dashboard', ['client' => $client, 'dette' => $dette]);
                $this->renderView('boutiquier_dashboard', [
                    'client' => $client,
                    'dette' => $detteResult,
                    'totalMontant' => $totalMontant,
                    'totalVerse' => $totalVerse,
                    'totalRestant' => $totalRestant,
                    // 'currentPage' => $currentPage,
                    // 'totalPages' => $totalPages,
                    'phone' => $telephone, // Ajout du téléphone pour préserver l'état de la recherche
                    'paiements' => $paiementResult,
                ]);
            }