<?php
 /**
 * classe Modelo
 * 
 * Rotina completa para gestão de uma tabela simples com rotinas de:
 * Pesquisa, Edição, Inclusão e Exclusão
 * 
 * By Alat
 */
 
class Modelo
{
    # Nome do Modelo (aparecerá nos fildset e no caption da tabela)
    private $nome = NULL;
    
    # id (para o fieldset) 
    private $id = 'Padrao';

    # botões de voltar da lista
    private $botaoVoltarLista = TRUE;
    private $voltarLista = NULL;

    # botão de voltar do formulário
    private $voltarForm = '?';
    private $botaoVoltarForm = TRUE;
    
    # botões Incluir e editar do list
    private $botaoIncluir = TRUE;
    private $botaoEditar = TRUE;    # esse flag é necessário pois o link de editar e incluir são os mesmos
                                    # e pode-se querer ter o botão incluir mas não o botão editar.   

    # botão de histórico
    private $botaoHistorico = TRUE;

    # campo de pesquisa de um parâmetro na rotina de listar
    private $parametroLabel = NULL;
    private $parametroValue = NULL;
    
    # Top bar
    private $topBarListar = TRUE;  # Exibe ou  não a top bar na rotina de lista
    private $topBarIncluir = TRUE;  # Exibe ou  não a top bar na rotina de inclusão

    # ordem da lista
    private $orderCampo = NULL;
    private $orderTipo = NULL;
    private $orderChamador = NULL;

    # select da lista
    private $selectLista;
    private $selectEdita;
    
    # Tempo de pesquisa
    private $exibeTempoPesquisa = TRUE;
    
    
    # Caminhos
    private $linkEditar = NULL;
    private $linkIncluir = NULL;
    private $linkExcluir = NULL;
    private $linkGravar = NULL;
    private $linkListar = NULL;

    # Parametros da tabela
    private $label = NULL;
    private $width = NULL;	
    private $align = NULL;
    private $idTabela = NULL;
    
    private $link = NULL;               # array de objetos link correspondente a coluna em que ele aparece
    private $linkCondicional = NULL;    # array com o valor que a coluna deve ter para ter o link
    private $imagemCondicional = NULL;    # array com a imagem condicional
    private $linkImage = NULL;
    private $linkTitle = NULL;
    private $linkCondicionalOperador = '='; # operador da compara��o. pode ser (=,<>, < ou >)
    
    private $formatacaoCondicional = NULL;  # Array com uma formata��o condicional de cores
    private $numeroOrdem = FALSE;           # Exibe (qualdo TRUE) uma numera��o das colunas
    private $numeroOrdemTipo = 'c';         # Informa que a ordena��o ser� 'c' crescente ou 'd' decrescente

    # Da função
    private $funcao = NULL;
 
    # da Classe
    private $classe = NULL;             # array de classes
    private $metodo = NULL;             # array de metodo das classes
    
    # das rotinas de exclusão
    private $excluirCondicional = NULL;	
    private $excluirCondicao = NULL;		
    private $excluirColuna = NULL;		

    # das rotinas de edição
    private $editarCondicional = NULL;	
    private $editarCondicao = NULL;		
    private $editarColuna = NULL;	
    private $botaoCancelaEdita = NULL;

    # do título das colunas de link padrão
    private $nomeColunaExcluir = NULL;
    private $nomeColunaEditar = NULL;

    # dos botões das colunas de editar e excluir
    private $editarBotao = NULL;
    private $excluirBotao = NULL;

    # Parâmetros da paginação da listagem
    private $paginacao = FALSE;			# Flag que indica se terá ou não paginação na lista
    private $paginacaoItens = 15;		# Quantidade de registros por página. 
    private $paginacaoInicial = 0;		# A paginação inicial
    private $pagina = 1;			# Página atual
    private $quantidadeMaxLinks = 10;           # Quantidade Máximo de links de paginação a ser exibido na página
    
    # Valores antes da atualização
    private $oldValue = NULL;

    # Classe do banco de dados
    private $classBd = NULL;

    # Nome da tabela
    private $tabela = NULL;	

    # Nome (e id) do Formulário para o css e jscript
    private $nomeForm = 'formPadrao';

    # Insere objeto (Imagem) para o form
    private $objetoForm = NULL;

    # Nome do campo id
    private $idCampo = NULL;	

    # Tipo de label do formulário
    private $formLabelTipo = 1;

    # Campos para o formulario
    private $campos = NULL;

    # Parâmetros pra a rotina de Log
    private $idUsuario = NULL;		    # Usuário logado
    private $idServidorPesquisado = NULL;   # Usado para informar qual servidor teve os dados alterados. Usado no sistema de pessoal 
    private $listaLog = 'listaLog.php';     # rotina externa para onde o botão levará
    private $log = TRUE;		    # Se grava ou não o log
    private $logDescricao = TRUE;           # Define se no log grava a atividade (descrição do que foi gravado)	

    # Botões extra
    private $botaoListarExtra; # Array de objetos button para fazer um menu na rotina de listar
    private $botaoEditarExtra; # Array de objetos button para fazer um menu na rotina de editar
    
    # Rotinas Extras - > rotina extra que aparecerá nas rotinas de listar e editar
    private $rotinaExtra = NULL;
    private $rotinaExtraParametro = NULL;
    
    # Rotinas Extras Editar - > rotina extra que aparecerá na rotina de editar
    private $rotinaExtraEditar = NULL;
    private $rotinaExtraEditarParametro = NULL;
    
    # Rotinas Extras Listar - > rotina extra que aparecerá na rotina de Lista
    private $rotinaExtraListar = NULL;
    private $rotinaExtraListarParametro = NULL;
    
    # Outros
    private $exibeInfoObrigatoriedade = TRUE;
    
    ###########################################################

    /**
    * Métodos get e set construídos de forma automática pelo 
    * metodo mágico __call.
    * Esse m�todo cria um set e um get para todas as propriedades da classe.
    * Um m�todo existente tem prioridade sobre os métodos criados pelo __call.
    * 
    * O formato dos métodos devem ser:
    * 	set_propriedade
    * 	get_propriedade
    * 
    * @param 	$metodo		O nome do metodo
    * @param 	$parametros	Os par�metros inseridos  
    */
    
    public function __call ($metodo, $parametros)
    {
        ## Se for set, atribui um valor para a propriedade
        if (substr($metodo, 0, 3) == 'set')
        {
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
    * @param 	$excluirCondicional string -> url para a rotina de exclus�o
    * @param 	$excluirCondicao	 string -> valor que exibe o bot�o de exclus�o
    * @param 	$excluirColuna		 integer -> n�mero da coluna cujo valor ser� comparado
    */
    
    public function set_excluirCondicional($excluirCondicional,$excluirCondicao,$excluirColuna)
    {
        $this->excluirCondicional = $excluirCondicional;
        $this->excluirCondicao = $excluirCondicao;
        $this->excluirColuna = $excluirColuna;
    }

    ###########################################################

    /**
    * Método set_editarCondicional
    * 
    * Define uma condiçãoo para exibir ou não a opção de edição
    * Usado na rotina de serviço para exibir a edição aos usuários 
    * comuns somente das OS desse mesmo usuário.
    * 
    * @param 	$editarCondicional string -> url para a rotina de editar
    * @param 	$editarCondicao	   string -> valor que exibe o botão de editar
    * @param 	$editarColuna	   integer -> número da coluna cujo valor será comparado
    */
    
    public function set_editarCondicional($editarCondicional,$editarCondicao,$editarColuna)
    {
        $this->editarCondicional = $editarCondicional;
        $this->editarCondicao = $editarCondicao;
        $this->editarColuna = $editarColuna;
    }

    ###########################################################
        
    /**
     * método set_botaoListarExtra
     * inclui um objeto (button ou link) na rotina listar (ao lado do botao voltar)
     * 
     * @param  $button    = objeto button
     */
    public function set_botaoListarExtra($button){
       $this->botaoListarExtra = $button; 
    }
    
    ###########################################################
        
    /**
     * método set_funcao
     * inclui um objeto (button ou link) na rotina listar (ao lado do botao voltar)
     * 
     * @param  $button    = objeto button
     */
    public function set_funcao($funcao){
       $this->funcao = $funcao; 
    }
    
    ###########################################################

    /**
    * método lista
    * Exibe os registros em uma tabela
    * 
    */
    public function listar()
    {
        # Pega o time inicial
        $time_start = microtime(TRUE);
        
        set_session('oldValue'.$this->tabela);

        # Limita o tamanho da tela
        $grid = new Grid();
        $grid->abreColuna(12);
        
        # Preenche a url do botão incluir se for nula ...
        if (is_null($this->linkIncluir)) {
            $this->linkIncluir = $this->linkEditar;
        }

        # Conecta com o banco de dados
        $objeto = new $this->classBd();

        # Cria um menu
        $menu = new MenuBar();
        
        # Botão voltar
        if($this->botaoVoltarLista){
            $linkBotaoVoltar = new Button("Voltar",$this->voltarLista);
            $linkBotaoVoltar->set_title('Volta para a página anterior');
            $linkBotaoVoltar->set_accessKey('V');
            $menu->add_link($linkBotaoVoltar,"left");
        }
        
        # Inclui botões extras
        if ($this->botaoListarExtra){
            foreach ($this->botaoListarExtra as $botao){
                $menu->add_link($botao,"right");
            }
        }

        # Botão incluir
         if ($this->botaoIncluir){
            $linkBotaoIncluir = new Button("Incluir",$this->linkIncluir);
            $linkBotaoIncluir->set_title('Incluir um Registro');
            $linkBotaoIncluir->set_accessKey('I');
            $menu->add_link($linkBotaoIncluir,"right");
        } 
        $menu->show(); 
        
        # Rotina Extra
        if(!is_null($this->rotinaExtra)){
            # Verifica se é array. Mais de uma função
            if(is_array($this->rotinaExtra)){
                # quantidade de itens
                $quantidade = count($this->rotinaExtra);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->rotinaExtra[$i];
                    $nomedafuncao($this->rotinaExtraParametro[$i]);
                }
            }else{
               $nomedafuncao = $this->rotinaExtra;
               $nomedafuncao($this->rotinaExtraParametro); 
            }
        }
        
        # Rotina Extra Listar
        if(!is_null($this->rotinaExtraListar)){
            # Verifica se é array. Mais de uma função
            if(is_array($this->rotinaExtraListar)){
                # quantidade de itens
                $quantidade = count($this->rotinaExtraListar);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->rotinaExtraListar[$i];
                    $nomedafuncao($this->rotinaExtraListarParametro[$i]);
                }
            }else{
               $nomedafuncao = $this->rotinaExtraListar;
               $nomedafuncao($this->rotinaExtraListarParametro); 
            }
        }
        
        # Pega a quantidade de registros antes da paginação
        $result = $objeto->select($this->selectLista);
        $totalRegistros = count($result);
                
        # Calculos da paginaçao
        $texto = NULL;
        if($this->paginacao){
            # Calcula o total de páginas
            $totalPaginas = ceil($totalRegistros/$this->paginacaoItens);

            # Calcula o número da página
            $this->pagina = ceil($this->paginacaoInicial/$this->paginacaoItens)+1;

            # Calcula o item inicial e final da página
            $itemFinal = $this->pagina * $this->paginacaoItens;
            $itemInicial = $itemFinal - $this->paginacaoItens+1;

            if ($itemFinal > $totalRegistros) {
                $itemFinal = $totalRegistros;
            }

            # Texto do fieldset
            $texto = 'Página: '.$this->pagina.' de '.$totalPaginas;
        
            # Acrescenta a sql
            $this->selectLista.=' LIMIT '.$this->paginacaoInicial.','.$this->paginacaoItens;

            # Botôes de Navegação das páginas 
            $proximo = $this->paginacaoInicial + $this->paginacaoItens;
            $anterior = $this->paginacaoInicial - $this->paginacaoItens;

            # Acrescenta o parâmetro (se houver)
            if(!is_null($this->parametroValue)){
                $proximo .= '&parametro='.$this->parametroValue;
                $anterior .= '&parametro='.$this->parametroValue;					
            }

            # Acrescenta a ordenação (se houver)
            if(!is_null($this->orderCampo)){
                $proximo .= '&orderCampo='.$this->orderCampo;
                $proximo .= '&orderTipo='.$this->orderTipo;
                $anterior .= '&orderCampo='.$this->orderCampo;
                $anterior .= '&orderTipo='.$this->orderTipo;
            }
        }
        
        # Botões de paginação
        if($this->paginacao){
            # Começa os botões de navegação
            $div = new Div("paginacao");
            $div->abre();            
            echo'<ul class="pagination text-center" role="navigation" aria-label="Pagination">';

            # Botão Página Anterior
            if($this->pagina == 1){
                echo '<li class="pagination-previous disabled"><span class="show-for-sr">page</span></li>';
            }else{
                echo '<li class="pagination-previous"><a href="?paginacao='.$anterior.'" aria-label="Página anterior"></a></li>';
            }

            # Links para a página
            for($pag = 1;$pag <= $totalPaginas; $pag++){
                if($pag == $this->pagina){
                    echo '<li class="current"><span class="show-for-sr">Página Atual</span> '.$pag.'</li>';
                }else{
                    $link = $this->paginacaoItens * ($pag-1);
                
                    if($totalPaginas > $this->quantidadeMaxLinks){
                        switch ($pag) {
                            case 1:
                            case 2:    
                                echo '<li><a href="?paginacao='.$link.'" aria-label="Pagina '.$pag.'">'.$pag.'</a></li>';
                                break;
                            case 3:
                                if($this->pagina == 2){
                                    echo '<li><a href="?paginacao='.$link.'" aria-label="Pagina '.$pag.'">'.$pag.'</a></li>';  
                                }else{
                                    echo '<li>...<li>';
                                }
                                break;
                            case $this->pagina-1:
                            case $this->pagina+1:    
                                echo '<li><a href="?paginacao='.$link.'" aria-label="Pagina '.$pag.'">'.$pag.'</a><li>';
                                break;
                            case $totalPaginas-2:
                                if($this->pagina == $this->pagina-4){
                                    echo '<li><a href="?paginacao='.$link.'" aria-label="Pagina '.$pag.'">'.$pag.'</a></li>';  
                                }else{
                                    echo '<li>...<li>';
                                }
                                break;
                            case $totalPaginas-1:
                            case $totalPaginas:
                                echo '<li><a href="?paginacao='.$link.'" aria-label="Pagina '.$pag.'">'.$pag.'</a></li>';
                                break;
                        }                                
                    }else{
                        echo '<li><a href="?paginacao='.$link.'" aria-label="Pagina '.$pag.'">'.$pag.'</a></li>';
                    }
                }
            }

            # Botão Próxima Página
            if($this->pagina < $totalPaginas){
                echo '<li class="pagination-next"><a href="?paginacao='.$proximo.'" aria-label="Próxima página"><span class="show-for-sr">page</span></a></li>';
            }else{
                echo '<li class="pagination-next disabled"><span class="show-for-sr">page</span></li>';
            }
            echo '</ul>';
            $div->fecha();
        }       
        
        # Topbar
        if($this->topBarListar){
            $top = new TopBar($this->nome);
            $top->set_title($this->nome);
        
            # Botão Incluir
            #if ($this->botaoIncluir){
            #    $top->add_link($linkBotaoIncluir,"right");
            #}

            # Coloca o campo de pesquisa (se tiver)
            if(!is_null($this->parametroLabel)){
                $top->add_pesquisa($this->parametroLabel, $this->parametroValue);
            }
            $top->show();
        }
            
        # Pega a lista em definitivo
        #echo $this->selectLista;
        $result = $objeto->select($this->selectLista);

        # se o resultado for vazio exibe mensagem ao inves de montar a tabela
        if(count($result) == 0){
            br();
            $callout = new Callout();
            $callout->abre();
                p('Nenhum item encontrado !!','center');
            $callout->fecha();
        }
        else{
            # Monta a tabela
            $tabela = new Tabela();
            $tabela->set_conteudo($result);
            $tabela->set_id($this->idTabela);
            $tabela->set_label($this->label);
            $tabela->set_align($this->align);
            $tabela->set_width($this->width);
            $tabela->set_link($this->link);
            $tabela->set_linkCondicional($this->linkCondicional);
            $tabela->set_linkCondicionalOperador($this->linkCondicionalOperador);
            $tabela->set_funcao($this->funcao);
            $tabela->set_classe($this->classe);
            $tabela->set_metodo($this->metodo);

            # acrescenta uma coluna com um número de ordenação
            if ($this->numeroOrdem){
                $tabela->set_numeroOrdem($this->numeroOrdem);
                $tabela->set_numeroOrdemTipo($this->numeroOrdemTipo);
            }        

            # formatação condicional
            $tabela->set_formatacaoCondicional($this->formatacaoCondicional);

            # imagem condicional
            $tabela->set_imagemCondicional($this->imagemCondicional);

            # se tem botão editar
            if ($this->botaoEditar) {
                $tabela->set_editar($this->linkEditar);
            }

            # coloca no rodapé a paginação (quando houver)
            if ($this->paginacao) {
                $tabela->set_rodape($texto . ' (' . $itemInicial . ' a ' . $itemFinal . ' de ' . $totalRegistros . ' Registros)');
            }

            # coloca o botão de editar (quando houver)
            if (!is_null($this->editarBotao)) {
                $tabela->set_editarBotao($this->editarBotao);
            }

            # coloca o botão de excluir (quando houver)
            if (!is_null($this->excluirBotao)) {
                $tabela->set_excluirBotao($this->excluirBotao);
            }

            $tabela->set_excluir($this->linkExcluir);
            $tabela->set_idCampo($this->idCampo);
            $tabela->set_order($this->orderCampo,$this->orderTipo,$this->orderChamador);

            $tabela->set_excluirCondicional($this->excluirCondicional,$this->excluirCondicao,$this->excluirColuna);

            $tabela->set_editarCondicional($this->editarCondicional,$this->editarCondicao,$this->editarColuna);

            if (!is_null($this->nomeColunaEditar)) {
                $tabela->set_nomeColunaEditar($this->nomeColunaEditar);
            }

            #$tabela->link_image = $this->link_image;
            #$tabela->link_title = $this->link_title;

            # informa para tabela se tem parametro para ser ressaltado na tabela
            if (!is_null($this->parametroValue) or ( $this->parametroValue == "")) {
                $tabela->set_textoRessaltado($this->parametroValue);
            }

            $tabela->show();
            
            # Pega o time final
            $time_end = microtime(TRUE);
            
            # Calcula e exibe o tempo
            if($this->exibeTempoPesquisa){
                $time = $time_end - $time_start;
                p(number_format($time, 4, '.', ',')." segundos","right","f10");
            }
            
            $grid->fechaColuna();
            $grid->fechaGrid();
        }       
    }

    ###########################################################

    /**
    * método editar (e incluir)
    * 
    * @param $id integer id se for para update NULL se for para insert 
    */

    public function editar($id = NULL) {
        # Limita o tamanho da tela
        $grid = new Grid();
        $grid->abreColuna(12);
        
        # Cria um menu
        $menu = new MenuBar();
        
        # Botão voltar
        if ($this->botaoVoltarForm){        
            $linkBotaoVoltar = new Button("Voltar",$this->voltarForm);
            $linkBotaoVoltar->set_title('Volta para a página anterior');
            $linkBotaoVoltar->set_accessKey('V');
            $menu->add_link($linkBotaoVoltar,"left");
        }
        
        # Inclui botões extras
        if ($this->botaoEditarExtra){
            foreach ($this->botaoEditarExtra as $botao){
                $menu->add_link($botao,"right");
            }
        }

        # Botão histórico
        if($this->botaoHistorico){
            if (Verifica::acesso($this->idUsuario,1)){
                if (!is_null($id)){
                    $linkBotaoHistorico = new Button("Histórico");
                    $linkBotaoHistorico->set_title('Exibe o histórico');
                    $linkBotaoHistorico->set_onClick("abreFechaDivId('divHistorico');");
                    $linkBotaoHistorico->set_accessKey('H');
                    $menu->add_link($linkBotaoHistorico,"right");
                }
            }
        }

        $menu->show();
        
        # Rotina Extra
        if(!is_null($this->rotinaExtra)){
            # Verifica se é array. Mais de uma função
            if(is_array($this->rotinaExtra)){
                # quantidade de itens
                $quantidade = count($this->rotinaExtra);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->rotinaExtra[$i];
                    $nomedafuncao($this->rotinaExtraParametro[$i]);
                }
            }else{
               $nomedafuncao = $this->rotinaExtra;
               $nomedafuncao($this->rotinaExtraParametro); 
            }
        }
        
        # Rotina Extra Editar
        if(!is_null($this->rotinaExtraEditar)){
            # Verifica se é array. Mais de uma função
            if(is_array($this->rotinaExtraEditar)){
                # quantidade de itens
                $quantidade = count($this->rotinaExtraEditar);

                # Percorre o array executando as funções na ordem do array
                for ($i = 0; $i < $quantidade; $i++) {
                    $nomedafuncao = $this->rotinaExtraEditar[$i];
                    $nomedafuncao($this->rotinaExtraEditarParametro[$i]);
                }
            }else{
               $nomedafuncao = $this->rotinaExtraEditar;
               $nomedafuncao($this->rotinaExtraEditarParametro); 
            }
        }
        
        # Topbar 
        if ($this->topBarIncluir){
            $top = new TopBar($this->nome);
            $top->set_title($this->nome);
            $top->show(); 
        }

       # exibe (ocultamente) o histórico
       if ((!is_null($id)) AND ($this->botaoHistorico)){
            $this->exibeHistorico($id);
       }


        if(($id <> NULL)and($this->selectEdita <> NULL)){	
            # Conecta com o banco de dados
            $objeto = new $this->classBd();

            # Nas classes genéricas inclui o nome da tabela
            if (!is_null($this->tabela)){
                $objeto->set_tabela($this->tabela, $this->idCampo);
            }

            # faz o select	
            $row = $objeto->select($this->selectEdita,FALSE);
        }  

        $form = new Form($this->linkGravar.'&id='.$id,$this->nomeForm);
        $form->set_id('form'.$this->id);
        
        if ($this->objetoForm){
            $form->set_objeto($this->objetoForm);
        }


        # Rotina que faz o calculo do tamanho das colunas
        # para adaptar a grid do frame Foundation
        $linhaAtual = 0;            // zera a flag da linha atual
        $somatorioSize = 0;         // somatorio temporário de uma determinada linha
        $somaPorLinha[] = NULL;     // Array com o somatório por linha
        foreach ($this->campos as $campo){
            # pega o tamanho de um controle (input)
            if ($campo['tipo'] == 'textarea') {
                $sizeFormulario = $campo['size'][0];
            } else {
                $sizeFormulario = $campo['size'];
            }  // se for text area tira do array


            # Se a linha não mudou ou se for a primeira linha
            if (($linhaAtual == $campo['linha']) OR ( $linhaAtual == 0)) {
                $somatorioSize += $sizeFormulario;
            }   // acrescenta
            else {
                $somatorioSize = $sizeFormulario;
            }    // iniciar o somatório

            $somaPorLinha[$campo['linha']] = $somatorioSize; // atualiza a soma por linha
        }

        $contador = 1;	// Contador para a tabulação do formulário

        foreach ($this->campos as $campo){
            $controle = new Input($campo['nome'],$campo['tipo'],$campo['label'],$this->formLabelTipo); 
            $controle->set_linha($campo['linha']);      // linha no form que vai ser colocado o controle
            $controle->set_tabindex($contador);		// tabulador (ordem de navega��o com a tecla tab)
            
            if (isset($campo['size'])) {
                $controle->set_size($campo['size']);
            }                    // tamanho do campos
            if (isset($campo['maxLength'])) {    // quantidade máxima de caracteres
                $controle->set_size($campo['size'], $campo['maxLength']);
            }
            if (isset($campo['required'])) {
                $controle->set_required($campo['required']);
            }   // faz o controle exibir o *
            if (isset($campo['tagHtml'])) {
                $controle->set_tagHtml($campo['tagHtml']);
            }   // faz o controle exibir o html
            if (isset($campo['array'])) {
                $controle->set_array($campo['array']);
            }    // conteudo de uma combo
            if (isset($campo['readOnly'])) {
                $controle->set_readonly($campo['readOnly']);
            }          // readonly
            if (isset($campo['disabled'])) {
                $controle->set_disabled($campo['disabled']);
            }
            if (isset($campo['autofocus'])) {
                $controle->set_autofocus($campo['autofocus']);
            }          // disabled
            if (isset($campo['placeholder'])) {
                $controle->set_placeholder($campo['placeholder']);
            } // placeholder (dica dentro do controle)
            if (isset($campo['title'])) {
                $controle->set_title($campo['title']);
            }          // title - dica do campo
            else {
                $controle->set_title($campo['label']);
            }
            if (isset($campo['onChange'])) {
                $controle->set_onChange($campo['onChange']);
            }         // onChange	
            if (isset($campo['fieldset'])) {
                $controle->set_fieldset($campo['fieldset']);
            }            // fieldse interno
            if (isset($campo['col'])) {
                $controle->set_col($campo['col']);
            }else{    // Tamanho da coluna
                $controle->set_col($this->CalculaTamanhoColuna($somaPorLinha[$campo['linha']], $sizeFormulario));
            }# Chama a rotina que transforma o tamanho das coluna para o formato do grid do Foundation

            # pega o tamanho de um controle (input)
            if ($campo['tipo'] == 'textarea') {
                $sizeFormulario = $campo['size'][0];
            } else {
                $sizeFormulario = $campo['size'];
            }  // se for text area tira do array

            # Inlcui o valor se for para editar (id <> NULL)
            if(($id <> NULL)and($this->selectEdita <> NULL))
            {
                # se tiver criptografia, descriptograva para exibi��o
                if ((isset($campo['encode'])) AND ( $campo['encode'])) {
                    $row[$campo['nome']] = base64_decode($row[$campo['nome']]);
                }

                # se for data coloca no formato brasileiro antes da exibi��o 
                # somente se n�o usa o controle data html5
                if(($campo['tipo'] == 'date') OR ($campo['tipo'] == 'data'))
                {
                    if(HTML5)
                    {
                        $controle->set_valor($row[$campo['nome']]); 
                        $oldValue[] = $row[$campo['nome']];
                    }
                    else
                    {
                        $controle->set_valor(date_to_php($row[$campo['nome']])); // se for data passa para o formato dd/mm/aaaa
                        $oldValue[] = date_to_php($row[$campo['nome']]);
                    }
                        
                }
                else // se aceitar tags html
                {
                    if ((isset($campo['tagHtml'])) AND ( $campo['tagHtml'] == TRUE)) {
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

            $form->add_item($controle);
            $contador++;	// incrementa o contador
        }

        # Passa por session os valores antigos
        if (($id <> NULL)and ( $this->selectEdita <> NULL)) {
            set_session('oldValue' . $this->tabela, $oldValue);
        }

        # submit
        $controle = new Input('submit','submit');
        $controle->set_valor(' Salvar ');
        $controle->set_size(20);
        $controle->set_tabindex($contador+1);
        $controle->set_accessKey('S');
        $controle->set_linha($linhaAtual+1);
        $controle->set_col(3);
        $form->add_item($controle);
        
        # cancelar
        if(!is_null($this->botaoCancelaEdita)){
            $controle = new Input('cancela','button');
            $controle->set_valor(' Cancelar ');
            $controle->set_size(20);
            $controle->set_onClick("$this->botaoCancelaEdita");
            $controle->set_tabindex($contador+2);
            $controle->set_fieldset('fecha');
            $controle->set_linha($linhaAtual+1);
            $controle->set_col(3);
            $form->add_item($controle);
        }
                
        # Exibe o form
        $box = new Callout();
        $box->abre();        
            $form->show();            
        $box->fecha();
        
        # Exibe informação de obrigatoriedade de certos campos
        if($this->exibeInfoObrigatoriedade){
            echo '<div id="right">';
            label("Campos marcados com * são obrigatórios","warning","f12");
            echo '</div>';
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
    
    public function gravar($id = NULL,$validacaoExtra = NULL)
    {	
        # Variáveis sobre um erro fatal (que não pode prosseguir com ele)
        $erro = 0;		    // flag de erro: 1 - tem erro; 0 - não tem	
        $msgErro = NULL; 	// repositório de mensagens de erro

        $contador = 0;		// contador para os arrays $campo_nome e $campo_valor
        $alteracoes = NULL;	// informa as alteraçõs dos valores antigos com os novos
        $atividade = NULL;	// Variavel que informa ao log o que foi feito

        # Pega o valor antigo
        $oldValue = get_session('oldValue'.$this->tabela);

        # percorre os dados digitados validando
        foreach ($this->campos as $campo)
        {		
            # passa o nome dos campos para o array de gravação
            $campoNome[$contador] = addslashes($campo['nome']);  // nome do campo no banco
            $campoValor[$contador] = post($campo['nome']);	     // array dos valores

            # Transforma aspas simples para dupla
            $campoValor[$contador] = str_replace("'",'"',$campoValor[$contador]);	
            #$campoValor[$contador] = addcslashes($campoValor[$contador],'"'); 

            # Apaga as tags de php e html
            if ((isset($campo['tagHtml'])) and ( $campo['tagHtml'])) {
                $campoValor[$contador] = strip_tags($campoValor[$contador], TAGS);
            } else {
                $campoValor[$contador] = strip_tags($campoValor[$contador]);
            }

            # Compara o valor antigo com o novo
            if($oldValue[$contador] <> $campoValor[$contador])
            {
                # verifica se � html5 para formatar a data
                if (HTML5) {
                    # verifica se é data
                    if (($campo['tipo'] == 'date')or ( $campo['tipo'] == 'data')) {
                        $alteracoes .= '[' . $campo['label'] . '] ' . $oldValue[$contador] . '->' . date_to_php($campoValor[$contador]) . '; ';
                    } else {
                        $alteracoes .= '[' . $campo['label'] . '] ' . $oldValue[$contador] . '->' . $campoValor[$contador] . '; ';
                    }
                }
                else {
                    $alteracoes .= '[' . $campo['label'] . '] ' . $oldValue[$contador] . '->' . $campoValor[$contador] . '; ';
                }
            }
            
            # passa para nulo os campos vazios
            if ($campoValor[$contador] == "") {
                $campoValor[$contador] = NULL;
            }

            # verifica not NULL
            if ((isset($campo['required'])) and ($campo['required']))
            {
                if (vazio($campoValor[$contador]))
                {
                    $msgErro.='O campo '.$campo['label'].' é obrigatório!\n';
                    $erro = 1;
                }
            }

            # verifica se é 'unique' -> único valor no campo nessa tabela
            if ((isset($campo['unique'])) and ($campo['unique']))
            {
                # Pega duplicados
                $duplicidade = new $this->classBd();
                if ((isset($id)) and ( $id <> NULL)) {
                    $result = $duplicidade->select("SELECT $this->idCampo FROM $this->tabela WHERE $campoNome[$contador] = '$campoValor[$contador]' AND $this->idCampo <> $id");
                } else {
                    $result = $duplicidade->select("SELECT $this->idCampo FROM $this->tabela WHERE $campoNome[$contador] = '$campoValor[$contador]'");
                } // quando insert
                 
                #echo "SELECT $this->idCampo FROM $this->tabela WHERE $campoNome[$contador] = '$campoValor[$contador]' AND $this->idCampo <> $id";br();
                
                $duplicatas = count($result);

                if ($duplicatas > 0)
                {
                    $erro = 1;
                    $msgErro .= 'Já existe um registro com esse valor de '.$campo['label'].'!\n';
                }
            }

            # verifica a validade do cpf
            if ($campo['tipo'] == 'cpf')
            {
                if(!is_null($campoValor[$contador]))
                {
                    if (!validaCpf(soNumeros($campoValor[$contador])))
                    {		
                        $msgErro.='CPF Inválido!\n';
                        $erro = 1;
                    }
                }
            }

            # validação dos campos tipo checkbox
            if ($campo['tipo'] == 'checkbox')
            {
                if (isset($campoValor[$contador])) {
                    $campoValor[$contador] = 1;
                }
            }

            # validação dos campos tipo data
            if ((($campo['tipo'] == 'date')or($campo['tipo'] == 'data'))and(!(is_null($campoValor[$contador]))))
            { 
                # formata data quando vier de um controle html5 (vem yyyy/mm/dd)
                if (HTML5) {
                    $campoValor[$contador] = date_to_php($campoValor[$contador]);
                }

                # verifica a validade da data
                if (!validaData($campoValor[$contador])) {
                    $msgErro .= 'A ' . $campo['label'] . ' não é válida!\n';
                    $erro = 1;
                } else {
                    $campoValor[$contador] = date_to_bd($campoValor[$contador]);
                } # passa a data para o formato de gravação
            }
            
            # Passa o campo moeda para o formato americano (para o banco de dados)
            if (($campo['tipo'] == 'moeda')and(!(is_null($campoValor[$contador]))))
            {
                $campoValor[$contador] = formataMoeda($campoValor[$contador],2);	
            }
       
            # se tiver criptografia, descriptograva para exibição
            if ((isset($campo['encode'])) AND ( $campo['encode'])) {
                $campoValor[$contador] = base64_encode($campoValor[$contador]);
            }

            /*	
            # criptografa quando for password
            if ($campo['tipo'] == 'password')
            $campo_valor[] = post($campo['nome']);
            */

            $contador++;
        }
        
        if (!is_null($validacaoExtra)) {
            include_once $validacaoExtra;
        }

        # Verifica se teve alterações em um editar       
        #if (is_null($alteracoes)){
        #    $msgErro.='Você não alterou nada! Vai gravar o que ?!\n';
        #    $erro = 1;
        #}  // Alterado seguindo a idéia de que o silêncio é de ouro

        if ($erro == 0)
        {
            # Conecta com o banco de dados
            $objeto = new $this->classBd();

            # Inclui o nome da tabela
            $objeto->set_tabela($this->tabela);

            # Inclui o nome do campo chave
            $objeto->set_idCampo($this->idCampo);

            # grava	
            $objeto->gravar($campoNome,$campoValor,$id);

            # Após a verificação se não alterou nada
            # passa a $alteracao para NULL caso lodDescricao 
            # peça isso
            if (!$this->logDescricao) {
                $alteracoes = NULL;
            }

            # Inicia o tipo de log
            $tipoLog = NULL;

            # Grava no log a atividade
            if($this->log)
            {
                $intra = new Intra();
                $data = date("Y-m-d H:i:s");

                # preenche atividade de inclusão
                if (is_null($id) or ($id == "")){
                    $atividade = 'Incluiu: '.$alteracoes;
                    $id = $objeto->get_lastId();
                    $tipoLog = 1;		
                }else{
                    $atividade .= 'Alterou: '.$alteracoes;
                    $tipoLog = 2;
                }
                
                # grava se tiver atividades para serem gravadas
                if (!is_null($atividade)){
                    $intra->registraLog($this->idUsuario,$data,$atividade,$this->tabela,$id,$tipoLog,$this->idServidorPesquisado);
                }
            }

            aguarde();

            loadPage($this->linkListar);
            return TRUE;
        }else{
            alert($msgErro);
            back(1);
        }		   	
    }

    ###########################################################

    /**
    * método excluir
    * Método de exclusão de registro
    * 
    * @param $id	integer	- id da not�cia
    */
    
    public function excluir($id){
        
        # Pega os dados caso seja tbpermissao
        if($this->log){
            $intra = new Intra();
            $data = date("Y-m-d H:i:s");
        
            if($this->tabela == 'tbpermissao')
            {
                $pessoal = new Pessoal();
                $permissao = $intra->get_permissao($id);             
                $atividade = "Exclui a permissao $id ($permissao) do servidor $this->idServidorPesquisado (".$pessoal->get_nome($this->idServidorPesquisado).")";
            }else{
                $atividade = 'Excluiu';
            }
        }

        # Conecta com o banco de dados
        $objeto = new $this->classBd();
        $objeto->set_tabela($this->tabela);		# a tabela
        $objeto->set_idCampo($this->idCampo);	# o nome do campo id
        if($objeto->excluir($id)){		
            if($this->log){
                $intra->registraLog($this->idUsuario,$data,$atividade,$this->tabela,$id,3,$this->idServidorPesquisado);
            }
        }
        loadPage ($this->linkListar);
    }

    ###########################################################

    /**
    * método add_objeto
    * inclui um objeto (imagem) apos o formulário
    * 
    * @param  $controle    = objeto controle
    */
    
    public function add_objeto($imagem){
        $this->objetoForm[] = $imagem; 
    }

    ###########################################################

    /**
    * método exibeHistorico
    * Exibe uma lista do histórico
    * 
    * @param  $id o id para se exibir o histórico
    */
    
    public function exibeHistorico($id = NULL)
    {
        echo '<div class="callout" id="divHistorico">';

        $select = 'SELECT tblog.data,
                          grh.tbpessoa.nome,
                          tblog.atividade,
                          tblog.idValor
                     FROM tblog 
                     JOIN tbusuario ON(tblog.idUsuario = tbusuario.idUsuario)
                     JOIN grh.tbservidor ON(tbusuario.idServidor = grh.tbservidor.idServidor)
                     JOIN grh.tbpessoa ON (grh.tbservidor.idPessoa = grh.tbpessoa.idPessoa)
                    WHERE tblog.tabela="'.$this->tabela.'"
                      AND tblog.idValor='.$id.' 
                 ORDER BY tblog.data desc';
                 
        # Conecta com o banco de dados
        $intra = new Intra();
        $result = $intra->select($select);
        $contadorHistorico = $intra->count($select); 

        # Parametros da tabela
        $label = array("Data","Nome","Atividade","id");
        $align = array("center","center","left");
        $width = array(13,22,50,5);
        $funcao = array ("datetime_to_php");

        # Monta a tabela
        $tabela = new Tabela();
        $tabela->set_conteudo($result);
        $tabela->set_label($label);
        $tabela->set_align($align);
        $tabela->set_width($width);
        $tabela->set_funcao($funcao);
        $tabela->set_titulo('Histórico de Alterações');

        $tabela->show();
        
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

    public function CalculaTamanhoColuna($totalSize, $sizeColuna)
    {
        return ((12*$sizeColuna)/$totalSize);  // faz a mágica

    }
}