<?php

class Calendario {

    /**
     * Classe que constroi e exibe um calendário.
     * 
     * @author Talianderson Dias - talianderson.web@gmail.com
     * 
     * @example exemplo.calendario.php 
     */
    private $mes = null;    // integer O mês a ser exibido. 1 a 12.
    private $ano = null;    // integer O ano do calandário com 4 dígitos
    private $tamanho = "p";     // string  O tamanho do calendário: p | g

    ###########################################################    

    public function __construct(
            $mes = null, // integer O mês a ser exibido. 1 a 12.
            $ano = null     // integer O ano do calandário com 4 dígitos 
    ) {
        /**
         * Inicia a classe atribuindo um valor do legend e do id
         * 
         * @note Se o mês não for informado, é exibido o mês atual.
         * @note Se o ano não for informado, é exibido o ano atual.
         * 
         * @syntax $calendario = new Calendario([$mes], [$ano]);
         */
        # Verifica se o mês está vazio e habilita o mês atual
        if (vazio($mes)) {
            $mes = date('m');
        }

        # Verifica se o mês é válido
        if (($mes < 1) or ($mes > 12)) {
            alert("É necessário informar o mês válido na Classe Calendário");
            return;
        }

        # Verifica se o ano está vazio e habilita o ano atual
        if (vazio($ano)) {
            $ano = date('Y');
        }

        $this->mes = $mes;
        $this->ano = $ano;
    }

    ###########################################################

    public function set_tamanho($tamanho = null) { // string O tamanho do calendário: p | g
        /**
         * Informa o tamanho do nome do dia da semana no cabeçalçho da tabela do calendário
         * 
         * @note O tamanho p é utilizado quando o espaço é pequeno para exibir o nome completo dos dias da semanas. 
         * 
         * @syntax $calendario->show($tamanho);
         */

        $this->tamanho = $tamanho;
    }

    ###########################################################

    public function show() {
        /**
         * Exibe o Calendário
         * 
         * @syntax $calendario->show();
         */
        # Verifica quantos dias tem o mês específico
        $dias = date("j", mktime(0, 0, 0, $this->mes + 1, 0, $this->ano));

        # Array dom os nomes do dia da semana
        switch ($this->tamanho) {
            case "p":
                $diaSemana = array("D", "S", "T", "Q", "Q", "S", "S");
                break;

            case "g":
                $diaSemana = array("Domingo", "2º feira", "3° feira", "4° feira", "5° feira", "6° feira", "Sabado");
                break;
        }

        # Determina o dia da semana do dia primeiro
        $tstamp = mktime(0, 0, 0, $this->mes, 1, $this->ano);
        $Tdate = getdate($tstamp);
        $wday = $Tdate["wday"];

        # Inicia a tabela
        echo '<table class="tabelaPadrao">';

        # Título Mês/Ano
        echo '<caption>' . get_nomeMes($this->mes) . ' / ' . $this->ano . '</caption>';

        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';
        echo '<col style="width:14%">';

        # Cabeçalho dias da semana
        echo '<tr>';
        foreach ($diaSemana as $ds) {
            echo "<th>$ds</th>";
        }
        echo '</tr>';

        # Contador do dia
        $dia = 1;

        # Corpo do calendário
        echo '<tr>';
        do {
            for ($i = 1; $i <= 7; $i++) {
                # Verifica se nesta data existe um feriado
                $data = "$dia/$this->mes/$this->ano";
                $pessoal = new Pessoal();
                $feriado = $pessoal->get_feriado($data);

                # Verifica o dia inicial do mes
                if ($dia == 1) {
                    if ($wday + 1 == $i) {
                        echo "<td align='center'";

                        # Verifica se é hoje
                        if (($this->ano == date('Y')) and ($this->mes == date('m')) and ($dia == date('d'))) {
                            echo " id='hoje'";
                        } else {
                            # Verifica se é Sábado ou Domeingo                                                
                            if (($i == 1) or ($i == 7)) {
                                echo " id='domingo'";
                            } elseif (!is_null($feriado)) {
                                echo " id='domingo' title='$feriado'";
                            }
                        }

                        # Exibe o dia
                        echo ">";

                        # Exibe o Feriado (caso tenha)
                        if (!is_null($feriado)) {     // verifica se tem feriado
                            echo $dia;
                            $figura = new Imagem(PASTA_FIGURAS_GERAIS . 'info.png', $feriado, 25, 25);
                            $figura->set_id("imgcalendario");
                            $figura->show();
                        } else {
                            echo $dia;
                        }

                        echo "</td>";
                        $dia++;
                    } else {
                        echo "<td align='center'";
                        # Verifica se é Sábado ou Domingo                                                
                        if (($i == 1) or ($i == 7)) {
                            echo " id='domingo' title='$feriado'";
                        }
                        echo "> --- </td>";
                    }
                } else {
                    if ($dia <= $dias) {
                        echo "<td align='center'";

                        # Verifica se é hoje
                        if (($this->ano == date('Y')) and ($this->mes == date('m')) and ($dia == date('d'))) {
                            echo " id='hoje'";
                        } else {
                            # Verifica se é Sábado ou Domingo                                                
                            if (($i == 1) or ($i == 7) or (!is_null($feriado))) {
                                echo " id='domingo' title='$feriado'";
                            }
                        }

                        # Exibe o dia
                        echo ">";

                        # Exibe o Feriado (caso tenha)
                        if (!is_null($feriado)) {     // verifica se tem feriado
                            echo $dia;
                            $figura = new Imagem(PASTA_FIGURAS_GERAIS . 'info.png', $feriado, 25, 25);
                            $figura->set_id("imgcalendario");
                            $figura->show();
                        } else {
                            echo $dia;
                        }

                        echo "</td>";
                        $dia++;
                    } else {
                        echo "<td align='center'";
                        # Verifica se é Sábado ou Domingo                                                
                        if (($i == 1) or ($i == 7)) {
                            echo " id='domingo' title='$feriado'";
                        }
                        echo "> --- </td>";
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
