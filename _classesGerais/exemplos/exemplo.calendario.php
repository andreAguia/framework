<?php

# Calendário pequeno com Mês e ano atual.
$cal = new Calendario();
$cal->show();

# Calendário grande com Mês e ano atual.
$cal = new Calendario();
$cal->set_tamanho("g");
$cal->show();

# Calendário pequeno do mês de Maio do ano atual.
$cal = new Calendario(5);
$cal->show();

# Calendário pequeno com mês e ano informados
$cal = new Calendario(1, 1987);
$cal->show();
