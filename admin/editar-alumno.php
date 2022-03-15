<?php 

require './funciones.php';

$autenticado = estaLogueado();

if(!$autenticado){
    header('Location: ../index.php');
}
// Importar la conexión
require '../config/database.php';
$db = conectarDB();



$query= "SELECT * FROM grupos";
$ejecutarGrupos = mysqli_query($db, $query);

$alumno = '';
$alumno = isset( $_GET['alumno']);

if($alumno){
    $idAlumno = $_GET['alumno'];
    $query = "SELECT * FROM alumnos
    INNER JOIN grupos ON grupos.id = alumnos.id_grupo
    WHERE idalumno = '{$idAlumno}'";
    $ejecutarAlumnos = mysqli_query($db, $query);

    $ejecutarAlumnos2 = mysqli_query($db, $query);

    $alumnos = mysqli_fetch_assoc($ejecutarAlumnos);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = $_POST['nombre'];
    $apPaterno = $_POST['ap_paterno'];
    $apMaterno = $_POST['ap_materno'];
    $matricula = $_POST['matricula'];
    $idGrupo = $_POST['id_grupo'];

    $query = "UPDATE alumnos SET nombre = '{$nombre}', ap_paterno = '{$apPaterno}', ap_materno = '{$apMaterno}', matricula = '{$matricula}', id_grupo = '{$idGrupo}' WHERE idalumno = '{$idAlumno}'";

    mysqli_query($db, $query);

    header('Location: listar-alumnos.php?grupo=' . $idGrupo);
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

<?php if($alumno){ ?>
    <div class="flex justify-center xl:px-60">


    <form class="bg-white shadow-md rounded-lg pt-10 pb-2 px-5 mb-10 container md:mx-auto md:w-50" method="POST">
    <div class="md:grid">

            <label for="nombre" class=" block text-gray-700 uppercase font-bold">Nombres: </label>
            <input type="text" name="nombre" value="<?php echo $alumnos['nombre']; ?>" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">

            <div class="md:flex py-3">
                <div class=" md:w-1/2 px-1">
                    <label for="ap_paterno" class=" block text-gray-700 uppercase font-bold">Apellido paterno: </label>
                    <input type="text" name="ap_paterno" value="<?php echo $alumnos['ap_paterno']; ?>" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
                </div>
                <div class=" md:w-1/2 px-1">
                    <label for="ap_materno" class=" block text-gray-700 uppercase font-bold">Apellido materno: </label>
                    <input type="text" name="ap_materno" value="<?php echo $alumnos['ap_materno']; ?>" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
                </div>
            </div>

            <div class="md:flex py-3">
                <div class=" md:w-1/2 px-1">
                    <label for="matricula" class=" block text-gray-700 uppercase font-bold">Matrícula: </label>
                    <input type="text" name="matricula" value="<?php echo $alumnos['matricula']; ?>" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
                </div>
                <div class=" md:w-1/2 px-1">
                    <label for="grupo" class=" block text-gray-700 uppercase font-bold">Grupo: </label>
                    <select name="id_grupo" id="" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
                        <option value="#" >--Seleccione--</option>
                        <?php
                            while($datos = mysqli_fetch_assoc($ejecutarGrupos)){ ?>
                            <option <?php echo $alumnos['id_grupo'] === $datos['id'] ? 'selected' : ''; ?> value="<?php echo $datos['id']; ?>"> <?php echo $datos['nombre_grupo']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            
        
    </div>

        
        <div class="flex justify-end py-3">
            <input type="submit" class=" md:w1/2 bg-indigo-600  p-3 text-white uppercase font-bold hover:bg-indigo-700 cursor-pointer transition-all rounded-lg" value="Actualizar Datos">
        </div>
    </form>
</div>
    
    <?php  } ?>
    <script src="../build/js/app.js"></script>
</body>
</html>
