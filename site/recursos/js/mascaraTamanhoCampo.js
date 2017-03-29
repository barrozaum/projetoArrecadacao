function preencheZeros (obj, tam)
{
  var  qtd_zeros, zeros, i;
  qtd_zeros = (tam - obj.value.length);
  zeros = '';
  for (i = 1; i <= qtd_zeros; i++) {
       zeros='0'+zeros;
  }
  obj.value = zeros+obj.value;
 }