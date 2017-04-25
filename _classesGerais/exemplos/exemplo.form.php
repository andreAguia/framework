<?php

# Formuário exemplo de login
$form = new Form('#','login');        
        
# usuário
$controle = new Input('usuario','numero','Matrícula (sem o dígito):',1);
$controle->set_size(20);
$controle->set_linha(1);
$controle->set_required(TRUE);
$controle->set_autofocus(TRUE);       
$controle->set_tabIndex(1);
$controle->set_placeholder('matrícula');
$controle->set_title('A matrícula do servidor sem o dígito verificador');
$form->add_item($controle);

# senha
$controle = new Input('senha','password','Senha:',1);
$controle->set_size(20);
$controle->set_linha(2);
$controle->set_required(TRUE);
$controle->set_tabIndex(2);
$controle->set_title('A senha da intranet');
$controle->set_placeholder('senha');
$form->add_item($controle);

# submit
$controle = new Input('submit','submit');
$controle->set_valor('Entrar');
$controle->set_linha(3);
$controle->set_tabIndex(3);
$controle->set_accessKey('E');
$form->add_item($controle);

$form->show();