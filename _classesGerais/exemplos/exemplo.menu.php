<?php

# Cria um menu 
$menu = new Menu();

$menu->add_item('titulo','Categoria 1');
$menu->add_item('link','Link 1','#');  
$menu->add_item('link','Link 2','#');
$menu->add_item('link','Link 3','#');
$menu->add_item('link','Link 4','#');
$menu->add_item('titulo','Categoria 2');
$menu->add_item('link','Link 1','#');  
$menu->add_item('link','Link 2','#');
$menu->add_item('link','Link 3','#');

$menu->show();

