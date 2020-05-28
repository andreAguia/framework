<?php

$browser = get_browserName();

# Exibindo simplesmente as informações do browser com print
print_r($browser);

br(2);

# Ou recuperando para usar em outro local
echo "Nome do navegador: " . $browser['browser'];
br();
echo "Versão: " . $browser['version'];
