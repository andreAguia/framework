<?php

/**
 * classe Modelo
 *
 * Rotina completa para gestão de uma tabela simples com rotinas de:
 * Pesquisa, Edição, Inclusão e Exclusão
 *
 * By Alat
 */
class Modelo {
    /*
     * Variáveis Gerais
     */
    # Nome do Modelo (aparecerá nos fildset e no caption da tabela)

    private $nome = null;

    # id (para o fieldset)
    private $id = 'Padrao';

    # Caminhos
    private $linkEditar = null;
    private $linkIncluir = null;
    private $linkExcluir = null;
    private $linkGravar = null;
    private $linkListar = null;

    # Rotinas Extras - > rotina extra que aparecerá nas rotinas de listar e editar
    private $rotinaExtra = null;
    private $rotinaExtraParametro = null;

    # Modo Somente Leitura. Não exibe os botões de inclusão, edição nem exclusão
    private $modoLeitura = false;

    ###########################################################

    /*
     * Rotina listar
     */

    # Top bar
    private $topBarListar = true;

    # select
    private $selectLista;

    # botão de voltar
    private $botaoVoltarLista = true;
    private $voltarLista = null;

    # Array de objetos button para incluir no menu
    private $botaoListarExtra;

    # botão Incluir
    private $botaoIncluir = true;
    private $botaoIncluirNome = "Incluir";

    # botão Editar
    private $botaoEditar = true;

    # campo de pesquisa
    private $parametroLabel = null;
    private $parametroValue = null;
    private $tipoCampoPesquisa = "texto";
    private $arrayPesquisa = null; // quando combo
    private $exibeTextoRessaltado = true;
    private $exibeTempoPesquisa = true;

    # ordem da lista
    private $orderCampo = null;
    private $orderTipo = null;
    private $orderChamador = null;

    # Parametros da tabela
    private $label = null;
    private $colspanLabel = null;
    private $width = null;
    private $align = null;
    private $idTabela = null;
    private $totalRegistro = true;

    # Define uma nova figura para os botões. Senão serã exibido a figura padrão
    private $editarBotao = null;
    private $excluirBotao = null;

    # Rotinas Extras Listar - > rotina extra que aparecerá na rotina de Lista
    private $rotinaExtraListar = null;
    private $rotinaExtraListarParametro = null;

    # link
    private $link = null; # array de objetos link correspondente a coluna em que ele aparece
    private $linkCondicional = null; # array com o valor que a coluna deve ter para ter o link
    private $imagemCondicional = null; # array com a imagem condicional
    private $linkImage = null;
    private $linkTitle = null;
    private $linkCondicionalOperador = '='; // operador da comparação. pode ser (=,<>, < ou >)
    private $formatacaoCondicional = null;  // Array com uma formatação condicional de cores
    private $numeroOrdem = false;           // Exibe (qualdo true) uma numeração das colunas
    private $numeroOrdemTipo = 'c';         // Informa que a ordenação ser� 'c' crescente ou 'd' decrescente
    # do somatório da tabela
    private $colunaSomatorio = null;        // coluna que terá somatório (por enquanto uma por relatório)
    private $textoSomatorio = 'Total:';     // texto a ser exibido na linha de totalização
    # Classes e Funções
    private $funcao = null;
    private $funcaoDepoisClasse = null;
    private $classe = null;
    private $metodo = null;

    # das rotinas de exclusão
    private $excluirCondicional = null;
    private $excluirCondicao = null;
    private $excluirColuna = null;
    private $excluirOperador = "==";

    # das rotinas de edição
    private $editarCondicional = null;
    private $editarCondicao = null;
    private $editarColuna = null;
    private $editarOperador = "==";
    private $botaoCancelaEdita = null;

    # do título das colunas de link padrão
    private $nomeColunaExcluir = null;
    private $nomeColunaEditar = null;

    # Paginação
    private $paginacao = false; # Flag que indica se terá ou não paginação na lista
    private $paginacaoItens = 15; # Quantidade de registros por página.
    private $paginacaoInicial = 0; # A paginação inicial
    private $pagina = 1; # Página atual
    private $quantidadeMaxLinks = 10; # Quantidade Máximo de links de paginação a ser exibido na página
    # Menu Lateral - Objeto menu a ser inserido ao lado da tabela de listagem
    private $menuLateralListar = null;

    # Se as linhas da tabela serão de cores diferentes
    private $comGridLista = true;

    # Coluna onde o código fará automaticamente rowspan de valores iguais (colocar na ordenação esta coluna)
    private $rowspan = null;

    # Indica se haverá colorização de um grupo por valores diferentes. Usado para diferenciar um grupo de linhas de outro grupo.
    private $grupoCorColuna = null;

    ###########################################################

    /*
     * Rotina Editar e Incluir
     */

    # Top bar
    private $topBarIncluir = true;

    # select
    private $selectEdita;

    # botão de voltar do formulário
    private $voltarForm = '?';
    private $botaoVoltarForm = true;

    # Array de objetos button para incluir no menu
    private $botaoEditarExtra;

    # botão de histórico (aparece no editar)
    private $botaoHistorico = true;

    # Nome (e id) do Formulário para o css e jscript
    private $nomeForm = 'formPadrao';

    # Tipo de label do formulário
    private $formLabelTipo = 1;

    # Campos para o formulario
    private $campos = null;

    # Insere objeto (Imagem) para o form
    private $objetoForm = null;

    # Rotinas Extras Editar - > rotina extra que aparecerá na rotina de editar
    private $rotinaExtraEditar = null;
    private $rotinaExtraEditarParametro = null;

    # Formnulário Extra
    private $formExtra = null;

    # Menu Lateral - Objeto menu a ser inserido ao lado do formulário de edição
    private $menuLateralEditar = null;

    # Exibe um * quando o campo for obrigatório
    private $exibeInfoObrigatoriedade = true;

    ###########################################################

    /*
     * Rotina Excluir
     */
    private $botaoExcluir = true;

    ###########################################################

    /*
     * Rotina Gravar
     */

    # Rotina que volta após gravar
    private $linkAposGravar = null;

    # Valores antes da atualização
    private $oldValue = null;

    # Classe do banco de dados
    private $classBd = null;

    # Nome da tabela
    private $tabela = null;

    # Nome do campo id
    private $idCampo = null;

    # Parâmetros para o log - Usuário logado
    private $idUsuario = null;

    # Parâmetros para o log - Qual servidor teve os dados alterados
    private $idServidorPesquisado = null;

    # Parâmetros para o log - Rotina externa para onde o botão levará
    private $listaLog = 'listaLog.php';

    # Parâmetros para o log - Se terá ou não log gravado
    private $log = true;

    # Parâmetros para o log - Define se no log grava a atividade (descrição do que foi gravado)
    private $logDescricao = true;

    ###########################################################

    /**
     * Métodos get e set construídos de forma automática pelo
     * metodo mágico __call.
     * Esse metodo cria um set e um get para todas as propriedades da classe.
     * Um metodo existente tem prioridade sobre os métodos criados pelo __call.
     *
     * O formato dos métodos devem ser:
     *     set_propriedade
     *     get_propriedade
     *
     * @param     $metodo        O nome do metodo
     * @param     $parametros    Os parametros inseridos
     */
    public function __call($metodo, $parametros) {
        ## Se for set, atribui um valor para a propriedade
        if (substr($metodo, 0, 3) == 'set') {
            $var = substr($metodo, 4);
            $this->$var = $parametros[0];
        }

        # Se for Get, retorna o valor da propriedade
        #if (substr($metodo, 0, 3) == 'get')
        #{
        # $var = substr($metodo, 4);
        #  return $this->$var;
        #}
    }

    ###########################################################

    /**
     * Método set_excluirCondicional
     *
     * Define uma condição para exibir ou não a opção de exclusão
     * Usado na rotina de férias para colocar a opção de exclusão
     * somente nas férias com status de solicitada.
     *
     * @param     $excluirCondicional string -> url para a rotina de exclusao
     * @param     $excluirCondicao     string -> valor que exibe o botao de exclusao
     * @param     $excluirColuna         integer -> numero da coluna cujo valor sera comparado
     */
    public function set_excluirCondicional($excluirCondicional, $excluirCondicao, $excluirColuna, $excluirOperador = null) {
        $this->excluirCondicional = $excluirCondicional;
        $this->excluirCondicao = $excluirCondicao;
        $this->excluirColuna = $excluirColuna;
        $this->excluirOperador = $excluirOperador;
    }

    ###########################################################

    /**
     * Método set_editarCondicional
     *
     * Define uma condiçãoo para exibir ou não a opção de edição
     * Usado na rotina de serviço para exibir a edição aos usuários
     * comuns somente das OS desse mesmo usuário.
     *
     * @param     $editarCondicional string -> url para a rotina de editar
     * @param     $editarCondicao       string -> valor que exibe o botão de editar
     * @param     $editarColuna       integer -> número da coluna cujo valor será comparado
     */
    public function set_editarCondicional($editarCondicional, $editarCondicao, $editarColuna, $editarOperador = null) {
        $this->editarCondicional = $editarCondicional;
        $this->editarCondicao = $editarCondicao;
        $this->editarColuna = $editarColuna;
        $this->editarOperador = $editarOperador;
    }

    ###########################################################

    /**
     * método set_botaoListarExtra
     * inclui um objeto (button ou link) na rotina listar (ao lado do botao voltar)
     *
     * @param  $button    = objeto button
     */
    public function set_botaoListarExtra($button) {
        $this->botaoListarExtra = $button;
    }

    ###########################################################

    /**
     * método set_funcao
     * inclui um objeto (button ou link) na rotina listar (ao lado do botao voltar)
     *
     * @param  $button    = objeto button
     */
    public function set_funcao($funcao) {
        $this->funcao = $funcao;
    }

    ###########################################################

    /**
     * método lista
     * Exibe os registros em uma tabela
     *
     */
    public function listar() {
        # Pega o time inicial
        if ($this->exibeTempoPesquisa) {
            $time_start = microtime(true);
        }

        set_session('oldValue' . $this->tabela);

        # Limita o tamanho da tela
        if ($this->comGridLista) {
            $grid = new Grid();
            $grid->abreColuna(12);
        }

        # Preenche a url do botão incluir se for nula ...
        if (is_null($this->linkIncluir)) {
            $this->linkIncluir = $this->linkEditar;
        }

        # Conecta com o banco de dados
        $objeto = new $this->classBd();

        # Cria um menu
        if (($this->botaoVoltarLista) or ($this->botaoListarExtra) or ($this->botaoIncluir)) {
            $menu = new MenuBar();

            # Botão voltar
            if ($this->botaoVoltarLista) {
                $linkBotaoVoltar = new Button("Voltar", $this->voltarLista);
                $linkBotaoVoltar->set_title('Volta para a página anterior');
                $linkBotaoVoltar->set_accessKey('V');
                $menu->add_link($linkBotaoVoltar, "left");
            }

            # Campo de Pesquisa
            if (!is_null($this->parametroLabel)) {
                $form = new Form('?fase=listar');

                $controle = new Input("parametro", $this->tipoCampoPesquisa);
                $controle->set_size(50);
                $controle->set_placeholder($this->parametroLabel);
                $controle->set_valor($this->parametroValue);
                $controle->set_autofocus(true);
                $controle->set_onChange('formPadrao.submit();');
                $controle->set_id("controlePesquisa");
                $controle->set_pesquisa(true);
                $controle->set_col(8);

                # Oculta o texto ressaltado quando for combo
                if ($this->tipoCampoPesquisa == "combo") {
                    $this->exibeTextoRessaltado = false;
                }
                # Envia o array quando é combo
                if (!is_null($this->arrayPesquisa)) {
                    $controle->set_array($this->arrayPesquisa);
                }
                $form->add_item($controle);
                $menu->add_link($form, "left");
            }

            # Inclui botões extras
            if ($this->botaoListarExtra) {
                foreach ($this->botaoListarExtra as $botao) {
                    $menu->add_link($botao, "right");
                }
            }

            # Botão incluir
            if (!$this->modoLeitura) {
                if ($this->botaoIncluir) {
                    $linkBotaoIncluir = new Button($this->botaoIncluirNome, $this->linkIncluir);
                    $linkBotaoIncluir->set_title('Incluir um Registro');
                    $linkBotaoIncluir->set_accessKey('I');
                    $menu->add_link($linkBotaoIncluir, "right");
                }
            }
            $menu->show();
        }

        # Formulário Extra
        if (!empty($this->formExtra)) {
            $this->formExtra->show();
        }

        # Rotina Extra
        if (!is_null($this->rotinaExtra)) {
            # Verifica se é array. Mais de uma função
            if (is_array($this->rotinaExtra)) {
                # quantidade de itens
                $quantidade = count($this->rotinaExtra);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->rotinaExtra[$i];
                    $nomedafuncao($this->rotinaExtraParametro[$i]);
                }
            } else {
                $nomedafuncao = $this->rotinaExtra;
                $nomedafuncao($this->rotinaExtraParametro);
            }
        }

        # Rotina Extra Listar
        if (!is_null($this->rotinaExtraListar)) {
            # Verifica se é array. Mais de uma função
            if (is_array($this->rotinaExtraListar)) {
                # quantidade de itens
                $quantidade = count($this->rotinaExtraListar);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->rotinaExtraListar[$i];
                    $nomedafuncao($this->rotinaExtraListarParametro[$i]);
                }
            } else {
                $nomedafuncao = $this->rotinaExtraListar;
                $nomedafuncao($this->rotinaExtraListarParametro);
            }
        }

        # Pega a quantidade de registros antes da paginação
        $result = $objeto->select($this->selectLista);
        $totalRegistros = count($result);

        # Calculos da paginaçao
        $texto = null;
        if ($this->paginacao) {
            # Calcula o total de páginas
            $totalPaginas = ceil($totalRegistros / $this->paginacaoItens);

            # Calcula o número da página
            $this->pagina = ceil($this->paginacaoInicial / $this->paginacaoItens) + 1;

            # Calcula o item inicial e final da página
            $itemFinal = $this->pagina * $this->paginacaoItens;
            $itemInicial = $itemFinal - $this->paginacaoItens + 1;

            if ($itemFinal > $totalRegistros) {
                $itemFinal = $totalRegistros;
            }

            # Texto do fieldset
            $texto = 'Página: ' . $this->pagina . ' de ' . $totalPaginas;

            # Acrescenta a sql
            $this->selectLista .= ' LIMIT ' . $this->paginacaoInicial . ',' . $this->paginacaoItens;

            # Botôes de Navegação das páginas
            $proximo = $this->paginacaoInicial + $this->paginacaoItens;
            $anterior = $this->paginacaoInicial - $this->paginacaoItens;

            # Acrescenta o parâmetro (se houver)
            if (!is_null($this->parametroValue)) {
                $proximo .= '&parametro=' . $this->parametroValue;
                $anterior .= '&parametro=' . $this->parametroValue;
            }

            # Acrescenta a ordenação (se houver)
            if (!is_null($this->orderCampo)) {
                $proximo .= '&orderCampo=' . $this->orderCampo;
                $proximo .= '&orderTipo=' . $this->orderTipo;
                $anterior .= '&orderCampo=' . $this->orderCampo;
                $anterior .= '&orderTipo=' . $this->orderTipo;
            }
        }

        # Botões de paginação
        if ($this->paginacao) {
            # Começa os botões de navegação
            $div = new Div("paginacao");
            $div->abre();
            echo '<ul class="pagination text-center" role="navigation" aria-label="Pagination">';

            # Botão Página Anterior
            if ($this->pagina == 1) {
                echo '<li class="pagination-previous disabled"><span class="show-for-sr">page</span></li>';
            } else {
                echo '<li class="pagination-previous"><a href="?paginacao=' . $anterior . '" aria-label="Página anterior"></a></li>';
            }

            # Links para a página
            for ($pag = 1; $pag <= $totalPaginas; $pag++) {
                if ($pag == $this->pagina) {
                    echo '<li class="current"><span class="show-for-sr">Página Atual</span> ' . $pag . '</li>';
                } else {
                    $link = $this->paginacaoItens * ($pag - 1);

                    if ($totalPaginas > $this->quantidadeMaxLinks) {
                        switch ($pag) {
                            case 1:
                            case 2:
                                echo '<li><a href="?paginacao=' . $link . '" aria-label="Pagina ' . $pag . '">' . $pag . '</a></li>';
                                break;
                            case 3:
                                if ($this->pagina == 2) {
                                    echo '<li><a href="?paginacao=' . $link . '" aria-label="Pagina ' . $pag . '">' . $pag . '</a></li>';
                                } else {
                                    echo '<li>...<li>';
                                }
                                break;
                            case $this->pagina - 1:
                            case $this->pagina + 1:
                                echo '<li><a href="?paginacao=' . $link . '" aria-label="Pagina ' . $pag . '">' . $pag . '</a><li>';
                                break;
                            case $totalPaginas - 2:
                                if ($this->pagina == $this->pagina - 4) {
                                    echo '<li><a href="?paginacao=' . $link . '" aria-label="Pagina ' . $pag . '">' . $pag . '</a></li>';
                                } else {
                                    echo '<li>...<li>';
                                }
                                break;
                            case $totalPaginas - 1:
                            case $totalPaginas:
                                echo '<li><a href="?paginacao=' . $link . '" aria-label="Pagina ' . $pag . '">' . $pag . '</a></li>';
                                break;
                        }
                    } else {
                        echo '<li><a href="?paginacao=' . $link . '" aria-label="Pagina ' . $pag . '">' . $pag . '</a></li>';
                    }
                }
            }

            # Botão Próxima Página
            if ($this->pagina < $totalPaginas) {
                echo '<li class="pagination-next"><a href="?paginacao=' . $proximo . '" aria-label="Próxima página"><span class="show-for-sr">page</span></a></li>';
            } else {
                echo '<li class="pagination-next disabled"><span class="show-for-sr">page</span></li>';
            }
            echo '</ul>';
            $div->fecha();
        }

        # Exibe o menu Lateral (quando tem)
        if (!is_null($this->menuLateralListar)) {
            $gridMenu = new Grid();
            $gridMenu->abreColuna(3);

            $this->menuLateralListar->show();

            $gridMenu->fechaColuna();
            $gridMenu->abreColuna(9);
        }

        # Pega a lista em definitivo
        #echo $this->selectLista;
        $result = $objeto->select($this->selectLista);

        # Monta a tabela
        $tabela = new Tabela();
        $tabela->set_titulo($this->nome);
        $tabela->set_conteudo($result);
        $tabela->set_id($this->idTabela);
        $tabela->set_label($this->label);
        $tabela->set_colspanLabel($this->colspanLabel);
        $tabela->set_align($this->align);
        $tabela->set_width($this->width);
        $tabela->set_link($this->link);
        $tabela->set_linkCondicional($this->linkCondicional);
        $tabela->set_linkCondicionalOperador($this->linkCondicionalOperador);
        $tabela->set_funcao($this->funcao);
        $tabela->set_funcaoDepoisClasse($this->funcaoDepoisClasse);
        $tabela->set_classe($this->classe);
        $tabela->set_metodo($this->metodo);
        $tabela->set_rowspan($this->rowspan);

        if (!is_null($this->grupoCorColuna)) {
            $tabela->set_grupoCorColuna($this->grupoCorColuna);
        }

        # acrescenta uma coluna com um número de ordenação
        if ($this->numeroOrdem) {
            $tabela->set_numeroOrdem($this->numeroOrdem);
            $tabela->set_numeroOrdemTipo($this->numeroOrdemTipo);
        }

        # Coluna do somatório
        if (!is_null($this->colunaSomatorio)) {
            $tabela->set_colunaSomatorio($this->colunaSomatorio);
        }

        # Texto do somatório
        if (!is_null($this->textoSomatorio)) {
            $tabela->set_textoSomatorio($this->textoSomatorio);
        }

        # Informa se exibe (ou não) o total de registros
        $tabela->set_totalRegistro($this->totalRegistro);

        # formatação condicional
        $tabela->set_formatacaoCondicional($this->formatacaoCondicional);

        # imagem condicional
        $tabela->set_imagemCondicional($this->imagemCondicional);

        # se tem botão editar
        if ($this->botaoEditar) {
            $tabela->set_editar($this->linkEditar);
        }

        # se tem botão excluir
        if ($this->botaoExcluir) {
            if (!$this->modoLeitura) {
                $tabela->set_excluir($this->linkExcluir);
            }
        }

        # coloca no rodapé a paginação (quando houver)
        if ($this->paginacao) {
            $tabela->set_rodape($texto . ' (' . $itemInicial . ' a ' . $itemFinal . ' de ' . $totalRegistros . ' Registros)');
        }

        # Muda a imagem do botão editar
        if (!is_null($this->editarBotao)) {
            $tabela->set_editarBotao($this->editarBotao);
        }

        # Muda a imagem do botão excluir
        if (!is_null($this->excluirBotao)) {
            $tabela->set_excluirBotao($this->excluirBotao);
        }

        $tabela->set_idCampo($this->idCampo);
        $tabela->set_order($this->orderCampo, $this->orderTipo, $this->orderChamador);

        $tabela->set_editarCondicional($this->editarCondicional, $this->editarCondicao, $this->editarColuna, $this->editarOperador);

        $tabela->set_excluirCondicional($this->excluirCondicional, $this->excluirCondicao, $this->excluirColuna, $this->excluirOperador);

        if (!is_null($this->nomeColunaEditar)) {
            $tabela->set_nomeColunaEditar($this->nomeColunaEditar);
        }

        #$tabela->link_image = $this->link_image;
        #$tabela->link_title = $this->link_title;
        # informa para tabela se tem parametro para ser ressaltado na tabela
        if (!is_null($this->parametroValue) or ($this->parametroValue == "")) {
            if ($this->exibeTextoRessaltado) {
                $tabela->set_textoRessaltado($this->parametroValue);
            }
        }
        $tabela->show();

        # Pega o time final
        $time_end = microtime(true);

        # Calcula e exibe o tempo
        if ($this->exibeTempoPesquisa) {
            $time = $time_end - $time_start;
            p(number_format($time, 4, '.', ',') . " segundos", "right", "f10");
        }

        if (!is_null($this->menuLateralEditar)) {
            $gridMenu->fechaColuna();
            $gridMenu->fechaGrid();
        }

        if ($this->comGridLista) {
            $grid->fechaColuna();
            $grid->fechaGrid();
        }
    }

    ###########################################################

    /**
     * método ver
     *
     * @param $id        integer null  id se for para update null se for para insert
     */
    public function ver($id = null) {

        # Cria o botão Editar
        $botaoEditar = new Button("Editar", "?fase=editar&id=$id");
        $botaoEditar->set_title("Editar");
        $this->botaoEditarExtra[] = $botaoEditar;

        $this::editar($id, true);
    }

    ###########################################################

    /**
     * método editar (e incluir)
     *
     * @param $id        integer null  id se for para update null se for para insert
     * @param $bloqueado bool    false Se está bloqueado para edição ou não
     */
    public function editar($id = null, $bloqueado = false) {
        # Limita o tamanho da tela
        $grid = new Grid();
        $grid->abreColuna(12);

        # Passa para bloqueado quando for modo leitura
        if ($this->modoLeitura) {
            $bloqueado = true;
        }

        # Cria um menu
        $menu = new MenuBar();

        # Botão voltar
        if ($this->botaoVoltarForm) {
            $linkBotaoVoltar = new Button("Voltar", $this->voltarForm);
            $linkBotaoVoltar->set_title('Volta para a página anterior');
            $linkBotaoVoltar->set_accessKey('V');
            $menu->add_link($linkBotaoVoltar, "left");
        }

        # Inclui botões extras
        if ($this->botaoEditarExtra) {
            foreach ($this->botaoEditarExtra as $botao) {
                $menu->add_link($botao, "right");
            }
        }

        # Botão histórico
        if ($this->botaoHistorico) {
            if (!$this->modoLeitura) {
                if (!is_null($id)) {
                    $linkBotaoHistorico = new Link("Histórico");
                    $linkBotaoHistorico->set_class('button success');
                    $linkBotaoHistorico->set_onClick("abreFechaDivId('divHistorico');");
                    $linkBotaoHistorico->set_title('Exibe o histórico');
                    $menu->add_link($linkBotaoHistorico, "right");
                }
            }
        }

        if (($this->botaoVoltarForm) or ($this->botaoEditarExtra) or ($this->botaoHistorico)) {
            $menu->show();
        }

        # Rotina Extra
        if (!is_null($this->rotinaExtra)) {
            # Verifica se é array. Mais de uma função
            if (is_array($this->rotinaExtra)) {
                # quantidade de itens
                $quantidade = count($this->rotinaExtra);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->rotinaExtra[$i];
                    $nomedafuncao($this->rotinaExtraParametro[$i]);
                }
            } else {
                $nomedafuncao = $this->rotinaExtra;
                $nomedafuncao($this->rotinaExtraParametro);
            }
        }

        # Rotina Extra Editar
        if (!is_null($this->rotinaExtraEditar)) {
            # Verifica se é array. Mais de uma função
            if (is_array($this->rotinaExtraEditar)) {
                # quantidade de itens
                $quantidade = count($this->rotinaExtraEditar);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->rotinaExtraEditar[$i];
                    $nomedafuncao($this->rotinaExtraEditarParametro[$i]);
                }
            } else {
                $nomedafuncao = $this->rotinaExtraEditar;
                $nomedafuncao($this->rotinaExtraEditarParametro);
            }
        }

        # exibe (ocultamente) o histórico
        if ((!is_null($id)) and ($this->botaoHistorico)) {
            $this->exibeHistorico($id);
        }

        # Exibe o menu Lateral (quando tem)
        if (!is_null($this->menuLateralEditar)) {
            $gridMenu = new Grid();
            $gridMenu->abreColuna(3);

            $this->menuLateralEditar->show();

            $gridMenu->fechaColuna();
            $gridMenu->abreColuna(9);
        }

        # Topbar
        if ($this->topBarIncluir) {
            tituloTable($this->nome);
            #$top = new TopBar($this->nome);
            #$top->set_title($this->nome);
            #$top->show();
        }

        if (($id != null) and ($this->selectEdita != null)) {
            # Conecta com o banco de dados
            $objeto = new $this->classBd();

            # Nas classes genéricas inclui o nome da tabela
            if (!is_null($this->tabela)) {
                $objeto->set_tabela($this->tabela, $this->idCampo);
            }

            # faz o select
            $row = $objeto->select($this->selectEdita, false);
        }

        $form = new Form($this->linkGravar . '&id=' . $id, $this->nomeForm);
        $form->set_id('form' . $this->id);

        if ($this->objetoForm) {
            $form->set_objeto($this->objetoForm);
        }

        # Rotina que faz o calculo do tamanho das colunas
        # para adaptar a grid do frame Foundation
        $linhaAtual = 0; // zera a flag da linha atual
        $somatorioSize = 0; // somatorio temporário de uma determinada linha
        $somaPorLinha[] = null; // Array com o somatório por linha
        foreach ($this->campos as $campo) {

            # pega o tamanho de um controle (input)
            if (($campo['tipo'] == 'textarea') or ($campo['tipo'] == 'editor')) {
                $sizeFormulario = $campo['size'][0];
            } else {
                $sizeFormulario = $campo['size'];
            } // se for text area tira do array
            # Se a linha não mudou ou se for a primeira linha
            if (($linhaAtual == $campo['linha']) or ($linhaAtual == 0)) {
                $somatorioSize += $sizeFormulario;
            } else { // acrescenta
                $somatorioSize = $sizeFormulario;
            } // iniciar o somatório
            $somaPorLinha[$campo['linha']] = $somatorioSize; // atualiza a soma por linha
        }

        $contador = 1; // Contador para a tabulação do formulário
        $ultimoFieldset = null; // Verifica se ultimo fieldset foi o de fechar

        foreach ($this->campos as $campo) {
            # Verifica o tipo do label
            if (empty($campo['tipoLabel'])) {
                $campo['tipoLabel'] = $this->formLabelTipo;
            }

            $controle = new Input($campo['nome'], $campo['tipo'], $campo['label'], $campo['tipoLabel']);
            $controle->set_linha($campo['linha']); // linha no form que vai ser colocado o controle
            $linhaAtual = $campo['linha'];

            $controle->set_tabindex($contador); // tabulador (ordem de navegaçao com a tecla tab)
            # Tamanho com input
            if (isset($campo['size'])) {
                $controle->set_size($campo['size']);
            }

            # Maximo de um controle numero
            if (isset($campo['max'])) {
                $controle->set_max($campo['max']);
            }

            # Mínimo de um controle numero
            if (isset($campo['min'])) {
                $controle->set_min($campo['min']);
            }

            # Quantidade máxima de caracteres
            if (isset($campo['maxLength'])) {
                $controle->set_size($campo['size'], $campo['maxLength']);
            }

            # Se e requerido. Faz o controle exibir o *
            if (isset($campo['required'])) {
                $controle->set_required($campo['required']);
            }

            # Transforma o digitado em minusculas e primeira letra maiusculas
            if (isset($campo['plm'])) {
                $controle->set_plm($campo['plm']);
            }

            # Faz o controle exibir o html
            if (isset($campo['tagHtml'])) {
                $controle->set_tagHtml($campo['tagHtml']);
            }

            # Conteudo de uma combo
            if (isset($campo['array'])) {
                $controle->set_array($campo['array']);
            }

            # Somente leitura
            if (isset($campo['readOnly'])) {
                $controle->set_readonly($campo['readOnly']);
            }

            # Desabilitado
            if (isset($campo['disabled'])) {
                $controle->set_disabled($campo['disabled']);
            }

            # optgroup
            if (isset($campo['optgroup'])) {
                $controle->set_optgroup($campo['optgroup']);
            }

            # datalist
            if (isset($campo['datalist'])) {
                $controle->set_datalist($campo['datalist']);
            }

            # Bloqueia quando for $bloqueado for true
            if ($bloqueado) {
                $controle->set_readonly(true);
                $controle->set_disabled(true);
                $this->exibeInfoObrigatoriedade = false;

                if (isset($campo['bloqueadoEsconde'])) {
                    if ($campo['bloqueadoEsconde']) {
                        continue;
                    }
                }
            }

            # Foco automatico
            if (isset($campo['autofocus'])) {
                $controle->set_autofocus($campo['autofocus']);
            }

            # Marca dagua o input
            if (isset($campo['placeholder'])) {
                $controle->set_placeholder($campo['placeholder']);
            }

            # helptext - texto embaixo do controle
            if (isset($campo['helptext'])) {
                $controle->set_helptext($campo['helptext']);
            }

            # texto no mouseover
            if (isset($campo['title'])) {
                $controle->set_title($campo['title']);
            } else {
                $controle->set_title($campo['label']);
            }

            # Evento onchange
            if (isset($campo['onChange'])) {
                $controle->set_onChange($campo['onChange']);
            }

            # Fieldset
            if (isset($campo['fieldset'])) {
                $controle->set_fieldset($campo['fieldset']);
                $ultimoFieldset = $campo['fieldset']; // Conta os fieldset usados
            }

            # Tamanho do grid da coluna
            if (isset($campo['col'])) {
                $controle->set_col($campo['col']);
            } else {
                $controle->set_col($this->CalculaTamanhoColuna($somaPorLinha[$campo['linha']], $sizeFormulario));
            }

            # pega o tamanho de um controle (input)
            if ($campo['tipo'] == 'textarea') {
                $sizeFormulario = $campo['size'][0];
            } else {
                $sizeFormulario = $campo['size'];
            } // se for text area tira do array
            # Inlcui o valor se for para editar (id <> null)
            if (($id != null) and ($this->selectEdita != null)) {
                # se tiver criptografia, descriptograva para exibi��o
                if ((isset($campo['encode'])) and ($campo['encode'])) {
                    $row[$campo['nome']] = base64_decode($row[$campo['nome']]);
                }

                # Data
                if (($campo['tipo'] == 'date') or ($campo['tipo'] == 'data')) {
                    $controle->set_valor($row[$campo['nome']]);
                    $oldValue[] = $row[$campo['nome']];
                } else { // se aceitar tags html
                    if ((isset($campo['tagHtml'])) and ($campo['tagHtml'] == true)) {
                        $valorCampo = $row[$campo['nome']];
                        $valorControle = htmlentities($valorCampo);
                        $controle->set_valor($valorControle);
                    } else {
                        $controle->set_valor($row[$campo['nome']]);
                    }

                    $oldValue[] = $row[$campo['nome']];
                }
            } elseif (isset($campo['padrao'])) {
                $controle->set_valor($campo['padrao']);
            }

            if (is_null($id)) {
                $oldValue[] = "";
            }

            $form->add_item($controle);
            $contador++; // incrementa o contador
        }

        # Passa por session os valores antigos
        set_session('oldValue' . $this->tabela, $oldValue);

        # Botão Salva quando não está bloqueado
        if (!$bloqueado) {
            $controle = new Input('submit', 'submit');
            $controle->set_valor(' Salvar ');
            $controle->set_size(20);
            $controle->set_tabindex($contador + 1);
            $controle->set_accessKey('S');
            $controle->set_linha($linhaAtual + 2);
            $controle->set_col(3);

            # Verifica se tem fieldset aberto e fecha
            if ($ultimoFieldset != "fecha") {
                $controle->set_fieldset("fecha");
            }

            $form->add_item($controle);
        }

        # cancelar
        if (!is_null($this->botaoCancelaEdita)) {
            $controle = new Input('cancela', 'button');
            $controle->set_valor(' Cancelar ');
            $controle->set_size(20);
            $controle->set_onClick("$this->botaoCancelaEdita");
            $controle->set_tabindex($contador + 2);
            $controle->set_fieldset('fecha');
            $controle->set_linha($linhaAtual + 1);
            $controle->set_col(3);
            $form->add_item($controle);
        }

        # Exibe o form
        $box = new Callout();
        $box->abre();
        $form->show();
        $box->fecha();

        # Exibe o id quando for necessário
        if (!empty($id)) {
            p($id, "pexibeId");
        }

        # Exibe informação de obrigatoriedade de certos campos
        if ($this->exibeInfoObrigatoriedade) {
            echo '<div id="right">';
            label("Campos marcados com * são obrigatórios", "warning", "f11");
            br();
            label("Campos marcados com (Aa) são passados para minusculas com primeira letra de cada palavra em maiusculas.", "warning", "f11");
            echo '</div>';
        }

        if (!is_null($this->menuLateralEditar)) {
            $gridMenu->fechaColuna();
            $gridMenu->abreColuna(9);
        }

        $grid->fechaColuna();
        $grid->fechaGrid();
    }

    ###########################################################

    /**
     * método gravar
     * Método de gravação
     *
     * @param $id                integer   id do registro a ser gravado (se update)
     *                                     se for nulo será insert
     * @param $validacaoExtra    string   rotina externa extra de validação
     */
    public function gravar($id = null, $validacaoExtra = null, $rotinaPosGravacao = null) {
        # Variáveis sobre um erro fatal (que não pode prosseguir com ele)
        $erro = 0; // flag de erro: 1 - tem erro; 0 - não tem
        $msgErro = null; // repositório de mensagens de erro

        $contador = 0; // contador para os arrays $campo_nome e $campo_valor
        $alteracoes = null; // informa as alteraçõs dos valores antigos com os novos
        $atividade = null; // Variavel que informa ao log o que foi feito
        # Pega o valor antigo
        $oldValue = get_session('oldValue' . $this->tabela);

//        var_dump(
//                $oldValue                
//        );
        # percorre os dados digitados validando
        foreach ($this->campos as $campo) {
            # Passa o nome dos campos para o array de gravação
            $campoNome[$contador] = addslashes($campo['nome']);

            # Array com valores
            $campoValor[$contador] = post($campo['nome']);

            # Promove higienização nos dados digitados
            if (!empty($campoValor[$contador])) {
                # Transforma aspas simples para dupla
                $campoValor[$contador] = str_replace("'", '"', $campoValor[$contador]);

                # Apaga as tags de php e html
                if ((isset($campo['tagHtml'])) and ($campo['tagHtml'])) {
                    $campoValor[$contador] = strip_tags($campoValor[$contador], TAGS);
                } else {
                    $campoValor[$contador] = strip_tags($campoValor[$contador]);
                }
            }

            # Compara o valor antigo com o novo
            if ($oldValue[$contador] != $campoValor[$contador]) {

                # formata a data
                if (($campo['tipo'] == 'date') or ($campo['tipo'] == 'data')) {
                    $alteracoes .= '[' . $campo['label'] . '] ' . date_to_php($oldValue[$contador]) . '->' . date_to_php($campoValor[$contador]) . '; ';
                } else {
                    $alteracoes .= '[' . $campo['label'] . '] ' . $oldValue[$contador] . '->' . $campoValor[$contador] . '; ';
                }
            }

            # passa para nulo os campos vazios
            $campoValor[$contador] = vazioPraNulo($campoValor[$contador]);

            /*
             * Require
             */

            # verifica not null
            if ((isset($campo['required'])) and ($campo['required'])) {
                if (vazio($campoValor[$contador])) {
                    $msgErro .= 'O campo ' . $campo['label'] . ' é obrigatório!\n';
                    $erro = 1;
                }
            }

            /*
             * Unique
             */

            # verifica se é 'unique' -> único valor no campo nessa tabela
            if ((isset($campo['unique'])) and ($campo['unique'])) {
                # Pega duplicados
                $duplicidade = new $this->classBd();

                if ((isset($id)) and ($id != null)) {
                    $result = $duplicidade->select("SELECT $this->idCampo FROM $this->tabela WHERE $campoNome[$contador] = '$campoValor[$contador]' AND $this->idCampo <> $id");
                } else {
                    $result = $duplicidade->select("SELECT $this->idCampo FROM $this->tabela WHERE $campoNome[$contador] = '$campoValor[$contador]'");
                } // quando insert
                #echo "SELECT $this->idCampo FROM $this->tabela WHERE $campoNome[$contador] = '$campoValor[$contador]' AND $this->idCampo <> $id";br();

                $duplicatas = count($result);

                if ($duplicatas > 0) {
                    $erro = 1;
                    $msgErro .= 'Já existe um registro com esse valor de ' . $campo['label'] . '!\n';
                }
            }

            /*
             * CPF
             */

            # verifica a validade do cpf
            if ($campo['tipo'] == 'cpf') {
                if (!is_null($campoValor[$contador])) {
                    if (!validaCpf(soNumeros($campoValor[$contador]))) {
                        $msgErro .= 'CPF Inválido!\n';
                        $erro = 1;
                    }
                }
            }

            /*
             * Email
             */

            # verifica a validade do email
            if ($campo['tipo'] == 'email') {

                if (!empty($campoValor[$contador])) {
                    if (!filter_var($campoValor[$contador], FILTER_VALIDATE_EMAIL)) {
                        $msgErro .= 'Email Inválido!\n';
                        $erro = 1;
                    }
                }
            }

            /*
             * Checkbox
             */

            # validação dos campos tipo checkbox
            if ($campo['tipo'] == 'checkbox') {
                if (isset($campoValor[$contador])) {
                    $campoValor[$contador] = 1;
                }
            }

            /*
             * SimNao
             */

            if ($campo['tipo'] == 'simnao') {
                if ($campoValor[$contador]) {
                    $campoValor[$contador] = 1;
                } else {
                    $campoValor[$contador] = 0;
                }
            }

            /*
             * Data
             */

            # validação dos campos tipo data
            if ((($campo['tipo'] == 'date') or ($campo['tipo'] == 'data')) and (!(is_null($campoValor[$contador])))) {

                # formata data quando vier de um controle (vem yyyy/mm/dd)
                $campoValor[$contador] = date_to_php($campoValor[$contador]);

                # verifica a validade da data
                if (!validaData($campoValor[$contador])) {
                    $msgErro .= 'A ' . $campo['label'] . ' não é válida!\n';
                    $erro = 1;
                } else {
                    $campoValor[$contador] = date_to_bd($campoValor[$contador]);
                } # passa a data para o formato de gravação
            }

            /*
             * PLM (Primeira Letra Maiúsculas)
             */

            # passa pra plm quando estiver true
            if ((isset($campo['plm'])) and ($campo['plm'])) {

                # passa para plm com a função plm
                $campoValor[$contador] = plm($campoValor[$contador]);
            }

            /*
             * Moeda
             */

            # Passa o campo moeda para o formato americano (para o banco de dados)
            if (($campo['tipo'] == 'moeda') and (!(is_null($campoValor[$contador])))) {
                $campoValor[$contador] = formataMoeda($campoValor[$contador], 2);
            }

            /*
             * Encode
             */

            # se tiver criptografia, descriptograva para exibição
            if ((isset($campo['encode'])) and ($campo['encode'])) {
                $campoValor[$contador] = base64_encode($campoValor[$contador]);
            }

            /*
              # criptografa quando for password
              if ($campo['tipo'] == 'password')
              $campo_valor[] = post($campo['nome']);
             */

            $contador++;
        }

        # Executa arquivo de validação extra (se houver)
        if (!empty($validacaoExtra)) {
            include_once $validacaoExtra;
        }

        # Verifica se teve alterações em um editar
        #if (is_null($alteracoes)){
        #    $msgErro.='Você não alterou nada! Vai gravar o que ?!\n';
        #    $erro = 1;
        #}  // Alterado seguindo a idéia de que o silêncio é de ouro

        if ($erro == 0) {
            # Conecta com o banco de dados
            $objeto = new $this->classBd();

            # Inclui o nome da tabela
            $objeto->set_tabela($this->tabela);

            # Inclui o nome do campo chave
            $objeto->set_idCampo($this->idCampo);

            # grava
            $objeto->gravar($campoNome, $campoValor, $id);

            # Após a verificação se não alterou nada
            # passa a $alteracao para null caso lodDescricao
            # peça isso
            if (!$this->logDescricao) {
                $alteracoes = null;
            }

            # Inicia o tipo de log
            $tipoLog = null;

            # Grava no log a atividade
            if (($this->log) and (!is_null($alteracoes))) {
                $intra = new Intra();
                $data = date("Y-m-d H:i:s");

                # preenche atividade de inclusão
                if (empty($id) or ($id == "")) {
                    $atividade = 'Incluiu: ' . $alteracoes;
                    $id = $objeto->get_lastId();
                    $tipoLog = 1;
                } else {
                    $atividade .= 'Alterou: ' . $alteracoes;
                    $tipoLog = 2;
                }

                # grava se tiver atividades para serem gravadas
                if (!empty($atividade)) {
                    $intra->registraLog($this->idUsuario,
                            $data,
                            $atividade,
                            $this->tabela,
                            $id,
                            $tipoLog,
                            $this->idServidorPesquisado);
                }
            }

            aguarde();

            # Executa rotina de pos gravação (se houver)
            if (!empty($rotinaPosGravacao)) {
                include_once $rotinaPosGravacao;
            }

            # Verifica onde vai retornar
            if (empty($this->linkAposGravar)) {
                loadPage($this->linkListar);
            } else {
                loadPage($this->linkAposGravar);
            }

            return true;
        } else {
            alert($msgErro);
            back(1);
        }
    }

    ###########################################################

    /**
     * método excluir
     * Método de exclusão de registro
     *
     * @param $id    integer    - o id 
     */
    public function excluir($id) {

        # Pega os dados caso seja tbpermissao
        if ($this->log) {
            $intra = new Intra();
            $data = date("Y-m-d H:i:s");

            if ($this->tabela == 'tbpermissao') {
                $pessoal = new Pessoal();
                $permissao = $intra->get_permissao($id);
                $atividade = "Exclui a permissao $id ($permissao) do servidor $this->idServidorPesquisado (" . $pessoal->get_nome($this->idServidorPesquisado) . ")";
            } else {
                $atividade = 'Excluiu';
            }
        }

        # Conecta com o banco de dados
        $objeto = new $this->classBd();
        $objeto->set_tabela($this->tabela); # a tabela
        $objeto->set_idCampo($this->idCampo); # o nome do campo id
        if ($objeto->excluir($id)) {
            if ($this->log) {
                $intra->registraLog($this->idUsuario, $data, $atividade, $this->tabela, $id, 3, $this->idServidorPesquisado);
            }
        }
        loadPage($this->linkListar);
    }

    ###########################################################

    /**
     * método add_objeto
     * inclui um objeto (imagem) apos o formulário
     *
     * @param  $controle    = objeto controle
     */
    public function add_objeto($imagem) {
        $this->objetoForm[] = $imagem;
    }

    ###########################################################

    /**
     * método exibeHistorico
     * Exibe uma lista do histórico
     *
     * @param  $id o id para se exibir o histórico
     */
    public function exibeHistorico($id = null) {
        echo '<div id="divHistorico">';

        $select = 'SELECT data,
                          usuario,
                          idLog,
                          idValor
                     FROM tblog
                     LEFT JOIN tbusuario USING (idUsuario)
                    WHERE tabela="' . $this->tabela . '"
                      AND idValor=' . $id . '
                 ORDER BY data desc';

        # Conecta com o banco de dados
        $intra = new Intra();
        $result = $intra->select($select);
        $contadorHistorico = $intra->count($select);

        if ($contadorHistorico > 0) {

            # Monta a tabela
            $tabela = new Tabela();
            $tabela->set_conteudo($result);
            $tabela->set_label(["Data", "Usuário", "Atividade"]);
            $tabela->set_align(["center", "center", "left"]);
            $tabela->set_funcao(["datetime_to_php"]);
            $tabela->set_titulo('Histórico de Alterações');
            $tabela->set_classe([null, null, "Log"]);
            $tabela->set_metodo([null, null, "getAtividades"]);

            $tabela->show();
        } else {
            tituloTable('Histórico de Alterações');

            $box = new Callout();
            $box->abre();

            p('Nenhum item encontrado !!', 'center');

            $box->fecha();
        }

        echo '</div>';
    }

    ###########################################################

    /**
     * método CalculaTamanhoColuna
     *
     * Calcula o tamanho da coluna para o framework Foundation
     * a partir da linha e do tamanho (size) do controle.
     *
     * Usado para adaptar ao framework foundatio sem muita
     * alteração do frame antigo
     *
     * @param  $id o id para se exibir o histórico
     */
    public function CalculaTamanhoColuna($totalSize, $sizeColuna) {
        return ((12 * $sizeColuna) / $totalSize); // faz a mágica
    }

}
