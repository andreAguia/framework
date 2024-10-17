<?php

class Imagem {

    /**
     * Exibe uma imagem
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @example exemplo.imagem.php 
     */
    private $figura = "_semImagem.jpg";     // string  Caminho e nome do arquivo de imagem a ser exibida.
    private $title = null;                  // string  Texto que irá aparecer no evento mouseover
    private $width = 15;                    // integer Largura da figura.
    private $height = 20;                   // integer Altura da figura. 
    private $class = null;                  // string O nome da classe.
    private $id = null;                     // string O nome do id
    private $onClick = null;                // string Rotina do evento onClick

###########################################################

    public function __construct($figura = null, // string  Caminho e nome do arquivo de imagem a ser exibida.
            $title = null, // string  Texto que irá aparecer no evento mouseover
            $width = 15, // integer Largura da figura.   
            $height = 20) {  // integer Altura da figura.
        /**
         * Cria a classe informando varios argumentos
         * 
         * @syntax $imagem = new Imagem($figura, $title, $width, $height);
         */

        $this->figura = $figura;
        $this->title = $title;
        $this->width = $width;
        $this->height = $height;
    }

###########################################################

    public function set_class($class = null) {   // string O nome da classe.
        /**
         * Altera a classe da figura para ser usado no CSS
         * 
         * @syntax $imagem->set_class($class);
         */

        $this->class = $class;
    }

###########################################################

    public function set_id($id = null) { // string O nome do id
        /**
         * Altera o id da figura para ser usado no CSS
         * 
         * @syntax $imagem->set_id($id);
         */

        $this->id = $id;
    }

###########################################################

    public function set_onClick($onClick = null) { // string Rotina em jscript a ser executada
        /**
         * Define uma rotina em jscript para ser executada no evento onclick
         * 
         * @syntax $imagem->set_onClick($rotina);
         */

        $this->onClick = $onClick;
    }

    ###########################################################

    public function set_title($title = null) {
        /**
         * Informa o texto a ser exibido no mouseOver
         * 
         * @syntax $botao->set_title($title);
         * 
         * @param $title string null O nome do id
         */
        $this->title = $title;
    }

###########################################################

    public function show() {
        /**
         * Exibe a imagem
         * 
         * @syntax $imagem->show();
         */
        # inicia a imagem
        echo '<img';

        # id para o css
        if (!(is_null($this->id))) {
            echo ' id="' . $this->id . '"';
        }

        # classe para o css    
        if (!(is_null($this->class))) {
            echo ' class="' . $this->class . '"';
        }

        # Onclick
        if (!(is_null($this->onClick))) {
            echo ' onClick="' . $this->onClick . '"';
        }

        # title 
        if (!(is_null($this->title))) {
            echo ' alt="' . $this->title . '"';     // mensagem quando a imagem não é encontrada
            echo ' title="' . $this->title . '"';   // dica no mouseover
        }

        # da figura
        echo ' src="' . $this->figura . '"';
        echo ' height="' . $this->height . '"';
        echo ' width="' . $this->width . '">';
    }

}
