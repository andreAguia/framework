<?php
class Calendario
{
 /**
  * Classe que constroi e exibe um calendário.
  * 
  * @author Talianderson Dias - talianderson.web@gmail.com
  * 
  * @var private $mes     integer NULL O mês a ser exibido. 1 a 12.
  * @var private $ano     integer NULL O ano do calandário com 4 dígitos
  * @var private $tamanho string  NULL O tamanho do calendário: p | g
  * 
  * @example exemplo.calendario.php 
  */

    private $mes = NULL;
    private $ano = NULL;
    private $tamanho = "p";

###########################################################    

    public function __construct($mes = NULL,$ano = NULL){
    /**
     * Inicia a classe atribuindo um valor do legend e do id
     * 
     * @param private $mes     integer NULL O mês a ser exibido. 1 a 12.
     * @param private $ano     integer NULL O ano do calandário com 4 dígitos     
     * 
     * @note Se o mês não for informado, é exibido o mês corrente
     * @note Se o ano não for informado, é exibido o mês corrente
     * 
     * @syntax $calendario = new Calendario([$mes], [$ano]);
     */
        
        # Verifica se o mês está vazio e habilita o mês atual
        if(vazio($mes)){
            $mes = date('m');
        }
        
    	# Verifica se o mês é válido
        if(($mes < 1) OR ($mes > 12)){
            alert("É necessário informar o mês válido na Classe Calendário");
            return;
        }
        
        # Verifica se o ano está vazio e habilita o ano atual
        if(vazio($ano)){
            $ano = date('Y');
        }
        
        $this->mes = $mes;
        $this->ano = $ano;
    }
    
###########################################################

    public function set_tamanho($tamanho = NULL){
    /**
     * Informa o tamanho do nome do dia da semana no cabeçalçho da tabela do calendário
     * 
     * @param private $tamanho string  NULL O tamanho do calendário: p | g
     *
     * @note O tamanho p é utilizado quando o espaço é pequeno para exibir o nome completo dos dias da semanas. 
     * 
     * @syntax $calendario->show($tamanho);
     */
    
        $this->tamanho = $tamanho;
    }

###########################################################
    
    public function show(){
    /**
     * Exibe o Mês
     * 
     * @syntax $calendario->show();
     */
        
        # Verifica quantos dias tem o mês específico
        $dias = date("j",mktime(0,0,0,$this->mes+1,0,$this->ano));
        
        # Array dom os nomes do dia da semana
        switch ($this->tamanho){
            case "p":
                 $diaSemana = array("D","S","T","Q","Q","S","S");
                break;
            
            case "g":
                $diaSemana = array("Domingo","2º feira","3° feira","4° feira","5° feira","6° feira","Sabado");
                break;
        }
        
        
        # Determina o dia da semana do dia primeiro
        $tstamp=mktime(0,0,0,$this->mes,1,$this->ano);
        $Tdate = getdate($tstamp);
        $wday=$Tdate["wday"];
        
        # Inicia a tabela
        echo '<table class="tabelaPadrao">';
        
        # Título Mês/Ano
        echo '<caption>'.get_nomeMes($this->mes).' / '.$this->ano.'</caption>';

        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';

        # Cabeçalho dias da semana
        echo '<tr>';
        foreach($diaSemana as $ds){
            echo "<th>$ds</th>";
        }
        echo '</tr>';
        
        # Contador do dia
        $dia = 1;
        
        # Corpo do calendário
        echo '<tr>';
        do {            
            for ($i = 1; $i <= 7; $i++) {
                # Verifica o dia inicial do mes
                if($dia == 1){
                    if($wday+1 == $i){
                        echo "<td align='center'";
                        
                        # Verifica se é hoje
                        if(($this->ano == date('Y')) AND ($this->mes == date('m')) AND ($dia == date('d'))){
                            echo " id='hoje'";
                        }else{
                            # Verifica se é Sábado ou Domeingo                                                
                            if(($i == 1) OR ($i == 7)){
                                echo " id='domingo'";
                            }
                        }
                        
                        # Exibe o dia
                        echo ">$dia</td>";
                        $dia++;
                    }else{
                        echo "<td align='center'";
                        if(($i == 1) OR ($i == 7)){
                            echo " id='domingo'";
                        }         
                        echo"> --- </td>";
                    }
                }else{
                    if($dia <= $dias){
                        echo "<td align='center'";
                        
                        # Verifica se é hoje
                        if(($this->ano == date('Y')) AND ($this->mes == date('m')) AND ($dia == date('d'))){
                            echo " id='hoje'";
                        }else{
                            # Verifica se é Sábado ou Domingo                                                
                            if(($i == 1) OR ($i == 7)){
                                echo " id='domingo'";
                            }
                        }
                        
                        # Exibe o dia
                        echo ">$dia</td>";
                        $dia++;
                    }else{
                        echo "<td align='center'";
                        if(($i == 1) OR ($i == 7)){
                            echo " id='domingo'";
                        }         
                        echo"> --- </td>";
                    }
                }
            }
            echo '</tr><tr>';
        } while ($dia <= $dias);
        echo '</tr>';
        
        # termina a tabela
        echo '</table>';
    }
    
}
