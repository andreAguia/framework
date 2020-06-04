<?php

# Abre o formulário
$form = new Form('#', 'exemplo');

# Nome
$controle = new Input('nome', 'texto', 'Nome:', 1);  // Dados básicos do controle
$controle->set_size(30);                          // Informa o tamanho. Observe que o maxlength não foi informado.
$controle->set_linha(1);                          // Informa a linha do controle
$controle->set_col(4);                            // Informa a quantidade de colunas usadas para esse controle.
$controle->set_required(true);                    // Informa que é obrigatório
$controle->set_autofocus(true);                   // Joga o foco para esse controle
$controle->set_tabIndex(1);                       // Primeiro controle do tab
$controle->set_placeholder('Nome do Servidor');   // Define a dica no corpo do controle
$controle->set_title('O nome do servidor');       // Define a dica no mouseover
$form->add_item($controle);                       // Adiciona ao form. Substitui o metodo show()
# Endereço
$controle = new Input('endereco', 'texto', 'Endereço:', 1);
$controle->set_size(50);
$controle->set_linha(1);                          // Mesma linha do controle acima
$controle->set_col(8);                            // A soma dos controle em uma linha deve dar 12
$controle->set_tabIndex(2);
$controle->set_placeholder('Endereço do Servidor');
$form->add_item($controle);

# CEP
$controle = new Input('cep', 'cep', 'Cep:', 1);
$controle->set_size(10);
$controle->set_linha(2);
$controle->set_col(2);                            // A soma dos controle em uma linha deve dar 12
$controle->set_tabIndex(3);
$controle->set_placeholder('Cep');
$controle->set_title('Cep');
$form->add_item($controle);

# Filhos
$controle = new Input('filhos', 'numero', 'Número de filhos:', 1);
$controle->set_size(10);
$controle->set_linha(2);
$controle->set_col(2);                            // A soma dos controle em uma linha deve dar 12
$controle->set_tabIndex(4);
$controle->set_placeholder('Filhos');
$controle->set_title('Quantidade de filhos');
$form->add_item($controle);

# Data
$controle = new Input('nascimento', 'data', 'Nascimento:', 1);
$controle->set_size(10);
$controle->set_linha(2);
$controle->set_col(3);                            // A soma dos controle em uma linha deve dar 12
$controle->set_tabIndex(5);
$controle->set_placeholder('Nascimento');         // Dependendo do browser o place hosder não funciona direito na data
$controle->set_title('Data de Nascimento');
$form->add_item($controle);

# cpf
$controle = new Input('cpf', 'cpf', 'Cpf:', 1);
$controle->set_size(10);
$controle->set_linha(2);
$controle->set_col(3);                            // A soma dos controle em uma linha deve dar 12
$controle->set_tabIndex(6);
$controle->set_placeholder('CPF');
$controle->set_title('Cpf do Servidor');
$form->add_item($controle);

# cor
$controle = new Input('cor', 'combo', 'Cor:', 1);
$controle->set_size(10);
$controle->set_linha(2);
$controle->set_col(2);                            // A soma dos controle em uma linha deve dar 12
$controle->set_tabIndex(7);
$controle->set_array(array(null, "azul", "verde", "preto", "rosa"));
$controle->set_placeholder('Cor');
$controle->set_title('Cor Preferida');
$form->add_item($controle);

$form->show();  // Exibe o formulário