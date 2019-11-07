<?php
class UploadDoc
{
/**
 * Upload uma Imagem
 *
 * @author Marco Antoni <marquinho9.10@gmail.com>
 * 
 * @var private $arquivo    FILE    NULL O arquivo a ser trabalhado
 * @var private $pasta      string  NULL O caminho da pasta onde será armazenada a imagem
 * @var private $nome       string  NULL O nome do arquivo ao final do upload
 */
    
    private $arquivo = NULL;    // FILE   O arquivo a ser trabalhado
    private $pasta = NULL;      // string O caminho da pasta onde será armazenada o documento
    private $nome = NULL;       // string O nome do arquivo ao final do upload
    
###########################################################

    function __construct($arquivo, $pasta, $nome){
        
        $this->arquivo = $arquivo;
        $this->pasta   = $pasta;
        $this->nome    = $nome;
    }
    
###########################################################

    private function getExtensao(){
        
        //retorna a extensao do documento
        $img_nome = $this->arquivo['name'];
        $img_separador = explode('.',$img_nome);
        $extensao = strtolower(end($img_separador));
        return $extensao;
    }
    
###########################################################

    private function ehImagem($extensao){
        
        $extensoes = array('gif', 'jpeg', 'jpg', 'png', 'img', 'jpeg');     // extensoes permitidas
        if (in_array($extensao, $extensoes)) {
            return true;
        }
    }
    
###########################################################

    public function salvar(){
        
        # Pega a extensão
        $extensao = $this->getExtensao();

        //gera um nome unico para a imagem em funcao do tempo
        if(is_null($this->nome)){
            $novo_nome = time().'.jpg';
        }else{
            $novo_nome = $this->nome.'.jpg';
        }
        //localizacao do arquivo 
        $destino = $this->pasta . $novo_nome;

        //move o arquivo
        if (! move_uploaded_file($this->arquivo['tmp_name'], $destino)){
            if ($this->arquivo['error'] == 1) {
                return "Tamanho excede o permitido";
            } 
        }
    }
    
###########################################################
}