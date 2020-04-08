<?php
class Button
{	    
/**
 * Monta um botão texto estilizado usando o framework Foundation
 * 
 * @author André Águia (Alat) - alataguia@gmail.com
 * 
 * @group do link
 * @var private $label    string NULL  O texto a ser exibido no link.
 * @var private $url      string NULL  A url do link.
 * @var private $title    string NULL  Texto que irá aparecer no evento mouseover.
 * @var private $target   string NULL  Nome da div ou da janela onde o link será aberto.
 * @var private $disabled bool   FALSE Informa se o botao estará ou não desabilitado
 * 
 * @group do css
 * @var private $class string button A classe para o css. Define a cor do button.
 * @var private $id    string NULL   O id parra o css.
 * 
 * @group eventos
 * @var private $onClick string NULL A rotina jscript a ser executada no evento onclick.
 * 
 * @group outros
 * @var private $confirma  string  NULL   Texto a ser exibido em uma janela confirmação em jscript. A rotina somente prosseguirá se o usuário pressionar sim.
 * @var private $accessKey string  NULL   Letra para se usar junto com a tecla ALT como atalho de acesso ao botão 
 * 
 * @example exemplo.button.php
 */

    private $label = NULL;
    private $url = NULL;
    private $title = NULL;
    private $target = NULL;  
    private $disabled = FALSE;

    private $class = 'button';
    private $id = NULL;
    
    private $onClick = NULL;
        
    private $confirma = NULL;
    private $accessKey = NULL;
    
    private $imagem = NULL;

###########################################################

    public function __construct($label = NULL,$url = NULL){
        
    /**
     * Constroi um link sem exibí-lo
     * 
     * @param $label string NULL O texto a ser exibido no link
     * @param $url   string NULL A url do link
     * 
     * @syntax $button = new Button($label,[$url]);
     */
    
        $this->label = $label;
        $this->url = $url;
    }

###########################################################
    
    public function set_url($url = NULL){
    /**
     * Informa a url
     * 
     * @syntax $button->set_url($url);
     * 
     * @param $url string NULL O caminho do link do botão
     */
    
        $this->url = $url;
    }

###########################################################
    
    public function set_class($class = NULL){
    /**
     * Informa o nome da class para o css
     * 
     * @syntax $button->set_class($class);
     * 
     * @param $class string NULL O nome da class para o css
     */
    
        $this->class = $class;
    }

###########################################################

    public function set_id($id = NULL){
    /**
     * Informa o id para o CSS
     * 
     * @syntax $button->set_id($id);
     * 
     * @param $id string NULL O nome do id
     */
    
        $this->id = $id;
    }

###########################################################

    public function set_title($title = NULL){
    /**
     * Informa o texto a ser exibido no mouseOver
     * 
     * @syntax $button->set_title($title);
     * 
     * @param $title string NULL O nome do id
     */
    
        $this->title = $title;
    }

###########################################################

    public function set_target($target = NULL){
    /**
     * Informa o nome da div ou da janela onde o link será aberto
     * 
     * @syntax $button->set_title($target);
     * 
     * @param $target string NULL Nome da div ou da janela onde o link será aberto
     */
    
        $this->target = $target;
    }

###########################################################

    public function set_onClick($onClick = NULL){
    /**
     * Informa a rotina jscript a ser executada no evento onclick.
     * 
     * @syntax $button->set_onClick($onClick);
     * 
     * @param $onClick string NULL A rotina jscript a ser executada no evento onclick.
     */
    
        $this->onClick = $onClick;
    }

###########################################################

    public function set_confirma($confirma = NULL){
    /**
     * Informa um Texto a ser exibido para confirmar o clique. O programa somente continuará após pressionar Sim.
     * 
     * @syntax $button->set_confirma($confirma);
     * 
     * @param $confirma string NULL Texto a ser exibido para confirmar o clique. 
     */
    
        $this->confirma = $confirma;
    }

###########################################################

    public function set_accessKey($accessKey = NULL){
    /**
     * Informa uma letra de atalho a ser utilizado junto com a tecla ALT para esse link
     * 
     * @syntax $button->set_accessKey($accessKey);
     * 
     * @param $accessKey string NULL A letra de atalho para esse link     * 
     */
    
        $this->accessKey = $accessKey;
    }
    
###########################################################

    public function set_imagem($imagem = NULL){
    /**
     * Informa uma imagem a ser exibida no botão junto ou ou inves do texto
     * 
     * @syntax $button->set_imagem($imagem);
     * 
     * @param $imagem string NULL O objeto imagem a ser inserido
     */
    
        $this->imagem = $imagem;
    }    

###########################################################

    public function set_disabled($disabled = NULL){
    /**
     * Informa se o botão estará desabilitado
     * 
     * @syntax $button->set_disabled($disabled);
     * 
     * @param $disabled bool FALSE Informa se o botão estará desabilitado
     */
    
        $this->disabled = $disabled;
    }    

###########################################################

    public function show($id = NULL){
    /**
     * Exibe o link
     * 
     * @param  $id integer NULL	Usado em links em tabelas para acrescentar o id do registro a url
     */    

        echo '<button class="w3-button w3-teal w3-uenf-color2">'.$this->label.'</button>';
       
        # on click
        if(!is_null($this->onClick)){

            # Verifica se tem confirmação
            if($this->confirma <> NULL){  // com confirmação
                if(is_null($id)){	// Exibe ou não o id
                    echo " onclick='confirma(\"$this->url\",\"$this->confirma\")'";
                }else{
                    echo " onclick='confirma(\"$this->url$id\",\"$this->confirma\")'"; 	
                }
                echo ' href="#"';
            }else{
                echo ' href="javascript:'.$this->onClick.'"';
                
            }
        }
    }
}
