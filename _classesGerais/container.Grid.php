<?php

class Grid
{
 /**
  * Classe do tipo container que funciona em conjunto com o framework Foundation para estruturar uma página.
  * 
  * @author André Águia (Alat) - alataguia@gmail.com
  * 
  * @var private $center bool FALSE Informa se o grid é centralizado. O grid e não o conteúdo do grid. Aceita os valores: TRUE ou FALSE 
  * 
  * @note Funciona a partir de uma sequencia de divs de forma similar às antigas estruturações por tabelas  
  * 
  * @example exemplo.grid.php
  */
	

    private $center = FALSE;
    
###########################################################
    
    public function __construct(){
    /**
     * Inicia uma linha de uma grid. Similar a um table e tr juntos.
     * 
     * @syntax $grid = new Grid();     
     */    
    
    	echo "<div class='row'>";
    }
    
###########################################################
    
    public function set_center($center = FALSE){
    /**
     * Informa se o grid será centralizado
     * 
     * @syntax $link->set_center($center);
     * 
     * @param $center bool FALSE Informa se o grid é centralizado. O grid e não o conteúdo do grid. Aceita os valores: TRUE ou FALSE 
     */
    
        $this->center = $center;
    }

###########################################################

    public function abreColuna($small = null,$medium = null, $large = null){	
    /**
     * Inicia uma coluna de uma grid. Similar a um td.
     * 
     * @note Cada grid tem a capacidade máxima de 12. Cada coluna poderá ter o tamanho entre 1 a 12 de forma que o somatório do tamanho das colunas seja 12. Cada coluna poderá ter um tamanho variável dependendo do tamanho da tela (responsivo) que é determinado pelos parâmetros $small, $medium e $large
     * 
     * @param $small    string NULL O tamanho da coluna quando a tela for pequena
     * @param $medium   string NULL O tamanho da coluna quando a tela for media
     * @param $large    string NULL O tamanho da coluna quando a tela for grande
     * 
     * @syntax $grid->abreColuna($small,$medium,$large);
     */    
    
        echo '<div class="';
        
        if(!is_null($small)){
            echo 'small-'.$small.' ';
        }
        
        if($this->center){
            echo 'small-centered';
        }
        
        if(!is_null($medium)){
            echo 'medium-'.$medium.' ';
        }
        
        if($this->center){
            echo 'medium-centered';
        }
        
        if(!is_null($large)){
            echo 'large-'.$large.' ';
        }
        
        if($this->center){
            echo 'large-centered';
        }
               
        echo 'columns">';
    }

###########################################################

    public function fechaColuna(){
    /**
     * Fecha uma coluna
     * 
     * @syntax $grid->fechaColuna();
     */    
    
        echo '</div>';
    }
    
###########################################################

    public function fechaGrid(){
    /**
     * Fecha uma Grid
     * 
     * @syntax $grid->fechaGrid();
     */    
    
        echo '</div>';
    }
}
