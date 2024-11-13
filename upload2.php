<?php
require 'logica/conexion.php';
$status = $statusMsg = 'hola';
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
if (isset($_POST["submit"])) {
    $status = 'error';
    if (!empty($_FILES["image"]["name"])) {
        // File info 
        $fileName = basename($_FILES["image"]["name"]);

        $imageUploadPath = $uploadPath . $fileName;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

        // Permitimos solo unas extensiones
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {


            switch ($fileType) {
                case "jpg":
                    $imageUploadPath = $uploadPath . $documento . " " . $horb . ".jpg";
                    break;
                case "png":
                    $imageUploadPath = $uploadPath . $documento . " " . $horb . ".png";
                    break;
                case "jpeg":
                    $imageUploadPath = $uploadPath . $documento . " " . $horb . ".jpeg";
                    break;
                case "gif":
                    $imageUploadPath = $uploadPath . $documento . " " . $horb . ".gif";
                    break;
            }
            echo  $imageUploadPath;
        }

        if (in_array($fileType, $allowTypes)) {
            // Image temp source 
            $imageTemp = $_FILES["image"]["tmp_name"];

            // Comprimos el fichero
            $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);

            if ($compressedImage) {
                $status = 'success';
                $statusMsg = " La imagen se ha subido satisfactoriamente.";
            } else {
                $statusMsg = "La compresion de la imagen ha fallado";
            }
        } else {
            $statusMsg = 'Lo sentimos, solo se permiten imágenes con estas extensiones: JPG, JPEG, PNG, & GIF.';
        }
    } else {
        $statusMsg = 'Por favor, selecciona una imagen.';
    }
}
echo   $status;


