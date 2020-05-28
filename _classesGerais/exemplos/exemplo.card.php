<?php

# Card 1
$card = new Card('Cabeçalho do Card', 'Rodapé do Card');
$card->set_title('Esse Card está Funcionando');
$card->abre();

echo "Este texto está dentro do Card!";
br();
echo "Aqui pode ter qualquer coisa !!";

$card->fecha();

br();

# Card 2
$card = new Card('Card sem rodapé');
$card->set_title('Esse Card está Funcionando');
$card->set_color('yellow');
$card->abre();

echo "Este texto está dentro do Card!";
br();
echo "Aqui pode ter qualquer coisa !!";
br(2);

$card->fecha();

br();

# Card 3
$card = new Card(NULL, 'Card sem cabeçalho');
$card->set_title('Esse Card está Funcionando');
$card->set_color('red');
$card->abre();

br();
echo "Este texto está dentro do Card!";
br();
echo "Aqui pode ter qualquer coisa !!";

$card->fecha();

br();

# Card 4
$card = new Card();
$card->abre();

br();
echo "Esse Card não Ttem nem Cabeçalho nem rodapé'";
br();
echo "Aqui pode ter qualquer coisa !!";
br(2);

$card->fecha();
