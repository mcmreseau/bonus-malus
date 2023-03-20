<?php
session_start();
include_once("../repositories/identifiant.php");
include_once("../repositories/professeur.php");
include_once("../repositories/etudiant.php");
include_once("../repositories/groupe.php");
include_once("../repositories/seance.php");
include_once("../repositories/matiere.php");
include_once("../db/connect.php");

$bdd = connexion();

$error = "";

// Connexion à la base de données
$groupeRepo = new Groupe();
$matiereRepo = new Matiere();
$professeurRepo = new Professeur();


// Récupération des données des tables
$groupes = $groupeRepo->findAll();
$matieres = $matiereRepo->finfAll();
$professeurs = $professeurRepo->finfAll();

// Si le formulaire est soumis
if (isset($_POST['creer_seance'])) {
    // Récupération des valeurs du formulaire
    $nom_seance = htmlspecialchars($_POST['nom_seance']);
    $id_groupe = htmlspecialchars($_POST['id_groupe']);
    $id_matiere = htmlspecialchars($_POST['id_matiere']);
    $id_prof = htmlspecialchars($_POST['id_prof']);
    date_default_timezone_set('UTC');
    $date = date('Y-m-d h:i:s', time());

    // Insertion de la nouvelle séance dans la table "seance"
    $requete = $bdd->prepare('INSERT INTO Seance(nom_seance, date_seance, id_groupe, id_matiere, id_prof) VALUES(:nom_seance, :date_seance, :id_groupe, :id_matiere, :id_prof)');
    $requete->execute(array(
        'nom_seance' => $nom_seance,
        'id_groupe' => $id_groupe,
        'id_matiere' => $id_matiere,
        'id_prof' => $id_prof,
        'date_seance' => $date
    ));

    $reqRecupererId = $bdd->prepare('SELECT id_seance FROM Seance WHERE nom_seance = :nom_seance AND id_groupe = :id_groupe');
    $reqRecupererId->execute(array('nom_seance' => $nom_seance, 'id_groupe' => $id_groupe));
    $idNewSeance = $reqRecupererId->fetch()[0];

    $reqRecupererEtudiants = $bdd->prepare("SELECT id_etudiant FROM Etudiant WHERE id_groupe = :id_groupe");
    $reqRecupererEtudiants->execute(array('id_groupe' => $id_groupe));
    $etudiants = $reqRecupererEtudiants->fetchAll();

    $reqAddBonus = $bdd->prepare('INSERT INTO Bonus(note, id_etudiant, id_seance) VALUES(:note, :id_etudiant, :id_seance)');
    foreach ($etudiants as $id_etudiants) {
        $reqAddBonus->execute(array(
            'note' => 0,
            'id_etudiant' => $id_etudiants[0],
            'id_seance' => $idNewSeance
        ));
    }

    header("Location: dashboard_admin.php");
    // Affichage d'un message de confirmation
    echo "La séance a été créée avec succès !";
}

?>

<!-- Affichage du formulaire -->
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create account</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/tailwind.output.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="assets/js/init-alpine.js"></script>
    <script src="jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="assets/img/create-account-office.jpeg" alt="Office" />
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="assets/img/create-account-office-dark.jpeg" alt="Office" />
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200 text-center">
                            INSCRIVEZ-VOUS
                        </h1>

                        <form action="add_seance.php" method="POST">
                            <form method="post">
                                <label>Nom de la séance :</label>
                                <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                  focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                  form-input" type="text" name="nom_seance"><br>

                                <label>Groupe :</label>
                                <select class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                  focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                  form-select" name="id_groupe">
                                    <?php foreach ($groupes as $groupe) { ?>
                                        <option value="<?php echo $groupe['id_groupe']; ?>"><?php echo $groupe['nom_groupe']; ?></option>
                                    <?php }
                                    ?>
                                </select><br>

                                <label>Matière :</label>
                                <select class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                  focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                  form-select" name="id_matiere">
                                    <?php foreach ($matieres as $matiere) { ?>
                                        <option value="<?php echo $matiere['id_matiere']; ?>"><?php echo $matiere['intitule']; ?></option>
                                    <?php } ?>
                                </select><br>

                                <label>Professeur :</label>
                                <select class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                  focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                  form-select" name="id_prof">
                                    <?php foreach ($professeurs as $professeur) { ?>
                                        <option value="<?php echo $professeur['id_prof']; ?>"><?php echo $professeur['nom_prof'] . ' ' . $professeur['prenom_prof']; ?></option>
                                    <?php } ?>
                                </select><br>

                                <input class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" type="submit" name="creer_seance" value="Créer la séance">
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/datepicker.min.js"></script>

    <script>
        function desactiverChamp(id) {
            $("#" + id).toggle();
        }
    </script>

</body>

</html>

<?php  ?>