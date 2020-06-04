<?php

# Diversos cpf
$cpf1 = null;
$cpf2 = "";
$cpf3 = "136.737.784-63";
$cpf4 = "13673778463";

# Valor nulo
if (validaCpf($cpf1)) {
    echo "true";
} else {
    echo "false";
}
br();

# Valor vazio
if (validaCpf($cpf2)) {
    echo "true";
} else {
    echo "false";
}
br();

# CPF correto
if (validaCpf($cpf3)) {
    echo "true";
} else {
    echo "false";
}
br();

# CPF sem pontuação
if (validaCpf($cpf4)) {
    echo "true";
} else {
    echo "false";
}
