var intRest = document.getElementById("intentos").value; //"<?php echo $cuantos; ?>";
//var canti; document.getElementById("cuantos").value; //"<?php echo $cuantos; ?>";
var dir = document.getElementById("dir").value; //"<?php echo $dir; ?>";
var ide = document.getElementById("id").value; // "<?php echo $id; ?>";
var premioB = document.getElementById("premio").value; //"<?php echo $premio ?>"
console.log(premioB);
var numero = NumerosAleatorios(1,12);

function NumerosAleatorios(min, max) {
    return Math.round(Math.random() * (max - min) + min);
 }