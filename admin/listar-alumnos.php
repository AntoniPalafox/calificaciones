<?php 
// Importar la conexión
require '../config/database.php';
$db = conectarDB();

require './funciones.php';

$autenticado = estaLogueado();

if(!$autenticado){
    header('Location: ../index.php');
}

$grupo = '';
$grupo = isset( $_GET['grupo']);

$query= "SELECT * FROM grupos";
$ejecutarGrupos = mysqli_query($db, $query);


if($grupo){
    $idGrupo = $_GET['grupo'];
    $query = "SELECT * FROM alumnos
    INNER JOIN grupos ON grupos.id = alumnos.id_grupo
    WHERE id_grupo = '{$idGrupo}'";
    $ejecutarAlumnos = mysqli_query($db, $query);
    /* 
    while ($alumnos = mysqli_fetch_assoc($resultadoAlumnos)) {
        echo "<pre>";
        var_dump($alumnos);
        echo "</pre>";
    } */
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


<div class=" flex justify-center flex-col bg-gray-100 shadow-md rounded-lg py-2 mx-4">
    <h2 class=" text-2xl flex justify-center font-bold">Selecciona un grupo: </h2>

    <div id="botonesGrupos" class="flex flex-col sm:flex-row sm:justify-center">
        <?php 
            while($grupos = mysqli_fetch_assoc($ejecutarGrupos)){ ?>
            <a id="grupo<?php echo $grupos['id'];?>" class="  transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2" href=listar-alumnos.php?grupo=<?php echo $grupos['id'];?>> <?php echo $grupos['nombre_grupo']; ?></a>
                
            <?php }?>
    </div> 
</div>
    <?php if ($grupo) {
        echo "<div class=\" flex justify-center flex-col bg-gray-100 shadow-md rounded-lg py-2 mx-4\">";
        echo "<h2 class=\" text-2xl flex justify-center font-bold\">Selecciona un alumno: </h2>";
        echo "<div id=botonesMaterias class=\"flex flex-col sm:flex-row sm:justify-center\">";
            while($alumnos = mysqli_fetch_assoc($ejecutarAlumnos)){ ?>
            <a id="materia<?php echo $alumnos['idalumno'];?>" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-4 rounded-md mt-2" href=editar-alumno.php?grupo=<?php echo $idGrupo; ?>&alumno=<?php echo $alumnos['idalumno']; ?>> <?php echo $alumnos['nombre']; ?> <a/>
    <?php } 
    }?>

    <script src="../build/js/app.js"></script>
</body>
</html>