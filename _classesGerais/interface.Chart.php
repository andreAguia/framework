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
    private $isStacked = FALSE;
    
    private $largura = '100%';
    private $altura = '100%';
    
    private $faixas = 1;
    private $tituloEixoX = NULL;
    private $tituloEixoY = NULL;
    private $cores = NULL;
    
    private $minValor = 0;

###########################################################

    public function __construct($tipo = NULL,$dados = NULL, $faixas = 1){
        
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
        $this->faixas = $faixas;
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

    public function set_cores($cores = NULL){
    /**
     * Informa label da colunas
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->cores = $cores;
    }

###########################################################

    public function set_tituloEixoX($tituloEixoX = NULL){
    /**
     * Informa titulo do eixo X
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->tituloEixoX = $tituloEixoX;
    }

###########################################################

    public function set_tituloEixoY($tituloEixoY = NULL){
    /**
     * Informa titulo do eixo Y
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->tituloEixoY = $tituloEixoY;
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

    public function set_isStacked($isStacked = NULL){
    /**
     * Informa label da colunas
     * 
     * @syntax $button->set_tresd($tresd);
     * 
     * @param $tresd bool NULL Informa se o gráfico será ou não em 3 dimensões
     */
    
        $this->isStacked = $isStacked;
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
            
            echo "[";
            echo "'".$item[0]."'";
            
            for ($i = 1; $i <= $this->faixas; $i++) {
               echo ",";
               echo $item[$i];
            }
            
            echo "]";
                         
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
            echo "is3D: true,";                
        }
         
        if($this->pieHole){
            echo "pieHole: 0.4,";                
        }
         
        if(!$this->legend){
            echo "legend: { position: 'none' },";                
        }
        
        if($this->isStacked){
            echo "isStacked: true,";             
        }
                 
        # cores
        if(!is_null($this->cores)){
            $numCor = count($this->cores);
            $contCor = 1;
            echo "colors: [";
            foreach ($this->cores as $cor){
                if($contCor == $numCor){
                    echo "'$cor'";
                }else{
                    echo "'$cor',";
                }
                $contCor++;
            }
            echo "],";
        }
         
        # Verifica o título do eixo X
        if(is_null($this->tituloEixoX)){
            $this->tituloEixoX = $this->label[0];
        }
         
        # Verifica o título do eixo Y
        if(is_null($this->tituloEixoY)){
            $this->tituloEixoY = $this->label[1];
        }
         
        echo "hAxis: {title: '".$this->tituloEixoX."'},";
        echo "vAxis: {title: '".$this->tituloEixoY."'},";
        echo " histogram: {
               bucketSize: 1,
               maxNumBuckets: 1000,
               minValue: 1,
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
            case "Bar":
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