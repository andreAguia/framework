<?php

$data1 = "12/03/2014";
$data2 = "31/02/2004";
$data3 = "";
$data4 = NULL;
$data5 = "fdsçlfksçfso";
$data6 = "25/10/2018";
    
if(validaData($data1)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

if(validaData($data2)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

if(validaData($data3)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

if(validaData($data4)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

if(validaData($data5)){
    echo "TRUE";
}else{
    echo "FALSE";
}
br();

if(validaData($data6)){
    echo "TRUE";
}else{
    echo "FALSE";
}

