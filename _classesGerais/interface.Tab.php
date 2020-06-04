<?php

class Tab {

    /**
     * Cria um fieldset. 
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @example exemplo.fieldset.php
     */
    private $tabs = array();         // array O texto das tabs
    private $contadorConteudo = 1;

###########################################################    

    public function __construct($tabs = null) {

        $this->tabs = $tabs;
        echo "<div class='row'>";
        echo "<div class='columns'>";

        echo "<ul class='tabs' data-tabs id='example-tabs'>";

        $contador = 1;

        foreach ($tabs as $item) {
            echo "<li ";

            if ($contador == 1) {
                echo "class='tabs-title is-active'>";
            } else {
                echo "class='tabs-title'>";
            }

            echo "<a href='#panel{$contador}'";

            if ($contador == 1) {
                echo "aria-selected='true'";
            }

            echo ">";

            echo $item;

            echo "</a>";
            echo "</li>";
            $contador++;
        }

        echo "</ul>";

        echo "<div class='tabs-content' data-tabs-content='example-tabs'>";
    }

###########################################################

    public function abreConteudo() {

        echo "<div ";

        if ($this->contadorConteudo == 1) {
            echo "class='tabs-panel is-active' id='panel1'>";
        } else {
            echo "class='tabs-panel' id='panel{$this->contadorConteudo}'>";
        }

        $this->contadorConteudo++;
    }

    ###########################################################

    public function fechaConteudo() {

        echo '</div>';
    }

    ###########################################################

    public function show() {

        echo "</div>";
        echo "</div>";

        echo "</div>";
        echo "</div>";
    }

}
