<?php

require_once("includes/connection.php");
include("includes/header.php");
session_start();

if (isset($_POST["login"])) {

    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $secretkey = "6LeFlDkgAAAAAEVv0Q-tUBA1Q1Q3Ub_ckX4jNZG5";

    $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=
    $secretkey&response=$captcha&remoteip=$ip");
    $atributos = json_decode($respuesta, TRUE);

    if (!$atributos['success']) {
        echo '<p><color="white">Verificar el capchat</color></p>';
    }

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $connection->prepare("SELECT * FROM users WHERE USERNAME=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo '<p> La combinacion del usuario y la contraseña son invalidos!</p>';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['session_username'] = $username;

                header("location: intropage.php");
            } else {
                $message = "Nombre de usuario o contraseña invalido!";
            }
        }
    } else {
        $message = "Todos los campos son requeridos!";
    }
}
