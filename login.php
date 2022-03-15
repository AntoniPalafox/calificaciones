<?php
// Importar la conexión
require 'config/database.php';
$db = conectarDB();

$errores = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = mysqli_real_escape_string($db,$_POST['usuario']);
    $contrasena = mysqli_real_escape_string($db,$_POST['contrasena']);

    if(!$usuario){
        $errores[] = "Escribe un usuario";
    }

    if(!$contrasena){
        $errores[] = "Escribe una contraseña";
    }

    if(empty($errores)){
        $query = "SELECT * FROM administradores WHERE usuario = '${usuario}'";
        $resultado = mysqli_query($db, $query);

        if($resultado->num_rows){
            $datos = mysqli_fetch_assoc($resultado);

            if($usuario === $datos['usuario']){
                echo "El usuario {$usuario} es correcto";

                $loginPass = password_verify($contrasena, $datos['contrasena']);
                if($loginPass){
                    session_start();

                    //Comprobar que usuario está autenticado
                    $_SESSION['usuario'] = $datos['usuario'];
                    $_SESSION['login'] = true;

                    header("Location: ./admin/index.php");

                }else{
                    $errores[] = "Contraseña incorrecta";
                }
            }else{
                $errores[] = "Usuario no encontrado";
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
    <link href="build/css/styles.css" rel="stylesheet">
    <title>Inicio de Sesión</title>
</head>
<body class=" bg-blue-200">
    <main >
        
        <form method="POST" class="bg-white shadow-md rounded-lg pt-10 pb-2 px-5 mb-10 container md:mx-auto sm:max-w-md mt-14">
        <h1 class=" text-3xl font-semibold flex justify-center mb-10">Inicio de sesión</h1>
            <label for="usuario" class=" block text-gray-700 uppercase font-bold">Usuario</label>
            <input type="text" name="usuario" placeholder="Ingresa tu usuario" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">

            <label for="contrasena" class=" block text-gray-700 uppercase font-bold">Contraseña</label>
            <input type="password" name="contrasena" placeholder="Ingresa tu contraseña" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
            <div class=" flex justify-end">
                <input type="submit" value="Iniciar Sesión" class="bg-indigo-600  mt-2 p-3 text-white uppercase font-bold hover:bg-indigo-700 cursor-pointer transition-all rounded-lg">
            </div>
            
        </form>

        <div class=" flex justify-center">
            <p class=" text-lg w-5/6 sm:w-1/2 text-justify">Aquí podrás administrar y crear grupos con sus respectivas materias para registrar calificaciones. Funciones limitadas para el usuario DEMO.</p>

        </div>
        <div class=" flex justify-center">
        <div class=" flex flex-col items-center">
            <p>Usuario: <span class=" font-bold">demo</span></p>
            <p>Contraseña: <span class=" font-bold">demo</span></p>
        </div>
            
        </div>
    </main>
</body>
</html>