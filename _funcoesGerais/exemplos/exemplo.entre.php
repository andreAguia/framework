<?php

# Data correta
$dataInicial = "05/12/2005";
$dataFinal = "12/08/2006";
$data = "03/03/2006";
if(entre($data,$dataInicial,$dataFinal)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

# Data anterior
$dataInicial = "05/12/2005";
$dataFinal = "12/08/2006";
$data = "03/03/2005";
if(entre($data,$dataInicial,$dataFinal)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

# Data posterior
$dataInicial = "05/12/2005";
$dataFinal = "12/08/2006";
$data = "13/08/2006";
if(entre($data,$dataInicial,$dataFinal)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();
