<?php

# Retirando aspas simples
$texto = "O Coração está 'saindo pela boca'";
echo $texto;
br();
echo retiraAspas($texto);

br(2);

# Retirando aspas duplas
$texto = 'Arlete leu o livro: "Só o Vento Sabe a Resposta"';
echo $texto;
br();
echo retiraAspas($texto);
