<?php
class Fieldset
{
 /**
  * Cria um fieldset. 
  * 
  * @author André Águia (Alat) - alataguia@gmail.com
  * 
  * @var private $legend string NULL O texto do item legend do fieldset
  * @var private $id     string NULL O id para o css
  * @var private $class  string fieldset A classe para o css
  * 
  * @example exemplo.fieldset.php
  */

    private $id = NULL;
    private $legend = NULL;
    private $class = "fieldset";

###########################################################    

    public function __construct($legend = null,$id = null){
    /**
     * Inicia a classe atribuindo um valor do legend e do id
     * 
     * @param $legend   string NULL O texto a ser exibido
     * @param $id       string NULL O id para o css
     * 
     * @syntax $field = new Fieldset([$legend], [$id]);
     */
    
    	$this->legend = $legend;
        $this->id = $id;
    }
    
###########################################################

    public function set_class($class = NULL){
    /**
     * Informa o nome da class para o css
     * 
     * @syntax $field->set_class($class);
     * 
     * @param $class string NULL O nome da class para o css
     */
    
        $this->title = $class;
    }

###########################################################

    public function abre(){
    /**
     * Abre um fieldset
     * 
     * @syntax $field->abre();
     */
    
        echo '<fieldset class="'.$this->class.'"';
        
        if(!is_null($this->id)){
            echo ' id="'.$this->id.'"';
        }
        echo '>';

        if(!is_null($this->legend)){
            echo '<legend>'.$this->legend.'</legend>';
        }
    }

    ###########################################################
	 
    public function fecha(){
    /**
     * Fecha um fieldset
     * 
     * @syntax $field->fecha();
     */
    
        echo '</fieldset>';
    }
}
