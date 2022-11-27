<?php

require_once("includes/connection.php");
include("index.php");
session_start();

if(isset($_POST["register"])){

    if(!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])){
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_hash = password_hash($password,PASSWORD_BCRYPT);

        $query = $connection->prepare("SELECT * FROM users WHERE EMAIL=:email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();

            if($query->rowCount() > 0) {
                echo '<p class="error">El email ya se encuentra registrado</p>';
            }

            if($query->rowCount() == 0) {
                $query = $connection->prepare("INSERT INTO users(USERNAME,PASSWORD,EMAIL) VALUES (:username,:password_hash,:email)");
                $query->bindParam("username", $username, PDO::PARAM_STR);
                $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
                $query->bindParam("email", $email, PDO::PARAM_STR);
                $result = $query->execute();

                if($result) {
                    $message = "Cuenta Correctamente Creada";
                }
                else {
                    $message = "Error al ingresar datos de informacion";
                }
            }
            else {
                $message = "El nombre del usuario ya existe! Por favor, intenta con otro";
            }
    }
    else {
        $message = "Todos los campos no deben de estar vacios!";
    }

}

?>

<?php if (!empty($message)) {echo "<p class=\"error\">" . "Mensaje: ". $message . "</p>";} ?>