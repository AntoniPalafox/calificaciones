<?php 
// Importar la conexión
require '../config/database.php';
$db = conectarDB();

require './funciones.php';

$autenticado = estaLogueado();

if(!$autenticado){
    header('Location: ../index.php');
}

$materias = [];
$docente = [];


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombreGrupo = $_POST['nombre_grupo'];
    $docente[] = $_POST['docente'];
    $materias[] = $_POST['nombre_materia'];

    $queryGrupo = "INSERT INTO grupos (nombre_grupo) VALUES ('{$nombreGrupo}')";
    mysqli_query($db, $queryGrupo);

    $queryNombreGrupo = "SELECT * FROM grupos WHERE nombre_grupo = '{$nombreGrupo}'";
    $resultadoGrupo = mysqli_query($db, $queryNombreGrupo);
    $datos = mysqli_fetch_assoc($resultadoGrupo);
    $idGrupo = $datos['id'];

    for ($i=0; $i < count( $_POST['nombre_materia']); $i++) { 
        $nombreMateria = $_POST['nombre_materia'][$i];
        $nombreDocente = $_POST['docente'][$i];

        $query = "INSERT INTO materias (nombre_materia, docente, id_grupo) VALUES ('{$nombreMateria}', '{$nombreDocente}', '{$idGrupo}');";
        mysqli_query($db, $query);
    }
    foreach($materias as $mat){
        $valor = implode("",$mat);
        /* echo "AA ";
        echo $valor;
        echo "AA "; */
        
    }

    header('Location: ./index.php');
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../build/css/styles.css" rel="stylesheet">
    <title>Crear Grupo</title>
</head>
<body>
<?php require './header.php'; ?>



<div class=" flex justify-center xl:px-60">
    <form class="bg-white shadow-md rounded-lg pt-10 pb-2 px-5 mb-10 container md:mx-auto"  method="POST">

    <div class="md:grid md:justify-items-center">
        <div class="md:w-1/2">
            <label for="nombre_grupo" class=" block text-gray-700 uppercase font-bold">Nombre del grupo: </label>
            <input type="text" name="nombre_grupo" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
        </div>
        
    </div>

    <div id="formularioGrupo" class=" w-full">
        <div class="md:flex py-3">
            <div class=" md:w-1/2 px-1">
                <label for="nombre_materia" class=" block text-gray-700 uppercase font-bold">Nombre Materia: </label>
                <input type="text" name="nombre_materia[]" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
            </div>
            <div class=" md:w-1/2 px-1">
                <label for="docente" class=" block text-gray-700 uppercase font-bold">Nombre del docente: </label>
                <input type="text" name="docente[]" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md mb-6 md:mb-0">
            </div>
        </div>
    </div>
    <div class="flex justify-between py-3">
        <input type="button" value="Agregar Materia" id="agregarMateria" class=" md:w1/2 text-xs bg-green-800 w-90 p-3 text-white uppercase font-bold hover:bg-green-900 cursor-pointer transition-all rounded-lg mb-2">

        <input type="submit" value="Guardar Datos" class=" md:w1/2 bg-indigo-600  p-3 text-white uppercase font-bold hover:bg-indigo-700 cursor-pointer transition-all rounded-lg">

    </div>

    </form>
</div>

    <script src="../build/js/app.js"></script>
</body>
</html>