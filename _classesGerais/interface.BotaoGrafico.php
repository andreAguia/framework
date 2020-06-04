<?php

class BotaoGrafico {

    /**
     * Cria um botão com uma imagem com um link
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @group do link
     * @var private $url       string  null    A url do botão. A página ou arquivo a ser chamado
     * @var private $tipo      string  link    O tipo do botão, podendo ser: link | print | exit | script | submit 
     * @var private $label     string  null    Label ou texto que ficará embaixo do botão
     * @var private $title     string  null    Texto de dica no onmouseover
     * @var private $target    string  null    Nome da div ou da janela onde será aberto o script
     * 
     * @group do css
     * @var private $id        string  null            Nome do id para o CSS
     * @var private $class     string  botaoGrafico    Nome da classe para o CSS
     * 
     * @group eventos
     * @var private $onclick       string  null    Jscript do onclick
     * @var private $onMouseOver   string  null    Jscript do onMouseOver
     * @var private $onMouseOut    string  null    Jscript do onMouseOut
     * 
     * @group quando for submit
     * @var private $formName string padrao Nome do Formulário quando o botão é do tipo submit
     * 
     * @group da imagem
     * @var private $image         string  "_semImagem.jpg" O caminho e o nome da Imagem a ser exibida
     * @var private $imageWidth    integer 48               Largura da imagem
     * @var private $imageHeight   integer 48               Altura da imagem
     * 
     * @group outros
     * @var private $confirma  string  null   Texto a ser exibido em uma janela confirmação em jscript. A rotina somente prosseguirá se o usuário pressionar sim. Utilizado na rotina de exclusão de registro, onde se pergunta se o usuário deseja realmente excluir.
     * @var private $tabIndex  integer null   Inteiro definindo a ordem na sequencia desse botão em um formulário.
     * @var private $accessKey string  null   Letra para se usar junto com a tecla ALT como atalho de acesso ao botão    
     * 
     * @example exemplo.botaoGrafico.php
     */
    private $url = null;
    private $tipo = 'link';
    private $label = null;
    private $title = null;
    private $target = null;
    private $id = null;
    private $class = "botaoGrafico";
    private $onClick = null;
    private $onMouseOver = null;
    private $onMouseOut = null;
    private $formName = 'padrao';
    private $imagem = "_semImagem.jpg";
    private $imagemWidth = 48;
    private $imagemHeight = 48;
    private $confirma = null;
    private $tabIndex = null;
    private $accessKey = null;

###########################################################

    public function __construct($id = null) {
        /**
         * Inicia a classe e define o id do css
         *  
         * @param $id string null O id para ser usado no css
         * 
         * @syntax $botao = new botaoGrafico([$id]);
         */
        $this->id = $id;
    }

###########################################################

    public function set_url($url = null) {
        /**
         * Informa A página a ser aberta
         * 
         * @syntax $botao->set_url($url);
         * 
         * @param $url string null A página a ser aberta
         */
        $this->url = $url;
    }

###########################################################

    public function set_tipo($tipo = null) {
        /**
         * Informa o tipo do botão grafico
         * 
         * @syntax $botao->set_tipo($tipo);
         * 
         * @param $tipo string null O tipo do botão, podendo ser: link | print | exit | script | submit 
         */
        $this->tipo = $tipo;
    }

###########################################################

    public function set_label($label = null) {
        /**
         * Informa o texto que ficará embaixo do botão
         * 
         * @syntax $botao->set_label($label);
         * 
         * @param $label string null Label ou texto que ficará embaixo do botão
         */
        $this->label = $label;
    }

###########################################################

    public function set_title($title = null) {
        /**
         * Informa o texto a ser exibido no mouseOver
         * 
         * @syntax $botao->set_title($title);
         * 
         * @param $title string null O nome do id
         */
        $this->title = $title;
    }

###########################################################

    public function set_target($target = null) {
        /**
         * Informa o nome da div ou da janela onde o link será aberto
         * 
         * @syntax $link->set_target($target);
         * 
         * @param $target string null Nome da div ou da janela onde o link será aberto
         */
        $this->target = $target;
    }

###########################################################

    public function set_id($id = null) {
        /**
         * Informa o id para o CSS
         * 
         * @syntax $link->set_id($id);
         * 
         * @param $id string null O nome do id
         */
        $this->id = $id;
    }

###########################################################

    public function set_class($class = null) {
        /**
         * Informa o nome da class para o css
         * 
         * @syntax $link->set_class($class);
         * 
         * @param $class string null O nome da class para o css
         */
        $this->class = $class;
    }

###########################################################

    public function set_imagem($image = null, $imageWidth = 48, $imageHeight = 48) {
        /**
         * Define a imagem do botão
         * 
         * @syntax $botao->set_imagem($image,[$imageWidth],[$imgageHeight]); 
         * 
         * @param $imagem        string  null O caminho e o nome da Imagem a ser exibida
         * @param $imagemWidth   integer 48	 Largura da imagem
         * @param $imagemHeight  integer 48	 Altura da imagem
         */
        $this->imagem = $image;
        $this->imagemWidth = $imageWidth;
        $this->imagemHeight = $imageHeight;
    }

###########################################################

    public function set_onClick($rotina = null) {
        /**
         * Define uma rotina em jscript para ser executada no evento onclick
         * 
         * @param $rotina string null Rotina em jscript a ser executada
         * 
         * @syntax $botao->set_onClick($rotina);
         * 
         * @note Ao definir o onclick de um botão a variável tipo passará automaticamente a ser script.
         */
        $this->onClick = $rotina;
        $this->tipo = 'script';
    }

    ###########################################################

    public function set_onMouseOver($rotina = null) {
        /**
         * Define uma rotina em jscript para ser executada no evento onMouseOver
         * 
         * @param $rotina string null Rotina em jscript a ser executada
         * 
         * @syntax $botao->set_onMouseOver($rotina);
         */
        $this->onMouseOver = $rotina;
    }

    ###########################################################

    public function set_onMouseOut($rotina = null) {
        /**
         * Define uma rotina em jscript para ser executada no evento onMouseOut
         * 
         * @param $rotina string null Rotina em jscript a ser executada
         * 
         * @syntax $botao->set_onMouseOut($rotina);
         */
        $this->onMouseOut = $rotina;
    }

    ###########################################################

    public function set_formName($formName = null) {
        /**
         * Define o nome do Formulário quando o botão é do tipo submit
         * 
         * @param formName string null Nome do Formulário quando o botão é do tipo submit
         * 
         * @syntax $botao->set_formName($formName);
         * 
         * @note Ao definir o formName de um botão a variável tipo passará automaticamente a ser submit.
         */
        $this->formName = $formName;
        $this->tipo = 'submit';
    }

    ###########################################################

    public function set_confirma($confirma = null) {
        /**
         * Informa um Texto a ser exibido para confirmar o clique. O programa somente continuará após pressionar Sim.
         * 
         * @syntax $botao->set_confirma($confirma);
         * 
         * @param $confirma string null Texto a ser exibido para confirmar o clique. 
         */
        $this->confirma = $confirma;
    }

###########################################################

    public function set_tabIndex($tabIndex = null) {
        /**
         * Informa um número inteiro definindo a ordem na sequencia desse botão em um formulário.
         * 
         * @syntax $botao->set_tabIndex($tabIndex);
         * 
         * @param $tabIndex integer null Número inteiro definindo a ordem na sequencia desse botão em um formulário. 
         */
        $this->tabIndex = $tabIndex;
    }

###########################################################

    public function set_accessKey($accessKey = null) {
        /**
         * Informa uma letra de atalho a ser utilizado junto com a tecla ALT para esse link
         * 
         * @syntax $botao->set_accessKey($accessKey);
         * 
         * @param $accessKey string null A letra de atalho para esse link     * 
         */
        $this->accessKey = $accessKey;
    }

###########################################################

    public function show($valorId = null) {
        /**
         * Exibe o botão
         * 
         * @param $valorId string null Usado na classe tabela quando se passa um objeto para ser exibido em uma célula da tabela e o parametro id é passado junto com o show($id)parâmetro Jscript ao evento onClick
         * 
         * @syntax $botao->show([$valorId]);
         */
        # Rotina de tecla de atalho
        if (!is_null($this->accessKey)) {
            # Altera o label colocando o sublinhado na letra do atalho (se tiver)
            $atalho = substr($this->label, 0, stripos($this->label, $this->accessKey));
            $atalho .= '<B><U>' . $this->accessKey . '</U></B>';
            $atalho .= substr($this->label, stripos($this->label, $this->accessKey) + 1);
            $this->label = $atalho;
        }

        # Abre a div
        $div = new Div($this->id, $this->class);
        $div->abre();

        # coloca a imagem
        echo "<input type=\"image\" src=\"$this->imagem\" width=\"$this->imagemWidth\" height=\"$this->imagemHeight\" title=\"$this->title\"";

        # id
        if (!is_null($this->id)) {
            echo ' id="' . $this->id . '"';
        }

        # verifica se tem tabulação definida
        if (!is_null($this->tabIndex)) {
            echo ' tabindex="' . $this->tabIndex . '"';
        }

        if (!is_null($this->accessKey)) {
            echo ' accesskey="' . $this->accessKey . '"';
        }

        # verifica se tem Mouse Over
        if (!is_null($this->onMouseOver)) {
            echo ' onMouseOver="' . $this->onMouseOver . '" ';
        }

        # verifica se tem Mouse Out
        if (!is_null($this->onMouseOut)) {
            echo ' onMouseOut="' . $this->onMouseOut . '" ';
        }

        # verifica o tipo de botão
        switch ($this->tipo) {
            case "link":
                if (!is_null($this->url)) {
                    if ((isset($this->confirma)) && ($this->confirma <> null)) {
                        echo " onclick='confirma(\"$this->url\",\"$this->confirma\")' />";
                    } else {
                        if (is_null($this->target)) {
                            if (is_null($valorId)) {
                                echo " onClick=\"window.location='$this->url'\" />";
                            } else {
                                echo " onClick=\"window.location='$this->url$valorId'\" />";
                            }
                        } else {
                            echo " onClick=\"window.open('$this->url','$this->target','menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=1000,height=700');\" />";
                        }
                    }
                }
                break;

            case "print":
                echo " onclick='window.print()' />";
                break;

            case "exit":
                echo " onclick='self.close()' />";
                break;

            case "script":
                echo ' onclick="' . $this->onClick;
                if (!is_null($valorId)) {
                    echo $valorId . ');';
                }
                echo '" />';
                break;

            case "submit":
                echo " onclick=\"document.$this->formName.submit();return false;\" />";
                break;
        }

        br();

        # coloca o label
        if (!is_null($this->label)) {
            echo $this->label;
        }

        # Fecha a div
        $div->fecha();
    }

}
