<?php
require 'logica/conexion.php';
function compressImage($source, $destination, $quality)
{
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }
    imagejpeg($image, $destination, $quality);
    return $destination;
}
getRealIP();
function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
}

//$uploadPath = "image/";
$status = $statusMsg = '';
$ip = getRealIP();
$uploadPath = "image/";
date_default_timezone_set('America/Bogota');
$hora = date('m-d-Y h:i:s', time());
$horb = date('mdY his', time());
$documento = $_POST['documento'];
$nombre = $_POST['nombre'];
$ciudad = $_POST['ciudad'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$moto = $_POST['moto'];
//$kilometraje = $_POST['kilometraje'];
$shell = $_POST['shell'];
$premio = $_POST['premio'];
$cuantos = $_POST['cuantos'];
$puntaje = 0;
$id = "";
$ganar=0;
$estado=0;
$correcto  = $nombre;
$prohibidos = array(";", "=", ":", "Drop Table", "update", "Update", "'", "DROP", "Truncate", "TRUNCATE", "truncate");
$remplazos  = array("n1", "n2", "n3", "n4", "n5", "n6", "n7", "n8", "n9", "n10", "n11");
$nombre = str_replace($prohibidos, $remplazos, $correcto);



if (mysqli_connect_errno()) {
    echo "Could not connect to database: Error: " . mysqli_connect_error();
    exit();
}
$sql = mysqli_query($dblink, "SELECT * FROM jugadores WHERE documento ='$documento' and ganar ='1'; ") or die(mysqli_error($link));
$row = mysqli_num_rows($sql);
//echo $row;

//if ($row > 0) {
    if ($sql) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $pack = array( // JSON array
                'id' => $row["id"],
                'nombre' => $row["nombre"],
            );
            $id = $pack['id'];
            //header('Location: JUEGO.php?code=' . $cuantos . '&nob=' . $id.'&ip='.$ip);
            $ganar=1;
            $estado=0;
            $premio="ya obtuvo";
         
        }
    }
    //echo "Usuario Registrado llevar juego N Gana " . $cuantos;
//} else {




    $regex = '/^[a-zA-ZáéíóúÁÉÍÓÚ-ñÑ ]+$/'; // nombres
    if (preg_match($regex, $nombre) && preg_match($regex, $ciudad)) {
        echo 'El texto es válido';
    } else {
        echo "texto invalido";
       // header ('Location: error.html');
    }

// desbloquear cuando no se requiera mas premios
   // $premio = "Ninguno"; 
    $query = "INSERT INTO jugadores (documento,nombre,ciudad,celular,email,moto,premio,ip,fecha,shell,intento,estado,ganar) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt =  mysqli_prepare($dblink, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssisssiii', $documento, $nombre, $ciudad, $celular, $email, $moto,  $premio, $ip, $hora, $shell, $cuantos,$estado,$ganar);


    if (!mysqli_stmt_execute($stmt)) {
        // echo mysqli_error($dblink);
    } else {
        
        if(isset($_POST["submit"])){ 
            $status = 'error'; 
            if(!empty($_FILES["image"]["name"])) { 
            // File info 
            $fileName = basename($_FILES["image"]["name"]);
           
            $imageUploadPath = $uploadPath . $fileName; 
            $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION); 
           
            // Permitimos solo unas extensiones
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes)){ 
               
                 
                switch($fileType){
                    case "jpg":  $imageUploadPath = $uploadPath . $documento." ".$horb. ".jpg" ;  break;
                    case "png":  $imageUploadPath = $uploadPath . $documento." ".$horb. ".png" ;  break;
                    case "jpeg": $imageUploadPath = $uploadPath . $documento." ".$horb. ".jpeg"; break;
                    case "gif":  $imageUploadPath = $uploadPath . $documento." ".$horb. ".gif" ;  break;
                        
                }
                echo  $imageUploadPath;
            }
            
            if(in_array($fileType, $allowTypes)){ 
                // Image temp source 
                $imageTemp = $_FILES["image"]["tmp_name"]; 
                
                // Comprimos el fichero
                $compressedImage = compressImage($imageTemp, $imageUploadPath, 75); 
                 
                if($compressedImage){ 
                    $status = 'success'; 
                    $statusMsg = " La imagen se ha subido satisfactoriamente."; 
                }else{ 
                    $statusMsg = "La compresion de la imagen ha fallado"; 
                } 
            }else{ 
                $statusMsg = 'Lo sentimos, solo se permiten imágenes con estas extensiones: JPG, JPEG, PNG, & GIF.'; 
            } 
            }else{ 
            $statusMsg = 'Por favor, selecciona una imagen.'; 
            } 
        }
        

        $query = mysqli_query($dblink, "SELECT * FROM jugadores where documento ='$documento' and estado = 0; ") or die(mysqli_error($dblink));
        $row = mysqli_num_rows($query);
        if ($query) {
            /* fetch associative array */
            while ($row = mysqli_fetch_assoc($query)) {

                $pack = array( // JSON array
                    'id' => $row["id"],
                    'nombre' => $row["nombre"],
                );
                $id = $pack['id'];
            }
            mysqli_free_result($query);
        }
  
      //header('Location: JUEGO.php?code=' . $cuantos . '&nob=' . $id.'&ip='.$ip);
    }
    echo "acascfasdflkjasldfkja;lsdfkj <br>";
    echo  $imageUploadPath." ". $status;
//}   
//**************************************************************************************************
  
    
    /* close connection */
   /* mysqli_close($dblink);*/
