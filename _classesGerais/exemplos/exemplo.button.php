<?php

# Exemplo de link comum
$link = new Button("Salvar","#");
$link->set_accessKey("S");
$link->set_id("linkAzul");
$link->show();

echo "<br/>";

# Exemplo de link abrindo jscript
$linkBotaoHistorico = new Button("Histórico");
$linkBotaoHistorico->set_title('Exibe o histórico');
$linkBotaoHistorico->set_onClick("abreFechaDivId('divHistorico');");
$linkBotaoHistorico->set_accessKey('H');
$linkBotaoHistorico->show();

