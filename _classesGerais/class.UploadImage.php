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

    function __construct($arquivo, $altura, $largura, $pasta, $nome){
        $this->arquivo = $arquivo;
        $this->altura  = $altura;
        $this->largura = $largura;
        $this->pasta   = $pasta;
        $this->nome    = $nome;
    }

    private function getExtensao(){
        //retorna a extensao da imagem
        $img_nome = $this->arquivo['name'];
        $img_separador = explode('.',$img_nome);
        $extensao = strtolower(end($img_separador));
        return $extensao;
    }

    private function ehImagem($extensao){
        $extensoes = array('gif', 'jpeg', 'jpg', 'png', 'img', 'jpeg');     // extensoes permitidas
        if (in_array($extensao, $extensoes)) {
            return true;
        }
    }

    //largura, altura, tipo, localizacao da imagem original
    private function redimensionar($imgLarg, $imgAlt, $tipo, $img_localizacao){
        //descobrir novo tamanho sem perder a proporcao
        if ( $imgLarg > $imgAlt ){
            $novaLarg = $this->largura;
            $novaAlt = round( ($novaLarg / $imgLarg) * $imgAlt );
        } elseif ($imgAlt > $imgLarg) {
            $novaAlt = $this->altura;
            $novaLarg = round(($novaAlt / $imgAlt) * $imgLarg);
        } else { // altura == largura
            $novaAlt = $novaLarg = max($this->largura, $this->altura);
        }

        //redimencionar a imagem

        //cria uma nova imagem com o novo tamanho   
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

        //destroi as imagens criadas
        imagedestroy($novaimagem);
        imagedestroy($origem);
    }

    public function salvar(){                                   
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

        if ($this->ehImagem($extensao)){                                             
            //pega a largura, altura, tipo e atributo da imagem
            list($largura, $altura, $tipo, $atributo) = getimagesize($destino);

            // testa se é preciso redimensionar a imagem
            if(($largura > $this->largura) || ($altura > $this->altura)){
                $this->redimensionar($largura, $altura, $tipo, $destino);
            }
        }
    }                       
}