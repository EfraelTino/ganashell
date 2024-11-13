<?php
require 'logica/conexion.php';

getRealIP();
function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
}


$id  = $_GET['nob'];
$cod = $_GET['cod'];
$ganar=false;

$correcto  = $id;
$prohibidos = array(";", "=", ":", "Drop Table", "update", "Update", "'", "DROP", "Truncate", "TRUNCATE", "truncate");
$remplazos  = array("n1", "n2", "n3", "n4", "n5", "n6", "n7", "n8", "n9", "n10", "n11");
$id = str_replace($prohibidos, $remplazos, $correcto);

if ($cod == "1550b") {
    echo "modificar base";
    $query = "UPDATE jugadores set intento = 0, estado = 1, ganar = 1 where id = ?";
    $ganar=true;
   
} else {
    echo "NO GANO NADA";
    $query = "UPDATE jugadores set intento = 0, estado = 1, ganar = 0 where id = ?";
    $ganar=false;
}

$stmt =  mysqli_prepare($dblink, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
$stmt->execute();
$stmt->close();

if($ganar){
    header ('Location: felicitaciones-2.html');
}else{
    header ('Location: felicitaciones.html');
}
