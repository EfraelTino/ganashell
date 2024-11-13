<!DOCTYPE html>
<html>

<head>
    <title>Juego Honda Registrado</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />


    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/ya.css">

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


<body bgcolor=ecc626 onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">

    <div>
        <section >
            <div>
                <div class="centradoContenido">

                      
                  <div class="letras_info4">

                    <span >
                            <strong> 
                              
                                ya estas registrado

                            </strong>
                        </span>
                 </div>
                        

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