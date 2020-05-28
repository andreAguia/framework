<?php

class Relatorio {

    /**
     * Classe para a criação de relatórios
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @group do relatório
     * @var private $conteudo array NULL Array com o conteúdo a ser exibido. Normalmente um resultado de uma consulta ao banco de dados.
     * @var private $label    array NULL Array com o nome das colunas seguindo a mesma ordem do array do conteúdo.
     * @var private $width    array NULL Array com o tamanho (em caracteres) das colunas seguindo a mesma ordem do array de conteúdo.
     * @var private $align    array NULL Array informando a alinhamento de cada coluna seguindo a mesma ordem do array de conteúdo. Valores possíveis: center / left / right
     * @var private $função   array NULL Array com a função a ser submetida o valor da coluna específica, exibindo-se assim o resultado da função.
     * @var private $classe   array NULL Array com a classe a ser submetida o valor da coluna específica.
     * @var private $metodo   array NULL Array com o método função a ser submetida o valor da coluna específica.
     * 
     * @group do título
     * @var private $titulo              string NULL O título do relatório. Texto que irá apacerer logo após o cabeçalho.
     * @var private $tituloLinha2        string NULL Segunda linha d título do relatório.
     * @var private $tituloLinha3        string NULL Terceira linha d título do relatório.
     * @var private $subtitulo           string NULL Subtítulo. Texto que irá apacerer logo após as linhas de título.
     * @var private $tituloTabela        string NULL Texto que aparecerá no caption da tabela.
     * @var private $objetoAntesTitulo   string NULL Envia um objeto para ser exibida no alto do relatório antes do título(usado na listagem de ramal)
     * @var private $objetoDepoisTitulo  string NULL o mesmo do acima mas esse é depois do titulo
     *
     * @group do agrupamento
     * @var private $subTotal       bool    TRUE  Informa se exibe ou não o subtotal de registros.
     * @var private $numGrupo       integer NULL  Se informado, indica qual o campo, na sequencia do array conteúdo, será agrupado.
     * @var private $ocultaGrupo    bool    TRUE  Informa se a coluna agrupada será ocultada.
     * @var private $saltoAposGrupo bool    FALSE Informa se terá salto de página após o agrupamento.
     * 
     * @group do subrelatório
     * @var private $subRelatorio   object  NULL Objeto relatório que será exibido como um subrelatório.
     * @var private $subSelect      bool    TRUE Informa se a coluna agrupada será ocultada.
     * @var private $subClasseBd    bool    TRUE Informa se a coluna agrupada será ocultada.
     * @var private $subJoin        bool    TRUE Informa se a coluna agrupada será ocultada.
     * 
     * @group do número de ordem
     * @var private $numeroOrdem     bool   FALSE  Exibe/Não exibe uma coluna com numeração de ordem das colunas
     * @var private $numeroOrdemTipo bool   'c'    Informa que a ordenação será 'c' crescente ou 'd' decrescente
     * 
     * @group outros
     * @var private $linhaFinal bool FALSE Exibe ou não linha final da tabela.
     * 
     * @example exemplo.relatorio.php
     * 
     */
    # do relatório
    private $conteudo = NULL;
    private $label = NULL;
    private $width = NULL;
    private $align = NULL;
    private $funcao = NULL;
    private $classe = NULL;
    private $metodo = NULL;

    # do título
    private $titulo = NULL;
    private $tituloLinha2 = NULL;
    private $tituloLinha3 = NULL;
    private $subtitulo = NULL;
    private $tituloTabela = NULL;

    # do número de ordem
    private $numeroOrdem = FALSE;
    private $numeroOrdemTipo = 'c';

    # Rotinas Extras
    private $funcaoAntesTitulo = NULL;
    private $funcaoAntesTituloParametro = NULL;
    private $objetoAntesTitulo = NULL;
    private $objetoDepoisTitulo = NULL;

    # do agrupamento
    private $subTotal = TRUE;
    private $numGrupo = NULL;
    private $ocultaGrupo = TRUE;
    private $saltoAposGrupo = FALSE;

    # do subrelatório
    private $subRelatorio = NULL;               // Objeto relatório que na verdade é um subrelatório
    private $subSelect = NULL;                  // sql do subrelatorio
    private $subClasseBd = NULL;  // Classe do bd   
    private $subJoin = NULL;   // posição no array do join no primeiro relatório    
    # do somatório
    private $colunaSomatorio = NULL;            // coluna que terá somatório (por enquanto uma por relatório)
    private $textoSomatorio = 'Total:';         // texto a ser exibido na linha de totalização
    private $colunaTexto = 0;                   // coluna onde o texto será exibido;
    private $funcaoSomatorio = NULL;            // se executa alguma função no somatório
    private $exibeSomatorioGeral = TRUE;        // se exibe o somatório geral ou somente o parcial
    private $totalRegistro = TRUE;  // se terá o número de registros no fim do relatório (e dos grupos))
    private $totalRegistroValor = NULL;  // Guarda o valor do toal para ser recuperado na rotina de relatório via get
    private $bordaInterna = FALSE;  // Exibe ou não uma linha dentro da tabela entro os registros 
    private $dataImpressao = TRUE;  // Exibe ou  não a Data de Impressão
    private $espacamento = 0;                   // Espaçamento entre as linha. 0 - espacamento padrão
    private $cabecalhoRelatorio = TRUE;         // Exibe ou não o cabeçalho do relatório
    private $botaoVoltar = NULL;  // Link do botão voltar
    private $mensagemNenhumRegistro = TRUE; // Exibe ou não a mensagem de quando não tem registro a ser exibido
    # do menu do relatório
    private $menuRelatorio = TRUE;  // se coloca ou não o menu relatório
    private $formCampos = NULL;    // array com campos para o formulario
    private $formFocus = NULL;     // Campos a receber foco no form
    private $formLink = NULL;    // para onde vai o post
    private $brHr = 1;                          // quantidade de saltos de linha antes do hr do menu
    # especiais
    private $linhaNomeColuna = FALSE;           // exibe (ou não) a linha entre o nome das colunas
    private $id = NULL;                         // id do css para alterações
    # do log
    private $log = TRUE;            // informa se gerará log ou não
    private $logDetalhe = NULL;     // detalhamento do log
    private $logServidor = NULL;    // o idServidor para quando o relatório for de um único servidor
    # do Rodapé
    private $rodape = NULL;

    # Outros
    private $linhaFinal = FALSE;                // Exibe linha final
    private $funcaoFinalGrupo = NULL;           // Executa uma rotina ao fim de cada agrupamento na forma de função
    private $funcaoFinalGrupoParametro = NULL;  // Usado na escala anual de férias para exibir texto.
    private $funcaoFinalRelatorio = NULL;           // Executa uma rotina ao fim do Relatorio
    private $funcaoFinalRelatorioParametro = NULL;
    private $aviso = NULL;                          // Exibe um aviso que não será impresso, no cabeçalho
    private $rowspan = NULL;            # Coluna onde o código fará automaticamente rowspan de valores iguais (colocar na ordenação esta coluna)
    private $grupoCorColuna = NULL;     # Indica se haverá colorização de um grupo por valores diferentes. Usado para diferenciar um grupo de linhas de outro grupo.

    ###########################################################

    public function __construct($id = NULL) {
        /**
         * Inicia o relatório
         * 
         *
         * @param $id string NULL O id da tabela. (opcional)
         * 
         * @syntax $relatorio = new Relatorio([$id]);
         * 
         */
        $this->id = $id;
    }

    ###########################################################

    /**
     * Métodos get e set construídos de forma automática pelo 
     * metodo mágico __call.
     * Esse método cria um set e um get para todas as propriedades da classe.
     * Um método existente tem prioridade sobre os métodos criados pelo __call.
     * 
     * O formato dos métodos devem ser:
     * 	set_propriedade
     * 	get_propriedade
     * 
     * @param 	$metodo		O nome do metodo
     * @param 	$parametros	Os parâmetros inseridos  
     */
    public function __call($metodo, $parametros) {
        ## Se for set, atribui um valor para a propriedade
        if (substr($metodo, 0, 3) == 'set') {
            $var = substr($metodo, 4);
            $this->$var = $parametros[0];
        }

        # Se for Get, retorna o valor da propriedade
        if (substr($metodo, 0, 3) == 'get') {
            $var = substr($metodo, 4);
            return $this->$var;
        }
    }

    ###########################################################

    /**
     * Método exibeCabecalho
     * 
     * Exibe o cabeçalho
     */
    public function exibeCabecalho() {

        $cabec = new Div('center');
        $cabec->abre();
        $imagem = new Imagem(PASTA_FIGURAS . 'novoTimbre.png', NULL, 120, 90);
        $imagem->show();
        $cabec->fecha();
        br();
    }

    ###########################################################

    /**
     * Método exibeCabecalhoVelho1
     * 
     * Exibe o cabeçalho
     */
    public function exibeCabecalhoVelho1() {

        $governo = "Governo do Estado do Rio de Janeiro";
        $universidade = "Universidade Estadual do Norte Fluminense Darcy Ribeiro";
        $diretoria = "Diretoria Geral de Administração";
        $gerencia = "Gerência de Recursos Humanos";

        $cabec = new Div('center');
        $cabec->abre();
        $imagem = new Imagem(PASTA_FIGURAS . 'brasao.gif', NULL, 50, 80);
        $imagem->show();
        $cabec->fecha();

        p($governo . "<br/>" . $universidade . "<br/>" . $diretoria . " - " . $gerencia, "pRelatorioCabecalho");
    }

    ###########################################################

    /**
     * Método exibeCabecalho
     * 
     * Exibe o cabeçalho
     */
    public function exibeCabecalhoVelho2() {

        $governo = "Governo do Estado do Rio de Janeiro";
        $universidade = "Fundação Estadual Norte Fluminense";
        $diretoria = "Diretoria de Planejamento Administração e Finanças";
        $gerencia = "Gerência de Recursos Humanos";

        $cabec = new Div('center');
        $cabec->abre();
        $imagem = new Imagem(PASTA_FIGURAS . 'brasao.gif', NULL, 50, 80);
        $imagem->show();
        $cabec->fecha();

        p($governo . "<br/>" . $universidade . "<br/>" . $diretoria . " - " . $gerencia, "pRelatorioCabecalho");
    }

    ###########################################################

    /**
     * Método set_numGrupo
     * 
     * @param 	$numGrupo		numero da coluna do agrupamento
     */
    function set_numGrupo($numGrupo = NULL, $ocultaGrupo = TRUE) {
        $this->numGrupo = $numGrupo;
        $this->ocultaGrupo = $ocultaGrupo;
    }

    ###########################################################

    /**
     * Método exibeTitulo
     * 
     * Exibe o título do relatório
     */
    private function exibeTitulo() {

        # Objeto antes do título
        if (!is_null($this->objetoAntesTitulo)) {
            $this->objetoAntesTitulo->show();
        }

        # Função antes do título
        if (!is_null($this->funcaoAntesTitulo)) {
            # Verifica se é array. Mais de uma função
            if (is_array($this->funcaoAntesTitulo)) {
                # quantidade de itens
                $quantidade = count($this->funcaoAntesTitulo);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->funcaoAntesTitulo[$i];
                    $nomedafuncao($this->funcaoAntesTituloParametro[$i]);
                }
            } else {
                $nomedafuncao = $this->funcaoAntesTitulo;
                $nomedafuncao($this->funcaoAntesTituloParametro);
            }
        }

        # Exibe o Título do relatório
        if (!is_null($this->titulo)) {
            p($this->titulo, "pRelatorioTitulo");
        }

        # Exibe a segunda linha do Título do relatório
        if (!is_null($this->tituloLinha2)) {
            p($this->tituloLinha2, "pRelatorioTitulo");
        }

        # Exibe a terceira linha do Título do relatório
        if (!is_null($this->tituloLinha3)) {
            p($this->tituloLinha3, "pRelatorioTitulo");
        }

        # Exibe o subtítulo (se houver))
        if (!is_null($this->subtitulo)) {
            p($this->subtitulo, "pRelatorioSubtitulo");
        }

        if ((!is_null($this->titulo)) or (!is_null($this->tituloLinha2)) or (!is_null($this->tituloLinha3)) or (!is_null($this->subtitulo))) {
            br();
        }

        # Exibe a mensagem depois do título (se houver))
        if (!is_null($this->objetoDepoisTitulo)) {
            $this->objetoDepoisTitulo->show();
        }
    }

    ###########################################################

    /**
     * Método exibeLinha
     * 
     * Exibe uma linha interna do relatório que separa os registros.
     */
    private function exibeLinha($tamanhoLinha) {

        # Verifica se tem coluna para numero de ordem
        if ($this->numeroOrdem) {
            $tamanhoLinha++;
        }

        # Monta a linha
        echo '<tr><td colspan="' . $tamanhoLinha . '">';
        hr();
        echo '</td></tr>';
    }

    ###########################################################

    /**
     * Método exibeSomatorio
     * 
     * Exibe o somatório de uma coluna no fim do relatório ou de um agrupamento
     */
    private function exibeSomatorio($tamanho, $subSomatorio) {
        # Exibe uma linha
        $this->exibeLinha($tamanho);

        # Inicia a linha
        echo '<tr>';

        # Percorre as colunas da tabela para chegar a coluna do somatório
        for ($i = 0; $i < $tamanho; $i++) {

            # Verifica se é a coluna onde terá o texto padrão a primeira coluna
            if ($i == $this->colunaTexto) {
                echo '<td>' . $this->textoSomatorio . '</td>';
            }

            if (is_array($this->colunaSomatorio)) {
                # Em desenvolvimento
                # Quando pronto possibilitará somatório 
                # em mais de uma coluna
            } else {
                # Se for a coluna do somatório exibe o somatório
                if ($i == $this->colunaSomatorio) {
                    # Se tiver função no somatório executa
                    if (is_null($this->funcaoSomatorio)) {
                        echo '<td>' . $subSomatorio . '</td>';
                    } # Senão exibe o somatório
                    else {
                        $nomedafuncao = $this->funcaoSomatorio;
                        $subSomatorio = $nomedafuncao($subSomatorio);
                        echo '<td>' . $subSomatorio . '</td>';
                    }
                }
            }

            # Senão exibe coluna em branco
            if (($i <> $this->colunaTexto) AND ($i <> $this->colunaSomatorio)) {
                echo '<td></td>';
            }
        }

        # Fecha a linha
        echo '</tr>';
    }

    ###########################################################

    /**
     * Método totalRegistro
     * 
     * Exibe o total de Registro
     */
    private function totalRegistro($totalRegistros) {
        p($totalRegistros . ' registros', "pRelatorioTotal");
    }

    ###########################################################

    /**
     * Método exibecabecalhoTabela
     * 
     * Exibe o cabeçalho da tabela
     */
    private function exibeCabecalhoTabela($tamanhoLinha, $tamanho, $grupo) {
        # Inicia a tabela
        echo '<table class="tabelaRelatorio" border="0"';

        # Redefine algumas variáveis
        if (is_null($this->numGrupo)) {
            $this->subTotal = FALSE;
        }

        # id da tabela (se houver)
        if (!is_null($this->id)) {
            echo ' id="' . $this->id . '"';
        }

        echo '>';

        # Colunas
        if ($this->numeroOrdem) {
            echo '<col style="width:5%">';
        }

        # informa o tamanho das colunas (width)
        for ($a = 0; $a < $tamanho; $a += 1) {
            if (isset($this->width[$a])) {         // verifica se foi definido um tamanho                                   // verifica se a coluna não foi ocultada para agrupamento
                if ((!$grupo) || (($grupo) && ($a <> $this->numGrupo)) || (($grupo) && (!$this->ocultaGrupo))) {
                    echo '<col style="width:' . $this->width[$a] . '%">';
                }
            }
        }

        # começa o cabeçalho                
        echo '<thead>';

        # título
        if (!is_null($this->tituloTabela)) {
            echo '<caption title="' . $this->tituloTabela . '">';
            echo $this->tituloTabela;
            echo '</caption>';
        }

        echo '<tr>';

        # Reserva uma coluna para o número de ordem (se tiver)
        if ($this->numeroOrdem) {
            echo '<th title="Número de Ordem" id="numeroOrdem">#</th>';
        }

        for ($a = 0; $a < $tamanho; $a += 1) {
            if ((!$grupo) || (($grupo) && ($a <> $this->numGrupo)) || (($grupo) && (!$this->ocultaGrupo))) {
                echo '<th>';
                echo $this->label[$a];
                echo '</th>';
            }
        }
        echo '</tr>';

        # Espaçamento
        if ($this->espacamento > 0) {
            for ($b = 0; $b < $this->espacamento; $b++) {
                echo '<tr></tr>';
            }
        }

        echo '</thead>';
    }

    ###########################################################

    /**
     * Método totalRegistro
     * 
     * Exibe o total de Registro
     */
    private function exibeDataImpressao() {
        # Pega o usuário
        $idUsuario = get_session('idUsuario');

        br();
        hr();
        p('Emitido em: ' . date('d/m/Y - H:i:s') . " (" . $idUsuario . ")", 'pRelatorioDataImpressao');
    }

    ###########################################################

    /**
     * Método show
     * 
     * Exibe o relatório
     */
    function show() {
        $contador = 0;  // contador de registros
        $subContador = 0; // contador de registros para grupo (zera a cada grupo)
        $agrupa = '#';       // guarda o nome do grupo
        $grupo = NULL;  // flag de agrupamento ou não
        $somatorio = 0;         // somatorio de colunas se houver
        $subSomatorio = 0;      // somatório do grupo
        #####

        $valorGrupoCorColuna = NULL;
        $corGrupo = "grupo1";

        # usado no rowspan para se ocultar a td repetida
        $exibeTd = TRUE;

        # rowspan
        if (!is_null($this->rowspan)) {
            $arrayRowspan = NULL;
            $rowspanAnterior = NULL;
            $rowspanAtual = NULL;

            # Passa os valores para o array
            foreach ($this->conteudo as $itens) {
                $arrayRowspan[] = $itens[$this->rowspan];
            }

            # Conta quantos valores tem e guarda no array $arr
            $arr = array_count_values($arrayRowspan);
        }

        #####
        # Linha de ordem (se tiver)
        if ($this->numeroOrdemTipo == 'c') {
            $numOrdem = 1;  # Inicia o número de ordem quando tiver
        } else {
            $numOrdem = count($this->conteudo);  # Inicia o número de ordem quando tiver
        }

        # Pega o tamanho da tabela
        if (!vazio($this->label)) {
            $tamanho = count($this->label);
        }

        # Alimenta a flag de grupo
        if (is_null($this->numGrupo)) {
            $grupo = FALSE;
        } else {
            $grupo = TRUE;
        }

        # Tira uma coluna da linha quando tiver agrupamento com ocultação da culuna
        if (!vazio($this->label)) {
            if (($grupo) && ($this->ocultaGrupo)) {
                $tamanhoLinha = $tamanho - 1;
            } else {
                $tamanhoLinha = $tamanho;
            }
        }

        # Se tiver número de ordem aumenta o tamanho da linha
        if ($this->numeroOrdem) {
            $tamanhoLinha++;
        }

        # Abre uma classe de menu do relatório
        if ($this->menuRelatorio) {
            $menuRelatorio = new menuRelatorio();
            $menuRelatorio->set_botaoVoltar($this->botaoVoltar);
            $menuRelatorio->set_formCampos($this->formCampos);
            $menuRelatorio->set_formFocus($this->formFocus);
            $menuRelatorio->set_formLink($this->formLink);
            $menuRelatorio->set_brHr($this->brHr);
            $menuRelatorio->set_aviso($this->aviso);
            $menuRelatorio->show();
        }

        # Exibe o cabeçalho
        if ($this->cabecalhoRelatorio) {
            $this->exibeCabecalho();
        }

        # Abre a div do relatório
        $div = new Div('divRelatorio');
        $div->abre();
        echo $this->aviso;

        # Limita o tamanho da tela
        $grid = new Grid();
        $grid->abreColuna(12);

        # Exibe o título do Relatório
        $this->exibeTitulo();

        # Começa o conteúdo do relatório
        if (!is_null($this->conteudo)) {

            # Percorre os registros
            foreach ($this->conteudo as $row) {

                #################
                # Como a flag agrupa é mudada no início do loop verifica-se 
                # a colocação do total do agrupamento anterior
                # Verifica se tem agrupamento
                if (!is_null($this->numGrupo)) {
                    # Verifica se o valor na coluna de agrupamento é diferente da flag agrupa
                    if (($agrupa <> $row[$this->numGrupo]) && ($agrupa <> "#") && ($grupo)) {
                        # linha
                        #$this->exibeLinha($tamanhoLinha);
                        # Exibe o somatório quando estiver habilitado
                        if (!is_null($this->colunaSomatorio)) {
                            $this->exibeSomatorio($tamanho, $subSomatorio);
                            $subSomatorio = 0;  // Zera o somatório
                        }

                        # Fecha a tabela
                        echo '<tfoot>';
                        echo '<tr><td colspan="' . ($tamanhoLinha) . '" title="Total de itens da tabela">';
                        echo '</td></tr>';
                        echo '</tfoot>';
                        echo '</table>';


                        # Exibe o número de registros
                        if (($this->subTotal) AND ($contador > 0)) {
                            $this->totalRegistro($subContador);
                            $subContador = 0;   // Zera o contador de registro
                        }

                        # Executa a rotina no final de um grupo na forma de função
                        if (!is_null($this->funcaoFinalGrupo)) {
                            # Verifica se é array. Mais de uma função
                            if (is_array($this->funcaoFinalGrupo)) {
                                # quantidade de itens
                                $quantidade = count($this->funcaoFinalGrupo);

                                # Percorre o array executando as funções na ordem do array
                                for ($i = 0; $i < $quantidade; $i++) {
                                    $nomedafuncao = $this->funcaoFinalGrupo[$i];
                                    $nomedafuncao($this->funcaoFinalGrupoParametro[$i]);
                                }
                            } else {
                                $nomedafuncao = $this->funcaoFinalGrupo;
                                $nomedafuncao($this->funcaoFinalGrupoParametro);
                            }
                        }

                        # Salta página quando o salto depois de um agrupamento estiver habilitado
                        if ($this->saltoAposGrupo) {
                            echo "<div style='page-break-before:always;'> </div>";

                            # Exibe o cabeçalho
                            if ($this->cabecalhoRelatorio) {
                                $this->exibeCabecalho();
                            }

                            # Exibe o título do Relatório
                            $this->exibeTitulo();
                        }
                    }
                }

                #################
                # Título do subgrupo (quando tiver)
                if (($grupo) && (($agrupa == '') || ($agrupa <> $row[$this->numGrupo]))) {

                    $textoSubitulo = $row[$this->numGrupo];

                    # Coloca a classe (se tiver)
                    if ((isset($this->classe[$this->numGrupo])) and ($this->classe[$this->numGrupo] <> NULL)) {
                        $instancia = new $this->classe[$this->numGrupo]();
                        $metodoClasse = $this->metodo[$this->numGrupo];
                        $textoSubitulo = $instancia->$metodoClasse($row[$this->numGrupo]);
                    }

                    # Coloca a função (se tiver)
                    if ((isset($this->funcao[$this->numGrupo])) and ($this->funcao[$this->numGrupo] <> NULL)) {
                        $nomedafuncao = $this->funcao[$this->numGrupo];
                        $textoSubitulo = $nomedafuncao($row[$this->numGrupo]);
                    }

                    # Exibe o subtitulo
                    p(' == ' . $textoSubitulo . ' == ', "pRelatorioSubgrupo");

                    # atualiza a variavel que guarda o nome do agrupamento atual
                    $agrupa = $row[$this->numGrupo];

                    $subSomatorio = 0;  // Zera o somatório
                    $subContador = 0;   // Zera o contador de registro
                }

                #################
                # Nome das colunas (labels)
                if ($subContador == 0) {
                    $this->exibeCabecalhoTabela($tamanhoLinha, $tamanho, $grupo);

                    # começa o corpo da tabela
                    echo '<tbody>';
                }

                #################
                # Incrementa contadores
                $contador += 1;
                $subContador += 1;

                # Espaçamento
                if ($this->espacamento > 0) {
                    for ($b = 0; $b < $this->espacamento; $b++) {
                        echo '<tr></tr>';
                    }
                }

                #################

                echo '<tr ';

                # Cor de agrupamento
                if (!is_null($this->grupoCorColuna)) {
                    if ($row[$this->grupoCorColuna] <> $valorGrupoCorColuna) {

                        $valorGrupoCorColuna = $row[$this->grupoCorColuna];
                        if ($corGrupo == "grupo1") {
                            $corGrupo = "grupo2";
                        } else {
                            $corGrupo = "grupo1";
                        }
                    }

                    echo ' id="' . $corGrupo . '"';
                }

                echo '>';

                #################

                if ($this->numeroOrdem) {
                    echo '<td id="center">' . $numOrdem . '</td>';
                }

                if ($this->numeroOrdemTipo == 'c') {
                    $numOrdem++;    # incrementa o número de ordem
                } else {
                    $numOrdem--;    # decrementa o número de ordem
                }

                #################
                # percorre as colunas
                for ($a = 0; $a < $tamanho; $a += 1) {

                    if ((!$grupo) || (($grupo) && ($a <> $this->numGrupo)) || (($grupo) && (!$this->ocultaGrupo))) {

                        #################

                        $rowspanValor = NULL;
                        $exibeTd = TRUE;

                        # Verifica se tem Rowlspan
                        if (!is_null($this->rowspan)) {

                            # Verifica se é essa coluna
                            if ($this->rowspan == $a) {

                                $rowAtual = $row[$a];

                                # Verifica se mudou o valor
                                if ($rowspanAnterior <> $rowAtual) {
                                    $rowspanAnterior = $rowAtual;  // habilita o novo valor anterior

                                    if ($arr[$row[$a]] > 1) {
                                        $rowspanValor = $arr[$row[$a]];
                                    }
                                } else {
                                    if ($arr[$row[$a]] > 1) {
                                        $exibeTd = FALSE;
                                    }
                                }
                            }
                        }

                        #################

                        if ($exibeTd) {

                            echo '<td ';

                            if (!is_null($rowspanValor)) {
                                echo 'rowspan="' . $rowspanValor . '" ';
                            }

                            # alinhamento
                            if ((isset($this->align[$a])) and ($this->align[$a] <> NULL)) {
                                echo 'id="' . $this->align[$a] . '" ';
                            } else {
                                echo 'id="center" ';
                            }

                            echo '>';

                            # Coloca a classe (se tiver)
                            if ((isset($this->classe[$a])) and ($this->classe[$a] <> NULL)) {
                                $instancia = new $this->classe[$a]();
                                $metodoClasse = $this->metodo[$a];
                                $row[$a] = $instancia->$metodoClasse($row[$a]);
                            }

                            # Coloca a função (se tiver)
                            if ((isset($this->funcao[$a])) and ($this->funcao[$a] <> NULL)) {
                                $nomedafuncao = $this->funcao[$a];
                                $row[$a] = $nomedafuncao($row[$a]);
                            }


                            echo $row[$a];

                            # soma o valor quando o somatório estiver habilitado
                            if (!is_null($this->colunaSomatorio)) {
                                if ($a == $this->colunaSomatorio) {
                                    $somatorio += $row[$a];
                                    $subSomatorio += $row[$a];
                                }
                            }
                            echo '</td>';
                        }// exibetd
                    }
                }
                echo '</tr>';

                # Espaçamento
                if ($this->espacamento > 0) {
                    for ($b = 0; $b < $this->espacamento; $b++) {
                        echo '<tr></tr>';
                    }
                }

                if ($this->subRelatorio) {
                    $nomeClasseBd = $this->subClasseBd;
                    $subBd = new $nomeClasseBd();
                    $subSelect = $this->subSelect;
                    $subSelect .= $row[$this->subJoin];
                    $result = $subBd->select($subSelect);

                    $nomeClasse = $this->subRelatorio;
                    $nomeClasse->set_cabecalhoRelatorio(FALSE);
                    $nomeClasse->set_menuRelatorio(FALSE);
                    $nomeClasse->set_conteudo($result);
                    $nomeClasse->set_dataImpressao(FALSE);

                    echo '<tr><td colspan="' . $tamanhoLinha . '">';
                    $nomeClasse->show();
                    echo '</td></tr>';
                }

                if ($this->bordaInterna) {
                    $this->exibeLinha($tamanhoLinha);
                }
            }

            # Exibe a soma quando o somatório estiver habilitado
            if ((!is_null($this->colunaSomatorio)) AND ($contador <> 0)) {
                $this->exibeSomatorio($tamanhoLinha, $subSomatorio);
                $subSomatorio = 0;  // Zera o somatório
            }

            echo '</tbody>';

            # linha
            if ($this->linhaNomeColuna) {
                $this->exibeLinha($tamanhoLinha);
            }

            # Fecha a tabela
            echo '<tfoot>';
            echo '<tr><td colspan="' . ($tamanhoLinha) . '" title="Total de itens da tabela">';
            echo '</td></tr>';
            echo '</tfoot>';
            echo '</table>';

            # Exibe o número de registros
            if (($this->subTotal) AND ($contador > 0)) {
                $this->totalRegistro($subContador);
                $subContador = 0;   // Zera o contador de registro
            }

            # Executa a rotina no final de um grupo na forma de função
            if (!is_null($this->funcaoFinalGrupo)) {
                # Verifica se é array. Mais de uma função
                if (is_array($this->funcaoFinalGrupo)) {
                    # quantidade de itens
                    $quantidade = count($this->funcaoFinalGrupo);

                    # Percorre o array executando as funções na ordem do array
                    for ($i = 0; $i < $quantidade; $i++) {
                        $nomedafuncao = $this->funcaoFinalGrupo[$i];
                        $nomedafuncao($this->funcaoFinalGrupoParametro[$i]);
                    }
                } else {
                    $nomedafuncao = $this->funcaoFinalGrupo;
                    $nomedafuncao($this->funcaoFinalGrupoParametro);
                }
            }

            if ($this->linhaFinal) {
                hr();
            }

            # Exibe a informação de que não tem nenhum resgistro
            if (($contador == 0) AND ($this->mensagemNenhumRegistro)) {
                br();
                p("Não existe nenhum registro a ser exibido !!!!", "pRelatorioNenhumItem");
                br();
            }
        } // se tem conteúdo (beta)

        echo '</table>';

        # Total de Registros
        if ($this->totalRegistro) {
            hr();
            p('Total de Registros: ' . $contador, 'pRelatorioTotal');
            $this->totalRegistroValor = $contador;
        }

        # Executa a rotina no final de um grupo na forma de função
        if (!is_null($this->funcaoFinalRelatorio)) {
            # Verifica se é array. Mais de uma função
            if (is_array($this->funcaoFinalRelatorio)) {
                # quantidade de itens
                $quantidade = count($this->funcaoFinalRelatorio);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->funcaoFinalRelatorio[$i];
                    $nomedafuncao($this->funcaoFinalRelatorioParametro[$i]);
                }
            } else {
                $nomedafuncao = $this->funcaoFinalRelatorio;
                $nomedafuncao($this->funcaoFinalRelatorioParametro);
            }
        }

        # Pega o usuário
        $idUsuario = get_session('idUsuario');

        # Data da Impressão
        if ($this->dataImpressao) {
            $this->exibeDataImpressao();
        }

        # Rodapé
        if (!vazio($this->rodape)) {
            echo "<footer>";
            echo $this->rodape;
            echo "</footer>";
        }

        # Fecha o grid
        $grid->fechaColuna();
        $grid->fechaGrid();

        # fecha a div relatório
        $div->fecha();

        # Grava no log a atividade
        if ($this->log) {

            if (is_null($this->logDetalhe)) {
                $atividade = 'Visualizou o(a) ' . $this->titulo;

                if (!is_null($this->tituloLinha2)) {
                    $atividade .= ' - ' . $this->tituloLinha2;
                }

                if (!is_null($this->subtitulo)) {
                    $atividade .= ' - ' . $this->subtitulo;
                }
            } else {
                $atividade = $this->logDetalhe;
            }

            $Objetolog = new Intra();
            $data = date("Y-m-d H:i:s");
            $Objetolog->registraLog($idUsuario, $data, $atividade, NULL, NULL, 4, $this->logServidor);
        }
    }

}
