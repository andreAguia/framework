<?php

# Data anteior
$data = "05/12/2005";
if (jaPassou($data)) {
    echo "true";
} else {
    echo "false";
}
br();

# Data de hoje
$data = date("d/m/Y");
if (jaPassou($data)) {
    echo "true";
} else {
    echo "false";
}
br();

# Data posterior
$data = addDias(date("d/m/Y"), 20);
if (jaPassou($data)) {
    echo "true";
} else {
    echo "false";
}

