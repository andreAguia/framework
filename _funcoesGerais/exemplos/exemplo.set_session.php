<?php

# Nesse exemplo insere um valor em uma variável de sessão
$carro = "Ferrari";
set_session('carro', $carro);

# Agora pega o valor dessa sessão
$padrao = 'Fusca';
$novoCarro = get_session('carro', $padrao);

# Exibe o valor
echo $novoCarro;
