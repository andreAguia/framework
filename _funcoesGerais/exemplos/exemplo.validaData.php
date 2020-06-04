<?php

$data1 = "12/03/2014";
$data2 = "31/02/2004";
$data3 = "";
$data4 = null;
$data5 = "fdsçlfksçfso";
$data6 = "25/10/2018";

if (validaData($data1)) {
    echo "true";
} else {
    echo "false";
}
br();

if (validaData($data2)) {
    echo "true";
} else {
    echo "false";
}
br();

if (validaData($data3)) {
    echo "true";
} else {
    echo "false";
}
br();

if (validaData($data4)) {
    echo "true";
} else {
    echo "false";
}
br();

if (validaData($data5)) {
    echo "true";
} else {
    echo "false";
}
br();

if (validaData($data6)) {
    echo "true";
} else {
    echo "false";
}

