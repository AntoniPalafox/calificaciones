<?php 

require '../config/database.php';
$db = conectarDB();

require './funciones.php';

$autenticado = estaLogueado();

if(!$autenticado){
    header('Location: ../index.php');
}

$idAlumno = [];
$asistencia = [];
$actividades = [];
$tareas = [];
$examen = [];
$promedio = [];

$query= "SELECT * FROM grupos";
$ejecutar = mysqli_query($db, $query);

$grupo = '';
$grupo = isset( $_GET['grupo']);

$materia = '';
$materia = isset( $_GET['materia']);

$unidad = '';
$unidad = isset( $_GET['unidad']);

if($grupo){
    $idGrupo = $_GET['grupo'];
    $queryMaterias = "SELECT * FROM materias WHERE id_grupo = {$idGrupo};";

    $ejecutarMaterias = mysqli_query($db, $queryMaterias);

    if($materia){
        $idMateria = $_GET['materia'];
    
        $queryUnidades = "SELECT * FROM unidades;";
    
        $ejecutarUnidades = mysqli_query($db, $queryUnidades);

        if($unidad){
            $idUnidad = $_GET['unidad'];
            //Query pendiente por definir debido a la estructura
            $queryCalificaciones = "SELECT * FROM calificaciones WHERE id_materia = '{$idMateria}' AND id_unidad = '{$idUnidad}'";
        
            $ejecutarCalificaciones = mysqli_query($db, $queryCalificaciones);

            if($ejecutarCalificaciones ->num_rows >= 1){
                header('Location: editar-calificaciones.php?grupo=' . $idGrupo . '&materia=' . $idMateria . '&unidad=' . $idUnidad);
            }
            
            $queryAlumnos = "SELECT * FROM alumnos
            INNER JOIN grupos ON grupos.id = alumnos.id_grupo
            INNER JOIN materias ON materias.id_grupo = grupos.id
            WHERE materias.id_grupo = '{$idGrupo}'
            AND materias.idmaterias = '{$idMateria}'";
            $ejecutarAlumnos = mysqli_query($db, $queryAlumnos);
        
            if($_SERVER['REQUEST_METHOD'] === "POST"){
        
                $idAlumno[] = $_POST['idalumno'];
                $asistencia[] = $_POST['asistencia'];
                $actividades[] = $_POST['actividades'];
                $tareas[] = $_POST['tareas'];
                $examen[] = $_POST['examen'];
                $promedio[] = $_POST['promedio'];
        
                for ($i=0; $i < count( $_POST['asistencia']); $i++) { 
                    $idAlumno = $_POST['idalumno'][$i];
                    $calAsistencia = $_POST['asistencia'][$i];
                    $calActividades = $_POST['actividades'][$i];
                    $calTareas = $_POST['tareas'][$i];
                    $calExamen = $_POST['examen'][$i];
                    $calPromedio = $_POST['promedio'][$i];

                    if(!$idAlumno){
                        $idAlumno = 0;
                    }
                    if(!$calAsistencia){
                        $calAsistencia = 0;
                    }
                    if(!$calActividades){
                        $calActividades = 0;
                    }
                    if(!$calTareas){
                        $calTareas = 0;
                    }
                    if(!$calExamen){
                        $calExamen = 0;
                    }
                    if(!$calPromedio){
                        $calPromedio = 0;
                    }
        
                    $query = "INSERT INTO calificaciones (id_alumno, id_materia, asistencia, actividades, tareas, examen, promedio, id_unidad) VALUES ('{$idAlumno}', '{$idMateria}', '{$calAsistencia}', '{$calActividades}', '{$calTareas}', '{$calExamen}', '{$calPromedio}', '{$idUnidad}');";
                    mysqli_query($db, $query);
                    
                    
                }
                header('Location: editar-calificaciones.php?grupo=' . $idGrupo . '&materia=' . $idMateria . '&unidad=' . $idUnidad);
            }
        } 
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../build/css/styles.css" rel="stylesheet">
    <title>Registrar calificaciones</title>
</head>
<body>
<?php require './header.php'; ?>

    <main>
    <div class=" flex justify-center flex-col bg-gray-100 shadow-md rounded-lg py-2 mx-4">
    <h2 class=" text-2xl flex justify-center font-bold">Selecciona un grupo: </h2>
        <div id="botonesGrupos" class="flex flex-col sm:flex-row sm:justify-center">
        <?php 
            while($datos = mysqli_fetch_assoc($ejecutar)){ ?>
                <a id="grupo<?php echo $datos['id'];?>" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2" href=registrar-calificaciones.php?grupo=<?php echo $datos['id'];?>> <?php echo $datos['nombre_grupo']; ?></a>
            <?php } ?>
        </div>
        </div>


        <?php 
        if($grupo){
            echo "<div class=\" flex justify-center flex-col bg-gray-100 shadow-md rounded-lg py-2 mx-4\">";
            echo "<h2 class=\" text-2xl flex justify-center font-bold\">Selecciona una materia: </h2>";
            echo "<div id=botonesMaterias class=\"flex flex-col sm:flex-row sm:justify-center\">";
            
            while($materias = mysqli_fetch_assoc($ejecutarMaterias)){ ?>
                <a id="materia<?php echo $materias['idmaterias'];?>" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2" href=registrar-calificaciones.php?grupo=<?php echo $idGrupo; ?>&materia=<?php echo $materias['idmaterias']; ?>> <?php echo $materias['nombre_materia']; ?> <a/>
        <?php } 
            echo "</div>";
            echo "</div>";
        }
        ?>

           <?php if($materia){
               echo "<div class=\" flex justify-center flex-col bg-gray-100 shadow-md rounded-lg py-2 mx-4\">";
               echo "<h2 class=\" text-2xl flex justify-center font-bold\">Selecciona una unidad: </h2>";
               echo "<div id=botonesUnidades class=\"flex flex-col sm:flex-row sm:justify-center\">";
                while($unidades = mysqli_fetch_assoc($ejecutarUnidades)){ ?>
                    <a id="unidad<?php echo $unidades['id'];?>" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2"  href=registrar-calificaciones.php?grupo=<?php echo $idGrupo; ?>&materia=<?php echo $idMateria; ?>&unidad=<?php echo $unidades['id']; ?>> <?php echo $unidades['nombre_unidad']?> </a>
                    
            <?php } 
            echo "</div>";
            echo "</div>";
        } ?>



        <?php
            if ($unidad) { ?>
            <div class=" md:w-auto">
            <form class="bg-white shadow-md rounded-lg pt-10 pb-2 px-5 mb-10 container md:mx-auto w-max" method="POST">
                <table class=" w-max">
                    <caption>Unidad <?php echo $idUnidad;?></caption>
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Asistencia</th>
                            <th>Actividades</th>
                            <th>Tareas</th>
                            <th>Exámen</th>
                            <th>Promedio</th>
                
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($ejecutarAlumnos) {
                            
                                while($alumnos = mysqli_fetch_assoc($ejecutarAlumnos)){

                                    $nombreAlumno = "{$alumnos['nombre']} {$alumnos['ap_paterno']} {$alumnos['ap_materno']}";
                                    echo "<tr>";

                                    echo "<td  class=\"capitalize min-w-max\">$nombreAlumno </td>";
                                    
                                    echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=asistencia[] > </td>";
                                    echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=actividades[] > </td>";
                                    echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=tareas[] > </td>";
                                    echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=examen[] > </td>";
                                    echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=promedio[] > </td>";
                                    echo "<td><input hidden type=text name=idalumno[] value={$alumnos['idalumno']}> </td>";

                                    echo "</tr>";
                                }
                        }
                        
                        ?>
                    </tbody>
                </table>
                <div class="flex justify-end py-3">
                    <input type="submit" value="Guardar datos" class=" md:w1/2 bg-indigo-600  p-3 text-white uppercase font-bold hover:bg-indigo-700 cursor-pointer transition-all rounded-lg">
                </div>
            </form>
            </div>
            
        <?php    } ?>

    </main>

    <script src="../build/js/app.js"></script>
</body>
</html>