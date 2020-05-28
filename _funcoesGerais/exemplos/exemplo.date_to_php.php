<?php

# Nesse exemplo vamos transformar uma data 
# que, supostamente, veio do banco de dados
$dataBanco = "2016-11-12";

# Preciso transformar para exibir no sistema
$dataBrasileira = date_to_php($dataBanco);

# Observe que como o separador 
# é igual ao padrão eu não precisei informá-lo
# caso não seja é necessário informá-lo
# Agora podemos exibir
echo $dataBrasileira;
