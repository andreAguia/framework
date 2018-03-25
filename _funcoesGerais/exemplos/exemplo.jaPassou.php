<?php

# Data anteior
$data = "05/12/2005";
if(jaPassou($data)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

# Data de hoje
$data = date("d/m/Y");
if(jaPassou($data)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

# Data posterior
$data = addDias(date("d/m/Y"),20);
if(jaPassou($data)){
    echo "TRUE";
}else{
    echo "FALSE";
}

