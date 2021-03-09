<?php

class Button {

    /**
     * Monta um botão texto estilizado usando o framework Foundation
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @group do link
     * @var private $label    string null  O texto a ser exibido no link.
     * @var private $url      string null  A url do link.
     * @var private $title    string null  Texto que irá aparecer no evento mouseover.
     * @var private $target   string null  Nome da div ou da janela onde o link será aberto.
     * @var private $disabled bool   false Informa se o botao estará ou não desabilitado
     * 
     * @group do css
     * @var private $class string button A classe para o css. Define a cor do button.
     * @var private $id    string null   O id parra o css.
     * 
     * @group eventos
     * @var private $onClick string null A rotina jscript a ser executada no evento onclick.
     * 
     * @group outros
     * @var private $confirma  string  null   Texto a ser exibido em uma janela confirmação em jscript. A rotina somente prosseguirá se o usuário pressionar sim.
     * @var private $accessKey string  null   Letra para se usar junto com a tecla ALT como atalho de acesso ao botão 
     * 
     * @example exemplo.button.php
     */
    private $label = null;
    private $url = null;
    private $title = null;
    private $target = null;
    private $disabled = false;
    private $class = 'button';
    private $id = null;
    private $onClick = null;
    private $confirma = null;
    private $accessKey = null;
    private $imagem = null;

###########################################################

    public function __construct($label = null, $url = null) {

        /**
         * Constroi um link sem exibí-lo
         * 
         * @param $label string null O texto a ser exibido no link
         * @param $url   string null A url do link
         * 
         * @syntax $button = new Button($label,[$url]);
         */
        $this->label = $label;
        $this->url = $url;
    }

###########################################################

    public function set_url($url = null) {
        /**
         * Informa a url
         * 
         * @syntax $button->set_url($url);
         * 
         * @param $url string null O caminho do link do botão
         */
        $this->url = $url;
    }

###########################################################

    public function set_class($class = null) {
        /**
         * Informa o nome da class para o css
         * 
         * @syntax $button->set_class($class);
         * 
         * @param $class string null O nome da class para o css
         */
        $this->class = $class;
    }

###########################################################

    public function set_id($id = null) {
        /**
         * Informa o id para o CSS
         * 
         * @syntax $button->set_id($id);
         * 
         * @param $id string null O nome do id
         */
        $this->id = $id;
    }

###########################################################

    public function set_title($title = null) {
        /**
         * Informa o texto a ser exibido no mouseOver
         * 
         * @syntax $button->set_title($title);
         * 
         * @param $title string null O nome do id
         */
        $this->title = $title;
    }

###########################################################

    public function set_target($target = null) {
        /**
         * Informa o nome da div ou da janela onde o link será aberto
         * 
         * @syntax $button->set_title($target);
         * 
         * @param $target string null Nome da div ou da janela onde o link será aberto
         */
        $this->target = $target;
    }

###########################################################

    public function set_onClick($onClick = null) {
        /**
         * Informa a rotina jscript a ser executada no evento onclick.
         * 
         * @syntax $button->set_onClick($onClick);
         * 
         * @param $onClick string null A rotina jscript a ser executada no evento onclick.
         */
        $this->onClick = $onClick;
    }

###########################################################

    public function set_confirma($confirma = null) {
        /**
         * Informa um Texto a ser exibido para confirmar o clique. O programa somente continuará após pressionar Sim.
         * 
         * @syntax $button->set_confirma($confirma);
         * 
         * @param $confirma string null Texto a ser exibido para confirmar o clique. 
         */
        $this->confirma = $confirma;
    }

###########################################################

    public function set_accessKey($accessKey = null) {
        /**
         * Informa uma letra de atalho a ser utilizado junto com a tecla ALT para esse link
         * 
         * @syntax $button->set_accessKey($accessKey);
         * 
         * @param $accessKey string null A letra de atalho para esse link     * 
         */
        $this->accessKey = $accessKey;
    }

###########################################################

    public function set_imagem($imagem = null) {
        /**
         * Informa uma imagem a ser exibida no botão junto ou ou inves do texto
         * 
         * @syntax $button->set_imagem($imagem);
         * 
         * @param $imagem string null O objeto imagem a ser inserido
         */
        $this->imagem = $imagem;
    }

###########################################################

    public function set_disabled($disabled = null) {
        /**
         * Informa se o botão estará desabilitado
         * 
         * @syntax $button->set_disabled($disabled);
         * 
         * @param $disabled bool false Informa se o botão estará desabilitado
         */
        $this->disabled = $disabled;
    }

###########################################################

    public function show($id = null) {
        /**
         * Exibe o link
         * 
         * @param  $id integer null	Usado em links em tabelas para acrescentar o id do registro a url
         */
        if($this->disabled){
            $this->class .= " disabled";
            $this->url = "#";
        }
        
        $link = new Link($this->label, $this->url, $this->title);
        $link->set_class($this->class);
        $link->set_id($this->id);
        $link->set_target($this->target);
        $link->set_onClick($this->onClick);
        $link->set_accessKey($this->accessKey);
        $link->set_confirma($this->confirma);
        $link->set_imagem($this->imagem);
        $link->show();
    }

}
