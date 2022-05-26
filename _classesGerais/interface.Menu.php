<?php

class Menu {

    /**
     * Monta um menu de opções
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @var private $item    array   null     Array de itens do menu
     * @var private $tipo    array   null     Array com o tipo de cada item: Pode ser: link|titulo|linkWindow|linkAjax
     * @var private $classe  string  menuVertical classe para o css
     * 
     * @example exemplo.menu.php 
     */
    private $item;
    private $tipo;
    private $classe = "menuVertical";
    private $destaque = null;

    ###########################################################    

    public function __construct($classe = "menuVertical", $destaque = null) {
        /**
         * Inicia a classe atribuindo um valor do formato do menu
         * 
         * @param $classe string  menuVertical stringo classe para o css
         * 
         * @syntax $field = new Menu([$classe]);
         */
        if (!empty($classe)) {
            $this->classe = $classe;
        }

        if (!empty($destaque)) {
            $this->destaque = $destaque;
        }
    }

###########################################################

    public function add_item($tipo = 'link', $label = null, $url = '#', $title = null, $accessKey = null, $target = null) {
        /**
         * Adiciona um item ao menu
         * 
         * @param $tipo      string link O tipo do item. Pode ser: link|titulo|linkWindow|linkAjax
         * @param $label     string null O nome que vai aparecer no item
         * @param $url       string # A url do link
         * @param $title     string null O texto que irá aparecer no mouseover
         * @param $accessKey string null A letra para o atalho do link
         * @param $target    string null O nome da janela ou div quando é do tipo linkWindow ou linkAjax 
         * 
         * @note os tipos de item: titulo -> será exibido com título; link -> é um link normal que abrirá na mesma janela; linkWindow -> link que abrirá em uma janela. Normalmente usado em relatórios; linkAjax -> usado para chamar uma rotina a ser aberta dentro de uma div sem reload.
         * 
         * @syntax $menu->add_item($tipo,$label,[$url],[$title],[$accessKey],[$target]); 
         */
        switch ($tipo) {
            case "titulo" :
                # titulo
                $link = new Link($label, $url);
                $link->set_title($title);
                $link->set_target($target);

                # Joga o objeto para o array
                $this->item[] = $link;
                $this->tipo[] = 'titulo';
                break;

            case "titulo1" :
                # titulo
                $link = new Link($label, $url);
                $link->set_title($title);
                $link->set_target($target);

                # Joga o objeto para o array
                $this->item[] = $link;
                $this->tipo[] = 'titulo1';
                break;

            case "titulo2" :
                # titulo
                $link = new Link($label, $url);
                $link->set_title($title);
                $link->set_target($target);
                $link->set_id('titulo2');

                # Joga o objeto para o array
                $this->item[] = $link;
                $this->tipo[] = 'titulo2';
                break;

            case "link" :
                # Link 
                $link = new Link($label, $url);
                $link->set_title($title);
                $link->set_target($target);
                $link->set_accessKey($accessKey);
                $link->set_id('link');

                $this->item[] = $link;
                $this->tipo[] = 'link';
                break;

            case "sublink" :
                # Link 
                $link = new Link($label, $url);
                $link->set_title($title);
                $link->set_target($target);
                $link->set_accessKey($accessKey);
                $link->set_id('sublink');

                $this->item[] = $link;
                $this->tipo[] = 'sublink';
                break;

            case "linkWindow" :
                # linkWindow
                $linkWindow = new Link($label);
                $linkWindow->set_title($title);
                $linkWindow->set_id('linkWindow');
                #$linkWindow->set_cursor('pointer');
                # Resolvendo o bug do firefox que ia para uma pagina em branco
                #  toda vez que se abria-se um relatorio
                if (BROWSER_NAME == "FIREFOX") {
                    $linkWindow->set_onClick("window.open('" . $url . "','_blank','menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=750,height=600');history.go(1);");
                } else {
                    $linkWindow->set_onClick("window.open('" . $url . "','_blank','menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=750,height=600');");
                }

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

    public function show() {
        /**
         * Exibe o menu
         *
         * @syntax $menu->show();
         *
         */
        # Inicia o contador
        $contador = 0;

        echo "<ul class='$this->classe'>";
        foreach ($this->item as $row) {

            # Bold
            if (!is_null($this->destaque)) {
                if ($this->destaque == $contador) {
                    $row->set_bold(true);
                }
            }

            switch ($this->tipo[$contador]) {
                case "titulo" :
                    echo "<li id='titulo'>";
                    $row->show();
                    echo "</li>";
                    break;

                case "titulo1" :
                    echo "<li id='titulo1'>";
                    $row->show();
                    echo "</li>";
                    break;

                case "titulo2" :
                    echo "<li id='titulo2'>";
                    $row->show();
                    echo "</li>";
                    break;

                case "link" :
                    echo "<li class='$this->classe'>";
                    $row->show();
                    echo "</li>";
                    break;

                case "sublink" :
                    echo "<li id='sublink'>";
                    $row->show();
                    echo "</li>";
                    break;

                default :
                    echo "<li class='$this->classe'>";
                    $row->show();
                    echo "</li>";
            }
            $contador++;
        }
        echo "</ul>";
    }

}
