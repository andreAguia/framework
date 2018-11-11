<?php
class BotaoGrafico
{
    /**
     * Cria um botão com uma imagem com um link
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @group do link
     * @var private $url       string  NULL    A url do botão. A página ou arquivo a ser chamado
     * @var private $tipo      string  link    O tipo do botão, podendo ser: link | print | exit | script | submit 
     * @var private $label     string  NULL    Label ou texto que ficará embaixo do botão
     * @var private $title     string  NULL    Texto de dica no onmouseover
     * @var private $target    string  NULL    Nome da div ou da janela onde será aberto o script
     * 
     * @group do css
     * @var private $id        string  NULL            Nome do id para o CSS
     * @var private $class     string  botaoGrafico    Nome da classe para o CSS
     * 
     * @group eventos
     * @var private $onclick       string  NULL    Jscript do onclick
     * @var private $onMouseOver   string  NULL    Jscript do onMouseOver
     * @var private $onMouseOut    string  NULL    Jscript do onMouseOut
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
     * @var private $confirma  string  NULL   Texto a ser exibido em uma janela confirmação em jscript. A rotina somente prosseguirá se o usuário pressionar sim. Utilizado na rotina de exclusão de registro, onde se pergunta se o usuário deseja realmente excluir.
     * @var private $tabIndex  integer NULL   Inteiro definindo a ordem na sequencia desse botão em um formulário.
     * @var private $accessKey string  NULL   Letra para se usar junto com a tecla ALT como atalho de acesso ao botão    
     * 
     * @example exemplo.botaoGrafico.php
     */
	
    private $url = NULL;
    private $tipo = 'link';
    private $label = NULL;
    private $title = NULL;
    private $target = NULL;
    
    private $id = NULL;
    private $class = "botaoGrafico";

    private $onClick = NULL;
    private $onMouseOver = NULL;
    private $onMouseOut = NULL;
    
    private $formName = 'padrao';       

    private $imagem = "_semImagem.jpg";
    private $imagemWidth = 48;
    private $imagemHeight = 48;    

    private $confirma = NULL;    
    private $tabIndex = NULL;
    private $accessKey = NULL;
    
###########################################################
    
    public function __construct($id = NULL){   
    /**
     * Inicia a classe e define o id do css
     *  
     * @param $id string NULL O id para ser usado no css
     * 
     * @syntax $botao = new botaoGrafico([$id]);
     */
        
        $this->id = $id;
    }
    
###########################################################

    public function set_url($url = NULL){
    /**
     * Informa A página a ser aberta
     * 
     * @syntax $botao->set_url($url);
     * 
     * @param $url string NULL A página a ser aberta
     */    
        $this->url = $url;
    }
    
###########################################################

    public function set_tipo($tipo = NULL){
    /**
     * Informa o tipo do botão grafico
     * 
     * @syntax $botao->set_tipo($tipo);
     * 
     * @param $tipo string NULL O tipo do botão, podendo ser: link | print | exit | script | submit 
     */
    
        $this->tipo = $tipo;
    }
    
###########################################################

    public function set_label($label = NULL){
    /**
     * Informa o texto que ficará embaixo do botão
     * 
     * @syntax $botao->set_label($label);
     * 
     * @param $label string NULL Label ou texto que ficará embaixo do botão
     */
    
        $this->label = $label;
    }
    
###########################################################


    public function set_title($title = NULL){
    /**
     * Informa o texto a ser exibido no mouseOver
     * 
     * @syntax $botao->set_title($title);
     * 
     * @param $title string NULL O nome do id
     */
    
        $this->title = $title;
    }
    
###########################################################

    public function set_target($target = NULL){
    /**
     * Informa o nome da div ou da janela onde o link será aberto
     * 
     * @syntax $link->set_target($target);
     * 
     * @param $target string NULL Nome da div ou da janela onde o link será aberto
     */
    
        $this->target = $target;
    }
    
###########################################################

    public function set_id($id = NULL){
    /**
     * Informa o id para o CSS
     * 
     * @syntax $link->set_id($id);
     * 
     * @param $id string NULL O nome do id
     */
    
        $this->id = $id;
    }
    
###########################################################
    
    public function set_class($class = NULL){
    /**
     * Informa o nome da class para o css
     * 
     * @syntax $link->set_class($class);
     * 
     * @param $class string NULL O nome da class para o css
     */
    
        $this->class = $class;
    }

###########################################################
    
    public function set_imagem($image = NULL,$imageWidth = 48, $imageHeight = 48){
    /**
     * Define a imagem do botão
     * 
     * @syntax $botao->set_imagem($image,[$imageWidth],[$imgageHeight]); 
     * 
     * @param $imagem        string  NULL O caminho e o nome da Imagem a ser exibida
     * @param $imagemWidth   integer 48	 Largura da imagem
     * @param $imagemHeight  integer 48	 Altura da imagem
     */
    
        $this->imagem = $image;
        $this->imagemWidth = $imageWidth;
        $this->imagemHeight = $imageHeight;        
    }

###########################################################
    
    public function set_onClick($rotina = NULL){
    /**
     * Define uma rotina em jscript para ser executada no evento onclick
     * 
     * @param $rotina string NULL Rotina em jscript a ser executada
     * 
     * @syntax $botao->set_onClick($rotina);
     * 
     * @note Ao definir o onclick de um botão a variável tipo passará automaticamente a ser script.
     */
    
        $this->onClick = $rotina;
        $this->tipo = 'script';
    }

 ###########################################################
    
    public function set_onMouseOver($rotina = NULL){
    /**
     * Define uma rotina em jscript para ser executada no evento onMouseOver
     * 
     * @param $rotina string NULL Rotina em jscript a ser executada
     * 
     * @syntax $botao->set_onMouseOver($rotina);
     */
    
        $this->onMouseOver = $rotina;
    }

 ###########################################################
    
    public function set_onMouseOut($rotina = NULL){
    /**
     * Define uma rotina em jscript para ser executada no evento onMouseOut
     * 
     * @param $rotina string NULL Rotina em jscript a ser executada
     * 
     * @syntax $botao->set_onMouseOut($rotina);
     */
    
        $this->onMouseOut = $rotina;
    }

 ###########################################################
    
    public function set_formName($formName = NULL){
    /**
     * Define o nome do Formulário quando o botão é do tipo submit
     * 
     * @param formName string NULL Nome do Formulário quando o botão é do tipo submit
     * 
     * @syntax $botao->set_formName($formName);
     * 
     * @note Ao definir o formName de um botão a variável tipo passará automaticamente a ser submit.
     */
    
        $this->formName = $formName;
        $this->tipo = 'submit';
    }

 ###########################################################

    public function set_confirma($confirma = NULL){
    /**
     * Informa um Texto a ser exibido para confirmar o clique. O programa somente continuará após pressionar Sim.
     * 
     * @syntax $botao->set_confirma($confirma);
     * 
     * @param $confirma string NULL Texto a ser exibido para confirmar o clique. 
     */
    
        $this->confirma = $confirma;
    }

###########################################################

    public function set_tabIndex($tabIndex = NULL){
    /**
     * Informa um número inteiro definindo a ordem na sequencia desse botão em um formulário.
     * 
     * @syntax $botao->set_tabIndex($tabIndex);
     * 
     * @param $tabIndex integer NULL Número inteiro definindo a ordem na sequencia desse botão em um formulário. 
     */
    
        $this->tabIndex = $tabIndex;
    }

###########################################################

    public function set_accessKey($accessKey = NULL){
    /**
     * Informa uma letra de atalho a ser utilizado junto com a tecla ALT para esse link
     * 
     * @syntax $botao->set_accessKey($accessKey);
     * 
     * @param $accessKey string NULL A letra de atalho para esse link     * 
     */
    
        $this->accessKey = $accessKey;
    }

###########################################################

 
    public function show($valorId = NULL){
    /**
     * Exibe o botão
     * 
     * @param $valorId string NULL Usado na classe tabela quando se passa um objeto para ser exibido em uma célula da tabela e o parametro id é passado junto com o show($id)parâmetro Jscript ao evento onClick
     * 
     * @syntax $botao->show([$valorId]);
     */
           
        # Rotina de tecla de atalho
        if(!is_null($this->accessKey)){			
            # Altera o label colocando o sublinhado na letra do atalho (se tiver)
            $atalho  = substr($this->label,0,stripos($this->label,$this->accessKey));
            $atalho .= '<B><U>'.$this->accessKey.'</U></B>';
            $atalho .= substr($this->label,stripos($this->label,$this->accessKey)+1);
            $this->label = $atalho;
        }

        # Abre a div
        $div = new Div($this->id,$this->class);
        $div->abre();
        
        # coloca a imagem
        echo "<input type=\"image\" src=\"$this->imagem\" width=\"$this->imagemWidth\" height=\"$this->imagemHeight\" title=\"$this->title\"";

        # id
        if(!is_null($this->id)){
            echo ' id="'.$this->id.'"';
        }
        
        # verifica se tem tabulação definida
        if(!is_null($this->tabIndex)){
            echo ' tabindex="'.$this->tabIndex.'"';
        }

        if(!is_null($this->accessKey)){
            echo ' accesskey="'.$this->accessKey.'"';
        }

        # verifica se tem Mouse Over
        if (!is_null($this->onMouseOver)){
            echo ' onMouseOver="'.$this->onMouseOver.'" ';
        }

        # verifica se tem Mouse Out
        if (!is_null($this->onMouseOut)){
            echo ' onMouseOut="'.$this->onMouseOut.'" ';
        }

        # verifica o tipo de botão
        switch ($this->tipo){
            case "link":
                if (!is_null($this->url)){
                    if ((isset($this->confirma)) && ($this->confirma <> NULL)){
                        echo " onclick='confirma(\"$this->url\",\"$this->confirma\")' />";
                    }
                    else{
                        if (is_null($this->target)){
                            if(is_null($valorId)){
                                echo " onClick=\"window.location='$this->url'\" />";
                            }                              
                            else{
                                echo " onClick=\"window.location='$this->url$valorId'\" />";
                                
                            }
                        }
                        else{
                            echo " onClick=\"window.open('$this->url','$this->target','menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=750,height=600');\" />";
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
                echo ' onclick="'.$this->onClick;
                if(!is_null($valorId)){
                    echo $valorId.');';
                }
                echo '" />';
                break;	

            case "submit":	
                echo " onclick=\"document.$this->formName.submit();return FALSE;\" />";
                break;	
        }
                
        br();
        
        # coloca o label
        if(!is_null($this->label)){
            echo $this->label;
        }
        
        # Fecha a div
        $div->fecha();        
    }
}