<?php

class Div {

    /**
     * Cria um container div
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @example exemplo.div.php
     */
    private $class = null;      // string A classe para o css.
    private $id = null;         // string O id para o css.
    private $title = null;      // string O texto para o evento mouseover.
    private $onClick = null;    // string Rotina jscript a ser executada no evento onclick.

###########################################################

    public function __construct($id = null, // string O id para o css.
            $class = null) {     // string A classe para o css.
        /**
         * Inicia a div informando o id e a classe para o css
         * 
         * @syntax $div = new Div($id,[$class]);
         */

        $this->id = $id;
        $this->class = $class;
    }

###########################################################

    public function set_title($title = null) {   // string O texto para o evento mouseover.
        /**
         * Informa o texto no mouse over
         * 
         * @syntax $div->set_title($title);
         */

        $this->title = $title;
    }

###########################################################

    public function set_onClick($onClick = null) {   // string A rotina jscript a ser executada no evento onclick.
        /**
         * Informa a rotina jscript a ser executada no evento onclick.
         * 
         * @syntax $div->set_onClick($onClick);
         */

        $this->onClick = $onClick;
    }

###########################################################

    public function abre() {
        /**
         * Inicia a abertura da div para inserção do conteúdo
         *
         * @syntax $div->abre();
         */
        # abre a div 
        echo '<div';

        # id
        if (!is_null($this->id)) {
            echo ' id="' . $this->id . '"';
        }

        # class
        if (!is_null($this->class)) {
            echo ' class="' . $this->class . '"';
        }

        # title
        if (!is_null($this->title)) {
            echo ' title="' . $this->title . '"';
        }

        # onClick
        if (is_null($this->onClick)) {
            echo ' onclick="' . $this->onClick . '"';
        }
        echo '>';
    }

###########################################################

    public function fecha() {
        /**
         * Fecha uma div aberta
         * 
         * @syntax $div->fecha();
         */
        echo '</div>';
    }

}
