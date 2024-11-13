<?php 
   require 'logica/conexion.php';
   function compressImage($source, $destination, $quality) { 
      // Obtenemos la información de la imagen
      $imgInfo = getimagesize($source); 
      $mime = $imgInfo['mime']; 
      // Creamos una imagen
      switch($mime){ 
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
       
      // Guardamos la imagen
      imagejpeg($image, $destination, $quality); 
       
      // Devolvemos la imagen comprimida
      return $destination; 
  } 
   $uploadPath = "image/"; 
   date_default_timezone_set('America/Bogota'); 
   $hora = date('m-d-Y h:i:s', time()); 
   $horb = date('mdY his', time()); 
   $documento = $_POST['documento'];
   $nombre= $_POST['nombre'];
   $ciudad = $_POST['ciudad'];
   $celular = $_POST['celular'];
   $email = $_POST['email'];
   $moto = $_POST['moto'];
   $kilometraje= $_POST['kilometraje'];
   $premio=$_POST['premio'];
   $ipreal=$_POST['ip'];
   $code=$_POST['code'];
   $id="";
  echo $ipreal;
  echo $code;
   getRealIP();
   function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
       return $_SERVER['HTTP_CLIENT_IP'];
      
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
       return $_SERVER['HTTP_X_FORWARDED_FOR'];
  
    return $_SERVER['REMOTE_ADDR'];
   }
$uploadPath = "image/"; 
$status = $statusMsg = ''; 
$ip = getRealIP();

    if (mysqli_connect_errno()) {
       echo "Could not connect to database: Error: ".mysqli_connect_error();
       exit();
    }
   $sql =mysqli_query($dblink, "SELECT * FROM jugadores where ip ='$ip' ") or die(mysqli_error($link));
   $row = mysqli_num_rows($sql);
   echo $row;

	if($row > 0){

        
        $premio="-+-.";
      //  header ('Location: yaregistro.php');
     //   throw new Exception(' Este usuario ya esta registrado ');
	   
    }

    if($ipreal!=$ip ){
       
        $premio="-+-";
    }
    
	$query = "INSERT INTO jugadores (documento,nombre,ciudad,celular,email,moto,kilometraje,premio,ip,fecha) VALUES (?,?,?,?,?,?,?,?,?,?)";
	$stmt =  mysqli_prepare($dblink, $query);
	mysqli_stmt_bind_param($stmt,'sssississs', $documento, $nombre, $ciudad, $celular, $email, $moto, $kilometraje, $premio, $ip, $hora);
    
   
    if(!mysqli_stmt_execute($stmt)){
      // echo mysqli_error($dblink);
      }
    else
    {
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

        $query =mysqli_query($dblink, "SELECT * FROM jugadores where documento ='$documento' ") or die(mysqli_error($dblink));
	     $row = mysqli_num_rows($query);
        if ($query) {
            /* fetch associative array */
           while ($row = mysqli_fetch_assoc($query)) {
       
           $pack = array(// JSON array
             'id' => $row["id"],
             'nombre' => $row["nombre"],
               
              );
              $id = $pack['id'];
             echo json_encode($pack);//encode the register in json and send it back to unity. (take a look in unity:httpRequestClient.On ("ANSWER", OnReceiveServerAnswer))
             echo "*";// set the * character as a separator for each json record that will be sent to unity
       }
   
       /* free result set */
       mysqli_free_result($query);
       }
        header ('Location: final.php?id='.$id.'&premio='.$premio);
        echo "bien";
    
    
    
    }
    
//**************************************************************************************************
  
    
    /* close connection */
   /* mysqli_close($dblink);*/
        
    
        
        
        
	



   


 

