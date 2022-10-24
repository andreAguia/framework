<?php

class Link {

    /**
     * Monta um Link
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @example exemplo.link.php
     */
    private $label = null;      // string O texto a ser exibido no link.
    private $url = null;        // string A url do link.
    private $title = null;      // string Texto que irá aparecer no evento mouseover
    private $target = null;     // string Nome da div ou da janela onde o link será aberto
    private $class = null;      // string A classe para o css.
    private $id = null;         // string O id para o css.
    private $onClick = null;    // string A rotina jscript a ser executada no evento onclick.
    private $confirma = null;   // string Texto a ser exibido em uma janela confirmação em jscript.
    private $accessKey = null;  // string Letra para se usar junto com a tecla ALT como atalho de acesso ao botão 
    private $imagem = null;     // string  O caminho e o nome da Imagem a ser exibida
    private $imagemWidth = 48;  // integer A largura da imagem
    private $imagemHeight = 48; // integer A altura da imagem
    private $bold = false;      // bool Se o título do link foi selecionado. (bold)

###########################################################

    public function __construct(
            $label = null, // string O texto a ser exibido no link
            $url = null, // string A url do link
            $title = null) { // string O texto a ser exibido no mouseover

        /**
         * Constroi um link sem exibí-lo
         * 
         * @syntax $link = new Link($label,[$url],[$title]);
         */

        $this->label = $label;
        $this->url = $url;
        $this->title = $title;
    }

###########################################################

    public function set_url($url = null) {   // string O caminho do link do link
        /**
         * Informa a url
         * 
         * @syntax $link->set_url($url);
         */

        $this->url = $url;
    }

###########################################################

    public function get_url($url = null) {   // string O caminho do link do link
        /**
         * Informa a url
         * 
         * @syntax $link->set_url($url);
         */

        return $this->url;
    }

###########################################################

    public function set_class($class = null) {   // string O nome da class para o css
        /**
         * Informa o nome da class para o css
         * 
         * @syntax $link->set_class($class);
         */

        $this->class = $class;
    }

###########################################################

    public function set_id($id = null) { // string O nome do id
        /**
         * Informa o id para o CSS
         * 
         * @syntax $link->set_id($id);
         */

        $this->id = $id;
    }

###########################################################

    public function set_bold($bold = false) { // bool se tem ou não bold no título
        /**
         * Define se o título aparecerá com bold ou nẽo (selecionado ou não)
         * 
         * @syntax $link->set_bold($bold);
         */

        $this->bold = $bold;
    }

###########################################################

    public function set_title($title = null) { // string O texto do mouseover
        /**
         * Informa o texto a ser exibido no mouseOver
         * 
         * @syntax $link->set_title($title);
         */

        $this->title = $title;
    }

###########################################################

    public function set_target($target = null) { // string Nome da div ou da janela onde o link será aberto
        /**
         * Informa o nome da div ou da janela onde o link será aberto
         * 
         * @syntax $link->set_target($target);
         */

        $this->target = $target;
    }

###########################################################

    public function set_onClick($onClick = null) { // string A rotina jscript a ser executada no evento onclick.
        /**
         * Informa a rotina jscript a ser executada no evento onclick.
         * 
         * @syntax $link->set_onClick($onClick);
         */

        $this->onClick = $onClick;
    }

###########################################################

    public function set_accessKey($accessKey = null) { // string A letra de atalho para esse link
        /**
         * Informa uma letra de atalho a ser utilizado junto com a tecla ALT para esse link
         * 
         * @syntax $link->set_accessKey($accessKey);
         */

        $this->accessKey = $accessKey;
    }

###########################################################

    public function set_confirma($confirma = null) { // string Texto a ser exibido para confirmar o clique. 
        /**
         * Informa um Texto a ser exibido para confirmar o clique. O programa somente continuará após pressinar Sim.
         * 
         * @syntax $link->set_confirma($confirma);
         */

        $this->confirma = $confirma;
    }

###########################################################

    public function set_imagem($imagem = null, // string  O caminho e o nome da Imagem a ser exibida
            $imagemWidth = 48, // integer Largura da imagem
            $imagemHeight = 48) { // integer Altura da imagem
        /**
         * Define a imagem do botão
         * 
         * @syntax $link->set_imagem($imagem,[$imagemWidth],[$imgagemHeight]); 
         */

        $this->imagem = $imagem;
        $this->imagemWidth = $imagemWidth;
        $this->imagemHeight = $imagemHeight;
    }

###########################################################

    public function show($id = null) { // integer Usado em links em tabelas para acrescentar o id do registro a url
        /**
         * Exibe o link
         * 
         * @syntax $link->show([$id]); 
         */

        # title
        if (is_null($this->title)) {
            $this->title = $this->label;
        }

        # Bold (selecionado)
        if ($this->bold) {
            $this->label = "<b>{$this->label}</b>";
        }

        # Atalho
        if ($this->accessKey <> null) {
            # Altera o label colocando o sublinhado na letra do atalho (se tiver)
            $atalho = substr($this->label, 0, stripos($this->label, $this->accessKey));
            $atalho .= '<B><U>' . $this->accessKey . '</U></B>';
            $atalho .= substr($this->label, stripos($this->label, $this->accessKey) + 1);
            $this->label = $atalho;
        }

        # Começa o link
        echo '<a';

        # class
        if (!is_null($this->class)) {
            echo ' class="' . $this->class . '"';
        }

        # id
        if (!is_null($this->id)) {
            echo ' id="' . $this->id . '"';
        }

        # target
        if (!is_null($this->target)) {
            switch ($this->target) {
                case '_blank':
                    echo " onClick=\"window.open('$this->url','$this->target','menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=780,height=800');\" ";
                    $this->url = "#";
                    break;

                case '_blank2':
                    echo " onClick=\"window.open('$this->url','$this->target','menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=780,height=300');\" ";
                    $this->url = "#";
                    break;
                
                case '_blank3':
                    echo " onClick=\"window.open('$this->url','$this->target','menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=850,height=800');\" ";
                    $this->url = "#";
                    break;

                default :
                    echo ' target="' . $this->target . '"';
                    break;
            }
        }

        # Verifica se tem confirmação
        if ($this->confirma <> null) {  // com confirmação
            if (is_null($id)) { // Exibe ou não o id
                echo " onclick='confirma(\"$this->url\",\"$this->confirma\")'";
            } else {
                echo " onclick='confirma(\"$this->url$id\",\"$this->confirma\")'";
            }

            echo ' href="#"';
        } else {    // sem confirmação
            if (is_null($this->onClick)) {
                if (is_null($id)) { // Exibe ou não o id
                    echo ' href="' . $this->url . '"';
                } else {
                    echo ' href="' . $this->url . $id . '"';
                }
            } else {
                echo ' href="javascript:' . $this->onClick . '"';
            }
        }

        if (!is_null($this->accessKey)) {
            echo ' accesskey="' . $this->accessKey . '"';
        }

        if (!is_null($this->title)) {
            echo ' title="' . $this->title . '"';
        }

        echo '>';

        # imagem
        if (!is_null($this->imagem)) {
            if (is_object($this->imagem)) {
                $this->imagem->show();
            } else {
                $figura = new Imagem($this->imagem, $this->title, $this->imagemWidth, $this->imagemHeight);
                $figura->show();
            }
        }

        if (!is_null($this->label)) {
            echo '<span>';
            echo $this->label;
            echo '</span>';
        }
        echo '</a>';
    }

}
