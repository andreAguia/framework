<?php

# Topbar        
$top = new TopBar("Menu Principal");
$top->set_title("Área de Cadastro");

# Variavel da pesquisa
$value = "";

# Coloca o campo de pesquisa
$top->add_pesquisa("Pesquisar por Nome:", $value);

$top->show();
