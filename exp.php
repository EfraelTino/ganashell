

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
     <caption style=" background-color: MediumPurple; font-size: 20px; color: gray; "><b>REGISTRO DE CONEXIONES IPS.</b> </caption>
     <tr>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">ID<td>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">DIRECCION IP</td>
        <td style=" background-color: MediumPurple; font-size: 15px; color: white;">FECHA</td>

     </tr>
     <?php
        require 'logica/conexion.php';
        header('Content-Type: application/vnd.ms-excel;');//header('Content-Type: application/vnd.ms-excel;charset= "iso-8859-15"');
        header('Content-Disposition: attachment;filename="ips.xls"');
        $consulta = "select DISTINCT id, direccion, hora from ips ORDER BY id DESC";
        $resultado = $dblink->query($consulta);
        $pos=0;
        while ($row = $resultado-> fetch_assoc()){
        $pos++;
    ?>  
               <td><?php echo $row ['id']; ?></td>
               <td><?php echo $row ['direccion']; ?></td>
               <td><?php echo $row ['hora']; ?></td>
             </tr>
            <?php 
            }

    ?>
