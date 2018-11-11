<?php

# Cria um menu com 3 colunas
$menu = new MenuGrafico(3);

# Sistema GRH
$botao1 = new BotaoGrafico();
$botao1->set_label('Sistema de Pessoal');
$botao1->set_url('#');
$botao1->set_title('Acessa o Sistema de Pessoal');
$botao1->set_imagem(PASTA_FIGURAS.'pessoais.jpg',40,40); 
$menu->add_item($botao1);

# Solicitação de Férias
$botao2 = new BotaoGrafico();
$botao2->set_label('Solicitação de Férias');
$botao2->set_url('#');
$botao2->set_imagem(PASTA_FIGURAS.'solicitaFerias.jpg',40,40);
$botao2->set_title('Solicita férias');                
$menu->add_item($botao2);

# Rotina de Alterar Senha
$botao3 = new BotaoGrafico();
$botao3->set_label('Alterar Senha');
$botao3->set_url('#');
$botao3->set_imagem(PASTA_FIGURAS.'trocarSenha.jpg',40,40);
$botao3->set_title('Altera a senha de acesso');            
$menu->add_item($botao3);

$menu->show();

