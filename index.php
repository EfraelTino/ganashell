<?php
require 'logica/conexion.php';
$ramdom = rand(9, 12);
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
//$dir="181.63.64.67";//$sql = mysqli_query($dblink, "SELECT * FROM ips WHERE direccion ='$dir' and premiu > 0") or die(mysqli_error($dblink));
$sql = mysqli_query($dblink, "SELECT count(direccion) as cont FROM ips WHERE direccion ='$dir'") or die(mysqli_error($dblink));
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
    $ramdom = rand(600, 620); //ya  participo

}

$query = "INSERT INTO ips (direccion, hora, premiu) VALUES(?,?,?)";
$stmt =  mysqli_prepare($dblink, $query);
mysqli_stmt_bind_param($stmt, 'ssi', $dir, $hora, $ramdom);

if (!mysqli_stmt_execute($stmt)) {
    echo mysqli_error($dblink);
}

$query = mysqli_query($dblink, "SELECT * FROM productosh where id ='$ramdom' and cantidad > 0 ") or die(mysqli_error($dblink));
$row = mysqli_num_rows($query);
if ($query) {

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

    mysqli_free_result($query);
}

if ($cantidad > 0) {
    $cantidad = $cantidad - 1;
    $stmt = $dblink->prepare("UPDATE `productosh` SET `cantidad` = ? WHERE id = ?  ");
    if (!$stmt) {
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
    <title>GanaShell</title>

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

    <canvas id="renderCanvas"></canvas> <!--  touch-action="none" for best results from PEP -->

    <script>
        const canvas = document.getElementById("renderCanvas");
        var engine = null;
        var scene = null;
        var sceneToRender = null;
        var createDefaultEngine = function() {
            return new BABYLON.Engine(canvas, true, {
                preserveDrawingBuffer: true,
                stencil: false,
                disableWebGL2Support: true
            });
        };
        var dir = "<?php echo $dir; ?>";
        var ramdom = "<?php echo $ramdom; ?>";
        var canti = "<?php echo $cantidad; ?>";
        console.log(ramdom);
        // console.log(dir, "aca");
        var rotar1 = 0;
        var vandera = false;
        var vanderb = false;
        var vanderc = false;
        var vanderd = false;
        var vandere = false;
        var vanderf = false;
        var vanderg = false;
        var vanderh = false;
        var vanderi = false;
        var rotarVelocidad = 1.0;

        var ramdom1 = Math.floor(Math.random() * (8 - 1) + 1);
        var ramdom2 = Math.floor(Math.random() * (8 - 1) + 1);
        var ramdom3 = Math.floor(Math.random() * (8 - 1) + 1);


        /*
         if(ramdom1==ramdom2){
            ramdom1=1; ramdom2=2;
             console.log("Cambio basico");
         };
         */

        //ramdom1=8;ramdom2=8;ramdom3=8;
        console.log("tiempo", ramdom1, ramdom2, ramdom3, canti);
        if (ramdom === 0 || ramdom > 13) {
            console.log("es Mayor y N");
            if (ramdom1 == ramdom2) {
                ramdom1 = 1;
                ramdom2 = 2;
                console.log("Cambio Mayor");
            } else {
                console.log("NO I");
            }
        } else {
            if (canti != 0) {
                console.log("------------------------- " + ramdom);
                switch (ramdom) {

                    case "1":
                        ramdom1 = 1;
                        ramdom2 = 1;
                        ramdom3 = 1;
                        break;
                    case "2":
                        ramdom1 = 2;
                        ramdom2 = 2;
                        ramdom3 = 2;
                        break;
                    case "3":
                        ramdom1 = 3;
                        ramdom2 = 3;
                        ramdom3 = 3;
                        break;
                    case "4":
                        ramdom1 = 4;
                        ramdom2 = 4;
                        ramdom3 = 4;
                        break;
                    case "5":
                        ramdom1 = 5;
                        ramdom2 = 5;
                        ramdom3 = 5;
                        break;
                    case "6":
                        ramdom1 = 6;
                        ramdom2 = 6;
                        ramdom3 = 6;
                        break;
                    case "7":
                        ramdom1 = 7;
                        ramdom2 = 7;
                        ramdom3 = 7;
                        break;
                    case "8":
                        ramdom1 = 8;
                        ramdom2 = 8;
                        ramdom3 = 8;
                        break;
                    case "9":
                        ramdom1 = 9;
                        ramdom2 = 9;
                        ramdom3 = 9;
                        break;
                    case "10":
                        ramdom1 = 3;
                        ramdom2 = 3;
                        ramdom3 = 3;
                        break;
                    case "11":
                        ramdom1 = 8;
                        ramdom2 = 8;
                        ramdom3 = 8;
                        break;

                }
            } else {
                console.log("NO A");
                switch (ramdom) {

                    case "1":
                        ramdom1 = 1;
                        ramdom2 = 3;
                        ramdom3 = 4;
                        break;
                    case "2":
                        ramdom1 = 5;
                        ramdom2 = 6;
                        ramdom3 = 7;
                        break;
                    case "3":
                        ramdom1 = 8;
                        ramdom2 = 9;
                        ramdom3 = 10;
                        break;
                    case "4":
                        ramdom1 = 11;
                        ramdom2 = 1;
                        ramdom3 = 2;
                        break;
                    case "5":
                        ramdom1 = 5;
                        ramdom2 = 5;
                        ramdom3 = 4;
                        break;
                    case "6":
                        ramdom1 = 6;
                        ramdom2 = 6;
                        ramdom3 = 7;
                        break;
                    case "7":
                        ramdom1 = 4;
                        ramdom2 = 7;
                        ramdom3 = 6;
                        break;
                    case "8":
                        ramdom1 = 7;
                        ramdom2 = 8;
                        ramdom3 = 5;
                        break;
                    case "9":
                        ramdom1 = 8;
                        ramdom2 = 9;
                        ramdom3 = 4;
                        break;
                    case "10":
                        ramdom1 = 1;
                        ramdom2 = 3;
                        ramdom3 = 2;
                        break;
                    case "11":
                        ramdom1 = 8;
                        ramdom2 = 8;
                        ramdom3 = 1;
                        break;

                }

            }

        }
        /*
         switch (ramdom){
                     
                 case "1": ramdom1=1;ramdom2=3;ramdom3=4; break;
                 case "2": ramdom1=5;ramdom2=6;ramdom3=7; break;
                 case "3": ramdom1=8;ramdom2=9;ramdom3=10; break;
                 case "4": ramdom1=11;ramdom2=1;ramdom3=2; break;
                 case "5": ramdom1=5;ramdom2=5;ramdom3=4; break;
                 case "6": ramdom1=6;ramdom2=6;ramdom3=7; break;
                 case "7": ramdom1=4;ramdom2=7;ramdom3=6; break;
                 case "8": ramdom1=7;ramdom2=8;ramdom3=5; break;
                 case "9": ramdom1=8;ramdom2=9;ramdom3=4; break;
                 case "10":ramdom1=1;ramdom2=3;ramdom3=2; break;
                 case "11":ramdom1=8;ramdom2=8;ramdom3=1; break;
                 
             }
        */
        console.log("tiempo", ramdom1, ramdom2, ramdom3, canti);
        var tiempo = Math.floor(1);
        var fin = false;
        var fi2 = false;
        var fi3 = false;
        var alestop = 0;
        var sigui = false;
        var rodMesh = null;
        var home = null;
        var pley = false;
        var premio = "Nada";
        var gana = false;
        var datos = "";

        var createScene = async function() {
            var scene = new BABYLON.Scene(engine);
            const camera = new BABYLON.ArcRotateCamera("camera", -Math.PI / 2, Math.PI / 2.5, 15, new BABYLON.Vector3(0, 0, 0));
            BABYLON.Engine.audioEngine.useCustomUnlockedButton = true;
            const light = new BABYLON.HemisphericLight("light", new BABYLON.Vector3(1, 1, 0));
            var rodillos = await BABYLON.SceneLoader.ImportMeshAsync("", "./scenes/", "slot.glb", scene);
            var master = rodillos.meshes[0];
            var r1 = rodillos.meshes[0].getChildren()[0];
            var r2 = rodillos.meshes[0].getChildren()[1];
            var r3 = rodillos.meshes[0].getChildren()[2];
            master.position = new BABYLON.Vector3(0, -3, 10);
            var son1 = new BABYLON.Sound("son1", "textures/rodillo.mp3", scene);
            var son2 = new BABYLON.Sound("son2", "textures/ganador.mp3", scene);
            materiales();

            function materiales() {
                let env = "textures/environmentSpecular.env";
                var caras = scene.getMaterialByName("rod");
                caras.albedoColor = new BABYLON.Color3.FromHexString("#ffffff");
                caras.albedoTexture = new BABYLON.Texture("scenes/ruleta.jpg");
                caras.reflectionTexture = new BABYLON.CubeTexture(env, scene);
                caras.roughness = 0.15;
                caras.metallic = 0.9;

            }



            //console.log("tiempo", ramdom1, ramdom2, ramdom3);
            var advancedTexture = BABYLON.GUI.AdvancedDynamicTexture.CreateFullscreenUI("U1");

            home = BABYLON.GUI.Button.CreateImageWithCenterTextButton(
                "bu",
                "",
                "textures/f1.png"
            );
            home.width = "100%";
            home.height = "100%";
            home.color = "white";
            home.border = "0px";
            home.thickness = 0;
            home.isEnabled = false;
            home.verticalAlignment = BABYLON.GUI.Control.VERTICAL_ALIGNMENT_CENTER;
            home.horizontalAlignment = BABYLON.GUI.Control.HORIZONTAL_ALIGNMENT_CENTER;
            advancedTexture.addControl(home);

            var jugar = BABYLON.GUI.Button.CreateImageWithCenterTextButton(
                "si",
                "",
                "textures/jugar.png"
            );
            jugar.width = "380px";
            jugar.height = "100px";
            jugar.color = "white";
            jugar.cornerRadius = 20;
            //  menor.border = "0px";
            jugar.thickness = 0;
            jugar.verticalAlignment = BABYLON.GUI.Control.VERTICAL_ALIGNMENT_CENTER;
            jugar.horizontalAlignment = BABYLON.GUI.Control.HORIZONTAL_ALIGNMENT_CENTER;
            jugar.isEnabled = true;
            jugar.top = "10%";
            jugar.onPointerClickObservable.add(function() {
                pley = true;
                son1.play();
                jugar.alpha=0;
                BABYLON.Engine.audioEngine.unlock();
                var music = new BABYLON.Sound("fondom", "textures/musica.mp3", scene, null, {
                    loop: true,
                    autoplay: true
                });
            });
            jugar.onPointerOutObservable.add(function() {
                jugar.alpha = 1;
            });
            jugar.onPointerEnterObservable.add(function() {
                jugar.alpha = 1;
            });

            advancedTexture.addControl(jugar);

            var intento = BABYLON.GUI.Button.CreateImageWithCenterTextButton(
                "si",
                "",
                "textures/registrar.png"
            );
            intento.width = "485px";
            intento.height = "176px";
            intento.color = "white";
            intento.cornerRadius = 20;
            intento.alpha = 0;
            intento.thickness = 0;
            intento.verticalAlignment = BABYLON.GUI.Control.VERTICAL_ALIGNMENT_CENTER;
            intento.horizontalAlignment = BABYLON.GUI.Control.HORIZONTAL_ALIGNMENT_CENTER;
            intento.isEnabled = false;
            intento.top = 250;
            intento.left = 0;
            intento.onPointerClickObservable.add(function() {
                pley = true;
                if (gana) {
                    datos = "ganaste.php?ip=" + dir + "&premio=" + premio + "&code=" + ramdom;
                } else {
                    datos = "normal.html?ip=" + dir + "&premio=" + "CascoZR" + "&code=" + ramdom;
                }
                enviar(datos);
            });
            intento.onPointerOutObservable.add(function() {
                intento.alpha = 1;
            });
            intento.onPointerEnterObservable.add(function() {
                intento.alpha = 1;
            });
            advancedTexture.addControl(intento);
            var contPal = 381;
            var up = false;

            var palpitar = window.setInterval(() => {
                // console.log(contPal);
                if (!up) {
                    contPal++;
                    if (contPal > 400) {
                        up = true;

                    }

                } else {
                    contPal--;
                    if (contPal < 350) {
                        up = false;
                    }

                }
                jugar.width = contPal + "px";
            }, 10);
            var handle = window.setInterval(() => {
                if (pley && !alarma) {
                    // console.log("jugando");
                    rotar1 = rotar1 + 10;
                }


                if (rotar1 === 0) {
                    rotar1 = 360;
                }
                if (!fin && !fi2 && !fi3) {
                    if (ramdom1 === 1 && !vandera) {
                        vandera = true;
                    }
                    if (ramdom1 === 2 && !vanderb) {
                        vanderb = true;
                    }
                    if (ramdom1 === 3 && !vanderc) {
                        vanderc = true;
                    }
                    if (ramdom1 === 4 && !vanderd) {
                        vanderd = true;
                    }
                    if (ramdom1 === 5 && !vandere) {
                        vandere = true;
                    }
                    if (ramdom1 === 6 && !vanderf) {
                        vanderf = true;
                    }
                    if (ramdom1 === 7 && !vanderg) {
                        vanderg = true;
                    }
                    if (ramdom1 === 8 && !vanderh) {
                        vanderh = true;
                    }
                    if (ramdom1 === 9 && !vanderi) {
                        vanderi = true;
                    }
                }
                if (fin && !fi2 && !fi3) {
                    if (ramdom2 === 1 && !vandera) {
                        vandera = true;
                    }
                    if (ramdom2 === 2 && !vanderb) {
                        vanderb = true;
                    }
                    if (ramdom2 === 3 && !vanderc) {
                        vanderc = true;
                    }
                    if (ramdom2 === 4 && !vanderd) {
                        vanderd = true;
                    }
                    if (ramdom2 === 5 && !vandere) {
                        vandere = true;
                    }
                    if (ramdom2 === 6 && !vanderf) {
                        vanderf = true;
                    }
                    if (ramdom2 === 7 && !vanderg) {
                        vanderg = true;
                    }
                    if (ramdom2 === 8 && !vanderh) {
                        vanderh = true;
                    }
                    if (ramdom2 === 9 && !vanderi) {
                        vanderi = true;
                    }
                }
                if (!fi3 && fi2) {
                    if (ramdom3 === 1 && !vandera) {
                        vandera = true;
                    }
                    if (ramdom3 === 2 && !vanderb) {
                        vanderb = true;
                    }
                    if (ramdom3 === 3 && !vanderc) {
                        vanderc = true;
                    }
                    if (ramdom3 === 4 && !vanderd) {
                        vanderd = true;
                    }
                    if (ramdom3 === 5 && !vandere) {
                        vandere = true;
                    }
                    if (ramdom3 === 6 && !vanderf) {
                        vanderf = true;
                    }
                    if (ramdom3 === 7 && !vanderg) {
                        vanderg = true;
                    }
                    if (ramdom3 === 8 && !vanderh) {
                        vanderh = true;
                    }
                    if (ramdom3 === 9 && !vanderi) {
                        vanderi = true;
                    }
                }

                if (!fin) {
                    r1.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(rotar1), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
                }
                if (!fi2) {
                    r2.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(rotar1), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
                }
                if (!fi3) {
                    r3.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(rotar1), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
                }
            }, 10);
            var segundo = window.setInterval(() => {
                if (pley && !alarma) {
                    tiempo++;
                }
                if (tiempo === 5 || tiempo === 10) {
                    son1.play();
                }

                if (tiempo === 5 || tiempo === 10 || tiempo === 15) {

                    alestop++;
                    revisar();
                    toOk();
                    borrar();
                }

                if (tiempo === 15) {
                    if (ramdom1 === ramdom2 && ramdom1 === ramdom3) {
                        gana = true;
                        son2.play();
                        intento.width = "473px";
                        intento.height = "142px";
                        jugar.children[0].source = "textures/ganaste.png";
                        intento.children[0].source = "textures/reclamar.png";
                        intento.alpha = 1;
                        intento.isEnabled = true;
                        switch (ramdom1) {
                            case 1:
                                console.log("Guantes");
                                premio = "Guantes Shaft";
                                break;
                            case 2:
                                console.log("Intercom");
                                premio = "Intercom Ultra X2";
                                break;
                            case 3:
                                console.log("Candado 512");
                                premio = "Candado BT 512";
                                break; // hay dos tipos 512 y 513
                            case 4:
                                console.log("Maletero");
                                premio = "Maletero Shad";
                                break;
                            case 5:
                                console.log("Casco");
                                premio = "Casco Integral NZ1";
                                break;
                            case 6:
                                console.log("Bono Exito");
                                premio = "Bono Exito Mercado OnLine";
                                break;
                            case 7:
                                console.log("netflix");
                                premio = "Netflix 53 días 1 pantalla";
                                break;
                            case 8:
                                console.log("recarga celu");
                                premio = "Nequi Daviplata 10k";
                                break; // dos recargas de 10 y de 5
                            case 9:
                                console.log("bono cagu");
                                premio = "Bono Rappi-Cangú";
                                break;
                            case 10:
                                console.log("Candado 514");
                                premio = "Candado BT 514 bullet";
                                break;
                            case 11:
                                console.log("bono cagu");
                                premio = "Recarga Nequi/DavidPlata 5K";
                                break;

                        }
                    } else {
                        gana = false;
                        console.log("perdiste");
                        jugar.children[0].source = "textures/sigue.png";
                        jugar.alpha=1;
                        intento.alpha = 1;
                        intento.isEnabled = true;
                        jugar.top = "7%";
                    }
                }
                if (tiempo === 20) {
                    console.log("fin de juego ", premio, dir);
                }

            }, 1000);

            function borrar() {
                vandera = false;
                vanderb = false;
                vanderc = false;
                vanderd = false;
                vandere = false;
                vanderf = false;
                vanderg = false;
                vanderh = false;
                vanderi = false;

            }

            function revisar() {
                toReset();
                if (vandera) {
                    mostrarA(rodMesh);
                }
                if (vanderb) {
                    mostrarB(rodMesh);
                }
                if (vanderc) {
                    mostrarC(rodMesh);
                }
                if (vanderd) {
                    mostrarD(rodMesh);
                }
                if (vandere) {
                    mostrarE(rodMesh);
                }
                if (vanderf) {
                    mostrarF(rodMesh);
                }
                if (vanderg) {
                    mostrarG(rodMesh);
                }
                if (vanderh) {
                    mostrarH(rodMesh);
                }
                if (vanderi) {
                    mostrarI(rodMesh);
                }

            }

            function toReset() {
                switch (alestop) {
                    case 1:
                        rodMesh = r1;
                        break;
                    case 2:
                        rodMesh = r2;
                        break;
                    case 3:
                        rodMesh = r3;
                        break;
                }

            }

            function toOk() {
                switch (alestop) {
                    case 1:
                        fin = true;
                        break;
                    case 2:
                        fi2 = true;
                        break;
                    case 3:
                        fi3 = true;
                        break;
                }
            }

            function enviar(data) {
                window.location.href = "./" + data;
                //  window.location.href = "../edituser.php?documento=" + documento + "&puntaje=" + puntos + "&tiempo=" + cronometro; 
            }

            function mostrarA(meshRo) {
                meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
            }

            function mostrarB(meshRo) {
                meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(40), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
            }

            function mostrarC(meshRo) {
                meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(80), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
            }

            function mostrarD(meshRo) {
                meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(120), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
            }

            function mostrarE(meshRo) {
                meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(160), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
            }

            function mostrarF(meshRo) {
                meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(200), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
            }

            function mostrarG(meshRo) {
                meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(240), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
            }

            function mostrarH(meshRo) {
                meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(280), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
            }

            function mostrarI(meshRo) {
                meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(320), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90));
            }
            var distanciaObjeto = 0;
            var ancho = 10;
            var alto = 10;
            var alarma = false;
            var relacion = 0;
            var relacio2 = 0;
            var multipli = 0;
            var multipl2 = 0;
            scene.registerAfterRender(function() {
                if (canvas.width < canvas.height) {

                    relacion = (canvas.height / canvas.width);

                    let sumA = relacion * 20;
                    let sumB = relacion * 4.25;

                    master.position = new BABYLON.Vector3(0, -sumB, sumA);
                    // console.log( relacion, sumB, sumA);
                    if (alarma) {
                        home.children[0].source = "textures/f1.png";
                        alarma = false;
                    }
                    if (!pley) {
                        home.children[0].source = "textures/f1.png";
                        jugar.isEnabled = true;
                        jugar.alpha = 1;

                    }


                } else {
                    home.children[0].source = "textures/celular.jpg";
                    jugar.isEnabled = false;
                    intento.isEnabled = false;
                    jugar.alpha = 0;
                    intento.alpha = 0;
                    alarma = true;
                }
                engine.resize();
            });
            var imag2 = new BABYLON.GUI.Image("buto", "textures/arriba.png");
            imag2.width = "75%";
            imag2.left = "10%";
            imag2.top = "-37%";
            imag2.populateNinePatchSlicesFromImage = true;
            imag2.stretch = BABYLON.GUI.Image.STRETCH_UNIFORM;
            imag2.verticalAlignment = BABYLON.GUI.VERTICAL_ALIGNMENT_BOTTOM;
            imag2.horizontalAlignment = BABYLON.GUI.HORIZONTAL_ALIGNMENT_CENTER;
            imag2.isEnabled = false;

            var image = new BABYLON.GUI.Image("buto", "textures/abajo.png");
            image.width = "75%";
            image.left = "10%";
            image.top = "33%";
            image.populateNinePatchSlicesFromImage = true;
            image.stretch = BABYLON.GUI.Image.STRETCH_UNIFORM;
            image.verticalAlignment = BABYLON.GUI.VERTICAL_ALIGNMENT_BOTTOM;
            image.horizontalAlignment = BABYLON.GUI.HORIZONTAL_ALIGNMENT_CENTER;
            image.isEnabled = false;
            // image.alpha = 0;
            advancedTexture.addControl(image);
            advancedTexture.addControl(imag2);

            return scene;

        };



        canvas.onresize = function() {
            engine.resize();
        };
        window.onresize = function() {
            engine.resize();
        };

        try {
            engine = createDefaultEngine();
        } catch (e) {
            console.log("la función createEngine disponible falló. Crear el motor predeterminado en su lugar");
            engine = createDefaultEngine();
        }
        if (!engine) throw 'el motor no debe ser nulo';
        scene = createScene();;
        scene.then(returnedScene => {
            sceneToRender = returnedScene;
        });
        engine.runRenderLoop(function() {
            if (sceneToRender) {
                sceneToRender.render();
            }
        });
        window.addEventListener("resize", function() {
            engine.resize();
        });
    </script>

</body>

</html>