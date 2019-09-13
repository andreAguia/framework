  <?php

class Tabela
{
   /**
    * Classe para criação de tabelas
    * 
    * @author André Águia (Alat) - alataguia@gmail.com
    * 
    * @note Quando existe o rodapé o total de registros não é exibido
    * 
    * @var private $class string NULL A classe para o css
    * @var private $id    string NULL O id para o css
    * 
    * @var private $titulo        string NULL   Título que aparecerá no alto da tabela 
    * @var private $conteudo      array  NULL   Array com o conteúdo da tabela principal
    * @var private $label         array  NULL   Array com o cabeçalho de cada coluna
    * @var private $align         array  center Array com o alinhamento de cada coluna: center | left | right
    * @var private $width         array  NULL   Array com o tamanho de cada coluna em %
    * @var private $rodape        string NULL   Exibe uma string no rodapé. O rodapé substituirá o total de regsitros.    
    * @var private $totalRegistro bool   TRUE   Informa se terá ou não total de registros
    * 
    * @var private $numeroOrdem     bool   FALSE  Exibe/Não exibe uma coluna com numeração de ordem das colunas
    * @var private $numeroOrdemTipo bool   'c'    Informa que a ordenação será 'c' crescente ou 'd' decrescente
    * 
    * @var private $link                    array NULL Array de objetos link correspondente a coluna em que ele aparece
    * @var private $linkCondicional         array NULL array com o valor que a coluna deve ter para ter o link
    * @var private $linkCondicionalOperador bool   'c'    operador da comparação. pode ser (=,<>, < ou >)
    * 
    * @var private $classe array NULL Array de classes.
    * @var private $metodo array NULL Array de métodos da classe.
    * @var private $funcao array NULL Array de funções.
    * 
    * @var private $formatacaoCondicional array NULL Exibe a tr com cor diferente dependendo de algum valor
    * @var private $imagemCondicional     array NULL Exibe um objeto imagem ao invés do valor dependendo de algum valor.
    * 
    * @var private $excluir  array NULL Exibe a tr com cor diferente dependendo de algum valor
    * @var private $imagemCondicional     array NULL Exibe um objeto imagem ao invés do valor dependendo de algum valor.
    * 
    * @var private $rowspan array NULL Informa com TRUE ou FALSE qual coluna terá rolspan
    * 
    * @example exemplo.tabela.php
    */  

    # do css    
    private $class;
    private $id = NULL;
    
    # da tabela
    private $titulo = NULL;
    private $conteudo;
    private $label = NULL;
    private $align = NULL;
    private $width = NULL;
    private $rodape = NULL;
    private $totalRegistro = TRUE;
    
    # do número de ordem
    private $numeroOrdem = FALSE;
    private $numeroOrdemTipo = 'c';
    
    # do link
    private $link = NULL;
    private $linkCondicional = NULL;
    private $linkCondicionalOperador = '=';
    
    # das Classes e Funções
    private $funcao = NULL;
    private $classe = NULL;
    private $metodo = NULL;
    private $funcaoDepoisClasse = NULL;    
    
    # condicional
    private $formatacaoCondicional = NULL;
    private $imagemCondicional = NULL;
    
    # das rotinas de exclusão
    private $excluir = NULL;
    private $nomeColunaExcluir = 'Excluir';	    # Nome da Coluna
    private $excluirCondicional = NULL;
    private $excluirCondicao = NULL;
    private $excluirColuna = NULL;
    private $excluirOperador = "==";
    private $excluirBotao = 'lixo.png';	# Figura do botão

    # das rotinas de edição
    private $editar = NULL;
    private $nomeColunaEditar = 'Editar';	# Nome da Coluna
    private $editarCondicional = NULL;
    private $editarCondicao = NULL;
    private $editarColuna = NULL;
    private $editarOperador = "==";
    private $editarBotao = 'bullet_edit.png';	# Figura do botao
    
    # do form de check
    private $check = FALSE;
    private $checkSubmit = NULL;

    # da ordenação
    private $orderCampo = NULL;
    private $orderTipo = NULL;
    private $orderChamador;
    
    # do link no título
    private $linkTitulo = NULL;
    private $linkTituloImagem = PASTA_FIGURAS_GERAIS.'plus.png';
    private $linkTituloImagemWidth = 15;
    private $linkTituloImagemHeight = 15; 
    private $linkTituloTitle = NULL;
    
    # do somatório
    private $colunaSomatorio = NULL;            // coluna que terá somatório (por enquanto uma por relatório)
    private $textoSomatorio = 'Total:';         // texto a ser exibido na linha de totalização
    private $colunaTexto = 0;                   // coluna onde o texto será exibido;
    private $funcaoSomatorio = NULL;            // se executa alguma função no somatório
    private $exibeSomatorioGeral = TRUE;        // se exibe o somatório geral ou somente o parcial
     
    # outros
    private $textoRessaltado = NULL;	# string que será ressaltada no resultado da tabela (usado para resaltar pesquisas)
    private $idCampo = NULL;
    private $nomeGetId = "id";          # Nome do get do id. 
    private $scroll = TRUE;             # Habilita ou não o scrool horizontal da tabela
    private $rowspan = NULL;            # Coluna onde o código fará automaticamente rowspan de valores iguais (colocar na ordenação esta coluna)
    private $grupoCorColuna = NULL;     # Indica se haverá colorização de um grupo por valores diferentes. Usado para diferenciar um grupo de linhas de outro grupo.
    
    ###########################################################

    /**
     * método construtor
     *  
     * @param 	$nome	string	-> nome da classe da tabela para o css
     */
    public function __construct($id = NULL,$class = 'tabelaPadrao table-scroll'){
        $this->id = $id;
        $this->class = $class;
    }

    ###########################################################

    /**
     * Métodos get e set construídos de forma automática pelo 
     * metodo mágico __call.
     * Esse método cria um set e um get para todas as propriedades da classe.
     * Se o método não estiver previsto no __call o php procura pela existência
     * do método na classe.
     * 
     * O formato dos métodos devem ser:
     * 	set_propriedade
     * 	get_propriedade
     * 
     * @param 	$metodo		O nome do metodo
     * @param 	$parametros	Os parâmetros inseridos  
     */
    public function __call ($metodo, $parametros){
        ## Se for set, atribui um valor para a propriedade
        if (substr($metodo, 0, 3) == 'set')
        {
          $var = substr($metodo, 4);
          $this->$var = $parametros[0];
        }

        # Se for Get, retorna o valor da propriedade
        #if (substr($metodo, 0, 3) == 'get')
        #{
        #  $var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
        #  return $this->$var;
        #}
    }
    
    ###########################################################

    /**
     * Método set_cabecalho
     * 
     * @param 	$label	array	-> array com o título de cada coluna
     * @param 	$width	array	-> array com o tamanho de cada coluna em %
     * @param 	$align	array	-> array com o alinhamento da coluna pode ser center, left, right ou justify
     */
    public function set_cabecalho($label = NULL,$width = NULL,$align = NULL){
        $this->label = $label;
        $this->width = $width;
        $this->align = $align;
    }

    ###########################################################

    /**
     * Método set_excluirCondicional
     * 
     * Define uma condição para exibir ou n�o a op��o de exclus�o
     * Usado na rotina de f�rias para colocar a op��o de exclus�o 
     * somente nas f�rias com status de solicitada.
     * 
     * @param 	$excluirCondicional string -> url para a rotina de exclus�o
     * @param 	$excluirCondicao	 string -> valor que exibe o bot�o de exclus�o
     * @param 	$excluirColuna		 integer -> n�mero da coluna cujo valor ser� comparado
     */
    public function set_excluirCondicional($excluirCondicional,$excluirCondicao,$excluirColuna,$excluirOperador) {
        $this->excluirCondicional = $excluirCondicional;
        $this->excluirCondicao = $excluirCondicao;
        $this->excluirColuna = $excluirColuna;
        $this->excluirOperador = $excluirOperador;
    }

    ###########################################################

    /**
     * Método set_editarCondicional
     * 
     * Define uma condição para exibir ou n�o a op��o de edi��o
     * Usado na rotina de servi�o para exibir a edi��o aos usu�rios 
     * comuns somente das OS desse mesmo usu�rio.
     * 
     * @param 	$editarCondicional string -> url para a rotina de editar
     * @param 	$editarCondicao	 string -> valor que exibe o bot�o de editar
     * @param 	$editarColuna		 integer -> n�mero da coluna cujo valor ser� comparado
     */
    public function set_editarCondicional($editarCondicional,$editarCondicao,$editarColuna,$editarOperador){
        $this->editarCondicional = $editarCondicional;
        $this->editarCondicao = $editarCondicao;
        $this->editarColuna = $editarColuna;
        $this->editarOperador = $editarOperador;
    }
    
    ###########################################################

    /**
     * Método set_order
     * 
     * Define a ordem da tabela
     * 
     * @param 	$orderCampo 	integer -> coluna da tabela onde ser� ordenado 
     * @param 	$orderTipo		string -> pode ser 'asc' ou 'desc'. informa o tipo de ordena��o
     * @param 	$orderChamador	string -> 
     */
    public function set_order($orderCampo,$orderTipo,$orderChamador){
        $this->orderCampo = $orderCampo;
        $this->orderTipo = $orderTipo;
        $this->orderChamador = $orderChamador;
    }

    ###########################################################
    
     /**
      * Método exibeSomatorio
      * 
      * Exibe o somatório de uma coluna no fim do relatório ou de um agrupamento
      */
    
    private function exibeSomatorio($tamanho,$somatorio){  
        # Exibe uma linha
        $this->exibeLinha($tamanho);
        
        # Inicia a linha
        echo '<tr id="somatorio">';
                        
        # Percorre as colunas da tabela para chegar a coluna do somatório
        for($i = 0; $i<$tamanho; $i++){
            
            # Verifica se é a coluna onde terá o texto padrão a primeira coluna
            if($i == $this->colunaTexto){
                echo '<td id="textoSomatorio">'.$this->textoSomatorio.'</td>';
            } 
            
            if(is_array($this->colunaSomatorio)){
                # Em desenvolvimento
                # Quando pronto possibilitará somatório 
                # em mais de uma coluna
            }else{
                # Se for a coluna do somatório exibe o somatório
                if($i == $this->colunaSomatorio){                
                    # Se tiver função no somatório executa
                    if(is_null($this->funcaoSomatorio)){
                        echo '<td>'.$somatorio.'</td>';                
                    } # Senão exibe o somatório
                    else{
                        $nomedafuncao = $this->funcaoSomatorio;
                        $subSomatorio = $nomedafuncao($somatorio);
                        echo '<td>'.$somatorio.'</td>';
                    }
                }
            }
            
            # Senão exibe coluna em branco
            if(($i <> $this->colunaTexto) AND ($i <> $this->colunaSomatorio)){ 
                echo '<td></td>';
            }
        }

        # Fecha a linha
        echo '</tr>';
    }
    ###########################################################
    
    /**
     * Método show
     * 
     * Exibe a tabela
     */

    public function show(){
        $numRegistros = 0;                  // Contador de registros
        $numColunas = count($this->label);  // Calcula o número de colunas da tabela
        $numColunasOriginal = $numColunas;  // O número de colunas da tabela sem o edit, exclui, etc
        
        $numRegistrosTotais = count($this->conteudo);
        
        $colunaEdita = 999;
        $colunaExcluir = 999;
        $colunaExcluirCondicional = 999;
        $colunaEditarCondicional = 999;
        
        $valorGrupoCorColuna = NULL;
        $corGrupo = "grupo1";
        
        # usado no rowspan para se ocultar a td repetida
        $exibeTd = TRUE;
        
        # Somatório
        $somatorio = 0;         // somatorio de colunas se houver
        
        # rowspan
        if(!is_null($this->rowspan)){
            $arrayRowspan = NULL;
            $rowspanAnterior = NULL;
            $rowspanAtual = NULL;
            
            # Passa os valores para o array
            foreach ($this->conteudo as $itens){
                $arrayRowspan[] = $itens[$this->rowspan];
            }
            
            # Conta quantos valores tem e guarda no array $arr
            $arr = array_count_values($arrayRowspan);
        }

        # Quando existir rotina de editar
        # acrescenta colunas extras e calcula a posi��o na tabela
        if($this->editar <> NULL){
            $colunaEdita = $numColunas;
            $numColunas++;
            $this->label[$colunaEdita] = 'Rotina de edição de registro';
        }

        # Quando existir rotina de excluir
        # acrescenta colunas extras e calcula a posição na tabela
        if($this->excluir <> NULL){
            $colunaExcluir = $numColunas;
            $numColunas++;
            $this->label[$colunaExcluir] = 'Rotina de exclusão de registro';
        }
        
        # Editar condicional
        if($this->editarCondicional <> NULL){
            $colunaEditarCondicional = $numColunas;
            $numColunas++;  
            $this->label[$colunaEditarCondicional] = 'Rotina de Edição de registro';
        }

        # Excluir condicional
        if($this->excluirCondicional <> NULL){
            $colunaExcluirCondicional = $numColunas;
            $numColunas++;   
            $this->label[$colunaExcluirCondicional] = 'Rotina de exclusão de registro';
        }        
               
        # Início da Tabela
        if($this->scroll){
            echo '<div class="table-scroll">';
        }
        
        # Iniciando a tabela
        echo '<table class="'.$this->class.'"';        
        
        # id
        if(!is_null($this->id)){
            echo ' id="'.$this->id.'"';
        }
              
        echo '>';
        
        # Colunas
        if($this->numeroOrdem){
            echo '<col style="width:5%">';
        }

        for($a = 0;$a < $numColunas;$a += 1){
            if(isset($this->width[$a])){
                echo '<col style="width:'.$this->width[$a].'%">';
            }
        }

        # Cabeçalho
        echo '<thead>';
        
        # título
        if ($this->titulo){
            echo '<caption>';
            echo $this->titulo;
            
            # Verifica se tem link no título
            if(!is_null($this->linkTitulo)){
                echo " ";
                $link = new Link(" +",$this->linkTitulo);
                $link->set_title($this->linkTituloTitle);
                $link->set_imagem($this->linkTituloImagem,$this->linkTituloImagemWidth,$this->linkTituloImagemHeight);
                $link->show();
            }
            
            echo '</caption>';
        }

        # ordem ascendente ou descendente?
        if ($this->orderTipo == "asc") {
            $this->orderTipo = "desc";
        } else {
            $this->orderTipo = "asc";
        }

        # cabeçalho das colunas
        echo '<tr>';
                        
        # Reserva uma coluna para o número de ordem (se tiver)
        if($this->numeroOrdem){
            echo '<th title="Número de Ordem" id="numeroOrdem">#</th>';
        }

        for($a = 0;$a < $numColunas;$a += 1){        
            echo '<th title="'.$this->label[$a].'">';

            # colunas
            if(($this->editar <> NULL) and ($a == $colunaEdita)){			// coluna de editar
                echo $this->nomeColunaEditar.'</th>';
            }elseif(($this->excluir <> NULL) and ($a == $colunaExcluir)){	// coluna de excluir
                echo $this->nomeColunaExcluir.'</th>';
            }elseif(($this->excluirCondicional <> NULL) and ($a == $colunaExcluirCondicional)){	// coluna de excluir_condicional
                echo $this->nomeColunaExcluir.'</th>';
            }elseif(($this->editarCondicional <> NULL) and ($a == $colunaEditarCondicional)){	// coluna de excluir_condicional
                echo $this->nomeColunaEditar.'</th>';
            }elseif($this->orderCampo <> NULL){		// coloca um link no cabe�alho da coluna para ordenamento (quando tiver ordenamento)
                $link = new Link($this->label[$a],$this->orderChamador.'&orderCampo='.($a+1).'&orderTipo='.$this->orderTipo);
                $link->show();
            }else{
                echo $this->label[$a].'</th>';
            }
        } // for

        echo '</tr>';
        echo '</thead>';

        # Corpo da Tabela
        echo '<tbody>';
        
        # Coluna de ordem
        if($this->numeroOrdemTipo == 'c'){
            $numOrdem = 1;  # Inicia o número de ordem quando tiver
        }else{
            $numOrdem = $numRegistrosTotais;  # Inicia o número de ordem quando tiver
        }
        
        foreach ($this->conteudo as $row){
            echo '<tr ';  
            
            # Formatação condicional
            if (!is_null($this->formatacaoCondicional)){
                $rowCondicional = $row;
                for ($a = 0;$a < ($numColunasOriginal);$a ++){
                    foreach ($this->formatacaoCondicional as $condicional){
                        if($a == $condicional['coluna']){
                            # somente para nivel de comparação
                            # Coloca a função (se tiver)
                            if((isset($this->funcao[$a])) and ($this->funcao[$a] <> NULL)){
                                $nomedafuncao = $this->funcao[$a];
                                $rowCondicional[$a] = $nomedafuncao($row[$a]);
                            }
                            
                            # Coloca a classe (se tiver)
                            if((isset($this->classe[$a])) and ($this->classe[$a] <> NULL)){
                                $instancia = new $this->classe[$a]();
                                $metodoClasse = $this->metodo[$a];
                                $rowCondicional[$a] = $instancia->$metodoClasse($row[$a]);
                            }
                            #echo "->".$condicional['valor'];
                            switch ($condicional['operador']){
                                case '=':
                                case '==':
                                    if($rowCondicional[$a] == $condicional['valor']){
                                        echo ' id="'.$condicional['id'].'"';
                                    }
                                    break;

                                case '<>':	
                                    if($rowCondicional[$a] <> $condicional['valor']){
                                        echo ' id="'.$condicional['id'].'"';
                                    }
                                    break;

                                case '>':	
                                    if($rowCondicional[$a] > $condicional['valor']){
                                        echo ' id="'.$condicional['id'].'"';
                                    }
                                    break;

                                case '<':	
                                    if($rowCondicional[$a] < $condicional['valor']){
                                        echo ' id="'.$condicional['id'].'"';
                                    }
                                    break;

                                case '>=':	
                                    if($rowCondicional[$a] >= $condicional['valor']){
                                        echo ' id="'.$condicional['id'].'"';
                                    }
                                    break;

                                case '<=':	
                                    if($rowCondicional[$a] <= $condicional['valor']){
                                        echo ' id="'.$condicional['id'].'"';
                                    }
                                    break;
                            }
                            
                        }		
                    }
                }
            }
            
            # Cor de agrupamento
            if(!is_null($this->grupoCorColuna)){
                if($row[$this->grupoCorColuna] <> $valorGrupoCorColuna){
                    
                    $valorGrupoCorColuna = $row[$this->grupoCorColuna];
                    if($corGrupo == "grupo1"){
                        $corGrupo = "grupo2";
                    }else{
                        $corGrupo = "grupo1";
                    }                   
                }
                
                echo ' id="'.$corGrupo.'"';
            }
        
            echo '>';// tr
            
            if($this->numeroOrdem){
                echo '<td id="center">'.$numOrdem.'</td>';            
            }
            
            if($this->numeroOrdemTipo == 'c'){
                $numOrdem++;    # incrementa o número de ordem
            }else{
                $numOrdem--;    # decrementa o número de ordem
            }
            
            $numRegistros ++;

            # Pega o id do Banco de dados
            if(isset($this->idCampo)){
                $id = $row["$this->idCampo"]; 
            }

            # Percorre as colunas 
            for ($a = 0;$a < ($numColunas);$a ++){  
                
                $rowspanValor = NULL;
                $exibeTd = TRUE;
                
                # Verifica se tem Rowlspan
                if(!is_null($this->rowspan)){
                    
                    # Verifica se é essa coluna
                    if($this->rowspan == $a){
                        
                        $rowAtual = $row[$a];
                        
                        # Verifica se mudou o valor
                        if($rowspanAnterior <> $rowAtual){
                            $rowspanAnterior = $rowAtual;  // habilita o novo valor anterior

                            if($arr[$row[$a]] > 1){
                                $rowspanValor = $arr[$row[$a]];
                            }
                        }else{
                            if($arr[$row[$a]] > 1){
                                $exibeTd = FALSE;
                            }

                        }
                    }
                }
                
                if($exibeTd){
                    
                    echo '<td ';
                    
                    if(!is_null($rowspanValor)){
                        echo 'rowspan="'.$rowspanValor.'" ';
                    }
                                                        
                    # alinhamento
                    if((isset($this->align[$a])) and ($this->align[$a] <> NULL)){ 
                        echo 'id="'.$this->align[$a].'"';
                    }else{
                        echo 'id="center"';
                    }

                    echo '>';

                    # colunas
                    # Botão editar
                    if(($this->editar <> NULL) and ($a == $colunaEdita)){
                        $link = new Link(NULL,$this->editar.'&'.$this->nomeGetId.'='.$id,$this->nomeColunaEditar.': '.$row[0]);
                        $link->set_imagem(PASTA_FIGURAS_GERAIS.$this->editarBotao,20,20);
                        $link->show();     

                        #$botao = new BotaoGrafico();
                        #$botao->set_url($this->editar.'&'.$this->nomeGetId.'='.$id);
                        #$botao->set_imagem(PASTA_FIGURAS_GERAIS.$this->editarBotao,20,20);
                        #$botao->set_title($this->nomeColunaEditar.': '.$row[0]);
                        #$botao->show();                    
                    }
                    elseif(($this->excluir <> NULL) and ($a == $colunaExcluir))	// coluna de excluir
                    {
                        $link = new Link(NULL,$this->excluir.'&'.$this->nomeGetId.'='.$id,$this->nomeColunaExcluir.': '.$row[0]);
                        $link->set_imagem(PASTA_FIGURAS_GERAIS.$this->excluirBotao,20,20);
                        $link->set_confirma('Deseja mesmo excluir?');
                        $link->show(); 

                        #$botao = new BotaoGrafico();
                        #$botao->set_url($this->excluir.'&'.$this->nomeGetId.'='.$id);
                        #$botao->set_imagemm(PASTA_FIGURAS_GERAIS.$this->excluirBotao,20,20);
                        #$botao->set_title($this->nomeColunaExcluir.': '.$row[0]);
                        #$botao->set_confirma('Deseja mesmo excluir?');
                        #$botao->show();                    
                    }						
                    elseif(($this->editarCondicional <> NULL) and ($a == $colunaEditarCondicional))	// coluna de editar_condicional
                    {
                        # Se o operador for igual
                        if($this->editarOperador == "=="){                    
                            if($row[$this->editarColuna] == $this->editarCondicao){
                                $link = new Link('Editar',$this->editarCondicional.'&'.$this->nomeGetId.'='.$id);
                                $link->set_imagem(PASTA_FIGURAS_GERAIS.$this->editarBotao,20,20);
                                $link->set_title($this->nomeColunaEditar.': '.$row[0]);
                                $link->show();
                            }
                        }

                        # Se o operador for diferente
                        if(($this->editarOperador == "<>") OR ($this->editarOperador == "!=")){          
                            if($row[$this->editarColuna] <> $this->editarCondicao){
                                $link = new Link('Editar',$this->editarCondicional.'&'.$this->nomeGetId.'='.$id);
                                $link->set_imagem(PASTA_FIGURAS_GERAIS.$this->editarBotao,20,20);
                                $link->set_title($this->nomeColunaEditar.': '.$row[0]);
                                $link->show();
                            }
                        }

                    }
                    elseif(($this->excluirCondicional <> NULL) AND ($a == $colunaExcluirCondicional))	// coluna de excluir_condicional
                    {
                        # Se o operador for igual
                        if($this->excluirOperador == "=="){ 
                            if($row[$this->excluirColuna] == $this->excluirCondicao){
                                $link = new Link('Excluir',$this->excluirCondicional.'&'.$this->nomeGetId.'='.$id);
                                $link->set_imagem(PASTA_FIGURAS_GERAIS.$this->excluirBotao,20,20);
                                $link->set_title('Exclui: '.$row[0]);
                                $link->set_confirma('Deseja mesmo excluir?');
                                $link->show();
                            }
                        }

                        # Se o operador for diferente
                        if(($this->excluirOperador == "<>") OR ($this->excluirOperador == "!=")){ 
                            if($row[$this->excluirColuna] <> $this->excluirCondicao){
                                $link = new Link('Excluir',$this->excluirCondicional.'&'.$this->nomeGetId.'='.$id);
                                $link->set_imagem(PASTA_FIGURAS_GERAIS.$this->excluirBotao,20,20);
                                $link->set_title('Exclui: '.$row[0]);
                                $link->set_confirma('Deseja mesmo excluir?');
                                $link->show();
                            }
                        }
                    }

                    # Coloca a função (se tiver)
                    if((isset($this->funcao[$a])) and ($this->funcao[$a] <> NULL)){
                        $nomedafuncao = $this->funcao[$a];
                        $row[$a] = $nomedafuncao($row[$a]);
                    }

                    # Coloca a classe (se tiver)
                    if((isset($this->classe[$a])) and ($this->classe[$a] <> NULL)){
                        $instancia = new $this->classe[$a]();
                        $metodoClasse = $this->metodo[$a];
                        $row[$a] = $instancia->$metodoClasse($row[$a]);
                    }
                    
                    # Coloca a função (se tiver)
                    if((isset($this->funcaoDepoisClasse[$a])) and ($this->funcaoDepoisClasse[$a] <> NULL)){
                        $nomedafuncao = $this->funcaoDepoisClasse[$a];
                        $row[$a] = $nomedafuncao($row[$a]);
                    }

                    # Coloca o link (se tiver)
                    if((isset($this->linkCondicional[$a])) and ($this->linkCondicional[$a] <> NULL)){
                        if($this->linkCondicionalOperador == '='){
                            if($this->linkCondicional[$a] == $row[$a]){
                                if((isset($this->link[$a])) and ($this->link[$a] <> NULL)) 
                                    $this->link[$a]->show($id);
                            }
                        }

                        if($this->linkCondicionalOperador == '<>'){
                            if($this->linkCondicional[$a] <> $row[$a]){
                                if((isset($this->link[$a])) and ($this->link[$a] <> NULL)){ 
                                    $this->link[$a]->show($id);
                                }
                            }
                        }
                    }else{
                        if((isset($this->link[$a])) and ($this->link[$a] <> NULL)){
                            $this->link[$a]->show($id);
                        }
                    }

                    # Se não é coluna de editar, nem de excluir, nem excluir condicional, nem de link etc
                    if (($a <> $colunaEdita) and ($a <> $colunaExcluir) and ($a <> $colunaExcluirCondicional) and ($a <> $colunaEditarCondicional)and ((!isset($this->link[$a])) or ($this->link[$a] == NULL))){
                        # verifica se tem imagem condicional, se tiver exibe o gráfico ao invel do valor                
                        if (!is_null($this->imagemCondicional)){
                            # pega as colunas que possuem imagens 
                            $colunasImagem = array();
                            foreach ($this->imagemCondicional as $condicionalColuna){ 
                                array_push($colunasImagem,$condicionalColuna['coluna']);
                            }

                            $contadorRow = 0;   // evita que o texto seja escrito mais de uma vez

                            foreach ($this->imagemCondicional as $condicionalImagem){ 
                                if($a == $condicionalImagem['coluna']){
                                    switch ($condicionalImagem['operador']){
                                        case '=':
                                        case '==':
                                            if($row[$a] == $condicionalImagem['valor'])
                                                $condicionalImagem['imagem']->show();
                                            break;

                                        case '<>':	
                                            if($row[$a] <> $condicionalImagem['valor'])
                                                $condicionalImagem['imagem']->show();
                                            break;	

                                        case '>':	
                                            if($row[$a] > $condicionalImagem['valor'])
                                                $condicionalImagem['imagem']->show();
                                            break;

                                        case '<':	
                                            if($row[$a] < $condicionalImagem['valor'])
                                                $condicionalImagem['imagem']->show();
                                            break;

                                        case '>=':	
                                            if($row[$a] >= $condicionalImagem['valor'])
                                                $condicionalImagem['imagem']->show();
                                            break;                                   

                                        case '<=':	
                                            if($row[$a] <= $condicionalImagem['valor'])
                                                $condicionalImagem['imagem']->show();
                                            break;
                                    }
                                }else{
                                    if((!in_array($a,$colunasImagem)) and ($contadorRow == 0)){
                                        if((!is_null($this->textoRessaltado)) AND ($this->textoRessaltado <> "") AND ($a <> $colunaEdita)){
                                            #$row[$a] = get_bold($row[$a],$this->textoRessaltado);
                                            echo $row[$a];
                                        }else{
                                            echo $row[$a];
                                        }
                                        $contadorRow++;
                                    }
                                }
                            }                            
                        }elseif((!is_null($this->textoRessaltado)) AND ($this->textoRessaltado <> "")){ # Verifica se tem negrito
                            if($a <> $colunaEdita){
                                $row[$a] = bold($row[$a],$this->textoRessaltado);
                            }
                            echo $row[$a];
                        }else{                        
                            echo $row[$a];
                        }
                        
                        # soma o valor quando o somatório estiver habilitado
                        if(!is_null($this->colunaSomatorio)){
                            if($a == $this->colunaSomatorio){
                                $somatorio +=$row[$a];
                            }
                        }
                    }                
                    echo '</td>';               
                }// exibetd
            }
            echo '</tr>';
        }
        
        # Exibe a soma quando o somatório estiver habilitado
            if((!is_null($this->colunaSomatorio)) AND ($numRegistros <> 0)){
                $this->exibeSomatorio($numColunas,$somatorio);
            }
            

        echo '</tbody>';
        
        # Rotapé da Tabela
        if (($this->totalRegistro) OR ($this->rodape)){
            echo '<tfoot>';
            if ($this->numeroOrdem) {
                echo '<tr><td colspan="' . ($numColunas + 1) . '" title="Total de itens da tabela">';
            }else{
                echo '<tr><td colspan="' . ($numColunas) . '" title="Total de itens da tabela">';
            }

            if (is_null($this->rodape)) {
                echo 'Total de Registros:   ' . $numRegistros;
            }else{
                echo $this->rodape;
            }
            echo '</td></tr>';
        }
        
        echo '</tfoot>';
        echo '</table>';
        
        if($this->scroll){
            echo '</div>';
        }        
    }
    
    ###########################################################
}