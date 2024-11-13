<?php
require 'logica/conexion.php';
$ramdom = rand(1, 12);
$documento = $_POST['documento'];
//echo "documento " . $documento;
$correcto  = $documento;
$prohibidos = array(";", "=", ":", "Drop Table", "update", "Update", "'", "DROP", "Truncate", "TRUNCATE", "truncate");
$remplazos  = array("n1", "n2", "n3", "n4", "n5", "n6", "n7", "n8", "n9", "n10", "n11");
$documento = str_replace($prohibidos, $remplazos, $correcto);
date_default_timezone_set('America/Bogota');
$hora = date('m-d-Y h:i:s', time());
$ip = getRealIP();

$nombre = "";
$ciduad = "";
$celular = "";
$email = "";
$moto = "";
$ganar = "";
$email = "";
$shell = "";
$noganar = false;

function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
}
if (mysqli_connect_errno()) {
    echo "No puedo conectar con base: " . mysqli_connect_error();
    exit();
}
$sql = mysqli_query($dblink, "SELECT * FROM jugadores WHERE documento ='$documento'") or die(mysqli_error($link));
$row = mysqli_num_rows($sql);

if ($row > 0) {
    if ($sql) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $pack = array( // JSON array

                'nombre' => $row["nombre"],
                'ciudad' => $row["ciudad"],
                'celular' => $row["celular"],
                'email'  => $row["email"],
                'moto' => $row["moto"],
                'ganar' => $row["ganar"],
                'shell' => $row["shell"]

            );
            // $id = $pack['id'];
            $nombre = $pack['nombre'];
            $ciudad = $pack['ciudad'];
            $celular = $pack['celular'];
            $email = $pack['email'];
            $moto = $pack['moto'];
            $shell = $pack['shell'];
            $ganar = $pack['ganar'];
            if ($ganar == 1) {
                $noganar = true;
            }
            //header('Location: JUEGO.php?code=' . $cuantos . '&nob=' . $id.'&ip='.$ip);
            $ganar = 1;
            $estado = 0;
            $premio = "ya obtuvo";
        }
    }
    //echo "si esta-----";
    if ($noganar) {

        $ramdom = $ramdom + 200;
        // echo "ya ganoo es te loco ".$ramdom;
        $query = "INSERT INTO ips (direccion, hora, premiu) VALUES(?,?,?)";
        $stmt =  mysqli_prepare($dblink, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $ip, $hora, $ramdom);

        if (!mysqli_stmt_execute($stmt)) {
            echo mysqli_error($dblink);
        }
    } else {
        // echo "NO ha ganado";

        $query = mysqli_query($dblink, "SELECT * FROM productoss where id ='$ramdom' and cantidad > 0 ") or die(mysqli_error($dblink));
        $row = mysqli_num_rows($query);
        if ($query) {
            if ($row > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $pack = array( // JSON array
                        'id' => $row["id"],
                        'premio' => $row["premio"],
                        'cantidad' => $row["cantidad"],
                    );
                    $id = $pack['id'];
                    $premio = $pack['premio'];
                    $cantidad = $pack['cantidad'];
                }
                if ($cantidad > 0) {
                    $cantidad = $cantidad - 1;
                    $stmt = $dblink->prepare("UPDATE `productoss` SET `cantidad` = ? WHERE id = ?  ");
                    if (!$stmt) {
                        echo "error";
                    }
                    $stmt->bind_param('ii', $cantidad, $id);
                    $stmt->execute();
                    $stmt->close();
                }
            } else {
                $ramdom = $ramdom + 50;
            }
            mysqli_free_result($query);
        }
        $sql = mysqli_query($dblink, "SELECT count(direccion) as cont FROM ips WHERE direccion ='$ip' and premiu<13") or die(mysqli_error($dblink));
        $row = mysqli_num_rows($sql);
        if ($sql) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $pack = array( // JSON array
                    'cont' => $row["cont"],
                );
                $opor = $pack['cont'];
            }
        }

        if ($opor > 0) {
            $ramdom = $ramdom + 100; // rand(600, 620); //ya  participo

        }

        $query = "INSERT INTO ips (direccion, hora, premiu) VALUES(?,?,?)";
        $stmt =  mysqli_prepare($dblink, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $ip, $hora, $ramdom);

        if (!mysqli_stmt_execute($stmt)) {
            echo mysqli_error($dblink);
        }
    }
} else {
    header('Location: formulario.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Promoción Shell</title>
    <link rel="stylesheet" href="index2.css" />
</head>

<body>
    <div class="container">
        <div>
            <div class="head-factura">
                <img
                    src="assets/shellicono.jpg"
                    alt="Shell Logo"
                    class="logo"
                    width="70"
                    style="width: 70px;" />
                <h1>
                    ¡Compra, inscríbete <br />
                    <span>y gana con Shell!</span>
                </h1>
            </div>

            <form class="form-section" action="upload.php" method="post" enctype="multipart/form-data">
                <div class="quantity-section">
                    <h3><?php echo $nombre ?></h3>
                </div>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre ?>" hidden />
                <input type="text" id="documento" name="documento" value="<?php echo $documento ?>" hidden />
                <input type="text" id="ciudad" name="ciudad" value="<?php echo $ciudad ?>" hidden />
                <input type="text" id="celular" name="celular" value="<?php echo $celular ?>" hidden />
                <input type="text" id="moto" name="moto" value="<?php echo $moto ?>" hidden />
                <input type="text" id="premio" name="premio" value="<?php echo $ramdom ?>" hidden />
                <input type="text" id="email" name="email" value="<?php echo $email ?>" hidden />
                <input type="text" id="shell" name="shell" value="<?php echo $shell ?>" hidden />
          
                <div class="upload-container">
                    <label for="image" class="upload-label">
                        <span class="image"> Adjunta tu factura</span>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            class="bi bi-camera"
                            viewBox="0 0 16 16">
                            <path
                                d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4z" />
                            <path
                                d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                        </svg>
                    </label>
                    <input type="file" id="image" name="image" accept="image/*" capture="camera" required hidden/>

                    <span class="adjunto">Imagen adjunta.png</span>
                </div>

                <div class="quantity-section">
                    <h3>Cantidad</h3>
                    <div class="units">
                        <input type="number" id="cuantos" name="cuantos" value="20" />
                        <div class="units-btn">
                            <button type="button" class="active" onclick="seleccionarCantidad(1, this)">Litros</button>
                            <button type="button" onclick="seleccionarCantidad(2, this)">Galones</button>
                            <button type="button" onclick="seleccionarCantidad(3, this)">Balde</button>

                        </div>
                    </div>
                </div>

                <button class="play-button" type="submit" name="submit" value="Enviar" onclick="error();">Jugar</button>
               
            </form>

            <div class="product-section">
                <img src="assets/bodegon.webp" alt="Productos Shell" class="products" />
            </div>

            <div class="footer">
                <img src="assets/logoabajo.webp" alt="Logo Altipal" class="altipal-logo" />

            </div>
        </div>
    </div>
    <div class="no-disponbile">SOLO DISPONIBLE EN DIPOSITIVOS MÓVILES</div>
    <script>
        
        const fileInput = document.getElementById("image");
        const fileNameDisplay = document.querySelector(".adjunto");

        fileInput.addEventListener("change", function() {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name;

            }
        });
              
        function error() {
           
            var image = document.getElementById('image').value;
            if (image == "") {
                alert("Toma la foto de la factura para poder continuar");
                return false;
            }

        }

        function seleccionarCantidad(id, element) {
            const buttons = document.querySelectorAll(".units-btn button");
            buttons.forEach((button) => button.classList.remove("active"));

            element.classList.add("active");

            switch (id) {
                case 1:
                    // AÑADIMOS LOGICA
                    break;
                case 2:
                    // AÑADIMOS LOGICA
                    break;
                case 3:
                    // AÑADIMOS LOGICA
                    break;
                default:
                    break;
            }
        }
    </script>

</body>

</html>