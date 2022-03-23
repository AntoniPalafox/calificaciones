<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', '', 'portal_calificaciones');

    if(!$db){
        echo "No se pudo conectar";
        exit;
    }

    return $db;
}