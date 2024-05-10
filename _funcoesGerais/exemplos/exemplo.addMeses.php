<?php

# Adiciona meses
$dataInicial = "12/09/2004";
$meses = 4;
echo addMeses($dataInicial, $meses, false);

br();

# Retira meses
$dataInicial = "15/12/2013";
$meses = -7;
echo addMeses($dataInicial, $meses, false);
