<?php
require '../config/database.php';
$db = conectarDB();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $nombreDocente = $_POST['nombreDocente'];
    $query = "INSERT INTO docentes (nombreDocente) VALUES ('{$nombreDocente}')";

    echo $query;
    mysqli_query($db, $query);
    
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../build/css/styles.css" rel="stylesheet">
    <title>Registrar Docentes</title>
</head>
<body>
    <form class=" container" id="formularioDocentes" method="POST">

    <label for="nombreDocente">Nombre del docente: </label>
    <input type="text" name="nombreDocente">

    <input type="submit" value="Registrar Docente">


    </form>

    <script src="../build/js/app.js"></script>
</body>
</html>