<?php

# Nesse exemplo vamos transformar uma data 
# para, supostamente, inserir em um banco de dados
$dataBrasileira = "12/11/2016";

# Preciso transformar para inserir no banco de dados
$dataBanco = date_to_bd($dataBrasileira);

# Observe que como o separador 
# é igual ao padrão eu não precisei informá-lo

# Agora podemos inserir ao banco
echo $dataBanco;