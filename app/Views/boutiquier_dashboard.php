<?php
// $fileErrors = [];
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
//         // Le fichier a été téléchargé avec succès
//         $fileTmpPath = $_FILES['photo']['tmp_name'];
//         $fileName = $_FILES['photo']['name'];
//         $fileSize = $_FILES['photo']['size'];
//         $fileType = $_FILES['photo']['type'];
//         // Traitez le fichier ici selon vos besoins
//     } else {
//         $fileErrors['photo'] = "Veuillez sélectionner un fichier.";
//     }
// }
function dateFormater($date)
{
    $date = new DateTime($date);
    $formatedDate = date_format($date, 'd/m/Y');
    return $formatedDate;
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutiquier dashboard</title>
    <link rel="stylesheet" href="/styles.css">

</head>

<body>
    <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white" style="margin-left:250px;">NOUVEAU CLIENT</h3>



    <ul class="grid w-full gap-6 md:grid-cols-2">

        <li>

            <!-- <div> -->
            <!-- <ul> -->
            <!-- <php foreach ($errors as $error): ?> -->
            <!-- <li><= $error ?></li> -->

            <!-- <php endforeach; ?> -->
            <!-- </ul> -->
            <!-- </div> -->




            <form method="POST" action="add_client" enctype="multipart/form-data" class="max-w-sm mx-auto">

                <!-- <input type="hidden" name="add_client" value="1"> -->
                <div class="mb-5">
                    <label for="nom_complet" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NOM
                        Complet</label>
                    <input type="text" name="nom_complet" id="nom_complet"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        placeholder="Nom Complet"
                        value="<?php echo isset($_POST['nom_complet']) && !isset($errors['nom_complet']) ? htmlspecialchars($_POST['nom_complet'], ENT_QUOTES, 'UTF-8') : ''; ?>" />


                    <?php if (isset($errors['nom_complet'])): ?>
                        <p style="color:tomato;font-weight:900"><?= $errors['nom_complet'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- <div class="mb-5">
                    <label for="prenomClient"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                    <input type="text" name="prenomClient" id="prenomClient"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" />
                </div> -->

                <div class="mb-5">
                    <label for="login"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Login</label>
                    <input type="text" name="login" id="login" placeholder="Login"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        value="<?php echo isset($_POST['login']) && !isset($errors['login']) ? htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8') : ''; ?>" />


                    <?php if (isset($errors['login'])): ?>
                        <p style="color:tomato;font-weight:900"><?= $errors['login'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-5">
                    <label for="telephone"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" placeholder="Téléphone"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        value="<?php echo isset($_POST['telephone']) && !isset($errors['telephone']) ? htmlspecialchars($_POST['telephone'], ENT_QUOTES, 'UTF-8') : ''; ?>" />


                    <?php if (isset($errors['telephone'])): ?>
                        <p style="color:tomato;font-weight:900"><?= $errors['telephone'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- <div class="mb-5">
                    <label for="photo"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Photo</label>
                    <input type="text" name="photo" id="photo"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" />
                </div> -->
                <div class="mb-5">
                    <label for="photo"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Photo</label>
                    <input type="file" name="photo" id="photo"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" />
                    <?php if (isset($fileErrors['photo'])): ?>
                        <p style="color:tomato;font-weight:900"><?= $fileErrors['photo'] ?></p>
                    <?php endif; ?>
                    <!-- value="<php echo isset($_POST['photo']) && !isset($errors['photo']) ? htmlspecialchars($_POST['photo'], ENT_QUOTES, 'UTF-8') : ''; ?>" -->



                    <!-- <php if (isset($errors['photo'])): ?> -->
                    <!-- <p style="color:tomato;font-weight:900"><= $errors['photo'] ?></p> -->

                    <!-- <php endif; ?> -->
                </div>

                <div class="flex items-start mb-5">

                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Ajouter</button>

            </form>



        </li>

        <li>

            <div
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Suivi Dettes Client
                </h5>
                <!-- SEARCH BY PHONE 1 -->
                <form method="POST" action="/search_client" class="max-w-md mx-auto">
                    <label for="phone" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">OK</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>

                        <input type="search" id="phone" name="phone"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Saisir téléphone client" />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                    </div>
                    <?php if (isset($searchError)): ?>
                        <p style="color:tomato;font-weight:900"><?= $searchError ?></p>

                    <?php endif; ?>


                </form>
                <!-- SEARCH BY PHONE 2 -->


                <?php if (isset($dette)): ?>

                    <div class="grid w-full gap-6 md:grid-cols-2" style="margin-top:20px;">

                        <button
                            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                            onclick="my_modal_1.showModal()">Liste Dettes</button>

                        <form method="GET" action="/ajoutDette">
                            <button type="submit"
                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Ajouter
                                Dette
                            </button>
                        </form>

                    </div>

                    <div style="display:flex;">
                        <img src=<?= $client['photo'] ?> style="height:15vh;" />
                        <h2 style="text-decoration:underline;font-size:1.2rem;color:tomato;font-weight:900">
                            CLIENT: <?= $client['nom_complet'] ?>
                        </h2>
                        <h2 style="text-decoration:underline;font-size:1.2rem;color:tomato;font-weight:900">
                            Tél: <?= $client['telephone'] ?>
                        </h2>
                        <!-- <img src="/uploads/icone7.png" alt="" style="height:15vh"> -->
                    </div>
                    <br>

                    <div class="grid gap-6 mb-6 md:grid-cols-2" style="margin-top:20px;">

                        <div>

                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">TOTAL DETTES</label>
                            <input type="text" id="first_name" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                readonly value=<?= $totalMontant ?> readonly />
                        </div>


                        <div>
                            <label for="montantVerse"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MONTANT VERSÉ</label>
                            <input type="text" id="first_name" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value=<?= $totalVerse ?> readonly />
                        </div>
                        <div>
                            <label for="montantRestant"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MONTANT RESTANT</label>
                            <input type="text" id="first_name" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                id="montantRestant" name="montantRestant" value=<?= $totalRestant ?> />
                        </div>
                        <br>
                        <div>
                            <button type="button"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 cleanForms">Annuler</button>
                        </div>

                    </div>
                <?php endif ?>


        </li>


    </ul>

    <!-- LISTE DETTE START -->
    <dialog id="my_modal_1" class="modal">
        <div class="modal-box" style="background-color:white; width:180vw; font-weight:900;">
            <h3 class="text-lg font-bold">LISTE DETTE CLIENT</h3> <br>
            <?php if ($client): ?>
                <h1 style="color:tomato;font-weight:900">TÉLÉPHONE: <strong><?= $client['nom_complet'] ?></strong></h1> <br>
                <h1 style="color:tomato;font-weight:900">NOM CLIENT: <strong><?= $client['telephone'] ?></strong></h1> <br>
            <?php endif ?>

            <!-- <form method="GET" action="/Gestion-Boutique2/public/search_client">
                <input type="hidden" name="phone" value="<?= htmlspecialchars($client['telephone']) ?>">

                <h1 style="text-align:center;color:tomato;font-weight:900;font-size:1.3rem;">Filtrer par</h1> <br>

                <div style="display:flex; justify-content:space-around;">

                    <div>
                        <label for="status">Status</label>
                        <select name="filter" id="filter" onchange="this.form.submit()">
                            <option value="all" <?= !isset($filter) || $filter === 'all' ? 'selected' : '' ?>>Toutes
                            </option>
                            <option value="solded" <?= isset($filter) && $filter === 'solded' ? 'selected' : '' ?>>Soldées
                            </option>
                            <option value="notsolded" <?= isset($filter) && $filter === 'notsolded' ? 'selected' : '' ?>>
                                Non soldées</option>
                        </select> -->
            <!-- <input type="text" name="status" style="width:10vw;" id="status"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                            placeholder="Soldée/Restant"> -->
            <!-- </div>

                    <div>
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" style="width:10vw;"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                            placeholder="Entrer Date">
                    </div>
                </div>
                <button type="button" id="filterButton"
                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Valider</button>
            </form> -->
            <br>
            <!--  -->
            <!-- <script>
                document.getElementById('filterButton').addEventListener('click', function () {
                    var status = document.getElementById('status').value;
                    var date = document.getElementById('date').value;
                    // var clientId = $clientId /* votre logique pour obtenir l'ID du client */;
                    var clientId = 1;
                    console.log(status);
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', '/?status=' + status + '&date=' + date + '&clientId=' + clientId, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // document.getElementById('results').innerHTML = xhr.responseText;
                        } 
                    };
                    xhr.send();
                });
            </script> -->

            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead">
                        <tr>
                            <th>Date</th>
                            <!-- <th></th> -->
                            <th>TOTAL</th>
                            <th>Acompte</th>
                            <th>Restant</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php if (isset($dette) && is_array($dette) && !empty($dette)): ?>
                                <button type="button" class="btn btn-primary" style=""
                                    onclick="my_modal_3.showModal()">Paiements</button>
                                <?php foreach ($dette as $det): ?>
                                    <tr class="bg-base-600">
                                        <td><?= dateFormater($det['dateCreation']) ?></td>
                                        <td><?= $det['montantTotal'] ?></td>
                                        <td><?= $det['montantVerse'] ?></td>
                                        <td><?= $det['montantRestant'] ?></td>
                                        <td>
                                            <!-- <button type="button" class="btn btn-primary" style="width:4vw;"
                                                onclick="my_modal_3.showModal()">Paie</button> -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">Aucune dette trouvée pour ce client.</td>
                                </tr>
                            <?php endif; ?>
                            <!--  -->
                        </tbody>
                </table>
                <!-- PAGINATION START -->
                <!-- Pagination controls -->
                <!-- <php if (isset($totalPages) && $totalPages > 1): ?> -->
                <!-- <nav> -->
                <!-- <ul class="pagination"> -->
                <!-- <php if ($currentPage > 1): ?> -->
                <!-- <li class="page-item"><a class="page-link" -->
                <!-- href="?phone=<= $phone ?>&page=<= $currentPage - 1 ?>"> -->
                <!-- Précédent</a></li> -->
                <!-- <php endif; ?> -->

                <!-- <php for ($i = 1; $i <= $totalPages; $i++): ?> -->
                <!-- <li class="page-item <= $i == $currentPage ? 'active' : '' ?>"><a class="page-link" -->
                <!-- href="?phone=<= $phone ?>&page=<= $i ?>"><= $i ?></a></li> -->
                <!-- <php endfor; ?> -->

                <!-- <php if ($currentPage < $totalPages): ?> -->
                <!-- <li class="page-item"><a class="page-link" -->
                <!-- href="?phone=<= $phone ?>&page=<= $currentPage + 1 ?>">Suivant</a></li> -->
                <!-- <php endif; ?> -->
                <!-- </ul> -->
                <!-- </nav> -->
                <!-- <php endif; ?> -->
                <!-- PAGINATION END  -->
            </div>
            <!--  -->

            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Fermer</button>
                </form>
            </div>
        </div>
    </dialog>


    <!-- AJOUTER DETTE START-->
    <dialog id="my_modal_2" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Ajouter Dette</h3>

            <h3>Client: <?= $client['nom_complet'] ?></h3>
            <h3>Téléphone: <?= $client['telephone'] ?></h3>
            <br>

            <form action="" method="POST">

                <div class="grid w-full gap-6 md:grid-cols-2">
                    <div>

                        <label for="product">Libellé Produit:</label>
                        <input type="search" id="product" name="product"
                            class="form-control block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Saisir libellé produit" style="width:15vw" />
                    </div>

                    <div>

                        <label for="quantity">Qté:</label>
                        <input type="number" id="quantity"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Quantité" style="width:15vw">
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="add_dette">Ajouter</button>

            </form>
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Article</th>
                        <!-- <th></th> -->
                        <th>Prix</th>
                        <th>Qté</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <td>Pain</td>
                    <td>150</td>
                    <td>2</td>
                    <td>300</td>
                </tbody>
            </table>


        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <!-- AJOUTER DETTE END -->

    <!-- LISTE PAIEMENT START -->

    <dialog id="my_modal_3" class="modal">
        <div class="modal-box">

            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Date paiement</th>
                        <!-- <th></th> -->
                        <th>Montant</th>

                    </tr>
                </thead>
                <tbody style="font-weight:900;">
                    <!-- <form method="" action="">
                        <label for="montantPaye">Ajouter paiement</label>
                        <input type="text" id="montantPaye" name="montantPaye" placeholder="Montant paiement">
                        <button>Payer</button>
                    </form> -->
                    <?php if (isset($paiements) && is_array($paiements) && !empty($paiements)): ?>
                        <div class="head" style="background-color:gray;display:flex;justify-content:space-around;">

                            <div class="headLeft">
                                <img src=<?= $client['photo'] ?> style="height:15vh;" />
                                <p style="font-size:1.3rem;font-weight:900;">Client: <?= $client['nom_complet'] ?></p>
                            </div>
                            <form method="GET" action="/paiementForm">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </form>
                            <div>

                            </div>
                        </div>
                        <?php foreach ($paiements as $pay): ?>
                            <tr class="bg-base-200">
                                <td><?= $pay['datePaiement'] ?></td>
                                <td><?= $pay['montant'] ?></td>
                                <td>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Aucun paiement effectué</td>
                        </tr>
                    <?php endif; ?>
            </table>
        </div>
    </dialog>
    <!-- LISTE PAIEMENT END -->

    <!--  -->
    <!-- <php foreach ($paiements as $paiement): ?> -->
    <!-- <tr> -->
    <!-- <td><php echo htmlspecialchars($paiement['datePaiement']); ?></td> -->

    <!-- </tr> -->
    <!-- <php endforeach; ?> -->

</body>

</html>