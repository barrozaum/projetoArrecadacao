function formatarValor(campo, separador_milhar, separador_decimal, tecla) {
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    //var whichCode = (window.Event) ? tecla.which : tecla.keyCode;
    var whichCode = tecla.keyCode ? tecla.keyCode : tecla.which ? tecla.which : tecla.charCode;

    //alert(whichCode)
    if (whichCode == 9)
        return true; // Tecla Tab
    if (whichCode == 13)
        return true; // Tecla Enter
    if (whichCode == 8)
        return true; // Tecla Delete
    key = String.fromCharCode(whichCode); // Pegando o valor digitado
    if (strCheck.indexOf(key) == -1)
        return false; // Valor inválido (não inteiro)
    len = campo.value.length;
    for (i = 0; i < len; i++)
        if ((campo.value.charAt(i) != '0') && (campo.value.charAt(i) != separador_decimal))
            break;
    aux = '';
    for (; i < len; i++)
        if (strCheck.indexOf(campo.value.charAt(i)) != -1)
            aux += campo.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0)
        campo.value = '';
    if (len == 1)
        campo.value = '0' + separador_decimal + '0' + aux;
    if (len == 2)
        campo.value = '0' + separador_decimal + aux;

    if (len > 2) {
        aux2 = '';

        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += separador_milhar;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }

        campo.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
            campo.value += aux2.charAt(i);
        campo.value += separador_decimal + aux.substr(len - 2, len);
    }

    return false;
}

function formata(texto, casas)
{
    var menos = 0;
    texto = String(texto);

    if (texto.indexOf('-') >= 0) {
        texto = texto.substring(1, texto.length);
        menos = 1;
    }

    while (texto.indexOf('.') >= 0)
        texto = apaga(texto, texto.indexOf('.'));
    while (texto.indexOf(',') >= 0)
        texto = apaga(texto, texto.indexOf(','));

    while (texto.charAt(0) == '0')
        texto = texto.substring(1, texto.length);

    while (texto.length < 3)
        texto = '0' + texto;

    texto = insere(texto, '.', texto.length - 2);
    while (texto.indexOf('.') > 3)
        texto = insere(texto, '.', texto.indexOf('.') - 3);
    texto = texto.substring(0, texto.length - 3) + ',' + texto.substring(texto.length - 2, texto.length);

    if (menos > 0)
        texto = '-' + texto;

    return(texto);
}

function insere(original, novo, onde)
{
    return original.substring(0, onde) + novo + original.substring(onde, original.length);
}

function apaga(a, x)
{
    if (x == 0)
        return a.substring(1);
    else
        return a.substr(0, x) + a.substring(x + 1);
}


function formatarValor_5Casas(campo, separador_milhar, separador_decimal, tecla) {
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	//var whichCode = (window.Event) ? tecla.which : tecla.keyCode;
	var whichCode = tecla.keyCode ? tecla.keyCode : tecla.which ? tecla.which : tecla.charCode;

	//alert(whichCode)
	if (whichCode == 9) return true; // Tecla Tab
	if (whichCode == 13) return true; // Tecla Enter
	if (whichCode == 8) return true; // Tecla Delete
	key = String.fromCharCode(whichCode); // Pegando o valor digitado
	if (strCheck.indexOf(key) == -1) return false; // Valor inválido (não inteiro)
	len = campo.value.length;
	for(i = 0; i < len; i++)
	if ((campo.value.charAt(i) != '0') && (campo.value.charAt(i) != separador_decimal)) break;
	aux = '';
	for(; i < len; i++)
	if (strCheck.indexOf(campo.value.charAt(i))!=-1) aux += campo.value.charAt(i);
	aux += key;
	len = aux.length;
	if (len == 0) campo.value = '';
	if (len == 1) campo.value = '0'+ separador_decimal + '0000' + aux;
	if (len == 2) campo.value = '0'+ separador_decimal + '000' + aux;
	if (len == 3) campo.value = '0'+ separador_decimal + '00' + aux;
	if (len == 4) campo.value = '0'+ separador_decimal + '0' + aux;
	if (len == 5) campo.value = '0'+ separador_decimal + aux;
        

	if (len > 5) {     
		aux2 = '';

		for (j = 0, i = len - 6; i >= 0; i--) {       
			if (j == 3) {
				aux2 += separador_milhar;
				j = 0;
			}
			aux2 += aux.charAt(i);
			j++;
		}

		campo.value = '';
		len2 = aux2.length;
		for (i = len2 - 1; i >= 0; i--)
		campo.value += aux2.charAt(i);
		campo.value += separador_decimal + aux.substr(len - 5, len);   
	}

	return false;
}