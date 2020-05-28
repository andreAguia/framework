<?php

class MenuVideo {

    /**
     * Monta um menu de vídeos do youTube e do Vimeo
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     */
    private $item;

###########################################################

    public function __construct() {
        /**
         * Inicia o menu.
         * 
         * @syntax $menuVideo = new MenuVideo();
         * 
         */
    }

###########################################################

    public function add_item($local, $id, $descricao) {
        /**
         * Inclui um video
         * 
         * @syntax $form->add_item($objeto);
         * 
         * @param $local     string  NULL ytVideo|vimeoVideo|dailyMVideo
         * @param $id        integer NULL id do vídeo
         * @param $descricao string  NULL Breve descrição do vídeo
         * 
         */
        $this->item[] = array($local, $id, $descricao);
    }

###########################################################

    public function show() {
        /**
         * Efetivamente constroi o menu
         * 
         * @syntax $form->show();
         * 
         */
        echo '<ul id="svList">"';

        foreach ($this->item as $video) {
            echo '<li class="svThumb ' . $video[0] . '" data-videoID="' . $video[1] . '">' . $video[2] . '</li>';
        }

        echo '</ul>';
        echo '<script src="' . PASTA_FUNCOES_GERAIS . '/speedvault.js"></script>';
    }

}
