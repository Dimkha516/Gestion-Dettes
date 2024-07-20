<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
    <title>Document</title>
</head>

<body>
    <!-- NAVBAR START  -->
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">

                    <form method="GET" action="/boutiquier_dashboard">

                        <li>
                            <button type="submit" class="btn btn-primary">Accueil</button>
                            <!-- <a href="#"
                                class="block py-2 px-3 text-black bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-black-500"
                                aria-current="page">Home</a> -->
                        </li>
                    </form>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">About</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Services</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- NAVBAR END  -->




    <!-- ADD DETTE START -->

    <ul class="grid w-full gap-6 md:grid-cols-2" style="margin-top:20px;">
        <li>
            <form action="/search_article" method="POST">

                <div class="grid w-full gap-6" style="margin-left:30px;">
                    <div>

                        <label for="product">Réf. Produit:</label>
                        <input type="search" id="reference" name="reference"
                            class="form-control block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Saisir ref prod" style="width:15vw" />
                    </div>
                    <?php if (isset($searchArticleError)): ?>
                        <p style="color: red; font-size:1.2rem;font-weight:900;"><?= $searchArticleError ?></p>
                    <?php endif; ?>

                    <div>

                        <label for="quantite">Qté:</label>
                        <input type="number" id="quantite" name="quantite"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Quantité" style="width:15vw">
                        <?php if (isset($quantityError)): ?>
                            <p style="color: red; font-size:1.2rem;font-weight:900;"><?= $quantityError ?></p>
                        <?php endif; ?>

                        <?php if (isset($stockError)): ?>
                            <p style="color: red; font-size:1.2rem;font-weight:900;"><?= $stockError ?></p>
                        <?php endif; ?>
                    </div>
                    <br>

                </div>
                <button type="submit" style="margin-left:70px;"
                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 cleanForms">+Ajouter</button>
            </form>
        </li>

        <li style="border:solid 2px white;">
            <form action="/addDette" method="POST">


                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr style="font-size:2rem;">
                            <th>Article</th>
                            <!-- <th></th> -->
                            <th>Prix</th>
                            <th>Qté</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($articles) && is_array($articles)): ?>
                            <?php foreach ($articles as $index => $article): ?>
                                <tr>
                                    <td style="font-size:1.2rem;font-weight:900;"><?= htmlspecialchars($article['libelle']) ?>
                                    </td>
                                    <td style="font-size:1.2rem;font-weight:900;"><?= htmlspecialchars($article['prix']) ?></td>
                                    <td style="font-size:1.2rem;font-weight:900;"><?= htmlspecialchars($article['quantite']) ?>
                                    </td>
                                    <td style="font-size:1.2rem;font-weight:900;"><?= htmlspecialchars($article['montant']) ?>
                                    </td>
                                    <td>


                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="color:tomato;font-size:1.2rem;text-align:center;">AUCUN PRODUIT
                                    CHOISI</td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>

                <?php if (isset($insertSuccess)): ?>
                    <p style="font-size:1.5rem;color:green;font-weight:900;text-align:center;"><?= $insertSuccess ?></p>
                <?php endif; ?>

                <?php if (isset($insertError)): ?>
                    <p style="font-size:1.2rem;color:tomato;font-weight;"><?= $insertError ?></p>
                <?php endif; ?>

                <?php if (!empty($articles)): ?>
                    <div class="grid w-full gap-6 md:grid-cols-2" style="margin-top:20px;">
                        <!--  -->

                        <!-- <form action="/clearArticle" method="POST">
                                <button type="submit" style="width:8vw;"
                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
                                font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Annuler</button>
                            </form> -->

                        <!--  -->
                        <button type="submit" style="width:8vw;"
                            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
                        font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Enregistrer
                        </button>


                    </div>

                <?php endif; ?>

            </form>

            <?php if (!empty($articles)): ?>
                <form action="/clearArticle" method="POST">
                    <button type="submit" style="width:8vw;"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
                font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Annuler</button>
                </form>
            <?php endif; ?>

        </li>
    </ul>


    <!-- ADD DETTE END -->




</body>

</html>