<?php
     require 'logica/conexion.php';
     getRealIP();
    function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
   
    return $_SERVER['REMOTE_ADDR'];
}

$dir = getRealIP();
//$dir="181.63.64.67";
$sql =mysqli_query($dblink, "SELECT * FROM ips WHERE direccion ='$dir'") or die(mysqli_error($dblink));
$row = mysqli_num_rows($sql);
 
if($row > 0){
  
   echo '<script language="javascript">alert("Al parecer ya realizaste un intento, pero si aún no te has registrado por favor registrate y participa por el sorteo");</script>';
  
   header ('Location: normal.html');
   throw new Exception(' Este usuario ya realizo un intento de juego ');
   
   
}
echo '<script language="javascript">alert("Solo tienes un intento, mucha suerte");</script>';
    echo "Solo tienes un intento, mucha suerte";
    $query = "INSERT INTO ips (direccion) VALUES(?)";
	
	$stmt =  mysqli_prepare($dblink, $query);
	mysqli_stmt_bind_param($stmt,'s',$dir);
    if(!mysqli_stmt_execute($stmt)){
        echo mysqli_error($dblink);
        }
        else{
        echo "bien";
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
            touch-action: none;
        }
    </style>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.6.2/dat.gui.min.js"></script>
    <script src="https://preview.babylonjs.com/ammo.js"></script>
    <script src="https://preview.babylonjs.com/cannon.js"></script>
    <script src="https://preview.babylonjs.com/Oimo.js"></script>
    <script src="https://preview.babylonjs.com/earcut.min.js"></script>
    <script src="https://preview.babylonjs.com/babylon.js"></script>
    <script src="https://preview.babylonjs.com/materialsLibrary/babylonjs.materials.min.js"></script>
    <script src="https://preview.babylonjs.com/proceduralTexturesLibrary/babylonjs.proceduralTextures.min.js"></script>
    <script src="https://preview.babylonjs.com/postProcessesLibrary/babylonjs.postProcess.min.js"></script>
    <script src="https://preview.babylonjs.com/loaders/babylonjs.loaders.js"></script>
    <script src="https://preview.babylonjs.com/serializers/babylonjs.serializers.min.js"></script>
    <script src="https://preview.babylonjs.com/gui/babylon.gui.min.js"></script>
    <script src="https://preview.babylonjs.com/inspector/babylon.inspector.bundle.js"></script>






</head>

<body>

   <canvas id="renderCanvas" ></canvas> <!--  touch-action="none" for best results from PEP -->

    <script>
        const canvas = document.getElementById("renderCanvas");
        var engine = null;
        var scene = null;
        var sceneToRender = null;
        var createDefaultEngine = function () {
            return new BABYLON.Engine(canvas, true, {
                preserveDrawingBuffer: true,
                stencil: false,
                disableWebGL2Support: true
            });
        };
        var dir ="<?php echo $dir; ?>";
        console.log(dir, "aca");
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
        // ramdom1 = 1; ramdom2 = 1; ramdom3 = 1;
        var tiempo = Math.floor(1);
        var fin = false;
        var fi2 = false;
        var fi3 = false;
        var alestop = 0;
        var sigui = false;
        var rodMesh = null;
        var home = null;
        var pley = false;
        var premio ="Nada";
        var gana=false;
        var datos="";
       
        var createScene = async function () {
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
            jugar.width = "381px";
            jugar.height = "142px";
            jugar.color = "white";
            jugar.cornerRadius = 20;
            //  menor.border = "0px";
            jugar.thickness = 0;
            jugar.verticalAlignment = BABYLON.GUI.Control.VERTICAL_ALIGNMENT_CENTER;
            jugar.horizontalAlignment = BABYLON.GUI.Control.HORIZONTAL_ALIGNMENT_CENTER;
            jugar.isEnabled = true;
            jugar.top = 150;
            jugar.onPointerClickObservable.add(function () {pley=true;son1.play();
                BABYLON.Engine.audioEngine.unlock();
                var music = new BABYLON.Sound("fondom", "textures/musica.mp3", scene, null, {
                loop: true,
                autoplay: true
            });
            });
            jugar.onPointerOutObservable.add(function () { jugar.alpha = 1; });
            jugar.onPointerEnterObservable.add(function () { jugar.alpha = 1; });
            
            advancedTexture.addControl(jugar);

            var intento = BABYLON.GUI.Button.CreateImageWithCenterTextButton(
                "si",
                "",
                "textures/registrar.png"
            );
            intento.width = "485px";
            intento.height = "101px";
            intento.color = "white";
            intento.cornerRadius = 20;
            intento.alpha = 0;
            intento.thickness = 0;
            intento.verticalAlignment = BABYLON.GUI.Control.VERTICAL_ALIGNMENT_CENTER;
            intento.horizontalAlignment = BABYLON.GUI.Control.HORIZONTAL_ALIGNMENT_CENTER;
            intento.isEnabled = false;
            intento.top = 320;
            intento.left = -220;
            intento.onPointerClickObservable.add(function () {pley=true;
                if(gana){datos= "ganaste.php?ip="+dir+ "&premio=" +premio;
                }else{datos= "normal.html?ip="+dir+ "&premio=" +premio;
                }
                enviar(datos);
            });
            intento.onPointerOutObservable.add(function () { intento.alpha = 1; });
            intento.onPointerEnterObservable.add(function () { intento.alpha = 1; });
            advancedTexture.addControl(intento);
            var contPal=381;
            var up=false;
        
            var palpitar = window.setInterval(() => {
               // console.log(contPal);
                if(!up){
                    contPal++;
                    if(contPal>400){
                        up = true;
                       
                    }
                    
                }
                else{
                    contPal--;
                    if(contPal<350){
                        up = false;
                    }
                    
                }
                jugar.width = contPal+"px";
            },10);
            var handle = window.setInterval(() => {
                if (pley && !alarma) {
                   // console.log("jugando");
                    rotar1 = rotar1 + 2;
                }


                if (rotar1 === 0) { rotar1 = 360; }
                if (!fin && !fi2 && !fi3) {
                    if (ramdom1 === 1 && !vandera) { vandera = true; }
                    if (ramdom1 === 2 && !vanderb) { vanderb = true; }
                    if (ramdom1 === 3 && !vanderc) { vanderc = true; }
                    if (ramdom1 === 4 && !vanderd) { vanderd = true; }
                    if (ramdom1 === 5 && !vandere) { vandere = true; }
                    if (ramdom1 === 6 && !vanderf) { vanderf = true; }
                    if (ramdom1 === 7 && !vanderg) { vanderg = true; }
                    if (ramdom1 === 8 && !vanderh) { vanderh = true; }
                    if (ramdom1 === 9 && !vanderi) { vanderi = true; }
                }
                if (fin && !fi2 && !fi3) {
                    if (ramdom2 === 1 && !vandera) { vandera = true; }
                    if (ramdom2 === 2 && !vanderb) { vanderb = true; }
                    if (ramdom2 === 3 && !vanderc) { vanderc = true; }
                    if (ramdom2 === 4 && !vanderd) { vanderd = true; }
                    if (ramdom2 === 5 && !vandere) { vandere = true; }
                    if (ramdom2 === 6 && !vanderf) { vanderf = true; }
                    if (ramdom2 === 7 && !vanderg) { vanderg = true; }
                    if (ramdom2 === 8 && !vanderh) { vanderh = true; }
                    if (ramdom2 === 9 && !vanderi) { vanderi = true; }
                }
                if (!fi3 && fi2) {
                    if (ramdom3 === 1 && !vandera) { vandera = true; }
                    if (ramdom3 === 2 && !vanderb) { vanderb = true; }
                    if (ramdom3 === 3 && !vanderc) { vanderc = true; }
                    if (ramdom3 === 4 && !vanderd) { vanderd = true; }
                    if (ramdom3 === 5 && !vandere) { vandere = true; }
                    if (ramdom3 === 6 && !vanderf) { vanderf = true; }
                    if (ramdom3 === 7 && !vanderg) { vanderg = true; }
                    if (ramdom3 === 8 && !vanderh) { vanderh = true; }
                    if (ramdom3 === 9 && !vanderi) { vanderi = true; }
                }

                if (!fin) { r1.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(rotar1), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
                if (!fi2) { r2.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(rotar1), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
                if (!fi3) { r3.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(rotar1), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            }, 1);
            var segundo = window.setInterval(() => {
                if (pley && !alarma) {
                    tiempo++;
                }
                if (tiempo === 5 || tiempo === 10){
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
                        gana=true;
                        son2.play();
                        jugar.children[0].source = "textures/ganaste.png";
                        intento.children[0].source = "textures/reclamar.png";
                        intento.alpha= 1; 
                        intento.isEnabled=true;
                        switch (ramdom1) {
                            case 1: console.log("Guantes"); premio="Guantes"; break;
                            case 2: console.log("Intercom");premio="Intercom"; break;
                            case 3: console.log("LLaves");premio="Candado"; break;
                            case 4: console.log("Maletero");premio="Maletero"; break;
                            case 5: console.log("Casco");premio="Casco"; break;
                            case 6: console.log("Bono");premio="Bono"; break;
                            case 7: console.log("netflix");premio="Netflix"; break;
                            case 8: console.log("recarga celu");premio="Recarga Celular"; break;
                            case 9: console.log("bono cagu");premio="Bono caju"; break;
                        }
                    }else{
                        gana=false;
                        console.log("perdiste");
                        jugar.children[0].source = "textures/sigue.png";
                        intento.alpha= 1; 
                        intento.isEnabled=true;
                    }
                }
                if(tiempo ===20){
                    console.log("fin de juego ",premio,dir);
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
                if (vandera) { mostrarA(rodMesh); }
                if (vanderb) { mostrarB(rodMesh); }
                if (vanderc) { mostrarC(rodMesh); }
                if (vanderd) { mostrarD(rodMesh); }
                if (vandere) { mostrarE(rodMesh); }
                if (vanderf) { mostrarF(rodMesh); }
                if (vanderg) { mostrarG(rodMesh); }
                if (vanderh) { mostrarH(rodMesh); }
                if (vanderi) { mostrarI(rodMesh); }

            }
            function toReset() {
                switch (alestop) {
                    case 1: rodMesh = r1; break;
                    case 2: rodMesh = r2; break;
                    case 3: rodMesh = r3; break;
                }

            }
            function toOk() {
                switch (alestop) {
                    case 1: fin = true; break;
                    case 2: fi2 = true; break;
                    case 3: fi3 = true; break;
                }
            }
            function enviar(data){
                window.location.href = "./" + data;
              //  window.location.href = "../edituser.php?documento=" + documento + "&puntaje=" + puntos + "&tiempo=" + cronometro; 
            }
            function mostrarA(meshRo) { meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            function mostrarB(meshRo) { meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(40), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            function mostrarC(meshRo) { meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(80), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            function mostrarD(meshRo) { meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(120), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            function mostrarE(meshRo) { meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(160), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            function mostrarF(meshRo) { meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(200), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            function mostrarG(meshRo) { meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(240), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            function mostrarH(meshRo) { meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(280), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            function mostrarI(meshRo) { meshRo.rotation = new BABYLON.Vector3(BABYLON.Tools.ToRadians(320), BABYLON.Tools.ToRadians(0), BABYLON.Tools.ToRadians(90)); }
            var distanciaObjeto = 0;
            var ancho = 10;
            var alto = 10;
            var alarma=false;
            scene.registerAfterRender(function () {
                if (canvas.width < canvas.height) {
                    ancho = 35 / (canvas.width) * 1000;
                    alto = 13.5 / (canvas.height) * -1000;
                    master.position = new BABYLON.Vector3(0, alto, ancho);
                   
                    if(alarma){
                        home.children[0].source = "textures/f1.png";
                        alarma=false;
                    }
                   if(!pley){
                     home.children[0].source = "textures/f1.png";
                     jugar.isEnabled=true;
                     jugar.alpha = 1;
                     
                   }
                    

                }else{
                    home.children[0].source = "textures/celular.jpg";
                    jugar.isEnabled=false;
                    intento.isEnabled=false;
                    jugar.alpha = 0;
                    intento.alpha=0;
                    alarma=true;
                }
                engine.resize();
            });


            return scene;

        };



        canvas.onresize = function () {
            engine.resize();
        };
        window.onresize = function () {
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
        engine.runRenderLoop(function () {
            if (sceneToRender) {
                sceneToRender.render();
            }
        });
        window.addEventListener("resize", function () {
            engine.resize();
        });

       

    </script>

</body>

</html>