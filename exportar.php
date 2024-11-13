

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento</title>
</head>
<body>
<table border="1" cellspacing="1" cellpadding="2" width="100%">
     <caption style=" background-color: MediumPurple; font-size: 20px; color: gray; "><b>REGISTRO DE INSCRITOS HONDA.</b> </caption>
     <tr>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">BOLETA</td>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">NOMBRE</td>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">DOCUMENTO</td>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">CIUDAD</td>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">CELULAR</td>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">EMAIL</td>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">MOTO</td> 
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">KMS</td> 
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">PREMIO</td>   
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">IP</td> 
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">FECHA</td> 

     </tr>
   <?php
    require 'logica/conexion.php';
    header('Content-Type: application/vnd.ms-excel;');//header('Content-Type: application/vnd.ms-excel;charset= "iso-8859-15"');
    header('Content-Disposition: attachment;filename="Juego.xls"');
    $consulta = "select DISTINCT id,nombre, documento, ciudad, celular, email, moto, kilometraje,fecha, premio,ip from jugadores ORDER BY id DESC";
    $consulta = "SELECT * from user_ruleta, ganadores where ganadores.id_jugador = user_ruleta.id";
    $consulta = "SELECT * FROM user_ruleta";

    $resultado = $dblink->query($consulta);
    $pos=0;
    while ($row = $resultado-> fetch_assoc()){
        $pos++;
    ?>  
               <td><?php echo '00'.$row ['id'];?></td>
               <td><?php echo $row ['nombre']; ?></td>
               <td><?php echo $row ['documento']; ?></td>
               <td><?php echo $row ['ciudad']; ?></td>
               <td><?php echo $row ['celular']; ?></td>
               <td><?php echo $row ['email']; ?></td>
               <td><?php echo $row ['moto']; ?></td>
               <td><?php echo $row ['kilometraje']; ?></td>
               <td><?php echo $row ['premio']; ?></td> 
               <td><?php echo $row ['ip']; ?></td> 
               <td><?php echo $row ['fecha']; ?></td>
        
           
               </tr>
            <?php 
            }

    ?>
