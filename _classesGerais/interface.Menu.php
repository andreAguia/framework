 <?php
 class Menu
 {
    /**
     * Monta um menu de opções
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @var private $item array  NULL Array de itens do menu
     * @var private $tipo array  NULL Array com o tipo de cada item: Pode ser: link|titulo|linkWindow|linkAjax
     * 
     * @example exemplo.menu.php 
     */

    private $item;
    private $tipo;

    ###########################################################
    
    public function add_item($tipo = 'link',$label = NULL,$url = '#',$title = NULL,$accessKey = NULL,$target = NULL){
    /**
     * Adiciona um item ao menu
     * 
     * @param $tipo      string link O tipo do item. Pode ser: link|titulo|linkWindow|linkAjax
     * @param $label     string NULL O nome que vai aparecer no item
     * @param $url       string # A url do link
     * @param $title     string NULL O texto que irá aparecer no mouseover
     * @param $accessKey string NULL A letra para o atalho do link
     * @param $target    string NULL O nome da janela ou div quando é do tipo linkWindow ou linkAjax 
     * 
     * @note os tipos de item: titulo -> será exibido com título; link -> é um link normal que abrirá na mesma janela; linkWindow -> link que abrirá em uma janela. Normalmente usado em relatórios; linkAjax -> usado para chamar uma rotina a ser aberta dentro de uma div sem reload.
     * 
     * @syntax $menu->add_item($tipo,$label,[$url],[$title],[$accessKey],[$target]); 
     */
    
        # title
        if(is_null($title)){
            $title = $label;
        }
        
        switch ($tipo)
        {
            case "titulo" :
                # titulo
                $link = new Link($label);
                $link->set_title($title);

                # Joga o objeto para o array
                $this->item[] = $link;
                $this->tipo[] = 'titulo';
                break;
            
            case "link" :
                # Link 
                $link = new Link($label,$url);
                $link->set_title($title);
                $link->set_target($target);
                $link->set_accessKey($accessKey);

                $this->item[] = $link;
                $this->tipo[] = 'item';
                break;
            
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
	
    public function show(){
        /**
         * Exibe o menu
         *
         * @syntax $menu->show();
         *
         */

        # Inicia o contador
        $contador = 0;

        # Começa
        echo "<ul class='menuVertical'>";
        foreach ($this->item as $row){
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
