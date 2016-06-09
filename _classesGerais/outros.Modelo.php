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
    private $nome = null;
    
    # id (para o fieldset) 
    private $id = 'Padrao';

    # botões de voltar da lista
    private $botaoVoltarLista = true;
    private $voltarLista = null;

    # botão de voltar do formulário
    private $voltarForm = '?';
    private $botaoVoltarForm = true;

    # botão salvar
    private $botaoSalvarGrafico = false;        # determina se o botão de salvar será gráfico(disquete) ou comum
    private $botaoSalvarImagem = 'salvar.jpg';  # determina a imagem do botão
    private $botaoSalvarLabel = 'Salvar';       # determina o label do botão Salvar
    private $botaoSalvarId = null;              # id do botão salvar para o css

    # botões Incluir e editar do list
    private $botaoIncluir = true;
    private $botaoEditar = true;    # esse flag é necessário pois o link de editar e incluir s�o os mesmos
                                    # e pode-se querer ter o bot�o incluir mas não o botão editar.   

    # botão de histórico
    private $botaoHistorico = true;

    # campo de pesquisa de um parâmetro na rotina de listar
    private $parametroLabel = null;
    private $parametroValue = null;

    # ordem da lista
    private $orderCampo = null;
    private $orderTipo = null;
    private $orderChamador = null;

    # select da lista
    private $selectLista;
    private $selectEdita;
    
    # Caminhos
    private $linkEditar = null;
    private $linkIncluir = null;
    private $linkExcluir = null;
    private $linkGravar = null;
    private $linkListar = null;

    # Parametros da tabela
    private $label = null;
    private $width = null;	
    private $align = null;
    
    private $link = null;               # array de objetos link correspondente a coluna em que ele aparece
    private $linkCondicional = null;    # array com o valor que a coluna deve ter para ter o link
    private $imagemCondicional = null;    # array com a imagem condicional
    private $linkImage = null;
    private $linkTitle = null;
    private $linkCondicionalOperador = '='; # operador da compara��o. pode ser (=,<>, < ou >)
    
    private $formatacaoCondicional = null;  # Array com uma formata��o condicional de cores
    private $numeroOrdem = false;           # Exibe (qualdo true) uma numera��o das colunas
    private $numeroOrdemTipo = 'c';         # Informa que a ordena��o ser� 'c' crescente ou 'd' decrescente

    private $function = null;
 
    # da Classe
    private $classe = null;             # array de classes
    private $metodo = null;             # array de metodo das classes
    
    # das rotinas de exclusão
    private $excluirCondicional = null;	
    private $excluirCondicao = null;		
    private $excluirColuna = null;		

    # das rotinas de edição
    private $editarCondicional = null;	
    private $editarCondicao = null;		
    private $editarColuna = null;		

    # do título das colunas de link padrão
    private $nomeColunaExcluir = null;
    private $nomeColunaEditar = null;

    # dos botões das colunas de editar e excluir
    private $editarBotao = null;
    private $excluirBotao = null;

    # Parâmetros da paginação da listagem
    private $paginacao = false;			# Flag que indica se ter� ou n�o pagina��o na lista
    private $paginacaoItens = 5;		# Quantidade de registros por p�gina
    private $paginacaoInicial = 0;		# 
    private $pagina = 1;			# Página atual
    
    # Valores antes da atualização
    private $oldValue = null;

    # Classe do banco de dados
    private $classBd = null;

    # Nome da tabela
    private $tabela = null;	

    # Nome (e id) do Formulário para o css e jscript
    private $nomeForm = 'formPadrao';

    # Insere objeto (Imagem) para o form
    private $objetoForm = null;

    # Nome do campo id
    private $idCampo = null;	

    # Tipo de label do formulário
    private $formLabelTipo = 1;

    # Campos para o formulario
    private $campos = null;

    # Parâmetros pra a rotina de Log
    private $matricula = null;		    # matrícula do usuário logado
    private $listaLog = 'listaLog.php';     # rotina externa para onde o botão levará
    private $log = true;		    # Se grava ou não o log
    private $logDescricao = true;           # Define se no log grava a atividade (descrição do que foi gravado)	

    # Botões extra
    private $botaoListar;      # Array de objetos button para fazer um menu na rotina de listar
    
    # Rotinas Extras - > rotina extra que aparecerá nas rotinas de listar e editar
    private $rotinaExtra = null;
    private $rotinaExtraParametro = null;
    
    # Rotinas Extras Editar - > rotina extra que aparecerá na rotina de editar
    private $rotinaExtraEditar = null;
    private $rotinaExtraEditarParametro = null;
    
    # Rotinas Extras Listar - > rotina extra que aparecerá na rotina de Lista
    private $rotinaExtraListar = null;
    private $rotinaExtraListarParametro = null;
    
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
     * método add_botaoListar
     * inclui um objeto (button ou link) na rotina listar (ao lado do botao voltar)
     * 
     * @param  $button    = objeto button
     */
    public function add_botaoListar($button)
    {
       $this->botaoListar[] = $button; 
    }
    
    ###########################################################

    /**
    * método lista
    * Exibe os registros em uma tabela
    * 
    */
    public function listar()
    {
        set_session('oldValue'.$this->tabela);

        # Limita o tamanho da tela
        $grid = new Grid();
        $grid->abreColuna(12);
        
        # Preenche a url do botão incluir se for nula ...
        if (is_null($this->linkIncluir))
            $this->linkIncluir = $this->linkEditar;
        
        # Conecta com o banco de dados
        $objeto = new $this->classBd();

        # Cria um menu
        $menu = new MenuBar();
        
        # Botão voltar
        $linkBotaoVoltar = new Button("Voltar",$this->voltarLista);
        $linkBotaoVoltar->set_title('Volta para a página anterior');
        $linkBotaoVoltar->set_accessKey('V');
        $menu->add_link($linkBotaoVoltar,"left");
        
        # Inclui botões extras
        if ($this->botaoListar){
            foreach ($this->botaoListar as $botao){
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
        
        # Calculos da paginaçao
        $texto = null;
        if($this->paginacao)
        {
            # Pega a quantidade de registros antes da paginação
            $result = $objeto->select($this->selectLista);
            $totalRegistros = count($result);

            # Calcula o total de páginas
            $totalPaginas = ceil($totalRegistros/$this->paginacaoItens);

            # Calcula o número da página
            $this->pagina = ceil($this->paginacaoInicial/$this->paginacaoItens)+1;

            # Calcula o item inicial e final da página
            $itemFinal = $this->pagina * $this->paginacaoItens;
            $itemInicial = $itemFinal - $this->paginacaoItens+1;

            if ($itemFinal > $totalRegistros)
            $itemFinal = $totalRegistros;

            # Texto do fieldset
            $texto = 'Página: '.$this->pagina.' de '.$totalPaginas;
        
            # Acrescenta a sql
            $this->selectLista.=' LIMIT '.$this->paginacaoInicial.','.$this->paginacaoItens;

            # Botôes de Navegação das páginas 
            $proximo = $this->paginacaoInicial + $this->paginacaoItens;
            $anterior = $this->paginacaoInicial - $this->paginacaoItens;

            # Acrescenta o parâmetro (se houver)
            if(!is_null($this->parametroValue))
            {
                $proximo .= '&parametro='.$this->parametroValue;
                $anterior .= '&parametro='.$this->parametroValue;					
            }

            # Acrescenta a ordenação (se houver)
            if(!is_null($this->orderCampo))
            {
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
                echo '<li class="pagination-previous disabled">Anterior<span class="show-for-sr">page</span></li>';
            }else{
                echo '<li class="pagination-previous"><a href="?paginacao='.$anterior.'" aria-label="Página anterior">Anterior</a></li>';
            }

            # Links para a página
            for($pag = 1;$pag <= $totalPaginas; $pag++){
                if($pag == $this->pagina){
                    echo '<li class="current"><span class="show-for-sr">Página Atual</span> '.$pag.'</li>';
                }else{
                    $link = $this->paginacaoItens * ($pag-1);
                    echo '<li><a href="?paginacao='.$link.'" aria-label="Pagina '.$pag.'">'.$pag.'</a></li>';
                }
            }

            # Botão Próxima Página
            if($this->pagina < $totalPaginas){
                echo '<li class="pagination-next"><a href="?paginacao='.$proximo.'" aria-label="Próxima página">Próximo <span class="show-for-sr">page</span></a></li>';
            }else{
                echo '<li class="pagination-next disabled">Próximo <span class="show-for-sr">page</span></li>';
            }
            echo '</ul>';
            $div->fecha();
        }       
        
        # Topbar        
        $top = new TopBar($this->nome);
        $top->set_title($this->nome);
        
        # Coloca o campo de pesquisa (se tiver)
        if(!is_null($this->parametroLabel)){
            $top->add_pesquisa($this->parametroLabel, $this->parametroValue);
        }       
        
        $top->show();
            
        # Pega a quantidade de registros
        $result = $objeto->select($this->selectLista);
        #echo $this->selectLista;

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
            $tabela->set_label($this->label);
            $tabela->set_align($this->align);
            $tabela->set_width($this->width);
            $tabela->set_link($this->link);
            $tabela->set_linkCondicional($this->linkCondicional);
            $tabela->set_linkCondicionalOperador($this->linkCondicionalOperador);
            $tabela->set_funcao($this->function);
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
            if ($this->botaoEditar)
                $tabela->set_editar($this->linkEditar);

            # coloca no rodapé a paginação (quando houver)
            if ($this->paginacao)
                $tabela->set_footTexto($texto.' ('.$itemInicial.' a '.$itemFinal.' de '.$totalRegistros.' Registros)');

            # coloca o botão de editar (quando houver)
            if (!is_null($this->editarBotao))
                $tabela->set_editarBotao($this->editarBotao);

            # coloca o botão de excluir (quando houver)
            if (!is_null($this->excluirBotao))
                $tabela->set_excluirBotao($this->excluirBotao);

            $tabela->set_excluir($this->linkExcluir);
            $tabela->set_idCampo($this->idCampo);
            $tabela->set_order($this->orderCampo,$this->orderTipo,$this->orderChamador);

            $tabela->set_excluirCondicional($this->excluirCondicional,$this->excluirCondicao,$this->excluirColuna);

            $tabela->set_editarCondicional($this->editarCondicional,$this->editarCondicao,$this->editarColuna);

            if (!is_null($this->nomeColunaEditar))
                $tabela->set_nomeColunaEditar($this->nomeColunaEditar);

            #$tabela->link_image = $this->link_image;
            #$tabela->link_title = $this->link_title;

            # informa para tabela se tem parametro para ser ressaltado na tabela
            if(!is_null($this->parametroValue) or ($this->parametroValue == ""))
                $tabela->set_textoRessaltado($this->parametroValue);

            $tabela->show();
            
            $grid->fechaColuna();
            $grid->fechaGrid();
        }       
    }

    ###########################################################

    /**
    * método editar (e incluir)
    * 
    * @param $id integer id se for para update null se for para insert 
    */

    public function editar($id = null)
    {
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

        # Botão histórico
        if ($this->matricula == GOD){
            if ((!is_null($id)) AND ($this->botaoHistorico)){
                $linkBotaoHistorico = new Button("Histórico");
                $linkBotaoHistorico->set_title('Exibe o histórico');
                $linkBotaoHistorico->set_onClick("abreFechaDivId('divHistorico');");
                $linkBotaoHistorico->set_accessKey('H');
                $menu->add_link($linkBotaoHistorico,"right");
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
        $top = new TopBar($this->nome);
        $top->set_title($this->nome);
        $top->show(); 

       # exibe (ocultamente) o histórico
       if ((!is_null($id)) AND ($this->botaoHistorico))
            $this->exibeHistorico($id);        
        
        
        if(($id <> null)and($this->selectEdita <> null))
        {	
            # Conecta com o banco de dados
            $objeto = new $this->classBd();

            # Nas classes genéricas inclui o nome da tabela
            if(!is_null($this->tabela))
                $objeto->set_tabela($this->tabela,$this->idCampo);
            
            # faz o select	
            $row = $objeto->select($this->selectEdita,false);
        }  

        $form = new Form($this->linkGravar.'&id='.$id,$this->nomeForm);
        $form->set_id('form'.$this->id);
        
        if($this->objetoForm)
            $form->set_objeto($this->objetoForm);

        
        # Rotina que faz o calculo do tamanho das colunas
        # para adaptar a grid do frame Foundation
        $linhaAtual = 0;            // zera a flag da linha atual
        $somatorioSize = 0;         // somatorio temporário de uma determinada linha
        $somaPorLinha[] = null;     // Array com o somatório por linha
        foreach ($this->campos as $campo)
        {
            # pega o tamanho de um controle (input)
            if($campo['tipo'] == 'textarea')
                $sizeFormulario = $campo['size'][0];
            else
                $sizeFormulario = $campo['size'];  // se for text area tira do array


            # Se a linha não mudou ou se for a primeira linha
            if(($linhaAtual == $campo['linha']) OR ($linhaAtual == 0))
                $somatorioSize += $sizeFormulario;   // acrescenta
            else
                $somatorioSize = $sizeFormulario;    // iniciar o somatório

            $somaPorLinha[$campo['linha']] = $somatorioSize; // atualiza a soma por linha
        }

        $contador = 1;	// Contador para a tabulação do formulário

        foreach ($this->campos as $campo)
        {
            $controle = new Input($campo['nome'],$campo['tipo'],$campo['label'],$this->formLabelTipo); 
            $controle->set_linha($campo['linha']);      // linha no form que vai ser colocado o controle
            $controle->set_tabindex($contador);		// tabulador (ordem de navega��o com a tecla tab)
            
            if (isset($campo['size']))
                $controle->set_size($campo['size']);                    // tamanho do campos
            if (isset($campo['maxLength']))				// quantidade máxima de caracteres
                $controle->set_size($campo['size'],$campo['maxLength']);
            if (isset($campo['required']))
                $controle->set_required($campo['required']);		 // faz o controle exibir o *
            if (isset($campo['tagHtml']))
                $controle->set_tagHtml($campo['tagHtml']);		 // faz o controle exibir o html
            if (isset($campo['array']))
                $controle->set_array($campo['array']);			 // conteudo de uma combo
            if (isset($campo['readOnly']))
                $controle->set_readonly($campo['readOnly']);	         // readonly
            if (isset($campo['disabled']))
                $controle->set_disabled($campo['disabled']);
            if (isset($campo['autofocus']))
                $controle->set_autofocus($campo['autofocus']);          // disabled
            if (isset($campo['placeholder']))
                $controle->set_placeholder($campo['placeholder']);	// placeholder (dica dentro do controle)
            if (isset($campo['title']))
                $controle->set_title($campo['title']);		        // title - dica do campo
            else
                $controle->set_title($campo['label']);
            if (isset($campo['onChange']))
                $controle->set_onChange($campo['onChange']);	        // onChange	
            if (isset($campo['fieldset']))
                $controle->set_fieldset($campo['fieldset']);            // fieldse interno
            if (isset($campo['col']))
                $controle->set_col($campo['col']);                       // Tamanho da coluna
            else
                $controle->set_col($this->CalculaTamanhoColuna($somaPorLinha[$campo['linha']], $sizeFormulario)); # Chama a rotina que transforma o tamanho das coluna para o formato do grid do Foundation

            # pega o tamanho de um controle (input)
            if($campo['tipo'] == 'textarea')
                $sizeFormulario = $campo['size'][0];
            else
                $sizeFormulario = $campo['size'];  // se for text area tira do array

            

            # Inlcui o valor se for para editar (id <> null)
            if(($id <> null)and($this->selectEdita <> null))
            {
                # se tiver criptografia, descriptograva para exibi��o
                if((isset($campo['encode'])) AND ($campo['encode']))
                    $row[$campo['nome']] = base64_decode($row[$campo['nome']]);                
                
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
                    if((isset($campo['tagHtml'])) AND ($campo['tagHtml'] == true))
                    {
                        $valorCampo = $row[$campo['nome']];
                        $valorControle = htmlentities($valorCampo);
                        $controle->set_valor($valorControle);
                    }                        
                    else                                   
                        $controle->set_valor($row[$campo['nome']]);

                    $oldValue[] = $row[$campo['nome']];
                }
            }
            elseif (isset($campo['padrao']))
                $controle->set_valor($campo['padrao']);

            $form->add_item($controle);
            $contador++;	// incrementa o contador
        }

        # Passa por session os valores antigos
        if(($id <> null)and($this->selectEdita <> null))
        set_session('oldValue'.$this->tabela,$oldValue);
        
        if($this->botaoSalvarGrafico)
        {
            # Botão salvar
            $botao = new BotaoGrafico($this->botaoSalvarId);
            $botao->set_label($this->botaoSalvarLabel);
            $botao->set_title($this->botaoSalvarLabel);
            $botao->set_image(PASTA_FIGURAS.$this->botaoSalvarImagem,35,35);
            $botao->set_tipo('submit');
            $botao->set_formName('form'.$this->id);            
            $botao->set_tabindex($contador+1);
            $botao->set_accessKey('S');
            $botao->show();
        }
        else
        {
            # submit
            $controle = new Input('submit','submit');
            $controle->set_valor(' Salvar ');
            $controle->set_size(20);
            $controle->set_tabindex($contador+1);
            $controle->set_accessKey('S');
            $controle->set_fieldset('fecha');
            $form->add_item($controle);
        }
        
        # Exibe o form 
        echo '<div class="callout secondary">';
            $form->show();
            p("Campos marcados com * são obrigatórios","right","size-12");
        echo '</div>';
        
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
    
    public function gravar($id = null,$validacaoExtra = null)
    {	
        # Variáveis sobre um erro fatal (que não pode prosseguir com ele)
        $erro = 0;		    // flag de erro: 1 - tem erro; 0 - não tem	
        $msgErro = null; 	// repositório de mensagens de erro

        $contador = 0;		// contador para os arrays $campo_nome e $campo_valor
        $alteracoes = null;	// informa as alteraçõs dos valores antigos com os novos
        $atividade = null;	// Variavel que informa ao log o que foi feito

        # Instancia um objeto de validação
        $valida = new Valida();

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
            if ((isset($campo['tagHtml'])) and ($campo['tagHtml']))
                $campoValor[$contador] = strip_tags($campoValor[$contador],TAGS);
            else
                $campoValor[$contador] = strip_tags($campoValor[$contador]);

            # Compara o valor antigo com o novo
            if($oldValue[$contador] <> $campoValor[$contador])
            {
                # verifica se � html5 para formatar a data
                if(HTML5)
                {
                    # verifica se é data
                    if (($campo['tipo'] == 'date')or($campo['tipo'] == 'data'))
                        $alteracoes.='['.$campo['label'].'] '.$oldValue[$contador].'->'.date_to_php($campoValor[$contador]).'; ';
                    else
                        $alteracoes.='['.$campo['label'].'] '.$oldValue[$contador].'->'.$campoValor[$contador].'; ';                    
                }
                else
                    $alteracoes.='['.$campo['label'].'] '.$oldValue[$contador].'->'.$campoValor[$contador].'; ';                
            }
            
            # passa para nulo os campos vazios
            if ($campoValor[$contador] == "")
             $campoValor[$contador] = null;

            # verifica not null
            if ((isset($campo['required'])) and ($campo['required']))
            {
                if ($valida->vazio($campoValor[$contador]))
                {
                    $msgErro.='O campo '.$campo['label'].' é obrigatório!<br />';
                    $erro = 1;
                }
            }

            # verifica se é 'unique' -> único valor no campo nessa tabela
            if ((isset($campo['unique'])) and ($campo['unique']))
            {
                # Pega duplicados
                $duplicidade = new $this->classBd();
                if ((isset($id)) and ($id <> null))
                    $result = $duplicidade->select("SELECT $this->idCampo FROM $this->tabela WHERE $campoNome[$contador] = '$campoValor[$contador]' AND $this->idCampo <> $id");
                else
                    $result = $duplicidade->select("SELECT $this->idCampo FROM $this->tabela WHERE $campoNome[$contador] = '$campoValor[$contador]'"); // quando insert

                $duplicatas = count($result);

                if ($duplicatas > 0)
                {
                    $erro = 1;
                    $msgErro .= 'Já existe um registro com esse valor de '.$campo['label'].'!<br />';
                }
            }

            # verifica a validade do cpf
            if ($campo['tipo'] == 'cpf')
            {
                if(!is_null($campoValor[$contador]))
                {
                    if (!$valida->cpf(soNumeros($campoValor[$contador])))
                    {		
                        $msgErro.='CPF Inválido!<br />';
                        $erro = 1;
                    }
                }
            }

            # validação dos campos tipo checkbox
            if ($campo['tipo'] == 'checkbox')
            {
                if(isset($campoValor[$contador]))
                $campoValor[$contador] = 1;
            }

            # validação dos campos tipo data
            if ((($campo['tipo'] == 'date')or($campo['tipo'] == 'data'))and(!(is_null($campoValor[$contador]))))
            { 
                # formata data quando vier de um controle html5 (vem yyyy/mm/dd)
                if(HTML5)
                    $campoValor[$contador] = date_to_php($campoValor[$contador]);
                
                # verifica a validade da data
                if (!validaData($campoValor[$contador]))
                {
                    $msgErro.='A '.$campo['label'].' não é válida!<br />';
                    $erro = 1;
                }
                else
                    $campoValor[$contador] = date_to_bd($campoValor[$contador]);	# passa a data para o formato de grava��o
            }
            
            # Passa o campo moeda para o formato americano (para o banco de dados)
            if (($campo['tipo'] == 'moeda')and(!(is_null($campoValor[$contador]))))
            {
                $campoValor[$contador] = formataMoeda($campoValor[$contador],2);	
            }
       
            # se tiver criptografia, descriptograva para exibição
            if((isset($campo['encode'])) AND ($campo['encode']))
                $campoValor[$contador] = base64_encode($campoValor[$contador]);
            
            /*	
            # criptografa quando for password
            if ($campo['tipo'] == 'password')
            $campo_valor[] = post($campo['nome']);
            */

            $contador++;
        }
        
         if(!is_null($validacaoExtra))
            include_once $validacaoExtra;
        
        # Verifica se teve alterações em um editar       
        if (is_null($alteracoes))
        {
            $msgErro.='Você não alterou nada! Vai gravar o que ?!<br />';
            $erro = 1;
        }

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
            # passa a $alteracao para null caso lodDescricao 
            # peça isso
            if(!$this->logDescricao)
                $alteracoes = null;

            # Grava no log a atividade
            if($this->log)
            {
                $Objetolog = new Intra();
                $data = date("Y-m-d H:i:s");

                # preenche atividade de inclusão
                if (is_null($id) or ($id == ""))
                {
                    $atividade = 'Incluiu: '.$alteracoes;
                    $id = $objeto->get_lastId();

                    # Pega os dados caso seja tbpermissao
                    if($this->tabela == 'tbpermissao')
                    {
                        $intra = new Intra();
                        $pessoal = new Pessoal();
                        $permissao = $intra->get_permissao($id);
                        $atividade = 'Incluiu a permissão de: '.$permissao[1].' para a matrícula '.$permissao[0].' ('.$pessoal->get_nome($permissao[0]).')';
                    }					
                }
                else
                    $atividade .= 'Alterou: '.$alteracoes;

                # Verifica o tipo de log
                $tipoLog = 0;
                if(($this->classBd == 'Pessoal') OR ($this->classBd == 'pessoal'))
                    $tipoLog = 3;
                
                # grava se tiver atividades para serem gravadas
                if (!is_null($atividade))
                    $Objetolog->registraLog($this->matricula,$data,$atividade,$this->tabela,$id,$tipoLog);
            }

            mensagemAguarde();

            loadPage($this->linkListar);
            return true;
        }
        else
        {
            br(2);
            # Limita o tamanho da tela
            $grid = new Grid();
            $grid->abreColuna(3);
            
            $grid->fechaColuna();
            $grid->abreColuna(6);
            
            # painel usando o callout
            $painel2 = new Callout();
            $painel2->set_botaoOk(NULL,"history.go(-1)");
            $painel2->abre();
                p($msgErro);
            $painel2->fecha();
            
            $grid->fechaColuna();
            $grid->abreColuna(3);
            
            $grid->fechaColuna();
            $grid->fechaGrid();
            
            # método antigo com jscript
            #alert($msgErro);
            #back(1);
            
            return false;
        }		   	
    }

    ###########################################################

    /**
    * método excluir
    * M�todo de exclus�o de registro
    * 
    * @param $id	integer	- id da not�cia
    */
    
    public function excluir($id)
    {	
        # Pega os dados caso seja tbpermissao
        if($this->tabela == 'tbpermissao')
        {
            $intra = new Intra();
            $pessoal = new Pessoal();
            $permissao = $intra->get_permissao($id);
            $atividade = 'Exclui a permissao de: '.$permissao[1].' da matrícula '.$permissao[0].' ('.$pessoal->get_nome($permissao[0]).')';
        }
        elseif($this->tabela == 'tbmovimento')
        {
            $intra = new Intra();
            $movimento = $intra->get_movimento($id);
            $atividade = 'Excluiu o movimento '.$id.' da OS '.$movimento[1].' escrito pelo Técnico/Solicitante '.$movimento[0].' em '.datetime_to_php($movimento[2]);
        }
        else
        {
            $atividade = 'Excluiu';
        }

        # Conecta com o banco de dados
        $objeto = new $this->classBd();
        $objeto->set_tabela($this->tabela);		# a tabela
        $objeto->set_idCampo($this->idCampo);	# o nome do campo id
        if($objeto->excluir($id));
        {		
            if($this->log)
            {
                $Objetolog = new Intra();
                $data = date("Y-m-d H:i:s");
                $Objetolog->registraLog($this->matricula,$data,$atividade,$this->tabela,$id);	
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
    
    public function add_objeto($imagem)
    {
        $this->objetoForm[] = $imagem; 
    }

    ###########################################################

    /**
    * método exibeHistorico
    * Exibe uma lista do histórico
    * 
    * @param  $id o id para se exibir o histórico
    */
    
    public function exibeHistorico($id = null)
    {
        echo '<div class="callout" id="divHistorico">';

        $select = 'SELECT tblog.data,
                          tblog.matricula,
                          tbpessoa.nome,
                          tblog.atividade,
                          tblog.idValor
                     FROM intra.tblog 
                LEFT JOIN pessoal.tbfuncionario ON intra.tblog.matricula = pessoal.tbfuncionario.matricula
                LEFT JOIN pessoal.tbpessoa ON pessoal.tbfuncionario.idpessoa = pessoal.tbpessoa.idpessoa 
                    WHERE tblog.tabela="'.$this->tabela.'"
                      AND tblog.idValor='.$id.' 
                 ORDER BY tblog.data desc';
                 
        # Conecta com o banco de dados
        $intra = new Intra();
        $result = $intra->select($select);
        $contadorHistorico = $intra->count($select); 

        # Parametros da tabela
        $label = array("Data","Matrícula","Nome","Atividade","id");
        $align = array("center","center","center","left");
        $width = array(13,10,22,50,5);
        $funcao = array ("datetime_to_php","dv");

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