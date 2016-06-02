<?php
class MenuBar
{   
    /**
     * Monta um menu horizontal
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @var private $link object NULL Array de objetos Link/Button a ser inseridos no menu
     * @var private $link object NULL Array informando o lado do objeto. Pode ser: left ou right
     * 
     * @example exemplo.menubar.php
     */
       
    # do link (botao)
    private $link = NULL;
    private $linkLado = NULL;    
       
###########################################################

    public function __construct(){
        
    /**
     * Iniciar a classe
     * 
     * @syntax $menu = new menuBar();
     */   
       
    }

###########################################################

    public function add_link($link, $linkLado){
        
    /**
     * Inclui um link na barra
     * 
     * @param object $link objeto link a ser inserido
     * @param string $linkLado string que deverá constar left ou right
     * 
     * @syntax $menu->add_link($link,$linkLado);
     */
    
       $this->link[] = $link;
       $this->linkLado[] = $linkLado;
    }
    
###########################################################

    public function show(){
        
        /**
         * Exibe o menu
         * 
         * @syntax $menu->show();
         */
        
        # Inicia a div container
        echo '<div id="container">';
        echo '<div id="space-between">';

        # Inicia o container da esquerda
        echo '<div class="button-group">';
        
        # Verifica se tem botões para colocar na barra
        if (!empty($this->link)){

            # contador
            $contadorEsquerdo = 0;

            # verifica se tem link do lado esquerdo
            if (in_array("left", $this->linkLado)){
                foreach ($this->link as $linkEsquerdo){
                    if($this->linkLado[$contadorEsquerdo ] == 'left')
                        $linkEsquerdo->show();

                    $contadorEsquerdo++;                   
                }                
            }
        }
        
        # Fecha a div do lado esquerdo
        echo '</div>';

        # Inicia o container da direita
        echo '<div class="button-group">';

        # Verifica se tem botões para colocar na barra
        if (!empty($this->link)){

            # contador
            $contadorDireito = 0;

            # verifica se tem link do lado direito
            if (in_array("right", $this->linkLado)){
                foreach ($this->link as $linkDireito){
                    if($this->linkLado[$contadorDireito ] == 'right'){
                        $linkDireito->show();
                    }
                    $contadorDireito++;                   
                }                
            }
        }
        
        # Fecha a div do lado direito
        echo '</div>';

         # Fecha a div do Container
        echo '</div>';
        echo '</div>';
    }
}