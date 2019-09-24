<?php

# Calendário pequeno
$cal = new Calendario();
$cal->show();

# Calendário grande
$cal = new Calendario();
$cal->set_tamanho("g");
$cal->show();

# Calendário pequeno com mês
$cal = new Calendario(5);
$cal->show();

# Calendário pequeno com mês e ano
$cal = new Calendario(5,1987);
$cal->show();
