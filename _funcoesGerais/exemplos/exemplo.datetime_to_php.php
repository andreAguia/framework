<?php

# Nesse exemplo vamos transformar uma data  com hora
# que, supostamente, veio do banco de dados
$dataBanco = "2016-11-12 12:03:22";

# Preciso transformar para exibir no sistema
$dataBrasileira = datetime_to_php($dataBanco);

# Observe que como o separador 
# é igual ao padrão eu não precisei informá-lo
# caso não seja é necessário informá-lo

# Agora podemos exibir
echo $dataBrasileira;