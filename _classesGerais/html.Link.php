<?php
class Link
{	    
    /**
     * Monta um Link
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @group do link
     * @var private $label  string NULL O texto a ser exibido no link.
     * @var private $url    string NULL A url do link.
     * @var private $title  string NULL Texto que irá aparecer no evento mouseover
     * @var private $target string NULL Nome da div ou da janela onde o link será aberto
     * 
     * @group do css
     * @var private $class string NULL A classe para o css.
     * @var private $id    string NULL O id para o css.
     * 
     * @group da janela
     * @var private $janela       boolean FALSE Indica se o link abrirá uma janela. Usado nas rotinas de relatórios.
     * @var private $janelaWidth  integer 750   A largura da janela
     * @var private $janelaHeight integer 600   A altura da janela 
     * 
     * @group eventos
     * @var private $onClick string NULL A rotina jscript a ser executada no evento onclick.
     *
     * @group outros
     * @var private $confirma  string  NULL   Texto a ser exibido em uma janela confirmação em jscript. A rotina somente prosseguirá se o usuário pressionar sim.
     * @var private $accessKey string  NULL   Letra para se usar junto com a tecla ALT como atalho de acesso ao botão 
     * 
     * @group da imagem
     * @var private $imagem         string  "_semImagem.jpg" O caminho e o nome da Imagem a ser exibida
     * @var private $imagemWidth    integer 48               Largura da imagem
     * @var private $imagemHeight   integer 48               Altura da imagem
     * 
     * @example exemplo.link.php
     */

    private $label = NULL;
    private $url = NULL;
    private $title = NULL;
    private $target = NULL;    

    private $class = NULL;
    private $id = NULL;
    
    private $onClick = NULL;
        
    private $confirma = NULL;
    private $accessKey = NULL;
    
    private $imagem = NULL;
    private $imagemWidth = 48;
    private $imagemHeight = 48;    

###########################################################

    public function __construct($label = NULL,$url = NULL, $title = NULL){
        
    /**
     * Constroi um link sem exibí-lo
     * 
     * @param $label string NULL O texto a ser exibido no link
     * @param $url   string NULL A url do link
     * @param $title string NULL O texto a ser exibido no mouseover
     * 
     * @syntax $link = new Link($label,[$url],[$title]);
     */
    
        $this->label = $label;
        $this->url = $url;
        $this->title = $title;
    }

###########################################################
    
    public function set_url($url = NULL){
    /**
     * Informa a url
     * 
     * @syntax $link->set_url($url);
     * 
     * @param $url string NULL O caminho do link do link
     */
    
        $this->url = $url;
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

    public function set_title($title = NULL){
    /**
     * Informa o texto a ser exibido no mouseOver
     * 
     * @syntax $link->set_title($title);
     * 
     * @param $title string NULL O texto do mouseover
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

    public function set_onClick($onClick = NULL){
    /**
     * Informa a rotina jscript a ser executada no evento onclick.
     * 
     * @syntax $link->set_onClick($onClick);
     * 
     * @param $onClick string NULL A rotina jscript a ser executada no evento onclick.
     */
    
        $this->onClick = $onClick;
    }

###########################################################

    public function set_accessKey($accessKey = NULL){
    /**
     * Informa uma letra de atalho a ser utilizado junto com a tecla ALT para esse link
     * 
     * @syntax $link->set_accessKey($accessKey);
     * 
     * @param $accessKey string NULL A letra de atalho para esse link     * 
     */
    
        $this->accessKey = $accessKey;
    }

###########################################################

    public function set_confirma($confirma = NULL){
    /**
     * Informa um Texto a ser exibido para confirmar o clique. O programa somente continuará após pressinar Sim.
     * 
     * @syntax $link->set_confirma($confirma);
     * 
     * @param $confirma string NULL Texto a ser exibido para confirmar o clique. 
     */
    
        $this->confirma = $confirma;
    }

###########################################################
    
    public function set_imagem($imagem = NULL,$imagemWidth = 48, $imagemHeight = 48){
    /**
     * Define a imagem do botão
     * 
     * @syntax $botao->set_imagem($imagem,[$imagemWidth],[$imgagemHeight]); 
     * 
     * @param $imagem        string  NULL O caminho e o nome da Imagem a ser exibida
     * @param $imagemWidth   integer 48	 Largura da imagem
     * @param $imagemHeight  integer 48	 Altura da imagem
     */
    
        $this->imagem = $imagem;
        $this->imagemWidth = $imagemWidth;
        $this->imagemHeight = $imagemHeight;        
    }

###########################################################

    public function show($id = NULL){
    /**
     * Exibe o link
     * 
     * @param  $id integer NULL	Usado em links em tabelas para acrescentar o id do registro a url
     */    

        # Atalho
        if($this->accessKey<>NULL){			
            # Altera o label colocando o sublinhado na letra do atalho (se tiver)
            $atalho  = substr($this->label,0,stripos($this->label,$this->accessKey));
            $atalho .= '<B><U>'.$this->accessKey.'</U></B>';
            $atalho .= substr($this->label,stripos($this->label,$this->accessKey)+1);
            $this->label = $atalho;
        }

        # Começa o link
        echo '<a';
        
        # class
        if(!is_null($this->class)){
            echo ' class="'.$this->class.'"';
        }
        
        # id
        if(!is_null($this->id)){
            echo ' id="'.$this->id.'"';
        }
        
        # target
        if (!is_null($this->target)){
            if($this->target == '_blank'){
                echo " onClick=\"window.open('$this->url','$this->target','menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=1000,height=700');\" ";
                $this->url = "#";
            }else{
                echo ' target="'.$this->target.'"';
            }
        }
        
        # Verifica se tem confirmação
        if ($this->confirma <> NULL){  // com confirmação
            if(is_null($id)){	// Exibe ou não o id
                echo " onclick='confirma(\"$this->url\",\"$this->confirma\")'";
            }
            else{
                echo " onclick='confirma(\"$this->url$id\",\"$this->confirma\")'"; 	
            }

            echo ' href="#"';
        }else{	   // sem confirmação
            if(is_null($this->onClick)){        
                if(is_null($id)){	// Exibe ou não o id
                    echo ' href="'.$this->url.'"';
                }
                else{
                    echo ' href="'.$this->url.$id.'"';
                }
            }
            else{
                echo ' href="javascript:'.$this->onClick.'"';
            }
        }
        
        # o destino
        if((!is_null($this->url)) OR (!is_null($this->onClick))){

            # Verifica se tem confirmação
            if($this->confirma <> NULL){  // com confirmação
                if(is_null($id)){	// Exibe ou não o id
                    echo " onclick='confirma(\"$this->url\",\"$this->confirma\")'";
                }else{
                    echo " onclick='confirma(\"$this->url$id\",\"$this->confirma\")'"; 	
                }
                echo ' href="#"';
            }else{	   // sem confirmação
                if(is_null($this->onClick)){        
                    if(is_null($id)){	// Exibe ou não o id
                        echo ' href="'.$this->url.'"';
                    }else{
                        echo ' href="'.$this->url.$id.'"';
                    }
                }else{
                    echo ' href="javascript:'.$this->onClick.'"';
                }
            }
        }
            
        if(!is_null($this->accessKey)){
            echo ' accesskey="'.$this->accessKey.'"';
        }

        if (!is_null($this->title)){
            echo ' title="'.$this->title.'"';
        }
        
        echo '>';
        
        # imagem
        if(!is_null($this->imagem)){
            if(is_object($this->imagem)){
                $this->imagem->show(); 
            }else{
                $figura = new Imagem($this->imagem,$this->title,$this->imagemWidth,$this->imagemHeight);
                $figura->show();
            }
        }
        
        if (!is_null($this->label)){
            echo '<span>';
            echo $this->label;
            echo '</span>';
        }        
        echo '</a>';
    }
}