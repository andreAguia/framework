<?php
class Chart
{	    
/**
 * Monta um gráfico estatístico
 * 
 * @author André Águia (Alat) - alataguia@gmail.com
 * 
 * @var private $dados array  NULL  Os dados do gráfico.
 * @var private $tipo  string NULL  O tipo do gráfico: Pie | Line | Area
 * @var private $tresd bool   FALSE Informa se o gráfico será ou não em 3 dimensões
 * 
 * @example exemplo.button.php
 */

    private $dados = NULL;
    private $tipo = NULL;
    private $tresd = FALSE;
    
    private $idDiv = "chart";
    private $pieHole = FALSE;
    private $legend = TRUE;
    
    private $largura = 800;
    private $altura = 400;

###########################################################

    public function __construct($tipo = NULL,$dados = NULL){
        
    /**
     * Inicia a classe
     * 
     * @param $tipo  string NULL O tipo do gráfico: pie|
     * @param $dados array  NULL Os dados do gráfico
     * 
     * @syntax $button = new Chart($tipo,$dados);
     */
    
        $this->tipo = $tipo;
        $this->dados = $dados;
    }

###########################################################

    public function set_tresd($tresd = NULL){
    /**
     * Informa se o gráfico será em 3d
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->tresd = $tresd;
    }

###########################################################

    public function set_idDiv($idDiv = NULL){
    /**
     * Informa se o gráfico será em 3d
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->idDiv = $idDiv;
    }

###########################################################

    public function set_pieHole($pieHole = NULL){
    /**
     * Informa se o gráfico será em 3d
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->pieHole = $pieHole;
    }

###########################################################

    public function set_legend($legend = NULL){
    /**
     * Informa se o gráfico será em 3d
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->legend = $legend;
    }

###########################################################

    public function set_tamanho($largura = NULL,$altura = NULL){
    /**
     * Informa se o gráfico será em 3d
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->largura = $largura;
        $this->altura = $altura;
    }

###########################################################

     public function show(){
    /**
     * Exibe o gráfico
     * 
     * @syntax $button->show();
     */ 
         
         # Inicia a rotina e jscript
         echo "<script type='text/javascript'>
                google.charts.load('current', {packages:['corechart']});
                google.charts.setOnLoadCallback(drawChart);
          
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([";
         
         # Inicia o contador
         $contador = 0;
         $numItens = count($this->dados);
         
         echo "['Coluna1', 'Coluna2'],";
         
         # Percorre o array de dados
         foreach ($this->dados as $item){
             echo "['".$item[0]."',".$item[1]."]";
             if($contador < $numItens-1){
                 echo ",";
             }
             $contador++;
         }
            
         echo "]);";
        
         echo "var options = {
                  title: '',";
         
         if($this->tresd){
             echo "is3D: true,";                
         }
         
         if($this->pieHole){
             echo "pieHole: 0.4,";                
         }
         
         if(!$this->legend){
             echo "legend: 'none',";                
         }
                   
         echo "};";

         echo "var chart = new google.visualization.".$this->tipo."Chart(document.getElementById('$this->idDiv'));
               chart.draw(data, options);
              }
            </script>";
          
            echo '<div id="'.$this->idDiv.'" style="width: '.$this->largura.'px; height: '.$this->altura.'px;"></div>';
     }
            
}