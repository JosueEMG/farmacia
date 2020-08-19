$(document).ready(function () {
    let funcion="listar";
    $.post('../controlador/VentaController.php',{funcion},(response)=>{
        console.log(JSON.parse(response));
    })
})