<?php
class UploadImage
{
/**
 * Upload uma Imagem
 *
 * @author Marco Antoni <marquinho9.10@gmail.com>
 * 
 * @var private $arquivo    FILE    NULL O arquivo a ser trabalhado
 * @var private $altura     integer NULL Altura máxima em que a imagem terá apos o upload
 * @var private $largura    integer NULL Largura máxima em que a imagem terá apos o upload
 * @var private $pasta      string  NULL O caminho da pasta onde será armazenada a imagem
 * @var private $nome       string  NULL O nome do arquivo ao final do upload
 */
    
    private $arquivo;
    private $altura;
    private $largura;
    private $pasta;
    private $nome;
    private $extensoes = NULL;  // array  As extensões permitidas. Pode ser array ou string.
    
###########################################################

    function __construct($arquivo = NULL, $altura = NULL, $largura = NULL, $pasta = NULL, $nome = NULL, $extensoes = NULL){
        $this->arquivo = $arquivo;
        $this->altura  = $altura;
        $this->largura = $largura;
        $this->pasta   = $pasta;
        $this->nome    = $nome;
        
        if(is_null($extensoes)){
            $this->extensoes = array("jpg");
        }else{
            $this->extensoes = $extensoes;
        }
    }

###########################################################
    
    private function getExtensao(){
        //retorna a extensao da imagem
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

    # Largura, altura, tipo, localizacao da imagem original
    private function redimensionar($imgLarg, $imgAlt, $tipo, $img_localizacao){
        
        # Descobrir novo tamanho sem perder a proporcao
        if ( $imgLarg > $imgAlt ){
            $novaLarg = $this->largura;
            $novaAlt = round( ($novaLarg / $imgLarg) * $imgAlt );
        } elseif ($imgAlt > $imgLarg) {
            $novaAlt = $this->altura;
            $novaLarg = round(($novaAlt / $imgAlt) * $imgLarg);
        } else { // altura == largura
            $novaAlt = $novaLarg = max($this->largura, $this->altura);
        }

        # Cria uma nova imagem com o novo tamanho   
        $novaimagem = imagecreatetruecolor($novaLarg, $novaAlt);

        switch ($tipo){
            case 1: // gif
                $origem = imagecreatefromgif($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
                $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagegif($novaimagem, $img_localizacao);
                break;
            case 2: // jpg
                $origem = imagecreatefromjpeg($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
                $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagejpeg($novaimagem, $img_localizacao);
                break;
            case 3: // png
                $origem = imagecreatefrompng($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
                $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagepng($novaimagem, $img_localizacao);
                break;
        }

        # Destroi as imagens criadas
        imagedestroy($novaimagem);
        imagedestroy($origem);
    }

###########################################################
    
    public function salvar(){                                   
        # Pega a extensão
        $extensaoArquivo = $this->getExtensao();
        
        # Verifica se a extensão é permitida
        if (in_array($extensaoArquivo, $this->extensoes)) {

            # Gera um nome unico para a imagem em funcao do tempo
            if(is_null($this->nome)){
                $novo_nome = time().".".$extensaoArquivo;
            }else{
                $novo_nome = $this->nome.".".$extensaoArquivo;
            }
            # Localizacao do arquivo 
            $destino = $this->pasta . $novo_nome;
            
            # Move o arquivo
            if (! move_uploaded_file($this->arquivo['tmp_name'], $destino)){
                if ($this->arquivo['error'] == 1) {
                    alert ("Tamanho excede o permitido");
                    return FALSE;
                } 
            }else{

                if ($this->ehImagem($extensaoArquivo)){                
                    # Pega a largura, altura, tipo e atributo da imagem
                    list($largura, $altura, $tipo, $atributo) = getimagesize($destino);

                    # Testa se é preciso redimensionar a imagem
                    if(($largura > $this->largura) || ($altura > $this->altura)){
                        $this->redimensionar($largura, $altura, $tipo, $destino);
                    }
                }
                return TRUE;
            }
         }else{
            alert ("Extensão não Permitida");
            return FALSE;
        }
    }
}