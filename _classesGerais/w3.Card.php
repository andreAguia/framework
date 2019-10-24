<?php

class Card
{    
   /**
    * Cria um container usando o framework W3C
    * 
    * @author André Águia (Alat) - alataguia@gmail.com
    * 
    * @example exemplo.card.php
    */
    
    private $header = NULL;     // string O texto para o cabeçalho.
    private $footer = NULL;     // string O texto para o rodapé.
    private $title = NULL;      // string O texto para o evento mouseover.
    private $onClick = NULL;    // string Rotina jscript a ser executada no evento onclick.
    private $color = 'blue';    // string Cor do cabeçalho e rodapé: blue | green | teal | indigo | yellow | red ... Várias cores

###########################################################

    public function __construct($header = NULL,     // string O texto para o cabeçalho.
                                $footer = NULL){    // string O texto para o rodapé.
    /**
     * Inicia o Card
     * 
     * @syntax $card = new Card([$header],[$footer]);
     */
    
    	$this->header = $header;
        $this->footer = $footer;
    }
    
###########################################################

    public function set_title($title = NULL){   // string O texto para o rodapé.
    /**
     * Informa o texto no mouse over
     * 
     * @syntax $card->set_title($title);
     */
    
        $this->title = $title;
    }

###########################################################

    public function set_color($color = NULL){   // string Cor do cabeçalho e rodapé: blue | Green | Teal | Indigo | Yellow | Red ... Várias cores
    /**
     * Informa a cor do cabeçalho e rodapé
     * 
     * @syntax $card->set_color($color);
     */
    
        $this->color = $color;
    }

###########################################################

    public function set_onClick($onClick = NULL){ // string Rotina jscript a ser executada no evento onclick.
    /**
     * Informa a rotina jscript a ser executada no evento onclick.
     * 
     * @syntax $card->set_onClick($onClick);
     */
    
        $this->onClick = $onClick;
    }

###########################################################

    public function abre(){	
    /**
     * Inicia a abertura do card para inserção do conteúdo
     *
     * @syntax $card->abre();
     */
    
        # abre o card 
        echo '<div class="w3-card-4" ';
        
        # title
        if(!is_null($this->title)){
            echo ' title="'.$this->title.'"';
        }
        
        # onClick
        if(is_null($this->onClick)){     
            echo ' onclick="'.$this->onClick.'"';
        }
        echo '>';

        if(!is_null($this->header)){
            echo '<header class="w3-container w3-'.$this->color.'">';
            echo '<h4>'.$this->header.'</h4>';
            echo '</header>';
        }
        
        echo '<header class="w3-container">';
    }

###########################################################

    public function fecha(){
    /**
     * Fecha um card aberto
     * 
     * @syntax $card->fecha();
     */
        echo '</header>';
        
        if(!is_null($this->footer)){
            echo '<footer class="w3-container w3-'.$this->color.'">';
            echo '<h6>'.$this->footer.'</h6>';
            echo '</footer>';
        }
        
        echo '</div>';
    }
}