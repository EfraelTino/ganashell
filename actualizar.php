<?php 
   require 'logica/conexion.php';
  
  
   $cn1=$_GET['pr1'];
   $cn2=$_GET['pr2'];
   $cn3=$_GET['pr3'];
   $cn4=$_GET['pr4'];
   $cn5=$_GET['pr5'];
   $cn6=$_GET['pr6'];
   $cn7=$_GET['pr7'];
   $cn8=$_GET['pr8'];
   $cn9=$_GET['pr9'];
   $cn10=$_GET['pr10'];
   $cn11=$_GET['pr11'];

   
    $id=1;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn1, $id);
    $stmt->execute();
    $stmt->close();

    $id=2;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn2, $id);
    $stmt->execute();
    $stmt->close();

    $id=3;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn3, $id);
    $stmt->execute();
    $stmt->close();

    $id=4;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn4, $id);
    $stmt->execute();
    $stmt->close();

    $id=5;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn5, $id);
    $stmt->execute();
    $stmt->close();

    $id=6;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn6, $id);
    $stmt->execute();
    $stmt->close();

    $id=7;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn7, $id);
    $stmt->execute();
    $stmt->close();

    $id=8;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn8, $id);
    $stmt->execute();
    $stmt->close();

    $id=9;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn9, $id);
    $stmt->execute();
    $stmt->close();

    $id=10;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn10, $id);
    $stmt->execute();
    $stmt->close();

    $id=11;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if(!$stmt) {echo "error";}
    $stmt->bind_param('ii', $cn11, $id);
    $stmt->execute();
    $stmt->close();

    

    


?>
<!DOCTYPE html>
<html>

<head>
    <title>Editor</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/centrarMaster.css">

    <script type="text/javascript">
        window.history.forward();

        function noBack() {
            window.history.forward();
            history.pushState(null, null, document.URL);
            window.addEventListener('popstate', function () {
                history.pushState(null, null, document.URL);
            });
        }

        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };

        window.location.hash = "no-back-button";
        window.location.hash = "Again-No-back-button"; //again because google chrome don't insert first hash into history
        window.onhashchange = function () {
            window.location.hash = "no-back-button";
        }

        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, "", window.location.href);
        };
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">

    <div>
        <section class="tecnica tecnica--margin-auto">
            <div class="contenedor">
                <div class="elemento">

                    <form action="uploadpro.php" method="POST" enctype="multipart/form-data">
                        <br>
                        <span class="letras_info">
                            <strong> actualizado</strong>
                        </span>
                    
                        <span class="aCentro">
                            <input style="float: center" type="submit" name="submit" value="VOLVER"
                                class="boton_personalizado" onclick="error();">
                        </span>


                    </form>


                </div>
            </div>
        </section>



    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->


</body>

</html>
<script type="text/javascript">
    var ventana;

    function ubicar() {
        var x = document.getElementById("window-notice");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }

    }

    function error() {
        //  window.location.href = "basico.html";
        var image = document.getElementById('image').value;
        if (image == "") {
            alert("Toma la foto de la factura para poder continuar");
            return false;

        }

    }


</script>