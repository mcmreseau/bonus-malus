<?php
  session_start();
  include('../repositories/identifiant.php');


    $error = "";

    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['role'])) {

      $email = htmlspecialchars($_POST['email']);
      $password = htmlspecialchars($_POST['password']);
      $role = htmlspecialchars($_POST['role']);

      //Vérification si l'utilisateur existe déjà

      $identifiant = new Identifiant();
      $check = $identifiant -> findByMail($email);

      $email = strtolower($email); //pour éviter de différencier les majuscules et les minuscules 

      if($check == false) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){

          //Insersion dans la base de données
          $tab = [];
          $tab[]=$email;
          $tab[]=$password;
          $tab[]=$role;

          $insert = new Identifiant();
          $newUser = $insert->addId($tab);
          
          //Redirection avec le message de succès
          header('Location:login.php?error=success');
        }else{
          header('Location:create-account.php?error=email');
        }
      }else{
        header('Location:create-account.php?error=already');
      }
    }
?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create account - Windmill Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="assets/css/tailwind.output.css" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="assets/js/init-alpine.js"></script>
  </head>
  <body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div
        class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              class="object-cover w-full h-full dark:hidden"
              src="assets/img/create-account-office.jpeg"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="assets/img/create-account-office-dark.jpeg"
              alt="Office"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h1
                class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200 text-center"
              >
                INSCRIVEZ-VOUS
              </h1>

              <?php
                if(isset($_GET['error'])){
                  $err = htmlspecialchars($_GET['error']);
                    switch($err){
                      case 'success':
              ?>
                <div class="alert alert-success">
                     <strong>Succès: </strong> inscription réussie !
                 </div
               <?php
                break;
                case 'email':
              ?>
                <div class = "alert alert-danger">
                  <strong>Erreur: </strong>Email non valide
                </div>
              <?php
                break;
                case 'already':
              ?>
                <div class = "alert alert-danger">
                  <strong>Erreur: </strong>Compte déjà existant
                </div>
              <?php
                    }
                  }
              ?>

          <form action = "create-account.php" method = "POST" >
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                  focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                  form-input"
                  name = "email"
                  type = "text"
                  placeholder="email@3il.fr"
                />
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Password</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="***************"
                  name = "password"
                  type="password"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Rôle</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                  focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                  form-input"
                  type = "text"
                  name = "role"
                  placeholder="Etudiant ou Professeur ?"
                />
              </label>

            <div class="dropdown">
               <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 Rôle
               </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <button class="dropdown-item" type="button">etudiant</button>
                         <button class="dropdown-item" type="button">professeur</button>
                    </div>
            </div>
 

              <!-- You should use a button here, as the anchor is only used for the example  -->
              <button
                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                type="submit"
              >
                Create account
              </button>
  </form>
              

              <p class="mt-4">
                <a
                  class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                  href="./login.php"
                >
                  Already have an account? Login
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
