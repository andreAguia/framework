<?php
 /**
  * @class Input
  * 
  * Cria um controle para um formulário
  * 
  * @author André Águia (Alat) - alataguia@gmail.com
  */
class Input
{	
    # do controle
    private $nome;
    private $tipo = 'texto';

    # do label
    private $label = null;
    private $tipoLabel = 0;

    # do tamanho
    private $size = 0;
    private $maxlength = 0;
    private $col = 12;              // Usado pela classe form para definir a 
                                    // largura da coluna onde o controle está (de 1 a 12)
                                    // de acordo com o grid o Foundation

    # outros
    private $readonly = false;
    private $disabled = false;
    private $valor = null;
    private $title = null;
    private $placeholder = null;
    private $tabindex = null;    
    private $tagHtml = false;
    private $accessKey = null;
    private $autofocus = false;     // determina se o focus será nesse input
    private $required = false;      // requerido (not null)
    
    # especial
    private $pularPara = null;     // informa qual o controle pulara automaticamente o foco 
                                   // quando o campo estiver preenchido

    # quando combo
    private $array = null;

    # dos eventos
    private $onClick = null;
    private $onChange = null;
    
    # do form
    private $linha = false;     // informa a linha do controle
    private $fieldset = null;   // cria um fieldset dentro do form
    private $align = null;      // alinha o input

    ###########################################################

    /**
    * @method construtor
    * 
    * cria um controle
    * 
    * @param    string  	nome       -> qual o nome do controle
    * @param	string		tipo       -> qual o tipo do controle ('texto' | 'numero' | 'cpf' | 'data' | 'hora' | 'cep' | 'hidden' | 'password' | 'combo' | 'checkbox' | 'textarea' | 'submit' | 'reset' | 'button')
    * @param    string  	label      -> texto do label
    * @param	integer 	tipo_label -> (0 | 1 | 2 | 3)
    *      		        0 - sem label
    *			        1 - label em cima
    *	 			2 - label do lado direito
    *                           3 - label do lado esquerdo
    */
    
    public function __construct($nome,$tipo,$label = null,$tipo_label = 0)
    {
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->label = $label;
        $this->tipoLabel = $tipo_label;
    }

    ###########################################################

    /**
    * Métodos get e set construídos de forma automática pelo 
    * metodo mágico __call.
    * Esse método cria um set e um get para todas as propriedades da classe.
    * Um método existente tem prioridade sobre os métodos criados pelo __call.
    * 
    * O formato dos métodos devem ser:
    * 	set_propriedade
    * 	get_propriedade
    * 
    * @param 	$metodo		O nome do metodo
    * @param 	$parametros	Os parâmetros inseridos  
    */
    
    public function __call ($metodo, $parametros)
    {
        ## Se for set, atribui um valor para a propriedade
        if (substr($metodo, 0, 3) == 'set')
        {
            $var = substr($metodo, 4);
            $this->$var = $parametros[0];
        }

        # Se for Get, retorna o valor da propriedade
        if (substr($metodo, 0, 3) == 'get')
        {
            $var = substr($metodo, 4);
            return $this->$var;
        }
    }
    ###########################################################

    /**
    * @method set_size
    * 
    * @param	integer		size    -> tamanho do input
    * @param 	integer		maxlength -> quantidade máxima de caracteres que poderá ser digitado dentro do imput
    */
    
    public function set_size($size,$maxlength = 0)
    {
        $this->size = $size;
        $this->maxlength = $maxlength;
    }

    ###########################################################

    /**
    * @method show
    * 
    * exibe o controle
    */
    
    public function show()
    {
        if ($this->tipo == "hidden")
            $this->tipoLabel = 0;

        if ($this->tipo == "checkbox")
            $this->tipoLabel = 3;	

        switch ($this->tipoLabel)
        {
            case 1:
                echo '<label for="'.$this->nome.'">';   
                echo $this->label;
                if ($this->required)
                    echo ' * ';	

                if ($this->tagHtml)
                    echo ' (html) ';	

                echo '</label>';
                break;

            case 2:
                echo '<label for="'.$this->nome.'">';   
                echo $this->label;
                echo '</label>';
                break;
        }	


        switch ($this->tipo)
        {
            case "processo":
            case "processoNovo":
            case "texto":
            case "numero":
            case "patrimonio":
            case "file":
            case "cpf":
            case "cep":    
            case "date":
            case "data":
            case "hora":            
            case "submit":
            case "reset":
            case "button":
            case "checkbox":
                echo '<INPUT';
                break;
            case "moeda":
                echo '<div class="input-group">';
                echo '<span class="input-group-label">R$</span>';
                echo '<input class="input-group-field"';
                break;
            case "hidden":
                echo '<INPUT';
                $this->tipo = 'hidden';
                break;	
            case "password":
                echo '<INPUT onPaste="return false;"'; 
                $this->tipo = 'password';
                break;
            case "combo":
            case "simnao":
                echo '<select';	
                break;			
            case "textarea":
                echo '<textarea';	
                break;
        }

        # tabulação
        if(!is_null($this->tabindex))
            echo ' tabindex="'.$this->tabindex.'"';
        
        # focus
        if($this->autofocus)
            echo ' autofocus';
        
        # required
        if($this->required)
            echo ' required';

        # title
        if(!is_null($this->title))
            echo ' title="'.$this->title.'"';
        
        # placeholder
        if(!is_null($this->placeholder))            
            echo ' placeholder="'.$this->placeholder.'"';

        # onChange	
        if(!is_null($this->onChange))
            echo ' onchange="'.$this->onChange.'"';

        # Máximo de caracteres		
        if (($this->maxlength == 0) and ($this->tipo <> 'textarea'))
        {	
            # Coloca o maxlengh = 10 quando data
            if ($this->tipo == 'date')
                echo ' maxlength="10"';
            else if($this->tipo <> "hidden")
                echo ' maxlength="'.$this->size.'"';
        }
        else if(($this->tipo <> 'textarea') AND ($this->tipo <> 'checkbox'))
            echo ' maxlength="'.$this->maxlength.'"';

        # se for readonly	
        if ($this->readonly)
            echo ' class="readonly" readonly ';
        
        # se for textarea com html
        #if ($this->tagHtml)                # A classe estava provocando erros
        #    echo ' class="ckeditor" ';

        # se for disabled	
        if ($this->disabled)
            echo ' class="disabled" disabled ';    	

        # dados do input
        echo ' name="'.$this->nome.'"'; # nome do controle (deve ser o mesmo que o do banco de dados)
        echo ' id="'.$this->nome.'"';
        
        switch ($this->tipo)
        {	
            case "textarea":
                echo ' cols="'.$this->size[0].'"';
                echo ' rows="'.$this->size[1].'"';
                echo '>';
                echo $this->valor;
                echo '</textarea> ';
                break;

            case "hidden":
                echo ' type="'.$this->tipo.'"';
                echo ' value="'.$this->valor.'" />';
                #echo '</INPUT>';
                break;
            
            case "simnao":
                echo '>';
                $this->array = array(array(null,""),array(true,"Sim"),array(false,"Não"));
                            
                echo '<option value="'.true.'"';
                if ($this->valor)
                    echo ' selected>';
                else
                    echo '>';
                echo 'Sim';
                echo '</option>';
                
                echo '<option value="'.false.'"';
                if (!($this->valor))
                    echo ' selected>';
                else
                    echo '>';
                echo 'Não';
                echo '</option>';
                break;
                
            case "combo":
                #echo ' size="'.($this->size).'"';
                echo '>';
                foreach($this->array as $field)
                {
                    if ($field <> "")
                    {
                        if (is_array($field))
                        {
                            echo '<option value="'.$field[0].'"';
                            if ($field[0] == $this->valor)
                                echo ' selected>';
                            else
                                echo '>';

                            echo  $field[1];
                            echo '</option>';	
                        }
                        else
                        {
                            echo ' <option value="'.$field.'"';
                            if ($field == $this->valor)
                                echo ' selected>';
                            else
                                echo '>';

                            echo  $field;
                            echo '</option>';

                        }
                    }
                }

                echo '</select>';
                break;	

            case "checkbox":
                echo ' type="'.$this->tipo.'"';
                echo ' size="'.($this->size).'"';
                #echo ' class="checkbox"';
                echo ' value="'.$this->nome.'"';
                if ($this->valor == $this->nome)	# se for true, ou seja valor igual a 1
                    echo ' checked>';
                else	
                    echo '>';                            
                break;

            case "date":
            case "data":
                if(HTML5)
                {
                    echo ' type="date"';
                    echo ' value="'.$this->valor.'"'; 

                    # Verifica se está habilitado o pulo para o controle seguinte
                    if (!is_null($this->pularPara))
                       echo '; pularCampo(\''.$this->nome.'\','.$this->size.',\''.$this->pularPara.'\')"';
                    else
                        echo '"';       
                    echo '/>';
                }
                else
                {   # Rotina antiga com type text para browsers que não renderizam o html5 muito bem
                    $mascara = '99/99/9999';
                    echo ' size="'.($this->size).'"';                    
                    echo ' type="text"';
                    echo ' value="'.$this->valor.'"';               
                    echo ' onkeypress="mask(this, \''.$mascara.'\',1,this)';

                    # Verifica se está habilitado o pulo para o controle seguinte
                    if (!is_null($this->pularPara))
                       echo '; pularCampo(\''.$this->nome.'\','.$this->size.',\''.$this->pularPara.'\')"';
                    else
                        echo '"';

                    echo ' onkeyup="mask(this, \''.$mascara.'\',1,this)" ';
                    echo ' onblur="mask(this, \''.$mascara.'\',1,this)" ';          
                    echo '/>';
                }                
                break; 

            case "hora":
                echo ' size="'.($this->size).'"';
                echo ' type="text"';
                echo ' value="'.$this->valor.'"';
                echo ' onkeypress="mask(this, \''.$mascara.'\',1,this)" ';
                echo ' onkeyup="mask(this, \''.$mascara.'\',1,this)" ';
                echo ' onblur="mask(this, \''.$mascara.'\',1,this)" ';          
                echo '/>';
                break;

            case "processo":
                $mascara = 'E-99/999999/9999';
                echo ' size="'.($this->size).'"';
                echo ' type="text"';
                echo ' value="'.$this->valor.'"';
                echo ' onkeypress="mask(this, \''.$mascara.'\',3,this)" ';
                echo ' onkeyup="mask(this, \''.$mascara.'\',3,this)" ';
                echo ' onblur="mask(this, \''.$mascara.'\',3,this)" ';          
                echo '/>';
                break; 
             
            case "processoNovo":
                $mascara = 'E-99/999/999999/9999';
                echo ' size="'.($this->size).'"';
                echo ' type="text"';
                echo ' value="'.$this->valor.'"';
                echo ' onkeypress="mask(this, \''.$mascara.'\',3,this)" ';
                echo ' onkeyup="mask(this, \''.$mascara.'\',3,this)" ';
                echo ' onblur="mask(this, \''.$mascara.'\',3,this)" ';          
                echo '/>';
                break;

            case "cpf":
                $mascara = '999.999.999-99';
                echo ' size="'.($this->size).'"';
                echo ' type="text"';
                echo ' value="'.$this->valor.'"';
                echo ' onkeypress="mask(this, \''.$mascara.'\',1,this)" ';
                echo ' onkeyup="mask(this, \''.$mascara.'\',1,this)" ';
                echo ' onblur="mask(this, \''.$mascara.'\',1,this)" ';     
                echo '/>';
                break;

           case "numero":
                #$mascara = str_repeat('9', $this->size);
                echo ' size="'.$this->size.'"';
                echo ' type="number"';
                echo ' value="'.$this->valor.'"';                
                #echo ' onkeypress="mask(this, \''.$mascara.'\',1,this)';
                
                # Verifica se está habilitado o pulo para o controle seguinte
                if (!is_null($this->pularPara))
                    echo '; pularCampo(\''.$this->nome.'\','.$this->size.',\''.$this->pularPara.'\')"';
                else
                    echo '"';
                
                #echo ' onkeyup="mask(this, \''.$mascara.'\',1,this)" ';
                #echo ' onblur="mask(this, \''.$mascara.'\',1,this)" ';           
                echo '/>';
                break;
            
            case "cep":
                $mascara = '99999-999';
                echo ' size="'.$this->size.'"';
                echo ' type="text"';
                echo ' value="'.$this->valor.'"';
                echo ' onkeypress="mask(this, \''.$mascara.'\',1,this)" ';
                echo ' onkeyup="mask(this, \''.$mascara.'\',1,this)" ';
                echo ' onblur="mask(this, \''.$mascara.'\',1,this)" ';     
                echo '/>';
                break;

            case "moeda":
                echo ' size="'.($this->size).'"';
                echo ' type="text"';
                echo ' value="'.formataMoeda($this->valor).'"';                
                echo ' onkeypress="return formatarMoeda(this,\'.\',\',\',event);" ';
                echo '/>';
                echo '</div>';
                break;

            case "password":
                echo ' size="'.($this->size).'"';
                echo ' type="password"';
                #echo ' name="'.$this->nome.'"';
                #echo ' id="'.$this->nome.'"';
                echo '/>';	
                break;    

            case "submit":
                echo ' size="'.$this->size.'"';
                echo ' type="submit"';
                echo ' value="'.$this->valor.'"';
                echo ' class="button"';
                echo ' accesskey="'.$this->accessKey.'"';
                echo '/>';  
                break;  	  	      		

            case "reset":
                echo ' size="'.$this->size.'"';
                echo ' type="reset"';
                echo ' value="'.$this->valor.'"';
                #echo ' name="'.$this->nome.'"';
                echo ' accesskey="'.$this->accessKey.'"';
                echo '/>';  
                break;

            case "button":
                echo ' size="'.$this->size.'"';
                echo ' type="button"';
                echo ' value="'.$this->valor.'"';
                #echo ' name="'.$this->nome.'"';
                #echo ' id="'.$this->nome.'"';
                echo ' onClick="'.$this->onclick.'"';
                echo ' accesskey="'.$this->accessKey.'"';
                echo '/>';  
                break;      

            case "file":
                echo ' size="'.$this->size.'"';
                echo ' type="file"';
                echo ' value="'.$this->valor.'"';
                #echo ' name="'.$this->nome.'"';
                #echo ' id="'.$this->nome.'"';
                echo ' onFocus="this.select();"';
                echo '/>';
                break;

            default:
                echo ' size="'.($this->size).'"';
                echo ' type="text"';
                #echo ' value="'.htmlspecialchars($this->valor).'"'; # retirado pois deu problemas com acentos
                echo ' value="'.$this->valor.'"';
                
                # Verifica se está habilitado o pulo para o controle seguinte
                if (!is_null($this->pularPara))
                    echo 'onkeypress="pularCampo(\''.$this->nome.'\','.$this->size.',\''.$this->pularPara.'\')"';
                          
                echo ' onFocus="this.select();"';
                echo '/>';
                break;
        }		

        switch ($this->tipoLabel)
        {
            case 3:
                echo '<label id="checkbox" for="'.$this->nome.'">';   
                echo $this->label;
                echo '</label>';
                break;
        }
    }

###########################################################

}			   
?>
