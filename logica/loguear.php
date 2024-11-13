<?php
    require 'conexion.php';
    session_start();
    
    $asesor =  $_POST['asesor'];
    $token   =  $_POST['token'];

    $query = "select count(*) as contar, id from visitadores where asesor = '$asesor' and token = '$token'";
    $consulta = mysqli_query($dblink, $query);
    $array = mysqli_fetch_array($consulta);
    echo $asesor;
    

    if($array['contar'] > 0 ){
        $_SESSION['username'] =$array['id'];
        echo "usuario ".$asesor." id = ".$array['id'];
        header("location: ../juego.php");
    }else{
        echo "LOS DATOS O EL USUARIO NO ESTAN CORRECTOS ";
       header('location: ../noregistrado.html');
    }


?>