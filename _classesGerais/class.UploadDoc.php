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
    private $extensoes = NULL;  // array  As extensões permitidas. Pode ser array ou string.
    
###########################################################

    function __construct($arquivo = NULL, $pasta = NULL, $nome = NULL, $extensoes = NULL){
        
        $this->arquivo = $arquivo;
        $this->pasta   = $pasta;
        $this->nome    = $nome;
        
        if(is_null($extensoes)){
            $this->extensoes = array("pdf");
        }else{
            $this->extensoes = $extensoes;
        }
    }
    
###########################################################

    private function getExtensao(){
        
        //retorna a extensao do documento
        $img_nome = $this->arquivo['name'];
        $img_separador = explode('.',$img_nome);
        $extensaoArquivo = strtolower(end($img_separador));
        return $extensaoArquivo;
    }
    
###########################################################

    public function salvar(){
        
        # Pega a extensão
        $extensaoArquivo = $this->getExtensao();
        echo $extensaoArquivo;
        # Verifica se a extensão é permitida
        if (in_array($extensaoArquivo, $this->extensoes)) {
            # Gera o nome do arquivo
            $novo_nome = $this->nome.'.'.$extensaoArquivo;

            # Localizacao do arquivo 
            $destino = $this->pasta . $novo_nome;

            # Move o arquivo
            if (! move_uploaded_file($this->arquivo['tmp_name'], $destino)){
                if ($this->arquivo['error'] == 1) {
                    alert ("Tamanho excede o permitido");
                    return FALSE;
                } 
            }else{
                return TRUE;
            }
        }else{
            alert ("Extensão não Permitida");
            return FALSE;
        }
    }
    
###########################################################
}