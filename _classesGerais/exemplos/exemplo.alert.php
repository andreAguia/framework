<?php

# Exemplo utilizando todos os parâmetros
$msg1 = new Alert('O registro não pode ser excluído !!','left');
$msg1->set_tipo('alert');
$msg1->set_title('Informação do Sistema');
$msg1->set_page('#');
$msg1->show();

# Exemplo utilizando os mínimo de parâmetros
$msg2 = new Alert('O registro não pode ser excluído !!');
$msg2->show();