 <?php
 class Imagem
{
 /**
  * Exibe uma imagem
  * 
  * @author André Águia (Alat) - alataguia@gmail.com
  * 
  * @example exemplo.imagem.php 
  */
     
    private $figura = "_semImagem.jpg";     // string  Caminho e nome do arquivo de imagem a ser exibida.
    private $title = NULL;                  // string  Texto que irá aparecer no evento mouseover
    private $width = 15;                    // integer Largura da figura.
    private $height = 20;                   // integer Altura da figura. 
    
    private $class = NULL;                  // string O nome da classe.
    private $id = NULL;                     // string O nome do id
    
    private $onClick = NULL;                // rotina do evento onClick

###########################################################

    public function __construct($figura = NULL,$title = NULL,$width = 15,$height = 20){
    /**
     * Cria a classe informando varios argumentos
     * 
     * @syntax $imagem = new Imagem($figura, $title, $width, $height);
     *  
     * @param $figura string  NULL  Caminho e nome do arquivo de imagem a ser exibida.
     * @param $title  string  NULL  Texto que irá aparecer no evento mouseover
     * @param $width  integer 15    Largura da figura.
     * @param $height integer 20    Altura da figura.
     */
    
        $this->figura = $figura;
        $this->title = $title;
        $this->width = $width;
        $this->height = $height;
    }

###########################################################

    public function set_class($class = NULL){   // string O nome da classe.
    /**
     * Altera a classe da figura para ser usado no CSS
     * 
     * @syntax $imagem->set_class($class);
     * 
     * @param $class string NULL O nome da classe
     */
    
        $this->class = $class;
    }

###########################################################

    public function set_id($id = NULL){ // string O nome do id
    /**
     * Altera o id da figura para ser usado no CSS
     * 
     * @syntax $imagem->set_id($id);
     * 
     * @param $id string NULL O nome do id
     */
    
        $this->id = $id;
    }

###########################################################
    
    public function set_onClick($onClick = NULL){
    /**
     * Define uma rotina em jscript para ser executada no evento onclick
     * 
     * @param $rotina string NULL Rotina em jscript a ser executada
     * 
     * @syntax $imagem->set_onClick($rotina);
     */
    
        $this->onClick = $onClick;
    }

 ###########################################################
    
    public function show(){
    /**
     * Exibe a imagem
     * 
     * @syntax $imagem->show();
     */
    
        # inicia a imagem
        echo '<img';
        
        # id para o css
        if(!(is_null($this->id))){
            echo ' id="'.$this->id.'"';
        }
        
        # classe para o css    
        if(!(is_null($this->class))){
            echo ' class="'.$this->class.'"';
        }
        
        # Onclick
        if(!(is_null($this->onClick))){
            echo ' onClick="'.$this->onClick.'"';
        }
        
        # title 
        if(!(is_null($this->title))){
            echo ' alt="'.$this->title.'"';     // mensagem quando a imagem não é encontrada
            echo ' title="'.$this->title.'"';   // dica no mouseover
        }
        
        # da figura
        echo ' src="'.$this->figura.'"';
        echo ' height="'.$this->height.'"';
        echo ' width="'.$this->width.'">';
    }
}