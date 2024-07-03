<?php

/**
 * classe menurelatorio
 * gera menu do relatorio
 * 
 * By Alat
 */
class menuRelatorio {

    private $formCampos = null;         # array com campos para o formulario    
    private $formLink = null;           # para onde vai o post
    private $botaoVoltar = null;        # define o link do botão voltar
    private $aviso = null;
    private $brHr = 1;                  # numeros de salto de linha antes do hr
    
    // usado quando se tem muitos controles e não se quer a 
    // div dos controles por cima do relatório
    ###########################################################

    /**
     * Métodos get e set construídos de forma automática pelo 
     * metodo mãgico __call.
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
    }

    ###########################################################

    function show() {
        $div = new Div('menuTopo');
        $div->abre();

        # Botão voltar       
        if ($this->botaoVoltar <> null) {
            botaoVoltar($this->botaoVoltar, 'Voltar', 'Volta para menu do servidor');
        }

        # Cria um grid para colocar o botão na lateral da tela
        $grid = new Grid("right");
        $grid->abreColuna(3);

        # Botão imprimir 
        $botao = new BotaoGrafico('botaoImprimir');
        $botao->set_label('Imprimir');
        $botao->set_title('Imprime o Relatório');
        $botao->set_imagem(PASTA_FIGURAS_GERAIS . 'relatorio.png');
        $botao->set_onClick("fechaDivId('menuTopo'); self.print(); abreDivId('menuTopo');");
        $botao->show();

        $grid->fechaColuna();
        $grid->fechaGrid();

        $grid = new Grid();
        $grid->abreColuna(12);

        # Campos
        if (!is_null($this->formCampos)) {
            # Abre a div		
            $divRelat = new Div('divRelatorioControles');
            $divRelat->abre();

            # Abre o form
            $formRelatorio = new Form($this->formLink);

            $contador = 1; // Contador para a tabulação do formulário

            foreach ($this->formCampos as $campo) {
                $controle = new Input($campo['nome'], $campo['tipo'], $campo['label'], 1);
                $controle->set_linha($campo['linha']); // linha no form que vai ser colocado o controle
                $controle->set_tabindex($contador);   // tabulador (ordem de navegação com a tecla tab)
                if (isset($campo['maxLength'])) {   // quantidade máxima de caracteres
                    $controle->set_size($campo['size'], $campo['maxLength']);   // tamanho do campos
                } else {
                    $controle->set_size($campo['size']);   // tamanho do campos
                }

                if (isset($campo['required'])) {
                    $controle->set_notnull($campo['required']);  // faz o controle exibir o *
                }

                if (isset($campo['array'])) {
                    $controle->set_array($campo['array']);   // conteudo de uma combo
                }

                if (isset($campo['readOnly'])) {
                    $controle->set_readonly($campo['readOnly']); // readonly
                }

                if (isset($campo['disabled'])) {
                    $controle->set_disabled($campo['disabled']); // disabled	
                }

                if (isset($campo['autofocus'])) {
                    $controle->set_autofocus($campo['autofocus']);          // disabled
                }

                if (isset($campo['placeholder'])) {
                    $controle->set_placeholder($campo['placeholder']); // placeholder (dica dentro do controle)            
                }

                if (isset($campo['title'])) {
                    $controle->set_title($campo['title']);          // title - dica do campo
                } else {
                    $controle->set_title($campo['label']);
                }

                if (isset($campo['onChange'])) {
                    $controle->set_onChange($campo['onChange']);  // onChange
                }

                if (isset($campo['fieldset'])) {
                    $controle->set_fieldset($campo['fieldset']);    // fieldse interno
                }

                if (isset($campo['col'])) {
                    $controle->set_col($campo['col']);
                }

                # Inlcui o valor padrão (se tiver)
                if (isset($campo['padrao'])) {
                    $controle->set_valor($campo['padrao']);
                }

                # Inlcui o valor digitado
                if (isset($campo['valor'])) {
                    $controle->set_valor($campo['valor']);
                }

                # optgroup
                if (isset($campo['optgroup'])) {
                    $controle->set_optgroup($campo['optgroup']);
                }

                # Coloca o foco no primeiro controle
                if ($contador == 1) {
                    $controle->set_autofocus(true);
                }

                $formRelatorio->add_item($controle);

                $contador++;  // incrementa o contador
            }
            $formRelatorio->show();

            $divRelat->fecha();
        }

        # Exibe o aviso (quando tiver)
        if (!is_null($this->aviso)) {
            br();
            callout($this->aviso);
        }

        $grid->fechaColuna();
        $grid->fechaGrid();

        # Quantidades de saltos de linha antes do hr
        for ($i = 1; $i <= $this->brHr; $i++) {
            br();
        }
        $div->fecha(); // menuTopo
    }
}
