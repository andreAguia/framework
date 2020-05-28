<?php

$valor1 = 123;              // Número normal
$valor2 = "12.234,89";      // Formato brasileiro
$valor3 = "12.34";          // Formato americano
# Normal para formato moeda brasileiro
echo formataMoeda($valor1);
br();

# Note o erro: informou-se um valor no formato brasileiro, mas não especificou o parâmetro formato de saída.
# Assim pegou-se um número no format brasileiro e converteu-se para o formato brasileiro.
echo formataMoeda($valor2);
br();

# O correto seria informar, no parâmetro formato, o valor 2.
# Dessa forma o sistema entenderia que o formato de entrada é o brasileiro
# E que o desejado é transformá-lo para o formato americano.
echo formataMoeda($valor2, 2);
br();

# Valor no formato americano será convertido corretamente para o formato brasileiro.
echo formataMoeda($valor3);
