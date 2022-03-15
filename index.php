<?php 
// Importar la conexión
require 'config/database.php';
$db = conectarDB();

$alumno= '';
$alumno = isset($_GET['matricula']);

$materia = "";
    $materia =isset( $_GET['materia']);

if ($alumno) {

    
    
    $matricula = $_GET['matricula'];
    $queryMaterias = "SELECT * FROM materias
    INNER JOIN grupos ON grupos.id = materias.id_grupo
    INNER JOIN alumnos ON alumnos.id_grupo = grupos.id
    WHERE alumnos.matricula = '{$matricula}'";

    $datos = mysqli_query($db, $queryMaterias);
    
    $alumnos = "SELECT * FROM alumnos 
    INNER JOIN grupos ON alumnos.id_grupo = grupos.id
    WHERE matricula = '{$matricula}'";
    $al = mysqli_query($db, $alumnos);

    $alumno = mysqli_fetch_assoc($al);

    if ($materia) {
        $nomMateria = $_GET['materia'];

        $query = "SELECT * FROM calificaciones 
        INNER JOIN materias on materias.idmaterias = calificaciones.id_materia
        INNER JOIN alumnos ON alumnos.idalumno = calificaciones.id_alumno 
        INNER JOIN unidades ON unidades.id = calificaciones.id_unidad
        WHERE matricula = '{$matricula}' AND idmaterias = '{$nomMateria}'";
        $result = mysqli_query($db, $query);

        $mater = mysqli_query($db, $query);
    }   
    
}


?>

<!DOCTYPE html>
<html lang="en" class=" min-h-full relative">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./build/css/styles.css" rel="stylesheet">
    <title>Calificaciones</title>
</head>
<body class=" bg-blue-100 m-0 mb-20">
    <div class=" bg-gray-800 py-4 rounded-b-lg w-full flex justify-center">
        <a href="./index.php" class=" flex justify-end font-extrabold text-2xl md:text-4xl text-gray-50">Portal del administrador</a>
    </div>

    <div class=" flex justify-center">
        <p class=" text-lg w-5/6 sm:w-1/2 text-justify">En este portal el alumno puede consultar sus calificaciones por materia, según hayan sido cargadas por el administrador del sitio. Intenta buscando las calificaciones de las matriculas 541910000, 541920333, 541920111 o ingresa al <span class=" font-bold"> portal del administrador</span> que se encuentra al pie de página para registrar tus alumnos.</p>
    </div>
    <div class=" flex justify-center">
        <form method="GET">
            <input type="text" name=matricula placeholder="Ingresa tu matrícula" class=" border-2 w-30 p-2 mt-2 placeholder-gray-400 rounded-md">
            <input type="submit" value="Buscar" class=" md:w1/2 bg-indigo-600  p-3 text-white uppercase font-bold hover:bg-indigo-700 cursor-pointer transition-all rounded-lg">
        </form>
    </div>




<?php 

if ($alumno) {
    echo "<div class=\" flex justify-center flex-col bg-gray-100 shadow-md rounded-lg py-2 mx-4 mb-4\">";
echo "<h2 class=\" text-2xl flex justify-center font-bold\">Selecciona una materia: </h2>";
echo "<div id=botonesMaterias class=\"flex flex-col sm:flex-row sm:justify-center\">";
    while ($materias = mysqli_fetch_assoc($datos)) { ?>
        <a id="materia<?php echo $materias['idmaterias'];?>" href="./index.php?matricula=<?php echo $matricula; ?>&materia=<?php echo $materias['idmaterias']; ?>" class=" transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 bg-blue-600 hover:bg-blue-900 text-white font-semibold py-3 px-6 sm:mx-2 mx-4 rounded-md mt-2"><?php echo $materias['nombre_materia']; ?></a>
   <?php }
   echo "</div>";
   echo "</div>";
}
?>
        <?php 
        if ($materia) {
            echo "<p id=\"matricula{$matricula}\"> </p>";
            echo "<div class=\"bg-white shadow-md rounded-lg pt-10 pb-2 px-5 mb-10 container mx-auto  w-max\">";
            echo "<h2 class=\"flex justify-center\">" . ' ' . "<span class=\"font-bold\">Alumno: </span>{$alumno['nombre']} {$alumno['ap_paterno']} {$alumno['ap_materno']} </h2>";
            echo "<p class=\"flex justify-center\"><span class=\"font-bold\">Grupo:</span> {$alumno['nombre_grupo']} </p>";
            for ($i = 1; $i <= 5 ; $i++) { 
                $resultado = mysqli_fetch_assoc($result);
                echo "<table class=\"table-auto\">";
                echo "<caption> Unidad {$i}</caption>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Asistencia</th>";
                echo "<th>Actividades</th>";
                echo "<th>Tareas</th>";
                echo "<th>Exámen</th>";
                echo "<th>Promedio</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                if(isset($resultado['id_unidad']) == $i){
            ?>
            
                    <tr>
                    <td class="bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm sm:text-sm"> <p><?php echo $resultado['asistencia']; ?></p></td>
                    <td class="bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm sm:text-sm"> <p><?php echo $resultado['actividades']; ?> </p></td>
                    <td class="bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm sm:text-sm"><?php echo $resultado['tareas']; ?></td>
                    <td class="bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm sm:text-sm"><?php echo $resultado['examen']; ?></td>
                    <td class="bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm sm:text-sm"><?php echo $resultado['promedio']; ?></td>
                </tr>
       
       <?php 
    }else{
        
        echo "<tr>";
        for ($i=0; $i < 5; $i++) { 
            echo "<td class=\"bg-white w-20 border border-slate-300 rounded-md py-2 px-7 shadow-sm sm:text-sm\">ND</td>";
        }
        echo "</tr>";
        
    }
    echo "</tbody>";
    echo "</table>";
       } 
       echo "</div>";
       }?>
   
<footer class=" bg-gray-700 absolute bottom-0 w-full h-14 text-white py-4">
    <a href="./login.php" class=" pl-20 pt-3 text-lg font-semibold">ADMINISTRADOR</a>
</footer>

<script src="./build/js/app.js"></script>
</body>
</html>