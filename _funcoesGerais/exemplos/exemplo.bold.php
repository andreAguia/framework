<?php

echo str_repeat("=", 40);
br();
echo "Destaque sem acento e texto sem acento";

$texto = "A girafa é um mamífero de pescoço bem comprido";
$destaque = "girafa";

br(2);
echo "Texto: " . $texto;
br();
echo "Destaque: " . $destaque;
br();
echo "Resultado: " . bold($texto, $destaque);
br();

echo str_repeat("=", 40);
br();
echo "Destaque com acento e texto com acento";

$texto = "A girafa é um mamífero de pescoço bem comprido";
$destaque = "mamífero";

br(2);
echo "Texto: " . $texto;
br();
echo "Destaque: " . $destaque;
br();
echo "Resultado: " . bold($texto, $destaque);
br();

echo str_repeat("=", 40);
br();

echo "Destaque com acento e texto sem acento";

$texto = "A girafa é um mamifero de pescoço bem comprido";
$destaque = "mamífero";

br(2);
echo "Texto: " . $texto;
br();
echo "Destaque: " . $destaque;
br();
echo "Resultado: " . bold($texto, $destaque);
br();

echo str_repeat("=", 40);
br();

echo "Destaque sem acento e texto com acento  *** PROBLEMA ***";

$texto = "A girafa é um mamífero de pescoço bem comprido";
$destaque = "mamifero";

br(2);
echo "Texto: " . $texto;
br();
echo "Destaque: " . $destaque;
br();
echo "Resultado: " . bold($texto, $destaque);
br();

echo str_repeat("=", 40);
br();
