<?php

# Nesse exemplo exibe o valor default (padrão)
$padrao = "Girafa";
$valor = post('campoValor',$padrao);

echo $valor;