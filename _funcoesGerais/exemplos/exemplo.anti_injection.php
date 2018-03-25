<?php

$texto = "select usuario from tbusuario";
echo anti_injection($texto);