<?php

# conteúdo
$array = array(array("Botafogo", 10, 20),
    array("Flamengo", 10, 18),
    array("Vasco", 10, 16),
    array("Fluminense", 10, 10));

# Exemplo de tabela simples
$tabela = new Tabela();
$tabela->set_titulo("Tabela Simples");
$tabela->set_conteudo($array);
$tabela->set_label(array("Time", "Jogos", "Pontos"));
$tabela->set_width(array(80, 10, 10));
$tabela->set_align(array("left", "center", "center"));

$tabela->set_colunaSomatorio(1);
$tabela->set_textoSomatorio("Total de Jogos:");
$tabela->set_totalRegistro(FALSE);
$tabela->show();

# Exemplo com mais itens
$tabela = new Tabela();
$tabela->set_titulo("Tabela com mais itens");
$tabela->set_conteudo($array);
$tabela->set_label(array("Time", "Jogos", "Pontos"));
$tabela->set_width(array(80, 10, 10));
$tabela->set_align(array("left", "center", "center"));
$tabela->set_rodape("Esse é o rodapé da tabela");
$tabela->set_numeroOrdem(TRUE);
$tabela->show();

# Exemplo mais complexo
$tabela = new Tabela();
$tabela->set_titulo("Tabela mais complexa");
$tabela->set_conteudo($array);
$tabela->set_label(array("Time", "Jogos", "Pontos"));
$tabela->set_width(array(80, 10, 10));
$tabela->set_align(array("left", "center", "center"));
$tabela->set_rodape("Esse é o rodapé da tabela");
$tabela->set_numeroOrdem(TRUE);
$tabela->show();
