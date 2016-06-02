<?php

# Callout do tipo secondary (default)
$painel1 = new Callout();
$painel1->set_title('Callout com tipo secondary');
$painel1->abre();

echo "Callout com tipo secondary";

$painel1 ->fecha();

# Callout do tipo primary
$painel2 = new Callout("primary");
$painel2->set_title('Painel com tipo primary');
$painel2->abre();

echo "Callout com tipo primary";

$painel2 ->fecha();

# Callout do tipo warning
$painel3 = new Callout("warning ");
$painel3->set_title('Painel com tipo warning ');
$painel3->abre();

echo "Callout com tipo warning ";

$painel3 ->fecha();

# Callout do tipo alert
$painel4 = new Callout("alert ");
$painel4->set_title('Painel com tipo alert ');
$painel4->abre();

echo "Callout com tipo alert ";

$painel4 ->fecha();

# Callout do tipo success 
$painel5 = new Callout("success  ");
$painel5->set_title('Painel com tipo success  ');
$painel5->abre();

echo "Callout com tipo success  ";

$painel5 ->fecha();
