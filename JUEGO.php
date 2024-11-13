<?php
require 'logica/conexion.php';

$premio = 0;
$cantidad = 0;
$estado = 0;
$ganar = 0;
$intento = 0;
$id = $_GET['nob'];
$ip = $_GET['ip'];
$ipIn = "";
$vic=false;
$ya = false;
if(empty($id) || empty($ip)){
   header('Location: inicio.php');
} 
$dir = getRealIP();
getRealIP();
function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
}

//echo $dir.' -  '.$id;
if (mysqli_connect_errno()) {
    //echo "No se puede conectar con la base" . mysqli_connect_error();
    exit();
}
$sql = mysqli_query($dblink, "SELECT * FROM jugadores WHERE id ='$id'") or die(mysqli_error($link));
$row = mysqli_num_rows($sql);
//echo $row;

if ($row > 0) {
    if ($sql) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $pack = array( // JSON array
                'intento'=> $row["intento"],
                'premio' => $row["premio"],
                'estado' => $row["estado"],
                'ganar' => $row["ganar"],
                'ip'=> $row['ip']
            );
            $intento = $pack['intento'];
            $premio = $pack['premio'];
            $estado = $pack['estado'];
            $ganar = $pack['ganar'];
            if($ganar == 1){ $vic=true;}
            $ipIn = $pack['ip'];
            if ($estado == 1 || ($ipIn != $ip)) {
                $ya = true;
                
            }
        }
    }
} 
    if($ya){header('Location: upGame.php?nob='.$id.'&cod=1550a1234897698asdfhg');}
    $estado = 1;
    if($premio>100 && !$vic){ 
        $premio=$premio-100; // evaluar si se desea ganar con IP o sin ella
        //echo "jugaste pero no ganaste";
    }

//echo " -------> ".$id."GANAR " . $estado." el premio es ".$premio;
//"UPDATE users set email = ?, pass = ? where id = ?");
$query = "UPDATE jugadores set estado = ? where id = ?";
$stmt =  mysqli_prepare($dblink, $query);
mysqli_stmt_bind_param($stmt, 'is', $estado, $id);
$stmt->execute();
$stmt->close();


?>



<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>GanaShell</title>

    <style>
        html,
        body {
            overflow: hidden;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: rgb(255, 200, 100);
        }

        #renderCanvas {
            width: 100%;
            height: 100%;
            touch-action: nocdn
        }
    </style>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.6.2/dat.gui.min.js"></script>
    <script src="https://cdn.babylonjs.com/recast.js"></script>
    <script src="https://cdn.babylonjs.com/ammo.js"></script>
    <script src="https://cdn.babylonjs.com/cannon.js"></script>
    <script src="https://cdn.babylonjs.com/Oimo.js"></script>
    <script src="https://cdn.babylonjs.com/earcut.min.js"></script>
    <script src="https://cdn.babylonjs.com/babylon.js"></script>
    <script src="https://cdn.babylonjs.com/materialsLibrary/babylonjs.materials.min.js"></script>
    <script src="https://cdn.babylonjs.com/proceduralTexturesLibrary/babylonjs.proceduralTextures.min.js"></script>
    <script src="https://cdn.babylonjs.com/postProcessesLibrary/babylonjs.postProcess.min.js"></script>
    <script src="https://cdn.babylonjs.com/loaders/babylonjs.loaders.js"></script>
    <script src="https://cdn.babylonjs.com/serializers/babylonjs.serializers.min.js"></script>
    <script src="https://cdn.babylonjs.com/gui/babylon.gui.min.js"></script>
    <script src="https://cdn.babylonjs.com/inspector/babylon.inspector.bundle.js"></script>

</head>

<body>
    <input type="text" id="premio" value="<?php echo $premio?>" hidden>
    <input type="text" id="dir" value="<?php echo $dir?>" hidden>
    <input type="text" id="id" value="<?php echo $id?>" hidden>
    <input type="text" id="intentos" value="<?php echo $intento ?>" hidden>
    <canvas id="renderCanvas"></canvas> <!--  touch-action="none" for best results from PEP -->
    <script src="js/pr.js"></script>
    <script src="js/ruleta.js"></script>
</body>

</html>