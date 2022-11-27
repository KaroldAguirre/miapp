<?php

session_start();
if(!isset($_SESSION["session_username"])) {
    header("location:index.php");
}
else {
    include("includes/header.php"); ?>
    <div id="BIenvenidos">
        <h2 class="h2">Bienvenido , <span> <?php echo $_SESSION['session_username'];?>! </span></h2>
        <p class="p"><a href="logout.php">Finalice</a> sesion aqui!</p>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php
}

?>