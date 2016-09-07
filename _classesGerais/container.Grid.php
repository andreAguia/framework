<?php

class Grid
{
 /**
  * Classe do tipo container que funciona em conjunto com o framework Foundation para estruturar uma página.
  * 
  * @author André Águia (Alat) - alataguia@gmail.com
  * 
  * @note Funciona a partir de uma sequencia de divs de forma similar às antigas estruturações por tabelas  
  * 
  * @example exemplo.grid.php
  */
	

###########################################################
    
    public function __construct($align = NULL){
    /**
     * Inicia uma linha de uma grid. Similar a um table e tr juntos.
     * 
     * @param $align string left O alinhamento do grid: center | left | right | justify | spaced
     * 
     * @syntax $grid = new Grid([$align]);     
     */    
    
    	echo '<div class="row';
        
        # alinhamento
        if(!is_null($align)){
            echo ' align-'.$align.' ';
        }
        
        echo '">';
    }

###########################################################

    public function abreColuna($small = null,$medium = null, $large = null){	
    /**
     * Inicia uma coluna de uma grid. Similar a um td.
     * 
     * @note Cada grid tem a capacidade máxima de 12. Cada coluna poderá ter o tamanho entre 1 a 12 de forma que o somatório do tamanho das colunas seja 12. Cada coluna poderá ter um tamanho variável dependendo do tamanho da tela (responsivo) que é determinado pelos parâmetros $small, $medium e $large
     * 
     * @param $small  string NULL O tamanho da coluna quando a tela for pequena
     * @param $medium string NULL O tamanho da coluna quando a tela for media
     * @param $large  string NULL O tamanho da coluna quando a tela for grande
     * 
     * @syntax $grid->abreColuna($small,$medium,$large);
     */    
    
        echo '<div class="';
        
        if(!is_null($small)){
            echo 'small-'.$small.' ';
        }
        
        if(!is_null($medium)){
            echo 'medium-'.$medium.' ';
        }
        
        if(!is_null($large)){
            echo 'large-'.$large.' ';
        }
               
        echo 'columns"';
        echo ">";
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
