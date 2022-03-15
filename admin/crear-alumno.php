<?php 
// Importar la conexión
require '../config/database.php';
$db = conectarDB();

require './funciones.php';

$autenticado = estaLogueado();

if(!$autenticado){
    header('Location: ../index.php');
}

$query = "SELECT * FROM grupos";
$resultadoGrupos = mysqli_query($db, $query);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['nombre'];
    $apPaterno = $_POST['ap_paterno'];
    $apMaterno = $_POST['ap_materno'];
    $matricula = $_POST['matricula'];
    $idGrupo = $_POST['id_grupo'];

    $queryInsertar = "INSERT INTO alumnos (nombre, ap_paterno, ap_materno, matricula, id_grupo) VALUES ('{$nombre}', '{$apPaterno}', '{$apMaterno}', '{$matricula}', '{$idGrupo}')";

    mysqli_query($db, $queryInsertar);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../build/css/styles.css" rel="stylesheet">
    <title>Dar de alta un alumno</title>
</head>
<body>
<?php require './header.php'; ?>


<div class="flex justify-center xl:px-60">


    <form class="bg-white shadow-md rounded-lg pt-10 pb-2 px-5 mb-10 container md:mx-auto md:w-50" method="POST">
    <div class="md:grid">

            <label for="nombre" class=" block text-gray-700 uppercase font-bold">Nombres: </label>
            <input type="text" name="nombre" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">

            <div class="md:flex py-3">
                <div class=" md:w-1/2 px-1">
                    <label for="ap_paterno" class=" block text-gray-700 uppercase font-bold">Apellido paterno: </label>
                    <input type="text" name="ap_paterno" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
                </div>
                <div class=" md:w-1/2 px-1">
                    <label for="ap_materno" class=" block text-gray-700 uppercase font-bold">Apellido materno: </label>
                    <input type="text" name="ap_materno" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
                </div>
            </div>

            <div class="md:flex py-3">
                <div class=" md:w-1/2 px-1">
                    <label for="matricula" class=" block text-gray-700 uppercase font-bold">Matrícula: </label>
                    <input type="text" name="matricula" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
                </div>
                <div class=" md:w-1/2 px-1">
                    <label for="grupo" class=" block text-gray-700 uppercase font-bold">Grupo: </label>
                    <select name="id_grupo" id="" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
                        <option value="#" >--Seleccione--</option>
                        <?php
                            while($datos = mysqli_fetch_assoc($resultadoGrupos)){
                                echo "<option value={$datos['id']}>{$datos['nombre_grupo']}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            
        
    </div>

        
        <div class="flex justify-end py-3">
            <input type="submit" class=" md:w1/2 bg-indigo-600  p-3 text-white uppercase font-bold hover:bg-indigo-700 cursor-pointer transition-all rounded-lg" value="Guardar Datos">
        </div>
    </form>
</div>

    <script src="../build/js/app.js"></script>
</body>
</html>
