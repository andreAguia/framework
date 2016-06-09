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
     * @var private $botaoOk     string NULL      Se preenchido com o arquivo, um botão de Ok surgirá e ao ser pressionado carregará a página indicada
     * @var private $onClick     string NULL      Se preenchido com o arquivo, um botão de Ok surgirá e ao ser pressionado executará o jscript indicado
     * 
     * @note Um painel onde a cor é definida pelo tipo do callout: secondary | primary | success | warning | alert
     * 
     * @example exemplo.callout.php
     */
    
    private $tipo = NULL;
    private $title = NULL;
    private $id = NULL;
    private $botaoFechar = FALSE;
    private $botaoOk = NULL;
    private $onClick = NULL;

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

    public function set_botaoOk($botaoOk = NULL,$onClick = NULL){
    /**
     * Informa se terá um botão de OK e qual página irá ser carregada após ser clicado
     * 
     * @syntax $callout->set_botaoOk($botaoOk,[$onClick]);
     * 
     * @param $botaoOk string NULL a página a ser carregada
     * @param $onclick string NULL rotina em jscript a ser executada
     */
    
        $this->botaoOk = $botaoOk;
        $this->onClick = $onClick;
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
        
         if (!is_null($this->botaoOk)){
            $link = new Button("OK",$this->botaoOk);
            $link->show();
        }
        
        if (!is_null($this->onClick)){
            $link = new Button("OK");
            $link->set_onClick($this->onClick);
            $link->show();
        }
        
        echo '</div>';
    }
}