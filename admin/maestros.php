<?php 

require './funciones.php';

$autenticado = estaLogueado();

/* if(!$autenticado){
    header('Location: ../index.php');
} */
// Importar la conexión
require '../config/database.php';
$db = conectarDB();


$query= "SELECT * FROM grupos";
$ejecutarGrupos = mysqli_query($db, $query);
$arregloMaestros = [];

while($grupos = mysqli_fetch_array($ejecutarGrupos)){
    array_push($arregloMaestros, $grupos);
    
}
echo json_encode($arregloMaestros);


?>