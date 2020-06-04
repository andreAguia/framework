<?php

class Fieldset {

    /**
     * Cria um fieldset. 
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @example exemplo.fieldset.php
     */
    private $legend = null;         // string O texto do item legend do fieldset
    private $id = null;             // string O id para o css
    private $class = "fieldset";    // string A classe para o css

###########################################################    

    public function __construct($legend = null, // string O texto do item legend do fieldset
            $id = null) {    // string O id para o css
        /**
         * Inicia a classe atribuindo um valor do legend e do id
         * 
         * @syntax $field = new Fieldset([$legend], [$id]);
         */

        $this->legend = $legend;
        $this->id = $id;
    }

###########################################################

    public function set_class($class = null) {   // string A classe para o css
        /**
         * Informa o nome da class para o css
         * 
         * @syntax $field->set_class($class);
         */

        $this->title = $class;
    }

###########################################################

    public function abre() {
        /**
         * Abre um fieldset
         * 
         * @syntax $field->abre();
         */
        echo '<fieldset class="' . $this->class . '"';

        if (!is_null($this->id)) {
            echo ' id="' . $this->id . '"';
        }
        echo '>';

        if (!is_null($this->legend)) {
            echo '<legend>' . $this->legend . '</legend>';
        }
    }

    ###########################################################

    public function fecha() {
        /**
         * Fecha um fieldset
         * 
         * @syntax $field->fecha();
         */
        echo '</fieldset>';
    }

}
