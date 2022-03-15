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

            $queryAlt = "SELECT * FROM alumnos 
            RIGHT JOIN calificaciones ON calificaciones.id_alumno = alumnos.idalumno 
            RIGHT JOIN unidades ON unidades.id = calificaciones.id_unidad";

            $ejecutarAlt = mysqli_query($db, $queryAlt);

            $queryCalificaciones = "SELECT * FROM calificaciones 
            INNER JOIN alumnos ON alumnos.idalumno = calificaciones.id_alumno 
            INNER JOIN unidades ON unidades.id = calificaciones.id_unidad
            WHERE id_materia = '{$idMateria}' AND id_unidad = '{$idUnidad}'";

            $ejecutarCalificaciones = mysqli_query($db, $queryCalificaciones);

            if($ejecutarCalificaciones ->num_rows <1){
                header('Location: registrar-calificaciones.php?grupo=' . $idGrupo . '&materia=' . $idMateria . '&unidad=' . $idUnidad);
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

                    $queryExistencia = "SELECT * FROM calificaciones WHERE id_materia = '{$idMateria}' AND id_unidad = '{$idUnidad}' AND id_alumno = '{$idAlumno}'";
                    $comprobarExistencia = mysqli_query($db, $queryExistencia);
                    $existe = mysqli_fetch_assoc($comprobarExistencia);

                    if (!isset($existe['id'])) {
                        $query = "INSERT INTO calificaciones (id_alumno, id_materia, asistencia, actividades, tareas, examen, promedio, id_unidad) VALUES ('{$idAlumno}', '{$idMateria}', '{$calAsistencia}', '{$calActividades}', '{$calTareas}', '{$calExamen}', '{$calPromedio}', '{$idUnidad}');";
                        mysqli_query($db, $query);
                        echo $query . "<br>";
                    }else{
                        $query = "UPDATE calificaciones SET asistencia = '{$calAsistencia}', actividades = '{$calActividades}', tareas = '{$calTareas}', examen = '{$calExamen}', promedio = '{$calPromedio}' WHERE id_alumno = '{$idAlumno}' AND id_materia = '{$idMateria}' AND id_unidad = '{$idUnidad}'";
                        mysqli_query($db, $query);

                        echo $query . "<br>";

                        
                    }
                    header('Location: editar-calificaciones.php?grupo=' . $idGrupo . '&materia=' . $idMateria . '&unidad=' . $idUnidad);
                }
            }
        } 
    }
    clearstatcache();
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
                <a id="grupo<?php echo $datos['id'];?>" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2" href=editar-calificaciones.php?grupo=<?php echo $datos['id'];?>> <?php echo $datos['nombre_grupo']; ?></a>
            <?php } ?>
        </div>
        </div>
                
        <?php 
        if($grupo){
            echo "<div class=\" flex justify-center flex-col bg-gray-100 shadow-md rounded-lg py-2 mx-4\">";
            echo "<h2 class=\" text-2xl flex justify-center font-bold\">Selecciona una materia: </h2>";
            echo "<div id=botonesMaterias class=\"flex flex-col sm:flex-row sm:justify-center\">";
            
            while($materias = mysqli_fetch_assoc($ejecutarMaterias)){ ?>
                <a id="materia<?php echo $materias['idmaterias'];?>" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-4 rounded-md mt-2" href=editar-calificaciones.php?grupo=<?php echo $idGrupo; ?>&materia=<?php echo $materias['idmaterias']; ?>> <?php echo $materias['nombre_materia']; ?> <a/>
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
                    <a id="unidad<?php echo $unidades['id'];?>" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-6 rounded-md mt-2"  href=editar-calificaciones.php?grupo=<?php echo $idGrupo; ?>&materia=<?php echo $idMateria; ?>&unidad=<?php echo $unidades['id']; ?>> <?php echo $unidades['nombre_unidad']?></a>
                    
            <?php } 
            echo "</div>";
            echo "</div>";
        } ?>

        <?php
            if (isset($ejecutarAlt)) { ?>
            <form class="bg-white shadow-md rounded-lg pt-10 pb-2 px-5 mb-10 container md:mx-auto  w-max" method="POST">
                <table>
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
                                while($calificaciones = mysqli_fetch_assoc($ejecutarAlt)){

                                    if($calificaciones['id_grupo'] == $idGrupo){

                                        if($calificaciones['id_unidad'] == $idUnidad){

                                            if($calificaciones['id_materia'] == $idMateria){

                                                $nombreAlumno = "{$calificaciones['nombre']} {$calificaciones['ap_paterno']} {$calificaciones['ap_materno']}";
                                                echo "<tr>";

                                                echo "<td  class=\"capitalize min-w-max\">$nombreAlumno </td>";
                                                
                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=asistencia[] value={$calificaciones['asistencia']}> </td>";
                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=actividades[] value={$calificaciones['actividades']}> </td>";
                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=tareas[] value={$calificaciones['tareas']}> </td>";
                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=examen[] value={$calificaciones['examen']}> </td>";
                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=promedio[] value={$calificaciones['promedio']}> </td>";
                                                echo "<td><input hidden  type=text name=idalumno[] value={$calificaciones['idalumno']}> </td>";

                                                echo "</tr>";
                                                
                                                    
                                                    
                                            }else{
                                               /*  $nombreAlumno = "{$calificaciones['nombre']} {$calificaciones['ap_paterno']} {$calificaciones['ap_materno']}";
                                                echo "<tr>";

                                                echo "<td  class=\"capitalize min-w-max\">$nombreAlumno </td>";

                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=asistencia[] value=0> </td>";
                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=actividades[] value=0> </td>";
                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=tareas[] value=0> </td>";
                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=examen[] value=0> </td>";
                                                echo "<td><input class=\"block bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm \" type=text name=promedio[] value=0> </td>";
                                                echo "<td><input hidden class=\"border-solid \" type=text name=idalumno[] value={$calificaciones['idalumno']}> </td>";

                                                echo "</tr>"; */
                                            }
                                            
                                        }
                                        
                                    }
                                    
                                }
                        ?>
                    </tbody>
                </table>

                <div class="flex justify-end py-3">
                    <input type="submit" value="Actualizar datos" class=" md:w1/2 bg-indigo-600  p-3 text-white uppercase font-bold hover:bg-indigo-700 cursor-pointer transition-all rounded-lg">
                </div>
            </form>
            
        <?php    } 
        mysqli_close($db)?>

    </main>

    <script src="../build/js/app.js"></script>
</body>
</html>