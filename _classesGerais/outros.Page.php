<?php
class Page
{
 /**
  * Inicia e termina uma página html
  *
  * @author André Águia (Alat) - alataguia@gmail.com
  * 
  * @group do atributos do config
  * @var private $description string DESCRICAO      Descrição do site ou sistema.
  * @var private $keywords    string PALAVRAS_CHAVE Palavras chave para site de busca.
  * @var private $author      string AUTOR          Autor do Código.
  * @var private $system      string SISTEMA        Nome do Sistema.
  * @var private $version     string VERSAO         Versão do Sistema.
  * @var private $title       string NULL           O title da página (mensagem do topo no browser)
  * 
  * @group do refresh
  * @var private $refresh     bool    FALSE Se a página terá refresh automático
  * @var private $refreshTime integer 30    Versão do Sistema.
  * 
  * @group do javaScript
  * @var private $jscript    string NULL Acrescenta uma rotina jscript extra.
  * @var private $bodyOnLoad string NULL Acrescenta rotina no onload do body.
  */
    
    # Atributos pegos do config
    private $description = DESCRICAO;       # Descrição do Site
    private $author = AUTOR;                # Autor do Código
    private $system = SISTEMA;              # Nome do Sistema
    private $version = VERSAO;              # Versão do Sistema
    private $title = NULL;                  # O title da página (mensagem do topo no browser)

    # refresh
    private $refresh = FALSE;   # Se a página terá refresh automático
    private $refreshTime = 30;  # O tempo para esse refresh em segundos    

    # javaScript
    private $jscript = NULL;    # acrescenta uma rotina jscript extra;
    private $bodyOnLoad = NULL; # acrescenta rotina no onload do body;
    
    # jquery
    private $ready = NULL;      # inicia a rotina quando a tela começa a carregar (DOM ready)
    private $onLoad = NULL;     # inicia a rotina quando toda a página terminar de carregar

###########################################################
    
    public function set_title($title = NULL){
    /**
     * Informa o title da página, mensagem do topo no browser
     * 
     * @syntax $page->set_title($title);
     * 
     * @param $title string NULL O title da página
     */
    
        $this->title = $title;
    }

###########################################################
    
    public function set_refresh($refresh, $refreshTime = 30){
    /**
     * Informa se a página terá atualização automática. 
     * 
     * @syntax $page->set_refresh($refresh, [$refreshTime]);
     * 
     * @param $refresh     bool    NULL Se a página possui ou não atualização automática (TRUE / FALSE)
     * @param $refreshTime integer 30   Informa, em segundos, o tempo para ser atualizada.
     */
    
        $this->refresh = $refresh;
        $this->refreshTime = $refreshTime;
    }

###########################################################
    
    public function set_jscript($jscript = NULL){
    /**
     * Informa a rotina jscript extra que será carregada junto com as outras rotinas js
     * 
     * @syntax $page->set_jscript($jscript);
     * 
     * @param $jscript string NULL Rotina jscript extra que será carregada junto com as outras rotinas js
     */
    
        $this->jscript = $jscript;
    }

###########################################################
    
    public function set_bodyOnLoad($bodyOnLoad = NULL){
    /**
     * Informa a rotina a ser executada ao carregar o body
     * 
     * @syntax $page->set_bodyOnLoad($bodyOnLoad);
     * 
     * @param $bodyOnLoad string NULL Rotina a ser executada ao carregar o body
     */
    
        $this->bodyOnLoad = $bodyOnLoad;
    }

###########################################################
    
    public function set_ready($ready = NULL){
    /**
     * Executa rotina ao iniciar a página (carregar o DOM) utilizando o jquery
     * 
     * @syntax $page->set_ready($ready);
     * 
     * @param $ready string NULL Rotina a ser executada 
     */
    
        $this->ready = $ready;
    }

###########################################################
    
    public function set_onLoad($onLoad = NULL){
    /**
     * Executa rotina quando toda a página for carregada utilizando o jquery
     * 
     * @syntax $page->set_onLoad($onLoad);
     * 
     * @param $onLoad string NULL Rotina a ser executada
     */
    
        $this->onLoad = $onLoad;
    }

###########################################################

    public function iniciaPagina(){
    /**
     * Inicia a página
     * 
     * @note Rotina executa todas os comandos iniciais da página. Carrega os arquivos de estilo (CSS) e de jscript.
     * 
     * @syntax $page->iniciaPagina();
     */
    
        # Inicia o buffer de saída
        ob_start();

        # Inicia a página
        echo '<!DOCTYPE html>';                     # Doctype para html5
        echo '<html class="no-js" lang="pt-br">';   # Abre a tag html e informa o idioma (html5)

        echo '<head>';
        echo '<meta charset="utf-8" />';               # Código de caractere
        
        echo '<meta http-equiv="x-ua-compatible" content="ie=edge">';                   # Foundation
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';  # Foundation
        
        echo '<meta name="description" content="'.$this->description.'">';  # Descrição da página
        echo '<meta name="author" content="'.$this->author.'">';            # Autor da Página
        
        echo '<meta http-equiv="pragma" content="no-cache">';               # Obriga o Navegador a não usar cache

        # Se tiver refresh automático
        if ($this->refresh) {
            echo '<meta http-equiv="refresh" content="' . $this->refreshTime . '">';
        }

        # Título da página
        if (is_null($this->title)) {
            echo '<title>' . $this->system . '</title>';
        } else {
            echo '<title>' . $this->title . '</title>';
        }

        # Java Script da máscara de entrada de dados
        echo'<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'mascara.js"></script>';

        # Java Script da máscara de entrada de moeda
        echo'<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'mascaraMoeda.js"></script>';        
        
        # Java Script de várias funções
        echo'<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'funcoes.java.js"></script>';
        
        # Jquery
        echo '<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'jquery.js"></script>';
        
        # Foundation
        echo '<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'foundation.js"></script>';
        
        # Java Script Extra
        if(!is_null($this->jscript)){
            echo $this->jscript;
        }
        
        # Jquery ready - executa no início do carregamento da página
        if(!is_null($this->ready)){
            echo "<script language='JavaScript'>   
            $(document).ready(function(){
                ".$this->ready."  
            });
            </script>
            ";
        }
        
        # Jquery load - executa somente depois de toda a página carregada
        if(!is_null($this->onLoad)){
            echo "<script language='JavaScript'>   
            $(windows).load(function(){
                ".$this->onLoad."  
            });
            </script>
            ";
        }

        # Carrega o css
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS_GERAIS.'foundation.css" />';
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS_GERAIS.'app.css" />';
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS_GERAIS.'impressao.css" media="print"/>';
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS.'estilos.css" />';
        
        echo '<link rel="shortcut icon" href="'.PASTA_FIGURAS.'uenf.gif" />';
        echo '</head>';

         if(is_null($this->bodyOnLoad)){
            echo '<body>';
         }else{
            echo '<body onload='.$this->bodyOnLoad.'>';
         }
         
         # Define o timezone
         date_default_timezone_set('America/Sao_Paulo');
    }

###########################################################
    
    public function terminaPagina(){
    /**
     * Termina a página
     * 
     * @note Rotina executa todas os comandos de fechamento da página.
     * 
     * @syntax $page->terminaPagina();
     */
        # Java Script do Foundation
        #echo '<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'what-input.js"></script>';
        echo '<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'foundation.js"></script>';
        #echo '<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'foundation.min.js"></script>'; 
        #echo '<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'app.js"></script>';

        echo '</body>';
        echo '<footer id="center">';        
        echo '</footer>';
        echo '</html>';

        # Termina o buffer de saída
        ob_end_flush();
    }
}