<?php

class Callout
{    
    /**
     * Cria um container Callout.
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @var private $tipo        string secondary O tipo do alert (callout): secondary | primary | success | warning | alert
     * @var private $id          string NULL      O id para o css
     * @var private $title       string NULL      O Texto para o evento mouseover
     * @var private $botaoFechar bool   FALSE     Se terá ou não botão de fechar
     * 
     * @note Um painel onde a cor é definida pelo tipo do callout: secondary | primary | success | warning | alert
     * 
     * @example exemplo.callout.php
     */
    
    private $tipo = NULL;
    private $title = NULL;
    private $id = NULL;
    private $botaoFechar = FALSE;

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
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
        }        
        echo '</div>';
    }
}