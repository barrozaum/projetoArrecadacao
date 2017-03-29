//seleciona o campo do select escolhido
function selecionar(campo, valor)
{
    var combo = document.getElementById(campo);

    for (var i = 0; i < combo.options.length; i++)
    {
        if (combo.options[i].value == valor)
        {
            combo.options[i].selected = "true";
            break;
        }
    }
}
