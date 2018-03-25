<?php

## Exemplo 1
echo "Exemplo 1";
br(2);

# Cria uma única coluna com tamanho 12
$grid1 = new Grid();
$grid1->abreColuna(12);

    $callout1 = new Callout('warning');
    $callout1->abre();
    echo "Grid com única coluna de tamanho 12";
    $callout1->fecha();
    
$grid1->fechaColuna();
$grid1->fechaGrid();

#####################################

## Exemplo 2
hr();
echo "Exemplo 2";
br(2);

# Grid com 2 colunas
$grid2 = new Grid();

# Coluna menor com 4 espaços
$grid2->abreColuna(4);
    
    $callout2 = new Callout('warning');
    $callout2->abre();
    echo "Grid com coluna de tamanho 4";
    $callout2->fecha();
    
$grid2->fechaColuna();

# Coluna maior com 8 espaços
$grid2->abreColuna(8);

    $callout3 = new Callout('warning');
    $callout3->abre();
    echo "Grid com coluna de tamanho 8";
    $callout3->fecha();
    
$grid2->fechaColuna();
$grid2->fechaGrid();

#####################################

## Exemplo 3
hr();
echo "Exemplo 3";
br(2);

# Cria duas colunas com tamanhos diferentes de acordo com o tamanho da tela (responsivo)
$grid3 = new Grid();

# Coluna com 4 espaços small
# Coluna com 3 espaços medium
# Coluna com 2 espaços large
$grid3->abreColuna(5,4,3);

    $callout4 = new Callout('warning');
    $callout4->abre();
    echo "Grid com coluna de tamanho 5, se tela for pequena";
    br();
    echo "Grid com coluna de tamanho 4, se tela for média";
    br();
    echo "Grid com coluna de tamanho 3, se tela for grande";
    $callout4->fecha();

$grid3->fechaColuna();

# Coluna com 8 espaços small
# Coluna com 9 espaços medium
# Coluna com 10 espaços large
$grid3->abreColuna(7,8,9);

    $callout5 = new Callout('warning');
    $callout5->abre();
    echo "Grid com coluna de tamanho 7, se tela for pequena";
    br();
    echo "Grid com coluna de tamanho 8, se tela for média";
    br();
    echo "Grid com coluna de tamanho 9, se tela for grande";
    $callout5->fecha();
    
$grid3->fechaColuna();
$grid3->fechaGrid();