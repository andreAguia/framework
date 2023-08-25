<?php

class TitleBar {

    /**
     * Exibe uma barra onde se pode incluir links, botões e controles 
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @var private $label string null Texto que aparecerá na barra.
     * @var private $title string null Texto exibido no mouseover
     * 
     * @example exemplo.topbar.php
     */
    private $label = null;
    private $title = null;

###########################################################

    public function __construct($label = null, $title = null) {
        /**
         * Método construtor que inicia a classe e informa o label da barra
         * 
         * @param $label string null Texto a ser exibodo do lado esquerdo.
         * 
         * @syntax $bar = new TopBar([$label]); 
         */
        $this->label = $label;
        $this->title = $title;
    }

###########################################################

    public function show() {

        /**
         * Exibe a barra
         *  
         * @syntax $bar->show();
         */
        # Verifica se existe title
        if (empty($this->title)) {
            $this->title = $this->label;
        }

        echo "<div class='title-bar' title='{$this->title}'>";
        echo "<div class='title-bar-title' title='{$this->title}'>";
        echo $this->label;
        echo "</div></div>";
    }
}
