<?php

class Panel
{    
   /**
    * Cria um container usando o framework W3C
    * 
    * @author André Águia (Alat) - alataguia@gmail.com
    * 
    * @var private $class string NULL A classe para o css
    * @var private $id    string NULL O id para o css
    * @var private $title string NULL Texto para o evento mouseover
    * 
    * @group eventos
    * @var private $onClick string NULL A rotina jscript a ser executada no evento onclick.
    * 
    * @example exemplo.div.php
    */
    
    private $header = NULL;
    private $footer = NULL;
    
    private $class = NULL;
    private $id = NULL;
    private $title = NULL;
    private $onClick = NULL;

###########################################################

    public function __construct($header = NULL, $footer = NULL){
    /**
     * Inicia a div informando o id e a classe para o css
     * 
     * @param $id       string NULL O id para o css
     * @param $class 	string NULL A classe para o css
     * 
     * @syntax $div = new Div($id,[$class]);
     */
    
    	$this->header = $header;
        $this->footer = $footer;
    }
    
###########################################################

    public function set_title($title = NULL){
    /**
     * Informa o texto no mouse over
     * 
     * @syntax $div->set_title($title);
     * 
     * @param $title string NULL O texto a ser exibido
     */
    
        $this->title = $title;
    }

###########################################################

    public function set_onClick($onClick = NULL){
    /**
     * Informa a rotina jscript a ser executada no evento onclick.
     * 
     * @syntax $div->set_onClick($onClick);
     * 
     * @param $onClick string NULL A rotina jscript a ser executada no evento onclick.
     */
    
        $this->onClick = $onClick;
    }

###########################################################

    public function abre(){	
    /**
     * Inicia a abertura da div para inserção do conteúdo
     *
     * @syntax $div->abre();
     */
    
        # abre a div 
        echo '<div class="w3-card-4">';

        if(!is_null($this->header)){
            echo '<header class="w3-container w3-blue">';
            echo '<h3>'.$this->header.'</h3>';
            echo '</header>';
        }
        
        echo '<header class="w3-container">';
    }

###########################################################

    public function fecha(){
    /**
     * Fecha uma div aberta
     * 
     * @syntax $div->fecha();
     */
        echo '</header>';
        
        if(!is_null($this->footer)){
            echo '<footer class="w3-container w3-blue">';
            echo '<p>'.$this->footer.'</p>';
            echo '</footer>';
        }
        
        echo '</div>';
    }
}