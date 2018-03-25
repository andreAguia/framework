<?php

# Informando a data final
$dataInicial = "05/06/2006";
$dataFinal = "24/07/2006";
echo dataDif($dataInicial,$dataFinal);

br();

# Não informando a data final
$dataInicial = "05/06/2006";
echo dataDif($dataInicial);