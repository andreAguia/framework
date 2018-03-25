<?php

# Considerando o primeiro dia
$dataInicial = "12/09/2004";
$dias = 30;
echo addDias($dataInicial,$dias);

br();

# Desconsiderando o primeiro dia
$dataInicial = "12/09/2004";
$dias = 30;
echo addDias($dataInicial,$dias,FALSE);