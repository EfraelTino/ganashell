<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="upload2.php" method="POST" enctype="multipart/form-data">
        <span class="image">

            <input type="file" name="image" id="image" accept="image/*" capture="camera"
                style="display:none" required>

        </span>
        <label for="image">
            <span>
                Adjuntar factura
            </span>
        </label>
        <span>
            <input type="submit" name="submit" value="Enviar" class="boton_personalizado"
                onclick="error();">
        </span>
    </form>
    <script>
        function error() {
        //  window.location.href = "basico.html";
        var image = document.getElementById('image').value;
        if (image == "") {
            alert("Toma la foto de la factura para poder continuar");
            return false;
        }

    }
    </script>
</body>

</html>