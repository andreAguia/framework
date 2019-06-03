<?php

class Callout
{    
    /**
     * Cria um painel com borda (container) para se adicionar conteúdo.
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @var private $tipo        string secondary O tipo do callout: secondary | primary | success | warning | alert
     * @var private $title       string NULL      O Texto para o evento mouseover
     * @var private $id          string NULL      O id para o css
     * @var private $botaoFechar BOLL   FALSE     Se terá ou não botão de fechar 
     * 
     * @note Utiliza o tipo callout do framework Zurb Foundation
     * @note A cor do painel é definida pelo tipo do callout: secondary | primary | success | warning | alert
     * 
     * @example exemplo.callout.php
     */
    
    private $tipo = "secondary";
    private $title = NULL;
    private $id = NULL;
    private $botaoFechar = FALSE;

###########################################################

    public function __construct($tipo = "secondary", $id = NULL){
    /**
     * Inicia o Callout informando o tipo
     * 
     * @param $tipo string secondary O tipo do callout: secondary | primary | success | warning | alert
     * @param $id   string NULL      O id para o css
     * 
     * @syntax $callout = new Callout([$tipo],[$id]);
     */
    
    	$this->tipo = $tipo;
        $this->id = $id;
    }
    
###########################################################

    public function set_id($id = NULL){ // string O nome do id
    /**
     * Informa o id da div para o css
     * 
     * @syntax $callout->set_id($id);
     */
    
        $this->id = $id;
    }

###########################################################

    public function set_title($title = NULL){ // string O texto a ser exibido
    /**
     * Informa o texto no mouse over
     * 
     * @syntax $callout->set_title($title);
     */
    
        $this->title = $title;
    }

###########################################################

    public function set_botaoFechar($botaoFechar = FALSE){ // bool Exibe ou não o botão
    /**
     * Informa se terá um botão de fechar o callout
     * 
     * @syntax $callout->set_botaoFechar($botaoFechar);
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