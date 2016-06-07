<?php
class MenuGrafico
{
    /**
     * Monta um menu de botões gráficos
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @var private $item    object  NULL Array de objetos do menu. Normalmente o objeto botaoGrafico.
     * @var private $colunas integer NULL Número de colunas do menu.
     * 
     * @example exemplo.menugrafico.php
     */

    private $item = NULL;
    private $colunas = NULL;
    
###########################################################
    
    public function __construct($colunas = NULL){
    /**
     * Inicia um menu
     *     
     * @param $colunas integer NULL O Número de colunas dos menus
     * 
     * @syntax $menu = new MenuGrafico($colunas);
     */
    
        $this->colunas = $colunas;
    }
	    
###########################################################
        
    public function add_item($objeto = NULL){
    /**
     * Inclui um item (botaoGrafico) ao menu
     * 
     * @param $objeto object O objeto botaografico a ser incluído
     * 
     * @syntax $menu->add_item($objeto);
     */
	
        $this->item[] = $objeto;       
    }
        
###########################################################
    
    public function show(){
    /**
     * Exibe o menuGrafico
     * 
     * @syntax $menu->show();
     */
    
    	# Contador de colunas
        $contador = 0;
        
        # Qualtidades de itens
        $quantidade = count($this->item);
        
        # Calcula automaticamente a quantidade necessário de coluna
        # caso não seja implicitamente informado
        if(is_null($this->colunas)){
            if($quantidade < 4){
                $this->colunas = $quantidade;
            }
            
            if(($quantidade >= 4) AND ($quantidade <= 12)){
                $this->colunas = intval($quantidade/2);
            }
            
            if($quantidade > 12){
                $this->colunas = 5;
            }
        }
        
        if($quantidade > 0)
        {
            # Cria uma grid
            $grid = new Grid();
            
            # Calcula o tamanhoda coluna
            $tamColuna = 12/$this->colunas;
            
            foreach ($this->item as $objeto)
            {
                $contador++;
                $grid->abreColuna($tamColuna);
                $objeto->show();
                $grid->fechaColuna();

                if($contador == $this->colunas){
                    $grid->fechaGrid();
                    $grid = new Grid();
                    $contador = 0;
                }
            }

            $grid->fechaGrid();
        }
    }
   
}
