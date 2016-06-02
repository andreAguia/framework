 <?php
 /**
 * classe Menu
 * Monta um menu de opções
 * 
 * By Alat
 */
class Menu
{
    private $item;  // Array de itens do menu
    private $tipo;  // Array com o tipo de item (item ou titulo)
    private $nome;  // Nome do menu para o css    

    ###########################################################
	
    /**
     * método construtor
     * inicia um menu
     * 
     * @param  $name    = nome da classe e do id para estilo
     */
    public function __construct($nome)
    {
        $this->nome = $nome;
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
        #if (substr($metodo, 0, 3) == 'get')
        #{
        # $var = substr($metodo, 4);
        #  return $this->$var;
        #}
    }
    ###########################################################
    
    /**
     * método add_item
     * 
     * Adiciona um item ao menu
     * 
     * @param  $name    = nome da classe e do id para estilo
     */
    public function add_item($tipo='link',$label=null,$url=null,$title=null,$accessKey=null,$target=null)
    {
        switch ($tipo)
        {
            case "titulo" :
                # titulo
                $titulo = new Link($label);
                $titulo->set_title($title);

                # Joga o objeto para o array
                $this->item[] = $titulo;
                $this->tipo[] = 'titulo';
                break;
            
            ####################################
            
            case "link" :
                # Link 
                $link = new Link($label,$url);
                $link->set_title($title);
                $link->set_target($target);
                $link->set_accessKey($accessKey);

                $this->item[] = $link;
                $this->tipo[] = 'item';
                break;      
            
            ####################################
            
            case "linkWindow" :
                # linkWindow
                $linkWindow = new Link($label);
                $linkWindow->set_title($title);
                $linkWindow->set_onClick("window.open('".$url."','_blank','menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=750,height=600');");
                #$linkWindow->set_cursor('pointer');

                # Joga o objeto para o array
                $this->item[] = $linkWindow;
                $this->tipo[] = 'item';
                break;   
            
            ####################################
            
            case "linkAjax" :
                # linkAjax
                $linkAjax = new Link($label);
                $linkAjax->set_title($title);
                $linkAjax->set_onClick("ajaxLoadPage('$url','$target','');");               
                #$linkAjax->set_textAlign('left');
                #$linkAjax->set_cursor('pointer');

                $this->item[] = $linkAjax;
                $this->tipo[] = 'item';
                break;      
            
        }
    }
    
    ###########################################################
	
    /**
     * método show
     * 
     * exibe o menu
     * 
     * @param  $name    = nome da classe e do id para estilo
     */
    
    public function show()
    {	
        # Inicia o contador
        $contador = 0;
        
        # Começa
        echo "<ul class='menuVertical'>";
        foreach ($this->item as $row)
        {
            if($this->tipo[$contador] == 'titulo'){
                echo "<li id='titulo'>";
                $row->show();
                echo "</li>";
            }else{
                echo "<li class='menuVertical'>";
                $row->show();
                echo "</li>";
            }
            $contador++;
        }
            
        echo "</ul>";
    }
}
