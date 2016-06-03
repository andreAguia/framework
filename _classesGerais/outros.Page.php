<?php
 /**
 * classe Page
 * Define uma página web
 *
 * By Alat
 */
class Page
{
    # Atributos pegos do config
    private $description = DESCRICAO;       # Descrição do Site
    private $keywords = PALAVRAS_CHAVE;     # Palavras chave para site de busca
    private $author = AUTOR;                # Autor do Código
    private $system = SISTEMA;              # Nome do Sistema
    private $version = VERSAO;              # Versão do Sistema

    # refresh
    private $refresh = false;   # Se a página terá refresh automático
    private $refreshTime = 30;  # O tempo para esse refresh em segundos

    # do título da página
    private $title = null;      # Guarda o title da página (mensagem do topo no browser)

    # javaScript extra
    private $jscript = null;    # acrescenta uma rotina jscript extra;
    private $bodyOnLoad = null; # acrescenta rotina no onload do body;

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
     * método iniciaPagina
     * 
     * Inicia uma página
     */
    public function iniciaPagina()
    {
        # Inicia o buffer de sa�da
        ob_start();

        # Inicia a página
        echo '<!DOCTYPE html>';                     # Doctype para html5
        echo '<html class="no-js" lang="pt-br">';   # Abre a tag html e informa o idioma (html5)

        echo '<head>';
        echo '<meta charset="utf-8" />';                                      # Código de caractere
        
        echo '<meta http-equiv="x-ua-compatible" content="ie=edge">';                   # Foundation
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';  # Foundation
        
        echo '<meta name="description" content="'.$this->description.'">';  # Descrição da página
        echo '<meta name="keywords" content="'.$this->keywords.'">';        # Palavras chave para motores de busca
        echo '<meta name="author" content="'.$this->author.'">';            # Autor da Página
        
        echo '<meta http-equiv="pragma" content="no-cache">';               # Obriga o Navegador a não usar cache
 

        # Se tiver refresh automático
        if($this->refresh)
            echo '<meta http-equiv="refresh" content="'.$this->refreshTime.'">';

        # Título da página
        if(is_null($this->title))
            echo '<title>'.$this->system.' - '.$this->version.'</title>';
        else
            echo '<title>'.$this->title.'</title>';

        # Java Script da máscara de entrada de dados
        echo'<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'mascara.js"></script>';

        # Java Script da máscara de entrada de moeda
        echo'<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'mascaraMoeda.js"></script>';        
        
        # Java Script de várias funções
        echo'<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'funcoes.java.js"></script>';
        
        # Java Script Extra
        if(!is_null($this->jscript))
            echo $this->jscript;

        # Carrega o css
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS_GERAIS.'foundation.css" />';
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS_GERAIS.'foundation-flex.css" />';
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS_GERAIS.'foundation-icons.css" />';
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS_GERAIS.'geral.css" />';
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS_GERAIS.'app.css" />';
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS_GERAIS.'impressao.css" media="print"/>';
        
        echo '<link rel="stylesheet" href="'.PASTA_ESTILOS.'estilos.css" />';
        
        echo '<link rel="shortcut icon" href="'.PASTA_FIGURAS.'uenf.gif" />';
        echo '</head>';

         if(is_null($this->bodyOnLoad))
            echo '<body>';
         else
            echo '<body onload='.$this->bodyOnLoad.'>';
    }

    ###########################################################
     /**
     * método terminaPagina
     * 
     * Termina e fecha a página
     */
    
    public function terminaPagina()
    {
         # Java Script do Foundation
        echo '<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'foundation.js"></script>';
        echo '<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'jquery.min.js"></script>';
        echo '<script language="JavaScript" src="'.PASTA_FUNCOES_GERAIS.'what-input.min.js"></script>';        

        echo '</body>';
        echo '<footer id="center">';        
        echo '</footer>';
        echo '</html>';

        ob_end_flush();
    }

}
?>
