<?php

class TopBar {

    /**
     * Exibe uma barra onde se pode incluir links, botões e controles 
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @var private $label string null Texto que aparecerá na barra.
     * @var private $title string null Texto exibido no mouseover
     * 
     * @example exemplo.topbar.php
     */
    private $label = null;
    private $title = null;
    private $link = null;
    private $linkLado = null;
    private $controleLabel = null;
    private $controleValor = null;

###########################################################

    public function __construct($label = null) {
        /**
         * Método construtor que inicia a classe e informa o label da barra
         * 
         * @param $label string null Texto a ser exibodo do lado esquerdo.
         * 
         * @syntax $bar = new TopBar([$label]); 
         */
        $this->label = $label;
    }

###########################################################

    public function add_pesquisa($controleLabel = null, $controleValor = null) {
        /**
         * Inclui um campo de pesquisa
         * 
         * @param $controleLado  string null O texto do label
         * @param $controleValor string null O valor do controle
         * 
         * @syntax $bar->add_pesquisa($controleLabel,[$controleValor]);
         */
        $this->controleLabel = $controleLabel;
        $this->controleValor = $controleValor;
    }

###########################################################

    public function set_title($title = null) {
        /**
         * Informa o title
         * 
         * @syntax $button->set_title($title);
         * 
         * @param $title string null O title do botão
         */
        $this->title = $title;
    }

###########################################################

    public function add_link($link = null, $linkLado = null) {

        /**
         * Inclui um link na barra
         * 
         * @param $link     object Objeto link a ser inserido
         * @param $linkLado string Lado do link na barra, podendo ser: left ou right.
         * 
         * @syntax $bar->add_link($link,$linkLado);
         */
        $this->link[] = $link;
        $this->linkLado[] = $linkLado;
    }

###########################################################

    public function show() {

        /**
         * Exibe a barra
         *  
         * @syntax $bar->show();
         */
        # Inicia a top bar
        echo '<div class="top-bar">';

        # Inicia o container da esquerda
        echo '<div class="top-bar-left">';

        # Escreve o título da rotina ou página
        echo '<ul class="menu">';
        echo '<li class="menu-text">' . $this->label;
        echo '</li>';

        # Verifica se tem botões para colocar na barra
        if (!empty($this->link)) {

            # contador
            $contadorEsquerdo = 0;
            $contadorDireito = 0;

            # verifica se tem link do lado esquerdo
            if (in_array("left", $this->linkLado)) {
                foreach ($this->link as $linkEsquerdo) {
                    if ($this->linkLado[$contadorEsquerdo] == 'left') {
                        echo '<li>';
                        $linkEsquerdo->show();
                        echo '</li>';
                    }
                    $contadorEsquerdo++;
                }
            }
        }

        echo '</ul>';
        echo '</div>';

        # Inicia o container da direita
        echo '<div class="top-bar">';
        echo '<ul class="menu">';

        if (!empty($this->link)) {
            # verifica se tem link do lado direito
            if (in_array("right", $this->linkLado)) {
                foreach ($this->link as $linkDireito) {
                    if ($this->linkLado[$contadorDireito] == 'right') {
                        echo '<li>';
                        $linkDireito->show();
                        echo '</li>';
                    }
                    $contadorDireito++;
                }
            }
        }

        # Exibe campo de pesquisa
        if (!is_null($this->controleLabel)) {
            if ($this->controleValor == '')
                $placeholder = $this->controleLabel;
            else
                $placeholder = $this->controleValor;

            echo '<form method="POST" action="?fase=listar">';
            echo '<li>';
            echo '<input size="50" type="search" placeholder="' . $placeholder . '" name="parametro" autofocus>';
            #echo '<li><button type="button" class="small button">'.$this->controleLabel.'</button></li>';
            echo '</li>';
            echo '</form>';
        }
        echo '</ul>';

        echo '</div>';
        echo '</div>';
    }

}
