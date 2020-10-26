// Almacenamos en un array todos los <td> con la clase color
// Armamos una funcion para completar el array
// Si la persona perdio peso este se pinta de verde, de lo contrario se pinta de rojo
var td = document.getElementsByClassName('color');
var contenido = [];
for(i=0; i<td.length; i++)
{
    contenido.push(td[i].outerText);
    if(parseInt(td[i].outerText) < 0)
    {
        td[i].classList.add('text-success');
    }
    else
    {
        td[i].classList.add('text-danger');
    }
}

// Obtenemos los valores del imc para pintar de amarillo, verde o rojo
// segun corresponda a la escala
var imc = document.getElementById('imc').outerText;
var txt = document.getElementById('escala');
var imcColor = document.getElementById('imc');

if(parseInt(imc) < 18.5){
    imcColor.classList.add('text-warning');
    txt.classList.add('text-warning');
} 
else if (parseInt(imc) >= 18.5 && parseInt(imc) < 25) 
{
    imcColor.classList.add('text-success');
    txt.classList.add('text-success');
} 
else 
{
    imcColor.classList.add('text-danger');
    txt.classList.add('text-danger');
}

function eliminar(id){
    alert("Hola Estoy Eliminando" + id);
    var id = id;

    $.ajax({
        type:"POST",
        url:"home.php",
        data: {idregistro: id},
        
    })
} 
