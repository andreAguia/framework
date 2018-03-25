<?php
class Form
{
/** 
 * Monta um formulário.
 * 
 * @author André Águia (Alat) - alataguia@gmail.com
 * 
 * @var private $class      string  formPadrao  A classe do form para o css e javaScript.
 * @var private $id         string  NULL        O id do form para o css.
 * @var private $submit     string  NULL        O arquivo que será direcionado após clicar no botão salvar.
 * @var private $title      string  NULL        Mensagem que será exibida no evento mouseover.
 * @var private $target     string  NULL        Indica se será aberto em outra janela.
 * @var private $method     string  POST        Indica o método de envio do formulário. Valores possíveis: GET/POST.
 * @var private $file       boolean FALSE       Se True informa que o formulário é para o envio de arquivos. Upload.
 * @var private $item[]     array   NULL        Array de objetos Input para inserir no formulário.
 * @var private $onSubmit   string  NULL        Acrescenta rotina jscript no evento onsubmit.
 * @var private $objeto     objeto  NULL        Insere um objeto (normalmente uma imagem) no form. Utilizado quando se quer exibir um objeto posicionado que se desloca quando se exibe o histórico.
 * 
 * @note Um formulário é na verdade um container de objetos input. 
 * 
 * @example exemplo.form.php
 */
    
    # do Form   
    private $class = 'formPadrao';
    private $id;
    private $submit;
    
    private $title = NULL;
    
    private $target = NULL;
    private $method = 'POST';
    private $file = FALSE;
    private $item;

    # eventos
    private $onSubmit = NULL;
    
    # especiais
    private $objeto = NULL;

###########################################################
                
    public function __construct($submit = NULL,$id = NULL){
    /**
     * Inicia um formulário.
     * 
     * @syntax $form = new Form($submit,$id);
     * 
     * @param $id string NULL id e nome do formulário (como ele será identificado pelo jascript.
     * @param $submit string NULL arquivo em php para onde será redirecionado para o post.
     */    
    
        $this->id = $id;
        $this->submit = $submit;
    }
    
###########################################################

    public function set_class($class){
    /**
     * Altera a classe do form para ser usado no CSS.
     * 
     * @syntax $form->set_class($class);
     * 
     * @param $class string NULL O nome da classe.
     */
        $this->class = $class;
    }

###########################################################

    public function set_id($id){
    /**
     * Altera o id do form para ser usado no CSS
     * 
     * @syntax $form->set_id($id);
     * 
     * @param $id string NULL O nome do id
     * 
     * @note O id pode (e deve) ser informado no método construtor. O set_id é apenas uma opção para quando se tem a necessidade de se incluir ou alterar o id após a classe ter sido criada.
     */
    
        $this->id = $id;
    }

###########################################################

    public function set_title($title){
    /**
     * Informa uma mensagem a ser exibida no evento mouseover.
     * 
     * @syntax $form->set_title($title);
     * 
     * @param $title string NULL Mensagem que será exibida no evento mouseover
     */
    
        $this->title = $title;
    }

###########################################################

    public function set_target($target){
    /**
     * Indica se será aberto em outra janela.
     * 
     * @syntax $form->set_target($target);
     * 
     * @param $target string NULL Nome da janela em que a página solicitada será aberta.
     */
    
        $this->target = $target;
    }

###########################################################

    public function set_method($method){
    /**
     * Informa qual método de envio será utilizado. O padrão é POST. 
     * 
     * @syntax $form->set_method($method);
     * 
     * @param $method string POST Indica o método de envio do formulário. Valores possíveis: GET/POST.
     */
    
        $this->method = $method;
    }

###########################################################

    public function set_file($file){
    /**
     * Se TRUE informa que o formulário é para o envio de arquivos. Upload.
     * 
     * @syntax $form->set_file($file);
     * 
     * @param $file boolean FALSE Informa se é pora o envio de arquivo(TRUE) ou não.
     */
    
        $this->file = $file;
    }

###########################################################

    public function onSubmit($onSubmit){
    /**
     * Informa rotina em javascript para ser executado no evento onSubmite.
     * 
     * @syntax $form->onSubmit($onSubmit);
     * 
     * @param $onSubmit string NULL Rotina em javascript.
     */
    
        $this->onSubmit = $onSubmit;
    }

###########################################################
	    
    public function add_item($controle){
    /**
     * Inclui um objeto Input ao formulário
     * 
     * @syntax $form->add_item($objeto);
     * 
     * @param $controle object NULL Objeto Input a ser inserido no Formulário
     * 
     */
    
       $this->item[] = $controle; 
    }
    
###########################################################
	    
    public function add_objeto($imagem){
    /**
     * Inclui um objeto após o formulário. O objeto mais comum é o objeto Imagem
     * 
     * @param $imagem object NULL Objeto Imagem a ser inserido
     * 
     * @deprecated
     */
    
       $this->objeto[] = $imagem; 
    }
    
###########################################################
    
    public function show(){  
    /**
     * Efetivamente constroi o formulário
     * 
     * @syntax $form->show();
     * 
     */
    
    	# Verifica se tem um fieldset aberto
        $fieldsetAberto = FALSE;
        
        # Contador de controles
        $contador = 0;
        
    	# Começa o form
        echo '<form';	

        # Class do form
        if(!is_null($this->class)){
            echo ' class="'.$this->class.'"';
        }
        
        # id e Nome do form (coloco o nome e o id igual para evitar problemas no jscript)
        if(!is_null($this->id)){
            echo ' id="'.$this->id.'" name="'.$this->id.'"';
        }else{
            echo ' name="'.$this->class.'"';
        }
            
        # Método do form
        if(!is_null($this->method)){
            echo ' method="'.$this->method.'"';
        }
        
        # Submit do form
        if(!is_null($this->submit)){
            echo ' action="'.$this->submit.'"';
        }
        
        # Target do form
        if(!is_null($this->target)){
            echo ' target="'.$this->target.'"';
        }
        
        # Title do form
        if(!is_null($this->title)){
            echo ' title="'.$this->title.'"';
        }
        
        if(!is_null($this->onSubmit)){
            echo ' onSubmit="'.$this->onSubmit.'"';
        }
            
        # Se for file (para upload)
        if ($this->file){
            echo ' enctype="multipart/form-data"';
        }

    	echo '>';        
    	foreach ($this->item as $objeto1){   
            # pega o texto do fieldset (se tiver)
            $fieldsetTag = $objeto1->get_fieldset();
            
            if ($contador == 0){
                $linhaAtual = $objeto1->get_linha();
                
                # fieldset interna
                if(!is_null($fieldsetTag)){
                    echo '<div id="div'.$contador.'">'; // Essa div somente é valida par quando se quer ocu
                    
                    echo '<fieldset class="fieldset">';
                    echo '<legend>'.$fieldsetTag.'</legend>';
                    $fieldsetAberto = TRUE;
                }

                echo '<div class="row">';
            }

            if ($linhaAtual <> $objeto1->get_linha()){
                echo '</div>';

                # fieldset interna
                if(!is_null($fieldsetTag)){

                    if($fieldsetAberto){
                        echo '</fieldset>';                           
                        $fieldsetAberto = FALSE;
                        echo '</div>'; // para quando se quer ocultar um grupo de campos
                    }

                    if($fieldsetTag <> 'fecha'){
                        echo '<div id="div'.$contador.'">';  // para quando se quer ocultar um grupo de campos

                        echo '<fieldset class="fieldset">';
                        echo '<legend>'.$fieldsetTag.'</legend>';            
                        $fieldsetAberto = TRUE;
                    }
                }

                echo '<div class="row">';

                $linhaAtual = $objeto1->get_linha();
            }

            # define o tamnho da coluna e exibe o controle
            echo '<div class="large-'.$objeto1->get_col().' medium-'.$objeto1->get_col().' columns">'; 
            
            # Exibe o objeto (controle)
            $objeto1->show();

            echo '</div>';
                        
            $contador++;                  		
      	}

        echo '</div>';
                
        if($fieldsetAberto){
            echo '</fieldset>';                           
            $fieldsetAberto = FALSE;
            echo '</div>'; // para quando se quer ocultar um grupo de campos
        }
      		      	
    	echo '</form>';  
        
        # Exibe o objeto (se tiver)
        if ($this->objeto){
            foreach ($this->objeto as $objeto2){
                $objeto2->show();
            }    	
        } 			
    }   
}