<?php
require 'logica/conexion.php';
$ramdom = rand(1, 12);
//$ramdom=10;
$cantidad = 0;

function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
}
date_default_timezone_set('America/Bogota');
$hora = date('m-d-Y h:i:s', time());
$dir = getRealIP();
$opor = 0;
$dir = getRealIP();

//SELECT * FROM productoss where id ='5' and cantidad > 0;
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
    }else{
        $ramdom = $ramdom+50;
    }
    mysqli_free_result($query);
} 

//SELECT count(direccion) as cont FROM ips WHERE direccion ='::1' and premiu<13
       //SELECT count(direccion) as cont FROM ips WHERE direccion ='::1'
    //$dir="181.63.64.67";//$sql = mysqli_query($dblink, "SELECT * FROM ips WHERE direccion ='$dir' and premiu > 0") or die(mysqli_error($dblink));
    $sql = mysqli_query($dblink, "SELECT count(direccion) as cont FROM ips WHERE direccion ='$dir' and premiu<13") or die(mysqli_error($dblink));
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
        $ramdom = $ramdom+100; // rand(600, 620); //ya  participo

    }

    $query = "INSERT INTO ips (direccion, hora, premiu) VALUES(?,?,?)";
    $stmt =  mysqli_prepare($dblink, $query);
    mysqli_stmt_bind_param($stmt, 'ssi', $dir, $hora, $ramdom);

    if (!mysqli_stmt_execute($stmt)) {
        echo mysqli_error($dblink);
    }

?>
<!DOCTYPE html>
<html>

<head>
    <title>Inscripción Gana Shell</title>
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
            window.addEventListener('popstate', function() {
                history.pushState(null, null, document.URL);
            });
        }

        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };

        window.location.hash = "no-back-button";
        window.location.hash = "Again-No-back-button"; //again because google chrome don't insert first hash into history
        window.onhashchange = function() {
            window.location.hash = "no-back-button";
        }

        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>
</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
    <div>
        <section class="tecnica tecnica--margin-auto">
            <div class="contenedor">

                <div class="elemento">
                    <header class="header">
                        <img src="./textures/header.webp" alt="Imagen header">
                    </header>
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <br>
                        <span class="letras_info">
                            <strong> Registra tus datos, adjunta una foto de la factura de compra para validar tu premio*, un asesor se comunicará contigo para entregar tu premio en los próximos 15 días hábiles y participa en el sorteo de diez motos Honda CB125F, tres televisores Samsung, tres neveras Samsung y dos viajes al gran premio Formula 1 Qatar.</strong>
                        </span>
                        <table>


                            <tr NOWRAP>
                                <p class="letras_text">Nombre y apellido</p>
                            </tr>
                            <tr><label for="nombre"></label>
                                <input class="intp" name="nombre" type="text" id="nombre" required>
                            </tr>



                            <tr>
                                <p class="letras_text">Documento &nbsp; </p>
                            </tr>
                            <tr align="left"><label for="nombre"></label>
                                <input class="intp" name="documento" type="number" id="documento" required>
                            </tr>



                            <tr>
                                <p class="letras_text">Ciudad</p>
                            </tr>
                            <tr align="left"><label for="nombre"></label>
                                <input class="intp" name="ciudad" type="text" id="ciudad" required>
                            </tr>


                            <tr>
                                <p class="letras_text">Celular</p>
                            </tr>
                            <tr align="left"><label for="nombre"></label>
                                <input class="intp" class="numero" name="celular" type="number" id="celular" required>
                            </tr>


                            <tr>
                                <p class="letras_text">Correo</p>
                            </tr>
                            <tr align="left"><label for="nombre"></label>
                                <input class="intp" name="email" type="email" id="email" required>
                            </tr>



                            <tr NOWRAP>
                                <p class="letras_text">Tipo de vehículo</p>
                            </tr>
                            <tr align="left"><label for="nombre"></label>
                                <input class="intp" name="moto" type="text" id="moto" required>
                            </tr>
    

                            <tr>
                                <p class="letras_text">Kilometraje</p>
                            </tr>
                            <tr align="left"><label for="nombre"></label>
                                <input class="intp" name="kilometraje" type="number" id="kilometraje" required>
                            </tr>

                            <tr>
                                <p class="letras_text">Tipo de producto Shell</p>
                            </tr>
                            <tr align="left"><label for="shell"></label>
                                <input class="intp" name="shell" type="text" id="shell" required>
                            </tr>
                            
                            <tr>
                                <p class="letras_text">Cantidad Litros</p>
                            </tr>
                            <tr align="left"><label for="nombre"></label>
                                <input class="intp" class="numero" name="cuantos" type="number" id="cuantos" required>
                            </tr>
                        </table>
                        <tr>
                            <p class="letras_text2" style="display: none">No </p>
                            <div><input style="display: none" size="22px" name="premio" type="text" id="premio" readonly
                                    value="<?php echo $ramdom; ?>"></div>
                        </tr>
                        <span>
                        </span>
                        <span class="image">

                            <input type="file" name="image" id="image" accept="image/*" capture="camera"
                                style="display:none">

                        </span>
                        <label for="image">
                            <span >
                                Adjuntar factura
                            </span>
                        </label>
                        <br>
                        <label style="font-size: 10px;">*sujeto a verificacion de la factura</label>
                        <div style="padding: 5px"></div>
                        <label class="letras_infoA">
                            <strong onclick="ubicar()"><a href="">Términos y condiciones</a></strong>
                        </label>
                        <span class="palomitas letras_info2" ;>
                            <input type="checkbox" name="ok" value="si" required
                                oninvalid="this.setCustomValidity('Acepta las políticas')"
                                onchange="this.setCustomValidity('')" />&nbsp; Sí. Autorizo el tratamiento de mis datos
                            personales.&nbsp;&nbsp;&nbsp;<br>

                            <input type="checkbox" name="ok2" value="no" required
                                oninvalid="this.setCustomValidity('Acepta los términos')"
                                onchange="this.setCustomValidity('')" />&nbsp; Acepto los terminos y condiciones de la
                            promoción.
                        </span>
                        <span>
                            <input type="submit" name="submit" value="Enviar" class="boton_personalizado"
                                onclick="error();">
                        </span>
                    </form>
                    <footer class="footer">
                        <img src="./textures/footer.webp" alt="Imagen footer">
                    </footer>
                </div>
            </div>
        </section>
        <div class="window-notice" id="window-notice" style="overflow-y:auto;">
            <div class="content">
                <div class="content-text">
                    <p style="text-align:justify">

                        <strong>REGLAMENTO DE TERMINOS Y CONDICIONES DEL JUEGO PROMOCIONAL “COMPRA, INSCRÍBITE Y
                            GANA”</strong><br><br>




                        <strong>MECÁNICA DEL JUEGO PROMOCIONAL</strong><br>

                        1. Todas las personas en cualquier lugar de Colombia que compren lubricante AGH podrán
                        participar para ganar premios con el “compra, inscribirte y gana” y adicional participar por el
                        sorteo de una moto HONDA CB190R TRICOLOR Modelo 2021. Esto aplica para las compras validas de
                        lubricante AGH, por cada producto comprado una persona tiene la posibilidad de jugar una sola
                        vez con la factura correspondiente que demuestre la compra del mismo, fraudes detectados como
                        varios intentos de juego con el mismo código o el uso indebido de las facturas en mas de un
                        registro, será causal de anulación y cancelación del participante y no se hará entrega de ningún
                        premio, la marca se reserva el derecho de notificar a la persona este hecho de fraude.<br>
                        2. Raspa el collarín de la botella de lubricantes AGH, escanea el Código QR que se encuentra
                        impreso y accede a la página web de la promoción.<br>
                        3. El consumidor debe dar CLICK en “JUGAR” para girar una ruleta virtual y participar por
                        premios.<br>
                        4. En el momento que la ruleta virtual se detenga sabrá si es un ganador de alguno de los
                        premios que serán escogidos aleatoriamente por parte del sistema.<br>
                        5. Si la ruleta virtual se detiene con la combinación de varios premios se le invita a seguir
                        intentando en su próxima compra, tendrá la posibilidad de seguir al siguiente paso donde podrá
                        registrar sus datos personales para participar en el sorteo de una moto HONDA CB190R TRICOLOR
                        Modelo 2021, el sorteo se realizará al finalizar la actividad promocional.<br>
                        6. Con Triple “PREMIO” en la ruleta, es un posible ganador de alguno de los siguientes premios:
                        ACC-INTERCOMUNICADOR PARA MOTO ULTRA X2 (15 unidades), GUANTES PARA MOTO-SHAFT 325-TL (30
                        unidades),
                        CASCO PARA MOTO NZ1-FUSION-BLTL (45 unidades), MALETERO PARA MOTO SHADSH-33 (15 unidades),
                        CANDADO-BULLET 514 PARA MOTO (300 unidades), Bono Rappi Pay de $50.000 (50 unidades), Bono Éxito
                        de $30.000 (200 unidades), Tarjeta Netflix de $20.000 (60 unidades), Recarga de celular de
                        $10.000 (1.500 unidades) y Recarga de celular de $5.000 (5.000 unidades); para un total de 7.216
                        premios.<br>
                        7. Los ganadores deben registrarse y llenar el formulario con sus datos personales, adjuntar
                        foto de la factura de compra del lubricante y seguir los pasos en la plataforma.
                        8.Uno de nuestros asesores se estará comunicando en los próximos 30 días despues de participar
                        para confirmar sus datos personales y la legalidad de la factura adjunta para poder hacer
                        entrega del
                        premio que le corresponde.<br>
                        9. Con solo el hecho de participar en la actividad podrá inscribirse en el sorteo de una moto
                        HONDA CB190R Modelo 2021. Después de llenar sus datos personales, la plataforma automáticamente
                        le indicará un número de boleto único con el que quedará inscrito para participar el día del
                        sorteo.<br>
                        10. En caso de que la factura no sea legible en la foto o no corresponda a compras reales de
                        lubricantes AGH, automáticamente será eliminado de los ganadores de premios o concursantes para
                        el sorteo de la moto CB190R TRICOLOR Modelo 202
                        <br><br>

                        <strong>DETALLES DEL SORTEO FINAL</strong><br>


                        1. El sorteo de la moto HONDA CB190R TRICOLOR Modelo 2021, se realizará el 27 de Noviembre de
                        2021 a las 3:00 PM, Vía Streaming (visualización de videos y audio en tiempo real y transmisión
                        en directo), por medio de la página web www.puntoarcade.com donde se anunciará al ganador y se
                        explicarán las reglas y condiciones del sorteo antes de dar inicio.<br>
                        2. Los registros de los clientes participantes se guardan automáticamente en una base de datos,
                        que se descargará en una plataforma privada en la cual se realizará el sorteo aleatorio de la
                        moto Honda.<br>
                        3. Cada participante tiene un número consecutivo el cual le arrojo la plataforma el día de su
                        registro y con el cual entrarán a participar en el sorteo. En vivo y en directo la plataforma
                        usará una fórmula “Aleatoria” la cual generará un número aleatorio y se ordenará de forma
                        descendente por el número generado y se tomará como ganador la primera posición. Adicional se
                        sacará un suplente y hasta un tercer suplente posicionado en caso de no encontrar al ganador
                        inicial o que este se rehúse a recibir el premio a futuro. De acuerdo con el artículo 2.7.4.10
                        del Decreto 1068 de 2015 asistirá un delegado de Coljuegos.<br>
                        4. El moderador encargado del programa en vivo, le contactará por teléfono con máximo 3 intentos
                        de llamada telefónica al primer ganador, de no poder contactar al titular se procederá a llamar
                        al suplente y así consecutivamente hasta lograr contactar al ganador definitivo.<br>
                        5. Un único ganador se llevará la moto HONDA CB190R TRICOLOR Modelo 2021. El premio se entregará
                        en el concesionario de Supermotos Honda más cercano a su domicilio a los 30 días siguientes de
                        que se validen los datos correspondientes al ganador.<br>
                        6. El ganador deberá firmar los documentos de aceptación del premio y presentarse con cédula de
                        ciudadanía o de extranjería original de ser el caso el día de la entrega de la moto, no tendrá
                        validez ningún otro documento. En caso de que el ganador respectivo no reclame el premio durante
                        los siguientes 30 días posteriores al día correspondiente de la entrega, que sus datos no
                        correspondan con los que se registraron en la plataforma para participar o se niegue a firmar el
                        documento de aceptación del premio y de asumir el valor de la ganancia ocasional o demás gastos
                        que le corresponden, se otorgará el premio al ganador que haya quedado como segundo suplente o
                        de ser el caso en tercer suplente en el sorteo realizado.<br>
                        7. El nuevo ganador tendrá las mismas obligaciones indicadas en estos términos. SA Producción de
                        eventos & publicidad SAS comunicará telefónicamente Si no fuere localizado o no cumple con los
                        requisitos reglamentarios
                        para recibir el premio, de dicha circunstancia se dejará constancia en el acta de anulación de
                        la
                        actividad. Los organizadores no tendrán la obligación de investigar los motivos por los cuales
                        una persona no es contactada en el número de teléfono registrado o sus datos no concuerdan con
                        el registro respectivo o base de datos, ni tampoco el motivo de no aceptación de los premios.
                        Estos términos estarán publicados en la plataforma donde se realiza la actividad. El solo hecho
                        de participar implica la total aceptación de las bases del sorteo, así como las decisiones del
                        organizador.<br><br>


                        <strong>CONDICIONES GENERALES:</strong><br>


                        1 Se hará entrega de un solo premio por factura de compra.<br>
                        2 Los premios del juego promocional de la ruleta virtual se estarán entregando en las fechas
                        correspondientes de los presorteos, una vez se registre el ganador en la plataforma.<br>
                        3 Las imágenes de los premios son de referencia y pueden cambiar en color, marca y diseño
                        teniendo en cuenta la disponibilidad del inventario.<br>
                        4 El solo hecho de participar en el presente sorteo, cada concursante que se registre acepta
                        quedar registrado inmediatamente en la base de datos de SA Producción de eventos & publicidad
                        SAS, para recibir por correo electrónico o mensaje instantáneo ofertas, promociones de la marca
                        o recordatorios de la hora y el día del sorteo.<br>
                        5 Incluye transporte hasta el lugar de la entrega formal, matrícula oficial de la moto,
                        traspaso, impuestos y SOAT por el primer año, por tanto, el ganador del sorteo no deberá asumir
                        dichos gastos. De ser necesario el traslado de la moto a su domicilio debe asumir el costo de
                        dicho transporte.<br>
                        6 El ganador de la motocicleta debe tener licencia de conducción vigente con categoría para
                        conducirla y debe encontrarse a paz y salvo por concepto de multas o comparendos ante el
                        organismo de transito correspondiente, ya que de otra manera no podrá ser entregado el
                        premio.<br>
                        7 El impuesto generado de ganancia ocasional, conforme a la legislación vigente correrá por
                        cuenta del ganador de la moto.<br>
                        8 Este sorteo está autorizado por COLJUEGOS.<br>
                        9 Para peticiones, quejas, reclamos y/o consultas acerca del tratamiento de información personal
                        o de la actividad puede realizarlo a través de
                        correo electrónico administracion@saproduccion.com<br><br>



                        <strong>CONDICIONES Y RESTRICCIONES PARA PARTICIPAR DEL JUEGO PROMOCIONAL “COMPRA, INSCRÍBETE Y
                            GANA”</strong><br>

                        La participación de los interesados, así como la actividad y el premio, están sujetos a las
                        condiciones y restricciones que se indican en estos términos. Cualquier situación que no se
                        encuentre prevista en el presente reglamento, será resuelto por los organizadores. Deberá
                        existir total coincidencia entre los datos brindados para participar y el documento de
                        identificación del ganador, de otro modo el premio no será entregado. La responsabilidad de
                        FABRICA NACIONAL DE AUTOPARTES S.A. FANALCA S.A. y SA Producción de eventos & publicidad S.A.S,
                        culmina con la entrega del premio. El ganador exime de toda responsabilidad a los organizadores
                        del uso o destinación que diere al premio, más aún si se tratare de actividades ilícitas o que
                        atenten contra la ley y/o las buenas costumbres. El ganador recibirá su premio y no se admiten
                        cambios por dinero, valores o cualquier otro producto material. Si no acepta el premio o sus
                        condiciones, este premio se considera renunciado y extinguido en relación con el ganador y no
                        tendrá derecho a reclamo o indemnización alguna, ni siquiera parcialmente. El ganador deberá
                        firmar conforme al recibido de su premio.
                        El derecho del premio no es transferible, negociable, ni puede ser comercializado o canjeado por
                        dinero en efectivo, ni por ningún otro premio. El premio es entregado únicamente a la persona
                        ganadora. SA Producción de eventos & publicidad SAS es el único administrador y organizador de
                        la presente actividad y sorteo.
                        La actividad promocional tiene cobertura en todo el territorio nacional. Podrán participar en la
                        actividad únicamente personas mayores de 18 años, deberán tener cédula de ciudadanía o de ser el
                        caso, cédula de extranjería, la cual deberá presentarse si es acreedor del premio. Toda persona
                        que desee participar en la
                        actividad o reclamar el premio, deberá tener conocimiento de este reglamento, ya que la
                        aceptación y recibo del premio conlleva a la forzosa e ineludible obligación de conocer las
                        condiciones de participación, así como las condiciones, limitaciones y responsabilidades, no
                        solo de este reglamento, sino las que en virtud de este mismo documento conlleva el reclamo y
                        aceptación del premio.<br><br>


                        <strong>POLÍTICA PARA EL TRATAMIENTO DE DATOS PERSONALES</strong><br>

                        Al diligenciar esta plataforma con sus datos personales, usted en calidad de titular de la
                        información; autoriza que sus datos sean tratados exclusivamente para contactarlo y serán
                        almacenados en nuestra base de datos. En caso de aceptar el uso de datos, al dar Click en
                        ACEPTO, autoriza de manera libre, previa, expresa e informada el tratamiento de sus datos
                        personales a las empresas: FABRICA NACIONAL DE AUTOPARTES S.A. FANALCA S.A. con Nit 890301886-1
                        y a SA Producción de eventos & publicidad SAS con Nit 900.867.150-2 y/o a la persona natural o
                        jurídica a quién este encargue, a recolectar, almacenar, utilizar, circular, suprimir y en
                        general, a realizar cualquier otro tratamiento a los datos personales por usted suministrados,
                        para todos aquellos aspectos inherentes al presente concurso y/o actividad promocional, lo que
                        implica el uso de los datos en actividades de mercadeo, enviar información comercial,
                        publicitaria, noticias, novedades, promociones sobre los servicios que ofrecen las sociedades
                        mencionadas, a través de correo electrónico, teléfono fijo, celular, uso de cookies, mensajería
                        instantánea, redes sociales, web Messenger, y/o envío de información impresa.
                        La información personal que suministra, circulará de manera restringida y podrá ser transmitida
                        y utilizada por las empresas mencionadas anteriormente, en el marco del artículo 26 de la Ley
                        1581 de 2016 y demás normatividad vigente que regule la materia, cumpliendo con todas las
                        medidas de privacidad, seguridad física, técnica y administrativa para evitar su perdida,
                        adulteración, uso fraudulento o no adecuado.
                        La supresión de la información se generará en caso de que no preexista la finalidad para la cual
                        se solicitaron los datos, conforme a las autorizaciones, contratos y/o acuerdos que el titular
                        previamente haya autorizado, o en caso de que el titular solicite la supresión de la
                        información. El titular tiene derecho a conocer, actualizar, y corregir sus datos personales,
                        así mismo, podrá solicitar la supresión o revocar la autorización otorgada para su
                        tratamiento.<br><br>



                        <strong>DERECHOS DE IMAGEN</strong><br>

                        Con el hecho de participar en la actividad, el ganador de manera libre, expresa, voluntaria e
                        informada, acepta y autoriza a FABRICA NACIONAL DE AUTOPARTES S.A. FANALCA S.A. con Nit
                        890301886-1 y a SA Producción de eventos & publicidad SAS con Nit 900.867.150-2 y/o a la persona
                        natural o jurídica a quien encargue, para que incluya en cualquier soporte audiovisual que sus
                        nombres, ideas e imágenes aparezcan en los programas, en transmisiones en vivo, publicaciones y
                        demás medios publicitarios y en general en todo material de divulgación con los fines
                        promocionales que los organizadores deseen hacer durante el evento o una vez finalizado el
                        mismo, sin que ello implique la obligación de remunerarlos o compensarlos adicionalmente. Así
                        mismo, renuncia a cualquier reclamo por derechos de imagen. Por virtud de esta autorización el
                        ganador declara que es el propietario integral de los derechos sobre el contenido audiovisual y
                        en consecuencia garantizan que pueden otorgar la presente autorización sin limitación alguna,
                        exonerando de cualquier responsabilidad a FABRICA NACIONAL DE AUTOPARTES S.A. FANALCA S.A. y a
                        SA Producción de eventos & publicidad SAS.<br><br>

                        <strong>SUSPENSIÓN DE LA ACTIVIDAD</strong><br>

                        En caso de haber motivos fundados en: fuerza mayor, caso fortuito, o hechos de terceros, tales
                        como desastres naturales, guerras, huelgas o disturbios, o restricciones a la movilización o
                        cualquier decreto gubernamental a causa del COVID 19, así como también situaciones que afecten
                        la actividad; o en caso de detectarse un fraude o intento de fraude en perjuicio de los
                        organizadores o los participantes de la misma, SA Producción de eventos y publicidad SAS, podrá
                        modificar en todo o en parte esta actividad, así como suspenderlo temporal o permanentemente sin
                        asumir ninguna responsabilidad al respecto. En estos casos, el fundamento de las medidas que se
                        adopten, así como las pruebas que demuestren la existencia de la causa invocada por los
                        organizadores estarán a disposición de cualquier interesado.

                        <br><br>

                    </p>

                </div>
                <div class="content-buttons"><a href="#" id="close-button"
                        style="color:#FF0000; text-decoration: underline;" onclick="ubicar()"><strong>CONTINUAR</strong>
                    </a></div>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->


</body>

</html>
<script type="text/javascript">
    var ventana;
    var x = document.getElementById("window-notice");
    ubicar();

    function ubicar() {

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
    var dir = "<?php echo $dir; ?>";
    var ramdom = "<?php echo $ramdom; ?>";
    var canti = "<?php echo $cantidad; ?>";
    console.log(ramdom);
</script>