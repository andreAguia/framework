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
    private $label = array("coluna1","coluna2");
    private $title = NULL;
    private $tipo = NULL;
    private $tresd = FALSE;
    
    private $idDiv = "chart";
    private $pieHole = FALSE;
    private $legend = TRUE;
    
    private $largura = '100%';
    private $altura = '100%';

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
        echo '<script type="text/javascript" src="'.PASTA_FUNCOES_GERAIS.'/loader.js"></script>';
    }

###########################################################

    public function set_title($title = NULL){
    /**
     * Informa label da colunas
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->title = $title;
    }

###########################################################

    public function set_label($label = NULL){
    /**
     * Informa label da colunas
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->label = $label;
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
         
         # Título das colunas (se precisar)
         $textoColuna = "[";
         
         # Percorre o label
         foreach ($this->label as $titColuna){
            $textoColuna .= "'$titColuna',";
         }
        
         # Retira a última vírgula
         $size = strlen($textoColuna);
         $textoColuna = substr($textoColuna,0, $size-1); 
        
        $textoColuna .= "],";
        echo $textoColuna;
        
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
         
         if(!is_null($this->title)){
             echo "title: '$this->title',";             
         }
         
         if($this->tresd){
             echo "is3D: TRUE,";                
         }
         
         if($this->pieHole){
             echo "pieHole: 0.4,";                
         }
         
         if(!$this->legend){
             echo "legend: { position: 'none' },";                
         }
         
         echo "hAxis: {title: '".$this->label[1]."'},";
         echo "vAxis: {title: '".$this->label[0]."'},";
         echo " histogram: {
                bucketSize: 1,
                maxNumBuckets: 1000,
                minValue: 18,
                maxValue: 100
              }"; 
         echo "};";
         
        switch ($this->tipo)
        {   
            case "Pie":
                echo "var chart = new google.visualization.".$this->tipo."Chart(document.getElementById('$this->idDiv'));
               chart.draw(data, options);
              }
            </script>";
                break;
            case "Histogram": 
            case "BarChart":
            case "ColumnChart":
            case "LineChart":
                echo "var chart = new google.visualization.".$this->tipo."(document.getElementById('$this->idDiv'));
               chart.draw(data, options);
              }
            </script>";
                break;
        } 
            echo '<div id="'.$this->idDiv.'" style="width: '.$this->largura.'px; height: '.$this->altura.'px;"></div>';
     }
            
}