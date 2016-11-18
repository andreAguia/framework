<?php

# Nesse exemplo exibe o valor default (padrão)
$padrao = "Girafa";
$valor = get('campoValor',$padrao);

echo $valor;