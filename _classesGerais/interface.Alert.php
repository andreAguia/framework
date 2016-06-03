<?php
class Alert
{
 /**
  * Exibe um Painel com mensagem
  *  
  * @author André Águia (Alat) - alataguia@gmail.com
  * 
  * @var private $mensagem  string NULL         A mensagem a ser exibida
  * @var private $id        string NULL         O id para o css
  * 
  * @var private $tipo      string secondary    O tipo do alert (callout): secondary | primary | success | warning | alert
  * @var private $title     string NULL         Um texto para o evento mouseover
  * @var private $page      string NULL         Página a ser redirecionada qualdo clica no ok
  * 
  * @note Classe construída com CSS, sendo uma alternativa a função alert que exibe uma mensagem utilizando o jscript
  * 
  * @example exemplo.alert.php
  */

    private $mensagem = NULL;
    private $id = NULL;
    
    private $tipo = 'secondary';
    private $title = NULL;
    private $page = NULL;    
    
###########################################################

    public function __construct($mensagem = NULL,$id = NULL){
    /**
     * Inicia a classe informando a mensagem e o id do css
     * 
     * @param $mensagem string NULL A mensage a ser exibida
     * @param $id 	string NULL O id para o css
     * 
     * @syntax $msg = new Alert($mensagem,[$id]);
     */
    
    	$this->mensagem = $mensagem;
        $this->id = $id;
    }
    
###########################################################

    public function set_tipo($tipo = NULL){
    /**
     * O tipo do alert (callout): secondary | primary | success | warning | alert
     * 
     * @syntax $msg->set_tipo($tipo);
     * 
     * @param $tipo string NULL O tipo do Callout que definirá a cor
     */
    
        $this->tipo = $tipo;
    }

###########################################################

    public function set_page($page = NULL){
    /**
     * Informa se o alert terá um botão de ok redirecionando para uma outra página
     * 
     * @syntax $msg->set_page($page);
     * 
     * @param $page string NULL A página para onde o programa será direcionado apõs o pressionamento do botão ok
     */
    
        $this->page = $page;
    }

###########################################################

    public function set_title($title = NULL){
    /**
     * Informa o texto no mouse over
     * 
     * @syntax $msg->set_title($title);
     * 
     * @param $title string NULL O texto a ser exibido
     */
    
        $this->title = $title;
    }

###########################################################

    public function show(){
        
        /**
        * Exibe o Alerta
        * 
        * @syntax $msg->show();
        */    
            
        # Abre o Callout(div)
        if (is_null($this->id)){
            $callout = new Callout($this->tipo);
        }else{
            $callout = new Callout($this->tipo,$this->id);
        }
        
        # Title
        if (!is_null($this->title)){
            $callout->set_title($this->title);
        }
        
        $callout->abre();
        # botão de fechar --- retirado pois não está funcionando
        #echo '<button class="close-button" aria-label="Dismiss alert" type="button" onclick="fechaDivId(\''.$this->id.'\');" data-close>';
        #echo '<span aria-hidden="true">&times;</span>';
        #echo '</button>';
        
        p($this->mensagem);

        if(!is_null($this->page)){
            $okBotao = new Link("Ok",$this->page);
            $okBotao->set_title('Ok');
            $okBotao->set_class('button');
            $okBotao->show();
        }
        
        $callout->fecha();
    }
}