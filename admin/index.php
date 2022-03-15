<?php 
require './funciones.php';

$autenticado = estaLogueado();

if(!$autenticado){
    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../build/css/styles.css" rel="stylesheet">
    <title>Portal administrador</title>
</head>
<body class=" bg-indigo-100">
    <?php require './header.php'; ?>
    

    <div class=" flex justify-center flex-col bg-gray-100 shadow-md rounded-t-sm py-2 mx-4 mt-4">
        <h2 class=" text-2xl flex justify-center font-bold capitalize">GRUPOS</h2>

        <div id="botonesGrupos" class="flex flex-col sm:flex-row sm:justify-center">
            <a href="./crear-grupo.php" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2"> Crear grupo</a>
            <a href="./editar-grupo.php" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2"> Editar grupo</a>

        </div>
    </div>

    <div class=" flex justify-center flex-col bg-gray-100 shadow-md py-2 mx-4">
        <h2 class=" text-2xl flex justify-center font-bold capitalize">ALUMNOS</h2>

        <div id="botonesGrupos" class="flex flex-col sm:flex-row sm:justify-center">
            <a href="./crear-alumno.php" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2"> Registrar alumno</a>
            <a href="./listar-alumnos.php" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2"> Editar alumno</a>

        </div>
    </div>

    <div class=" flex justify-center flex-col bg-gray-100 shadow-xl rounded-b-3xl py-2 mx-4">
        <h2 class=" text-2xl flex justify-center font-bold capitalize">CALIFICACIONES</h2>

        <div id="botonesGrupos" class="flex flex-col sm:flex-row sm:justify-center">
            <a href="./registrar-calificaciones.php" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2"> Registrar calificaciones</a>
            <a href="./editar-calificaciones.php" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2"> Editar calificaciones</a>

        </div>
    </div>

    <script src="../build/js/app.js"></script>
</body>
</html>