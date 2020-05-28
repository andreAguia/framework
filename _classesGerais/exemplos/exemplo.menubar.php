<?php

# Cria um menu
$menu = new MenuBar();

# Botão voltar
$botao1 = new Button("Voltar", "#");
$botao1->set_title('Volta para a página anterior');
$botao1->set_accessKey('V');
$menu->add_link($botao1, "left");

# Botão incluir
$botao2 = new Button("Incluir", "#");
$botao2->set_title('Incluir um Registro');
$botao2->set_accessKey('I');
$menu->add_link($botao2, "right");

# Botão excluir
$botao3 = new Button("Excluir", "#");
$botao3->set_title('Excluir um Registro');
$botao3->set_accessKey('E');
$menu->add_link($botao3, "right");

# Botão histórico
$botao4 = new Button("Histórico", "#");
$botao4->set_title('Histórico');
$botao4->set_accessKey('H');
$menu->add_link($botao4, "right");

$menu->show();
