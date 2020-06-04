<?php

class Callout {

    /**
     * Cria um painel com borda (container) para se adicionar conteúdo.
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @note Utiliza o tipo callout do framework Zurb Foundation
     * @note A cor do painel é definida pelo tipo do callout: secondary | primary | success | warning | alert
     * 
     * @example exemplo.callout.php
     */
    private $tipo = "secondary";    // string O tipo do callout: secondary | primary | success | warning | alert
    private $title = null;          // string O Texto para o evento mouseover
    private $id = null;             // string O id para o css
    private $botaoFechar = false;   // bool   Se terá ou não um botão (X) para fechar 

###########################################################

    public function __construct($tipo = "secondary", // string O tipo do callout: secondary | primary | success | warning | alert
            $id = null) {            // string O id para o css
        /**
         * Inicia o Callout informando o tipo
         * 
         * @syntax $callout = new Callout([$tipo],[$id]);
         */

        $this->tipo = $tipo;
        $this->id = $id;
    }

###########################################################

    public function set_id($id = null) { // string O nome do id
        /**
         * Informa o id da div para o css
         * 
         * @syntax $callout->set_id($id);
         */

        $this->id = $id;
    }

###########################################################

    public function set_title($title = null) { // string O texto a ser exibido
        /**
         * Informa o texto no mouse over
         * 
         * @syntax $callout->set_title($title);
         */

        $this->title = $title;
    }

###########################################################

    public function set_botaoFechar($botaoFechar = false) { // bool Exibe ou não o botão
        /**
         * Informa se terá um botão de fechar o callout
         * 
         * @syntax $callout->set_botaoFechar($botaoFechar);
         */

        $this->botaoFechar = $botaoFechar;
    }

###########################################################

    public function abre() {
        /**
         * Inicia a abertura do Callout para inserção do conteúdo
         *
         * @syntax $callout->abre();
         */
        # abre a div 
        echo '<div class="callout ' . $this->tipo . '"';

        if (!is_null($this->id)) {
            echo ' id="' . $this->id . '"';
        }

        if (!is_null($this->title)) {
            echo ' title="' . $this->title . '"';
        }

        if ($this->botaoFechar) {
            echo ' data-closable';
        }

        echo '>';
    }

###########################################################

    public function fecha() {
        /**
         * Fecha um Callout aberto
         * 
         * @syntax $callout->fecha();
         */
        # Exibe o botão de fechar        
        if ($this->botaoFechar) {
            echo '<button class="close-button" aria-label="Dismiss alert" type="button" data-close>';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
        }
        echo '</div>';
    }

}
