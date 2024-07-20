<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
    <title>Document</title>

</head>

<body>

    <?php
    if (isset($_SESSION['client'])):
        $client = ($_SESSION['client']);
    endif;

    if (isset($_SESSION['totalMontant'])):
        $totalMontant = $_SESSION['totalMontant'];
    endif;

    if (isset($_SESSION['totalVerse'])):
        $totalVerse = $_SESSION['totalVerse'];
    endif;

    if (isset($_SESSION['totalRestant'])):
        $totalRestant = $_SESSION['totalRestant'];

    endif; ?>

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

    <!-- <h1> FORMULAIRE D'AJOUT PAIEMENT DETTE:</h1> -->

    <form method="POST" action="/addPayement" class="max-w-md mx-auto">
        <h1 style="text-align:center;font-size:2rem;">PAIEMENT DETTE:</h1> <br>

        <div style="display:flex;justify-content:space-around;background-color:whitesmoke;">
            <img src=<?= $client['photo'] ?> style="height:15vh; margin-bottom:10px;" />
            <h2 style="text-decoration:underline;font-size:1.2rem;font-weight:900">
                CLIENT: <?= $client['nom_complet'] ?>
            </h2>
            <h2 style="text-decoration:underline;font-size:1.2rem;font-weight:900">
                Tél: <?= $client['telephone'] ?>
            </h2>
            <!-- <img src="/uploads/icone7.png" alt="" style="height:15vh"> -->
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="totalMontant" id="totalMontant" style="font-size:1.5rem;"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder="TOTAL DETTE:       <?= $totalMontant ?> Fr" readonly>

        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="totalVerse" id="totalVerse" style="font-size:1.5rem;"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder="MONTANT VERSÉ:      <?= $totalVerse ?> Fr" readonly />
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="totalRestant" id="totalRestant" style="font-size:1.5rem;"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder="MONTANT RESTANT:      <?= $totalRestant ?> Fr" readonly />
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="montantPaye" id="montantPaye"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " />
                <label for="montantPaye"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">SAISIR
                    MONTANT À PAYER...</label>
            </div>

        </div>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>

</body>

</html>