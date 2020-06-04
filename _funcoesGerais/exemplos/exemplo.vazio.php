<?php

# Diversos valores
$a = null;
$b = "";
$c = " ";

# Valor nulo
if (vazio($a)) {
    echo "true";
} else {
    echo "false";
}
br();

# Valor vazio
if (vazio($b)) {
    echo "true";
} else {
    echo "false";
}
br();

# Valor espaço
if (vazio($c)) {
    echo "true";
} else {
    echo "false";
}

