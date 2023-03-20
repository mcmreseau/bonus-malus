<?php
session_start();
if (empty($_SESSION["user"])) {
    header("location:connect_sample.php");
}

if (!isset($_GET["page"]) || !in_array($_GET['page'], ['groupe', 'etudiant', 'professeur', 'seance'])) {
    header("location:dashboard_admin.php?page=groupe");
}

include_once("../repositories/identifiant.php");
include_once("../repositories/professeur.php");
include_once("../repositories/etudiant.php");
include_once("../repositories/groupe.php");
include_once("../repositories/seance.php");
$identifiantRepo = new Identifiant();
$admin = $identifiantRepo->findByMail($_SESSION["user"]["mail"]);

$groupeRepo = new Groupe();
$etudiantRepo = new Etudiant();
$professeurRepo = new Professeur();
$seanceRepo = new SeanceRepo();

?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page accueil prof</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/tailwind.output.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
</head>

<body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->
        <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
            <div class="py-4 text-gray-500 dark:text-gray-400">
                <ul class="mt-6">
                    <li class="relative px-6 py-3">
                        <?php
                        if ($_GET['page'] === 'groupe') {
                        ?>
                            <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        <?php
                        }
                        ?>
                        <a href="dashboard_admin.php?page=groupe" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
                            <span class="ml-4">Groupes</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-3">
                        <?php
                        if ($_GET['page'] === 'etudiant') {
                        ?>
                            <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        <?php
                        }
                        ?>
                        <a href="dashboard_admin.php?page=etudiant" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
                            <span class="ml-4">Etudiants</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-3">
                        <?php
                        if ($_GET['page'] === 'professeur') {
                        ?>
                            <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        <?php
                        }
                        ?>
                        <a href="dashboard_admin.php?page=professeur" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
                            <span class="ml-4">Professeurs</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-3">
                        <?php
                        if ($_GET['page'] === 'seance') {
                        ?>
                            <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        <?php
                        }
                        ?>
                        <a href="dashboard_admin.php?page=seance" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
                            <span class="ml-4">Séances</span>
                        </a>
                    </li>
                </ul>
                <ul>
                </ul>
            </div>
        </aside>

        <!-- Backdrop -->
        <!--
    <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
    -->
        <div class="flex flex-col flex-1 w-full">
            <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
                <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
                    <button><a href="add_<?= $_GET['page'] ?>.php">Ajouter <?= $_GET["page"] ?></a></button>
                    <button><a href="create-account.php">Ajouter un compte</a></button>
                    <ul class="flex items-center flex-shrink-0 space-x-6">
                        <!-- Theme toggler -->
                        <li class="flex">
                            <button class="rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleTheme" aria-label="Toggle color mode">
                                <template x-if="!dark">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                    </svg>
                                </template>
                                <template x-if="dark">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                    </svg>
                                </template>
                            </button>
                        </li>
                        <!-- Notifications menu -->

                        <!-- Profile menu -->
                        <li class="relative">
                            <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none" @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account" aria-haspopup="true">
                                <img class="object-cover w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=aa3a807e1bbdfd4364d1f449eaa96d82" alt="" aria-hidden="true" />
                            </button>
                            <template x-if="isProfileMenuOpen">
                                <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeProfileMenu" @keydown.escape="closeProfileMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700" aria-label="submenu">
                                    <li class="flex">

                                        <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span><?= $_SESSION["user"]["mail"] ?></span>

                                    </li>

                                    <li class="flex">
                                        <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="log_out.php">
                                            <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                            <span>Log out</span>
                                        </a>
                                    </li>
                                </ul>
                            </template>
                        </li>
                    </ul>
                </div>
            </header>
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        <?= strtoupper($_GET['page']) ?>
                    </h2>

                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-no-wrap">
                                <!-- Remplissage du tableau affichant la liste des étudiants -->
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                                        <!-- New Table -->
                                        <?php
                                        switch ($_GET["page"]) {
                                            case 'groupe':
                                        ?>
                                                <th class="px-4 py-3">Id</th>
                                                <th class="px-4 py-3">Nom du groupe</th>
                                            <?php
                                                break;
                                            case 'etudiant':
                                            ?>
                                                <th class="px-4 py-3">Id</th>
                                                <th class="px-4 py-3">Nom de l'étudiant</th>
                                                <th class="px-4 py-3">Mail</th>
                                                <th class="px-4 py-3">Nom du groupe</th>
                                            <?php
                                                break;
                                            case 'professeur':
                                            ?>
                                                <th class="px-4 py-3">Id</th>
                                                <th class="px-4 py-3">Nom du professeur</th>
                                                <th class="px-4 py-3">Prénom du professeur</th>
                                                <th class="px-4 py-3">Mail</th>
                                            <?php
                                                break;
                                            case 'seance':
                                            ?>
                                                <th class="px-4 py-3">Id</th>
                                                <th class="px-4 py-3">Nom de la séance</th>
                                                <th class="px-4 py-3">Date de la séance</th>
                                                <th class="px-4 py-3">Groupe</th>
                                                <th class="px-4 py-3">Matiere</th>
                                                <th class="px-4 py-3">Prof</th>
                                        <?php
                                                break;

                                            default:
                                                break;
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody id="cc" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    <?php
                                    switch ($_GET["page"]) {
                                        case 'groupe':
                                            $groupes = $groupeRepo->findAll();
                                            foreach ($groupes as $groupe) {
                                    ?>
                                                <tr>
                                                    <td><?= $groupe["id_groupe"] ?></td>
                                                    <td><?= $groupe["nom_groupe"] ?></td>
                                                </tr>
                                            <?php
                                            }
                                            break;
                                        case 'etudiant':
                                            $etudiants = $etudiantRepo->findAll();
                                            foreach ($etudiants as $etudiant) {
                                            ?>
                                                <tr>
                                                    <td><?= $etudiant["id_etudiant"] ?></td>
                                                    <td><?= $etudiant["nom_etudiant"] ?></td>
                                                    <td><?= $etudiant["mail"] ?></td>
                                                    <td><?= $etudiant["nom_groupe"] ?></td>
                                                </tr>
                                            <?php
                                            }
                                            break;
                                        case 'professeur':
                                            $professeurs = $professeurRepo->finfAll();
                                            foreach ($professeurs as $professeur) {
                                            ?>
                                                <tr>
                                                    <td><?= $professeur["id_prof"] ?></td>
                                                    <td><?= $professeur["nom_prof"] ?></td>
                                                    <td><?= $professeur["prenom_prof"] ?></td>
                                                    <td><?= $professeur["mail"] ?></td>
                                                </tr>
                                            <?php
                                            }
                                            break;
                                        case 'seance':
                                            $seances = $seanceRepo->findAll();
                                            foreach ($seances as $seance) {
                                            ?>
                                                <tr>
                                                    <td><?= $seance["id_seance"] ?></td>
                                                    <td><?= $seance["nom_seance"] ?></td>
                                                    <td><?= $seance["date_seance"] ?></td>
                                                    <td><?= $seance["nom_groupe"] ?></td>
                                                    <td><?= $seance["intitule"] ?></td>
                                                    <td><?= $seance["nom_prof"] ?></td>
                                                </tr>
                                    <?php
                                            }
                                            break;

                                        default:
                                            break;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
<script src="assets/js/init-alpine.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="./assets/js/charts-lines.js"></script>
<script src="./assets/js/charts-pie.js"></script>
<script src="../view/assets/jquery/jqueryy.js"></script>


</html>