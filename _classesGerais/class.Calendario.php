<?php

class Calendario {

    /**
     * Classe que constroi e exibe um calendário.
     * 
     * @author Talianderson Dias - talianderson.web@gmail.com
     * 
     * @example exemplo.calendario.php 
     */
    private $mes = null;        // integer O mês a ser exibido. 1 a 12.
    private $ano = null;        // integer O ano do calandário com 4 dígitos
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

    public function show($submit = null) {
        /**
         * Exibe o Calendário
         * 
         * @syntax $calendario->show();
         * 
         * submit string  Se nulo não exibe o formulário de pesquisa
         */
        # Cria array dos meses
        if (!empty($submit)) {
            $mes = array(
                array("1", "Janeiro"),
                array("2", "Fevereiro"),
                array("3", "Março"),
                array("4", "Abril"),
                array("5", "Maio"),
                array("6", "Junho"),
                array("7", "Julho"),
                array("8", "Agosto"),
                array("9", "Setembro"),
                array("10", "Outubro"),
                array("11", "Novembro"),
                array("12", "Dezembro"));

            # Monta o formulário
            $form = new Form($submit);

            $controle = new Input('ano', 'texto', 'Ano:', 1);
            $controle->set_size(4);
            $controle->set_title('Filtra por Ano');
            $controle->set_valor($this->ano);
            $controle->set_onChange('formPadrao.submit();');
            $controle->set_linha(1);
            $controle->set_col(5);
            $form->add_item($controle);

            $controle = new Input('mes', 'combo', 'Mês:', 1);
            $controle->set_size(10);
            $controle->set_title('Filtra por Mês');
            $controle->set_valor($this->mes);
            $controle->set_onChange('formPadrao.submit();');
            $controle->set_array($mes);
            $controle->set_linha(1);
            $controle->set_col(7);
            $form->add_item($controle);

            $form->show();
        }

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
        echo '<tr id="calendario">';
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
                            echo " id='hoje' title='Hoje'";
                        } else {
                            # Verifica se é feriado
                            if (!is_null($feriado)) {
                                echo " id='feriado' title='{$feriado}'";
                            } elseif (($i == 1) or ($i == 7)) {
                                # Verifica se é Sábado ou Domingo       
                                echo " id='domingo' title='{$feriado}'";
                            }
                        }

                        # Exibe o dia
                        echo ">";
                        echo $dia;
                        echo "</td>";
                        $dia++;
                    } else {
                        echo "<td align='center'";
                        # Verifica se é Sábado ou Domingo                                                
                        if (($i == 1) or ($i == 7)) {
                            echo " id='domingo' title='{$feriado}'";
                        }
                        echo "> --- </td>";
                    }
                } else {
                    if ($dia <= $dias) {
                        echo "<td align='center'";

                        # Verifica se é hoje
                        if (($this->ano == date('Y')) and ($this->mes == date('m')) and ($dia == date('d'))) {
                            echo " id='hoje' title='Hoje'";
                        } else {
                            # Verifica se é feriado
                            if (!is_null($feriado)) {
                                echo " id='feriado' title='{$feriado}'";
                            } elseif (($i == 1) or ($i == 7)) {
                                # Verifica se é Sábado ou Domingo       
                                echo " id='domingo' title='{$feriado}'";
                            }
                        }

                        # Exibe o dia
                        echo ">";
                        echo $dia;
                        echo "</td>";
                        $dia++;
                    } else {
                        echo "<td align='center'";
                        # Verifica se é Sábado ou Domingo                                                
                        if (($i == 1) or ($i == 7)) {
                            echo " id='domingo' title='{$feriado}'";
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
