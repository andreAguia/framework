<?php

class Callout
{    
    /**
     * Cria um container Callout.
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @note Um painel onde a cor é definida pelo tipo do callout: secondary | primary | success | warning | alert
     * 
     * @example exemplo.callout.php
     */
    
    private $tipo = "secondary";    // string O tipo do alert (callout): secondary | primary | success | warning | alert
    private $title = NULL;          // string O Texto para o evento mouseover
    private $id = NULL;             // string O id para o css
    private $botaoFechar = FALSE;   // bool   Se terá ou não botão de fechar

###########################################################

    public function __construct($tipo = "secondary", $id = NULL){
    /**
     * Inicia o Callout informando o tipo
     * 
     * @param $tipo  string secondary O tipo do alert (callout): secondary | primary | success | warning | alert
     * @param $id    string NULL      O id para o css
     * 
     * @syntax $callout = new Callout([$tipo],[$id]);
     */
    
    	$this->tipo = $tipo;
        $this->id = $id;
    }
    
###########################################################

    public function set_id($id = NULL){
    /**
     * Informa o id da div para o css
     * 
     * @syntax $callout->set_id($id);
     * 
     * @param $id string NULL O nome do id
     */
    
        $this->id = $id;
    }

###########################################################

    public function set_title($title = NULL){
    /**
     * Informa o texto no mouse over
     * 
     * @syntax $callout->set_title($title);
     * 
     * @param $title string NULL O texto a ser exibido
     */
    
        $this->title = $title;
    }

###########################################################

    public function set_botaoFechar($botaoFechar = FALSE){
    /**
     * Informa se terá um botão de fechar o callout
     * 
     * @syntax $callout->set_botaoFechar($botaoFechar);
     * 
     * @param $botaoFechar bool FALSE TRUE/FALSE Exibe ou não o botão
     */
    
        $this->botaoFechar = $botaoFechar;
    }

###########################################################

    public function abre(){	
    /**
     * Inicia a abertura do Callout para inserção do conteúdo
     *
     * @syntax $callout->abre();
     */
    
        # abre a div 
        echo '<div class="callout '.$this->tipo.'"';
        
        if (!is_null($this->id)){
            echo ' id="'.$this->id.'"';
        }
        
        if (!is_null($this->title)){
            echo ' title="'.$this->title.'"';
        }
        
        if ($this->botaoFechar){
            echo ' data-closable';
        }
        
        echo '>';
    }

###########################################################

    public function fecha(){
    /**
     * Fecha um Callout aberto
     * 
     * @syntax $callout->fecha();
     */
        
        # Exibe o botão de fechar        
        if ($this->botaoFechar){
            echo '<button class="close-button" aria-label="Dismiss alert" type="button" data-close>';
            echo '<span aria-hidden="TRUE">&times;</span>';
            echo '</button>';
        }        
        echo '</div>';
    }
}