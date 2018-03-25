<?php

# Diversos cpf
$cpf1 = NULL;
$cpf2 = "";
$cpf3 = "136.737.784-63";
$cpf4 = "13673778463";

# Valor nulo
if(validaCpf($cpf1)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

# Valor vazio
if(validaCpf($cpf2)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

# CPF correto
if(validaCpf($cpf3)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

# CPF sem pontuação
if(validaCpf($cpf4)){
    echo "TRUE";
}else{
    echo "FALSE";
}
