<?php
     require 'logica/conexion.php';
     $ramdom=rand(9,12);
     //$ramdom=10;
     $cantidad=0; 
    
    function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
   
    return $_SERVER['REMOTE_ADDR'];
    }
    date_default_timezone_set('America/Bogota'); 
    $hora = date('m-d-Y h:i:s', time());
    $dir = getRealIP();
    $opor=0;
    $dir = getRealIP();
    //$dir="181.63.64.67";//$sql = mysqli_query($dblink, "SELECT * FROM ips WHERE direccion ='$dir' and premiu > 0") or die(mysqli_error($dblink));
    $sql = mysqli_query($dblink, "SELECT count(direccion) as cont FROM ips WHERE direccion ='$dir'") or die(mysqli_error($dblink));
    $row = mysqli_num_rows($sql);
    if ($sql) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $pack = array(// JSON array
            'cont' => $row["cont"],
             );
            $opor = $pack['cont'];
        }

    }   

    if($opor > 0){
        $ramdom=rand(600,620);//ya  participo
   
    }

    $query = "INSERT INTO ips (direccion, hora, premiu) VALUES(?,?,?)";
	$stmt =  mysqli_prepare($dblink, $query);
	mysqli_stmt_bind_param($stmt,'ssi',$dir,$hora,$ramdom);

    if(!mysqli_stmt_execute($stmt)){
    echo mysqli_error($dblink);
    }
        
    $query =mysqli_query($dblink, "SELECT * FROM productosh where id ='$ramdom' and cantidad > 0 ") or die(mysqli_error($dblink));
	$row = mysqli_num_rows($query);
    if ($query) {
   
           while ($row = mysqli_fetch_assoc($query)) {
             $pack = array(// JSON array
             'id' => $row["id"],
             'premio' => $row["premio"],
             'cantidad' => $row["cantidad"],
              );
              $id = $pack['id'];
              $premio = $pack['premio'];
              $cantidad= $pack['cantidad'];
              
 
            }
         
        mysqli_free_result($query);
    }
   
    if($cantidad>0){
        $cantidad=$cantidad-1;
        $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
        if(!$stmt) {
	     echo "error";
        }
       // echo "Actualizado! ".$id."  y ".$premio ." cantidad ".$cantidad ;
        $stmt->bind_param('ii', $cantidad, $id);
        $stmt->execute();
        $stmt->close();
        }

?> 

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Slot Honda</title>
    <style>
        html,
        body {
            overflow: hidden;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #renderCanvas {
            width: 100%;
            height: 100%;
            touch-action: nocdn
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.6.2/dat.gui.min.js"></script>
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

   <canvas id="renderCanvas" ></canvas> <!--  touch-action="none" for best results from PEP -->
        <script type="text/javascript" src="js/juego.js" >

        </script>
 
</body>

</html>