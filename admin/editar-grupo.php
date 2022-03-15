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

$query = "SELECT * FROM grupos";
$listarGrupos = mysqli_query($db, $query);


$grupo = '';
$grupo = isset($_GET['grupo']);
if ($grupo) {
    $idGrupo = $_GET['grupo'];
    $queryMat = "SELECT * FROM materias 
    INNER JOIN grupos ON grupos.id = materias.id_grupo
    WHERE id_grupo = '{$idGrupo}'";
    $listarMaterias = mysqli_query($db, $queryMat);

    $query = "SELECT * FROM grupos WHERE id = '{$idGrupo}'";
    $nombreGrupo = mysqli_query($db, $query);
    $grupo = mysqli_fetch_assoc($nombreGrupo);

}



if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombreGrupo = $_POST['nombre_grupo'];
    $docente[] = $_POST['docente'];
    $materias[] = $_POST['nombre_materia'];
    $idmaterias[] = $_POST['idmaterias'];

    for ($i=0; $i < count( $_POST['nombre_materia']); $i++) { 
        $nombreMateria = $_POST['nombre_materia'][$i];
        $nombreDocente = $_POST['docente'][$i];
        $materiaId = $_POST['idmaterias'][$i];

        $query = "UPDATE materias SET nombre_materia = '{$nombreMateria}', docente = '{$nombreDocente}' WHERE idmaterias = '{$materiaId}'";
        mysqli_query($db, $query);
    }
    header('Location: editar-grupo.php?grupo=' . $idGrupo);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../build/css/styles.css" rel="stylesheet">
    <title>Editar Grupo</title>
</head>
<body>
<?php require './header.php'; ?>
    

    <div id="botonesGrupos" class="flex flex-col sm:flex-row sm:justify-center">
        <?php
        while ($grupos = mysqli_fetch_assoc($listarGrupos)) { ?>
            
            <a id="grupo<?php echo $grupos['id'];?>" class="  transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2" href=editar-grupo.php?grupo=<?php echo $grupos['id'];?>> <?php echo $grupos['nombre_grupo']; ?></a>
       <?php } ?>
    </div>
    <?php if ($grupo) { ?>
        
<div class=" xl:px-60">
    <form class="bg-white shadow-md rounded-lg pt-10 pb-2 px-5 mb-10 container md:mx-auto"  method="POST">

    <div class="md:grid md:justify-items-center">
        <div class="md:w-1/2">
            <label for="nombre_grupo" class=" block text-gray-700 uppercase font-bold">Nombre del grupo: </label>
            <input type="text" name="nombre_grupo" value="<?php echo $grupo['nombre_grupo'] ?>" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
        </div>
    </div>
    
    <?php if($grupo){
                while ($materias = mysqli_fetch_assoc($listarMaterias)) { ?>

                    <div id="formularioGrupo" class=" w-full">
                        <div class="md:flex py-3">
                            <div class=" md:w-1/2 px-1">
                                <label for="nombre_materia" class=" block text-gray-700 uppercase font-bold">Nombre Materia: </label>
                                <input type="text" name="nombre_materia[]" value="<?php echo $materias['nombre_materia']; ?>" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
                            </div>
                            <div class=" md:w-1/2 px-1">
                                <label for="docente" class=" block text-gray-700 uppercase font-bold">Nombre del docente: </label>
                                <input type="text" name="docente[]" value="<?php echo $materias['docente'] ?>" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md mb-6 md:mb-0">
                            </div>
                        </div>
                        <input type="text" name="idmaterias[]" hidden value="<?php echo $materias['idmaterias'] ?>">
                    </div>
                
                
                    <?php  } 
            } ?>
            <div class="flex justify-between py-3">
                <input type="button" value="Agregar Materia" id="agregarMateria" class=" md:w1/2 text-xs bg-green-800 w-90 p-3 text-white uppercase font-bold hover:bg-green-900 cursor-pointer transition-all rounded-lg mb-2">

                <input type="submit" value="Guardar Datos" class=" md:w1/2 bg-indigo-600  p-3 text-white uppercase font-bold hover:bg-indigo-700 cursor-pointer transition-all rounded-lg">

            </div>

    </form>


</div>


<?php } ?>
    <script src="../build/js/app.js"></script>
</body>
</html>