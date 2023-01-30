<?php

class Tab {

    /**
     * Cria uma tab de conteúdo. 
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     */
    private $tabs = array();         // array O texto das tabs
    private $contadorConteudo = 1;
    private $ativo = 1;

###########################################################    

    public function __construct($tabs = null, $ativo = 1) {

        # Guarda o array de abas 
        $this->tabs = $tabs;
        
        # Guarda o número da aba ativa
        $this->ativo = $ativo;
        
        # Inicia o código das abas
        echo "<div class='row'>";
        echo "<div class='columns'>";

        echo "<ul class='tabs' data-tabs id='example-tabs'>";

        $contador = 1;

        foreach ($tabs as $item) {
            echo "<li ";

            if ($contador == $ativo) {
                echo "class='tabs-title is-active'>";
            } else {
                echo "class='tabs-title'>";
            }

            echo "<a href='#panel{$contador}'";

            if ($contador == $ativo) {
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

        echo "<div class='tabs-panel";

        if ($this->contadorConteudo == $this->ativo) {
            echo " is-active'";
        }
        
        echo "' id='panel{$this->contadorConteudo}'>";

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
