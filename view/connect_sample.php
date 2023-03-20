<?php
//limoges pour les etudiants
//marrakech pour les profs
//bangkok admin
    session_start();
    $err = "";
    if(isset($_POST["connex"])){
        //echo password_hash("admin2",PASSWORD_DEFAULT);
        if(!empty($_POST["login"]) && !empty($_POST["password"])){
            $log = htmlspecialchars($_POST["login"]);
            $pass = htmlspecialchars($_POST["password"]);
            include_once("../repositories/identifiant.php");
            $ident = new Identifiant();
            $user = $ident->findByMail($log);
            
            if($user==null){
                $err = "mail introuvable";
            }
            else{
                // if(password_verify($pass,$user["mdp"])){
                if($user["mdp"] === $pass){
                    $user["mdp"] = "";
                    $_SESSION["role"] = $user["role_id"];
                    $_SESSION["user"] = $user;
                    $err="connexion réussie";
                    header("location:accueil.php");
                }
                else{
                    $err = "Mot de passe incorrect";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/connect.css">
</head>

<body>
    <div class="container"> 
        <div class="row"> 
            <div class="col-md-6"> 
                <div class="card"> 
                    <form class="box" method="POST" action="connect_sample.php"> <h1>Login</h1> 
                    <p class="text-muted"> <?= $err ?> </p>
                     <input type="text" name="login" placeholder="Username"> 
                     <input type="password" name="password" placeholder="Password"> 
               <a class="forgot text-muted" href="#">Forgot password?</a>
                      <input type="submit" name="connex" value="Login" href="#"> 
                      <div class="col-md-12"> <ul class="social-network social-circle"> 
                          <li><a href="#" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                           <li><a href="#" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li> 
            <li><a href="#" class="icoGoogle" title="Google +"><i class="fab fa-google-plus"></i></a></li>
                            </ul>
        </div> </form> </div> </div> </div>
    </div>
</body>

</html>