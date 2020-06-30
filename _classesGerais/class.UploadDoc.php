<?php

class UploadDoc {

    /**
     * Upload de Documentos em Geral que não são Imagens
     *
     * @author Marco Antoni <marquinho9.10@gmail.com>
     */
    private $arquivo = null;    // FILE   O arquivo a ser trabalhado
    private $pasta = null;      // string O caminho da pasta onde será armazenada o documento
    private $nome = null;       // string O nome do arquivo ao final do upload
    private $extensoes = null;  // array  As extensões permitidas. Pode ser array ou string.

###########################################################

    public function __construct($arquivo = null, // file     O arquivo que veio por post para ser subido.
                                $pasta = null, // string   A pasta onde vai ser gravado
                                $nome = null, // string   O nome que o arquivo será gravado no servidor 
                                $extensoes = null)
    {    // array    As extensões permitidas nesse upload        
        /**
         * Inicia a classe
         * 
         * @syntax $documento = new UploadDoc($arquivo, $pasta, $nome, $extensoes);
         */

        $this->arquivo = $arquivo;
        $this->pasta = $pasta;
        $this->nome = $nome;

        if (is_null($extensoes)) {
            $this->extensoes = array("pdf");
        } else {
            $this->extensoes = $extensoes;
        }
    }

###########################################################

    private function getExtensao() {
        /**
         * Retorna a extensão do arquivo a ser subido
         * 
         * @syntax $documento->getExtensao();
         */
        $img_nome = $this->arquivo['name'];
        $img_separador = explode('.', $img_nome);
        $extensaoArquivo = strtolower(end($img_separador));
        return $extensaoArquivo;
    }

###########################################################

    public function salvar() {

        /**
         * Executa o Upload salvando na pasta indicada ou retornando um erro
         * 
         * @syntax $documento->salvar();
         */
        # Pega a extensão
        $extensaoArquivo = $this->getExtensao();

        # Verifica se a extensão é permitida
        if (in_array($extensaoArquivo, $this->extensoes)) {
            # Gera o nome do arquivo
            $novo_nome = $this->nome . '.' . $extensaoArquivo;

            # Localizacao do arquivo 
            $destino = $this->pasta . $novo_nome;

            # Move o arquivo
            if (move_uploaded_file($this->arquivo['tmp_name'], $destino)) {
                return true;
            } else {
                if ($this->arquivo['error'] == 1) {
                    alert("Tamanho excede o permitido.");
                    return false;
                } else {
                    alert("Aconteceu algum problema.");
                    return false;
                }
            }
        } else {
            alert("Extensão não Permitida. ($extensaoArquivo)");
            return false;
        }
    }

###########################################################
}
