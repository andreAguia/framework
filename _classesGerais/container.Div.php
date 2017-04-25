<?php

class Div
{    
    /**
    * Cria um container div
    * 
    * @author André Águia (Alat) - alataguia@gmail.com
    * 
    * @var private $class string NULL A classe para o css
    * @var private $id    string NULL O id para o css
    * @var private $title string NULL Texto para o evento mouseover
    * 
    * @example exemplo.div.php
    */
    
    private $class = NULL;
    private $id = NULL;
    private $title = NULL;

###########################################################

    public function __construct($id = NULL, $class = NULL){
    /**
     * Inicia a div informando o id e a classe para o css
     * 
     * @param $id       string NULL O id para o css
     * @param $class 	string NULL A classe para o css
     * 
     * @syntax $div = new Div($id,[$class]);
     */
    
    	$this->id = $id;
        $this->class = $class;
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

    public function abre(){	
    /**
     * Inicia a abertura da div para inserção do conteúdo
     *
     * @syntax $div->abre();
     */
    
        # abre a div 
        echo '<div';
        
        if (!is_null($this->id)){
            echo ' id="'.$this->id.'"';
        }
        
        if (!is_null($this->class)){
            echo ' class="'.$this->class.'"';
        }
        
        if (!is_null($this->title)){
            echo ' title="'.$this->title.'"';
        }
        
        echo '>';
    }

###########################################################

    public function fecha(){
    /**
     * Fecha uma div aberta
     * 
     * @syntax $div->fecha();
     */
    
        echo '</div>';
    }
}