<?php

class Input {

    /**
     * Cria um controle para um formulário
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @group do controle
     * @var private $nome string NULL    O nome do controle
     * @var private $tipo string 'texto' O tipo do controle: texto|numero|cpf|data|hora|cep|hidden|password|combo|checkbox|textarea|submit|reset|button
     *
     * @group do label
     * @var private $label     string NULL    O label do controle
     * @var private $tipoLabel string integer O tipo do label: 0 - sem label, 1 - label em cima, 2 - label do lado direito e 3 - label do lado esquerdo
     * @var private $inLine    string NULL    Um texto que aparece em frente do input (Zurb Foundation)
     *   
     * @group do tamanho
     * @var private $size      integer 0  O tamanho do controle
     * @var private $maxlength integer 0  O tamanho máximo do valor do controle
     * @var private $col       integer 12 Define, para o Grid do Foundation, o tamanho da coluna onde o controle se encontra (1 a 12)
     * 
     * @group das dicas
     * @var private $title       string NULL  Informa texto a ser exibido no evento mouseover
     * @var private $placeholder string NULL  Informa texto a ser exibido dentro do controle quando não tiver valor
     * 
     * @group outros
     * @var private $readonly  bool    FALSE Informa se o controle será somente leitura
     * @var private $disabled  bool    FALSE Informa se o controle será desabilitado. Se ficará oculto.
     * @var private $valor     string  NULL  Informa o valor desse controle
     * @var private $tabindex  integer NULL  Informa um número que ordena os controles dentro do form para a navegação pela tecla TAB.
     * @var private $accessKey string  NULL  Informa uma letra de atalho para quando o controle for um botão.
     * @var private $autofocus bool    FALSE Informa se o controle será o primeiro a receber foco quando a página carregar. Deverá se ter somente um controle com autofocus habilitado por página.
     * @var private $required  bool    FALSE Informa se o conterole deverá obrigatoriamente ser preenchido. Requerido. Not NULL
     * @var private $array     array   NULL  Informa o array de valores para uma combo.
     * @var private $datalist  array   NULL  Informa o array de valore para o datalist de um controle de texto 
     * 
     * @var private $id        string  NULL  Informa o id do input para o css ou jscript
     * 
     * @group dos eventos
     * @var private $onClick   string  NULL  Informa rotina do evento OnClick
     * @var private $onChange  string  NULL  Informa rotina do evento OnChange
     * 
     * @group do form
     * @var private $linha    integer NULL Informa a linha do formulário onde o o controle ficará 
     * @var private $fieldset string  NULL Texto do fieldset interno que começará antes desse controle 
     * 
     * @group do ratio e checkbox
     * @var private $checked   bool   FALSE Informa se o radio ou o checkbox está ticado
     *  
     * @example exemplo.input.php
     */
    # do controle
    private $nome = NULL;
    private $tipo = 'texto';

    # do label
    private $label = NULL;
    private $tipoLabel = 0;
    private $inLine = NULL;

    # do tamanho
    private $size = 0;
    private $maxlength = 0;
    private $col = 12;

    # do limite do input numero
    private $max = NULL;
    private $min = NULL;

    # da dica
    private $title = NULL;
    private $placeholder = NULL;

    # outros
    private $readonly = FALSE;
    private $disabled = FALSE;
    private $valor = NULL;
    private $tabindex = NULL;
    private $tagHtml = FALSE;
    private $accessKey = NULL;
    private $autofocus = FALSE;
    private $required = FALSE;
    private $array = NULL;
    private $datalist = NULL;
    private $bloqueadoEsconde = FALSE;  // Esconde o controle quando o forma está bloqueado
    private $pesquisa = FALSE;          // exibe um gráfico com lupa antes do controle
    private $formation = NULL;
    private $id = NULL;
    private $class = NULL;

    # dos eventos
    private $onClick = NULL;        // Evento ao clicar
    private $onChange = NULL;       // Evento ao alterar. Obs não funciona corretamente em campos date
    private $onBlur = NULL;         // Evento ao sair do controle
    # do form
    private $linha = NULL;      // informa a linha do controle
    private $fieldset = NULL;   // cria um fieldset dentro do form
    # do ratio ou do checkbos
    private $checked = FALSE;

    # Rotinas para modificar valores digitados antes da gravaçao
    private $plm = FALSE;     # Primeira Letra Maiusculas - Habilita, se TRUE, a converter o digitado a minusculas com as primeiras letras de cada palavra maiusculas.

###########################################################

    public function __construct($nome, $tipo = "texto", $label = NULL, $tipoLabel = 0) {
        /**
         * Cria um controle
         * 
         * @param $nome      string NULL    O nome do controle
         * @param $tipo      string "texto" O tipo do controle: texto|numero|cpf|data|hora|cep|hidden|password|combo|checkbox|textarea|submit|reset|button
         * @param $label     string NULL    O label do controle
         * @param $tipoLabel string 0       O tipo do label: 0 - sem label, 1 - label em cima, 2 - label do lado direito e 3 - label do lado esquerdo 
         * 
         * @syntax $input = new Input($nome,[$tipo],[$label],[$tipoLabel]); 
         */
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->label = $label;
        $this->tipoLabel = $tipoLabel;
    }

###########################################################

    public function set_size($size, $maxlength = NULL) {
        /**
         * Informa o tamanho do controle
         * 
         * @param $size      integer NULL O tamanho do input
         * @param $maxlength integer NULL A quantidade máxima de caracteres que poderá ser digitado dentro do input
         * @note Quando o maxlength não é informado ele assume o valor da variavel size.
         * 
         * @syntax $input->set_size($size,[$maxlength]);  
         */
        $this->size = $size;
        $this->maxlength = $maxlength;
    }

###########################################################

    public function set_max($max = NULL) {
        /**
         * Informa o maximo de um controle numerico
         * 
         * @param $max      integer NULL O valor máximo do campo
         * 
         * @syntax $input->set_max($max);  
         */
        $this->max = $max;
    }

###########################################################

    public function set_min($min = NULL) {
        /**
         * Informa o mininmo de um controle numerico
         * 
         * @param $min      integer NULL O valor mínimo do campo
         * 
         * @syntax $input->set_min($min);  
         */
        $this->min = $min;
    }

###########################################################

    public function set_tipo($tipo = "texto") {
        /**
         * Altera o tipo quando se deseja alterar depois da classe instanciada
         * 
         * @param $tipo      string "texto" O tipo do controle: texto|numero|cpf|data|hora|cep|hidden|password|combo|checkbox|textarea|submit|reset|button
         * 
         * @syntax $input->set_tipo([$tipo]);  
         */
        $this->tipo = $tipo;
    }

###########################################################

    public function set_id($id) {
        /**
         * Informa o id para o css ou jscript
         * 
         * @param $id      string NULL O id do input
         * 
         * @syntax $input->set_id($id);  
         */
        $this->id = $id;
    }

###########################################################

    public function set_inLine($inLine) {
        /**
         * Informa um texto para o inline 
         * 
         * @param $inLine string NULL O texto para o inLine
         * 
         * @syntax $input->set_inLine($inLine);  
         */
        $this->inLine = $inLine;
    }

###########################################################

    public function set_col($col = NULL) {
        /**
         * Informa o tamanho da coluna do controle para o grid do Foundation
         * 
         * @param $col integer NULL O tamanho da coluna (1 a 12)
         * 
         * @note As variaveis col e linha só funcionam quando são vinculas a um formulário.
         * 
         * @syntax $input->set_col($col);  
         */
        $this->col = $col;
    }

##########################################################       

    public function set_checked($checked) {
        /**
         * Informa o valor da variavel checked 
         * 
         * @syntax $input->set_checked();
         * 
         * @note A variavel checked só funciona no radio e no checkbox.
         */
        $this->checked = $checked;
    }

###########################################################                   

    public function get_col() {
        /**
         * Informa o valor da variavel col 
         * 
         * @syntax $input->get_col();
         * 
         * @note As variaveis col e linha só funcionam quando são vinculas a um formulário.
         * 
         * @return integer com o número da coluna desse controle
         */
        return $this->col;
    }

###########################################################            

    public function set_title($title = NULL) {
        /**
         * Informa o texto no mouse over
         * 
         * @syntax $input->set_title($title);
         * 
         * @param $title string NULL O texto a ser exibido
         */
        $this->title = $title;
    }

###########################################################       

    public function set_placeholder($placeholder = NULL) {
        /**
         * Informa o texto a ser exibido dentro do controle quando não tiver valor
         * 
         * @syntax $input->set_placeholder($placeholder);
         * 
         * @note Quando o placeholder não é informado ele assume o valor do nome.
         * 
         * @param $placeholder string NULL Informa texto a ser exibido dentro do controle quando não tiver valor
         */
        $this->placeholder = $placeholder;
    }

###########################################################       

    public function set_readonly($readonly = FALSE) {
        /**
         * Informa se o controle será somente leitura
         * 
         * @syntax $input->set_readonly($readonly);
         * 
         * @param $readonly string FALSE TRUE se for somente leitura ou FALSE se for habilitado para edição
         */
        $this->readonly = $readonly;
    }

###########################################################       

    public function set_disabled($disabled = FALSE) {
        /**
         * Informa se o controle será desabilitado. Se ficará oculto.
         * 
         * @syntax $input->set_disabled($disabled);
         * 
         * @param $disabled string FALSE TRUE se estiver desabilitado e oculto ou FALSE se for habilitado e visível
         */
        $this->disabled = $disabled;
    }

###########################################################       

    public function set_valor($valor = NULL) {
        /**
         * Informa o valor do controle
         * 
         * @syntax $input->set_valor($valor);
         * 
         * @param $valor string NULL O valor do controle
         */
        $this->valor = $valor;
    }

###########################################################       

    public function set_tabindex($tabindex = NULL) {
        /**
         * Informa um número que ordena os controles dentro do form para a navegação pela tecla TAB.
         * 
         * @syntax $input->set_tabindex($tabindex);
         * 
         * @param $tabindex integer NULL O número de ordem desse controle
         */
        $this->tabindex = $tabindex;
    }

###########################################################       

    public function set_accessKey($accessKey = NULL) {
        /**
         * Informa uma letra de atalho para quando o controle for um botão.
         * 
         * @syntax $input->set_accessKey($accessKey);
         * 
         * @param $accessKey string NULL A letra para o atalho
         */
        $this->accessKey = $accessKey;
    }

###########################################################       

    public function set_autofocus($autofocus = NULL) {
        /**
         * Informa se o controle será o primeiro a receber foco quando a página carregar. Deverá se ter somente um controle com autofocus habilitado por página.
         * 
         * @syntax $input->set_autofocus($autofocus);
         * 
         * @param $accessKey bool FALSE A letra para o atalho
         */
        $this->autofocus = $autofocus;
    }

###########################################################       

    public function set_required($required = NULL) {
        /**
         * Informa se o conterole deverá obrigatoriamente ser preenchido. Requerido. Not NULL
         * 
         * @syntax $input->set_required($required);
         * 
         * @note Quando o controle for marcado como required, aparecerá um asterísco para informar que é obrigatório.
         * 
         * @param $required bool FALSE Indica se é requerido TRUE ou não FALSE
         */
        $this->required = $required;
    }

###########################################################       

    public function set_array($array = NULL) {
        /**
         * Informa o array de valores para uma combo.
         * 
         * @syntax $input->set_array($array);
         * 
         * @param $array array NULL O array da combo.
         */
        $this->array = $array;
    }

###########################################################       

    public function set_onClick($onClick = NULL) {
        /**
         * Informa rotina do evento OnClick
         * 
         * @syntax $input->set_onClick($onClick);
         * 
         * @param $onClick string NULL A rotina a ser inserida
         */
        $this->onClick = $onClick;
    }

###########################################################       

    public function set_onBlur($onBlur = NULL) {
        /**
         * Informa rotina do evento onBlur
         * 
         * @syntax $input->set_onBlur($onBlur);
         * 
         * @param $onBlur string NULL A rotina a ser inserida
         */
        $this->onBlur = $onBlur;
    }

###########################################################         

    public function set_onChange($onChange = NULL) {
        /**
         * Informa rotina do evento onChange
         * 
         * @syntax $input->$onChange($onChange);
         * 
         * @param $onChange string NULL A rotina a ser inserida
         */
        $this->onChange = $onChange;
    }

########################################################### 

    public function set_linha($linha = NULL) {
        /**
         * Informa a linha do formulário onde o o controle ficará 
         * 
         * @syntax $input->set_linha($linha);
         * 
         * @note As variaveis col e linha só funcionam quando são vinculas a um formulário.
         * 
         * @param $linha integer NULL O número da linha
         */
        $this->linha = $linha;
    }

##########################################################       

    public function get_linha() {
        /**
         * Informa o valor da variavel linha 
         * 
         * @syntax $input->get_linha();
         * 
         * @note As variaveis col e linha só funcionam quando são vinculas a um formulário.
         * 
         * @return integer o Número da linha desse controle
         */
        return $this->linha;
    }

###########################################################       

    public function set_fieldset($fieldset = NULL) {
        /**
         * Texto do fieldset interno que começará antes desse controle 
         * 
         * @syntax $input->set_fieldset($fieldset);
         * 
         * @param $fieldset integer NULL O texto
         */
        $this->fieldset = $fieldset;
    }

##########################################################       

    public function get_fieldset() {
        /**
         * Informa o valor da variavel fieldset 
         * 
         * @syntax $input->get_fieldset();
         * 
         * @return string o texto do fieldset
         */
        return $this->fieldset;
    }

##########################################################       

    public function set_plm($plm) {
        /**
         * Habilita, se TRUE, a converter o digitado a minusculas com as primeiras letras de cada palavra maiusculas.
         * 
         * @syntax $input->set_plm($plm);
         * 
         * @param $plm BOLL FALSE TRUE ou False - Habilita ou nao o plm
         */
        $this->plm = $plm;
    }

##########################################################       

    public function set_datalist($datalist) {
        /**
         * Informa uma lista de valores para o datalist do contrle
         * 
         * @syntax $input->set_datalist($datalist);
         * 
         * @param $datalist array NULL informa a lista de valores
         */
        $this->datalist = $datalist;
    }

##########################################################       

    public function set_bloqueadoEsconde($bloqueadoEsconde) {
        /**
         * Esconde, se TRUE, o controle quando o from estiver bloqueado para edição
         * 
         * @syntax $input->set_bloqueadoEsconde($bloqueadoEsconde);
         * 
         * @param $bloqueadoEsconde bool FALSE TRUE ou False - Esconde o não o controle
         */
        $this->bloqueadoEsconde = $bloqueadoEsconde;
    }

##########################################################       

    public function set_pesquisa($pesquisa) {
        /**
         * Exibe, se TRUE, o uma lupa decorativa na frente do controle
         * 
         * @syntax $input->set_pesquisa($pesquisa);
         * 
         * @param $pesquisa bool FALSE TRUE ou False - Exibe ou não a lupa
         */
        $this->pesquisa = $pesquisa;
    }

##########################################################       

    public function set_formation($formation) {
        /**
         * Altera o atributo formation do controle
         * 
         * @syntax $input->set_formation($formation);
         * 
         * @param $formation texto NULL O valor a ser atribuído 
         */
        $this->formation = $formation;
    }

##########################################################       

    public function set_tagHtml($tagHtml) {
        /**
         * Altera o atributo tagHtml do controle
         * 
         * @syntax $input->set_tagHtml($tagHtml);
         * 
         * @param $tagHtml texto NULL O valor a ser atribuído 
         */
        $this->tagHtml = $tagHtml;
    }

##########################################################                                                   

    public function show() {
        /**
         * Exibe o controle
         * 
         * @note As variáveis col, linha, fieldset só funcionam quando o controle está vinculado a um form. Então quando se vincula um conrole a um form o método show() não é digitado.
         * 
         * @syntax $input->show(); 
         */
        if ($this->tipo == "hidden") {
            $this->tipoLabel = 0;
        }

        if (($this->tipo == "checkbox") OR ($this->tipo == "radio")) {
            $this->tipoLabel = 3;
        }

        #  Tipo do label: 
        #  0 - sem label, 
        #  1 - label em cima, 
        #  2 - label do lado direito 
        #  3 - label do lado esquerdo
        switch ($this->tipoLabel) {
            case 1:
                echo '<label id="label' . $this->nome . '" for="' . $this->nome . '">';
                echo $this->label;
                if ($this->required) {
                    echo ' * ';
                }

                if ($this->tagHtml) {
                    echo ' (html) ';
                }

                if ($this->plm) {
                    echo ' (Aa) ';
                }

                echo '</label>';
                break;

            case 2:
                echo '<label id="label' . $this->nome . '" for="' . $this->nome . '">';
                echo $this->label;
                echo '</label>';
                break;
        }

        if (!is_null($this->inLine)) {
            echo '<div';

            if (!is_null($this->id)) {
                echo ' id="div' . $this->id . '"';
            } else {
                echo ' id="div' . $this->nome . '"';
            }

            echo ' class="input-group">';

            echo '<span ';

            if (!is_null($this->id)) {
                echo ' id="span' . $this->id . '"';
            } else {
                echo ' id="span' . $this->nome . '"';
            }

            echo ' class="input-group-label">';
            echo $this->inLine;
            echo '</span>';

            $this->class = "input-group-field";
        }

        switch ($this->tipo) {
            case "processo":
            case "texto":
            case "numero":
            case "patrimonio":
            case "cpf":
            case "email":
            case "cep":
            case "date":
            case "data":
            case "hora":
            case "telefone":
            case "celular":
                if ($this->pesquisa) {
                    echo '<div class="input-group" id="pesquisa">';
                    echo '<span class="input-group-label"><i class="fi-magnifying-glass"></i></span>';
                    echo '<input class="input-group-field"';
                } else {
                    echo '<INPUT autocomplete="on"';        // Habilita histórico
                }
                break;
            case "file":
            case "submit":
            case "reset":
            case "button":
            case "checkbox":
            case "radio":
                echo '<INPUT';
                break;
            case "sei":
                echo '<div class="input-group">';
                echo '<span class="input-group-label">SEI</span>';
                echo '<input class="input-group-field"';
                break;
            case "porcentacem":
            case "percentagem":
                echo '<div class="input-group">';
                echo '<input class="input-group-field"';
                break;
            case "moeda":
                echo '<div class="input-group">';
                echo '<span class="input-group-label">R$</span>';
                echo '<input class="input-group-field"';
                break;
            case "hidden":
                echo '<INPUT';
                $this->tipo = 'hidden';
                break;
            case "password":
                echo '<INPUT onPaste="return FALSE;"';
                $this->tipo = 'password';
                break;
            case "combo":
            case "simnao":
                if ($this->pesquisa) {
                    echo '<div class="input-group" id="pesquisa">';
                    echo '<span class="input-group-label"><i class="fi-magnifying-glass"></i></span>';
                    echo '<select class="input-group-field"';
                } else {
                    echo '<select';
                }
                break;
            case "editor":
            case "textarea":
                echo '<textarea';
                break;
        }

        # id
        if (!is_null($this->id)) {
            echo ' id="' . $this->id . '"';
        } else {
            echo ' id="' . $this->nome . '"';
            $this->id = $this->nome;
        }

        # class
        if (!is_null($this->class)) {
            echo ' class="' . $this->class . '"';
        }
        # tabulação
        if (!is_null($this->tabindex)) {
            echo ' tabindex="' . $this->tabindex . '"';
        }

        # focus
        if ($this->autofocus) {
            echo ' autofocus';
        }

        # required
        if ($this->required) {
            echo ' required';
        }

        # title
        if (!is_null($this->title)) {
            echo ' title="' . $this->title . '"';
        }

        # placeholder
        if (!is_null($this->placeholder)) {
            echo ' placeholder="' . $this->placeholder . '"';
        }

        # formation
        if (!is_null($this->formation)) {
            echo ' formation="' . $this->formation . '"';
        }

        # onChange	
        if (!is_null($this->onChange)) {
            echo ' onchange="' . $this->onChange . '"';
        }

        # onBlur	
        if (!is_null($this->onBlur)) {
            echo ' onblur="' . $this->onBlur . '"';
        }

        # Máximo de caracteres		
        if (($this->maxlength == 0) AND ($this->tipo <> 'textarea') AND ($this->tipo <> 'editor')) {
            # Coloca o maxlengh = 10 quando data
            if ($this->tipo == 'date') {
                echo ' maxlength="10"';
            } elseif ($this->tipo <> "hidden") {
                echo ' maxlength="' . $this->size . '"';
            }
        } else if (($this->tipo <> 'textarea') AND ( $this->tipo <> 'checkbox') AND ( $this->tipo <> 'editor')) {
            echo ' maxlength="' . $this->maxlength . '"';
        }

        # se for readonly	
        if ($this->readonly) {
            echo ' class="readonly" readonly ';
        }

        # se for disabled	
        if ($this->disabled) {
            echo ' class="disabled" disabled ';
        }

        # dados do input
        echo ' name="' . $this->nome . '"'; # nome do controle (deve ser o mesmo que o do banco de dados)
        # Verifica se tem datalist
        if (!is_null($this->datalist)) {
            echo ' list="lista' . $this->nome . '"';
        }

        switch ($this->tipo) {
            case "textarea":
                echo ' cols="' . $this->size[0] . '"';
                echo ' rows="' . $this->size[1] . '"';
                echo '>';
                echo $this->valor;
                echo '</textarea> ';
                break;

            case "editor":
                echo ' cols="' . $this->size[0] . '"';
                echo ' rows="' . $this->size[1] . '"';
                echo '>';
                echo $this->valor;
                echo '</textarea> ';
                echo "<script>CKEDITOR.replace('$this->id')</script>";
                break;

            case "hidden":
                echo ' type="' . $this->tipo . '"';
                echo ' value="' . $this->valor . '" />';
                #echo '</INPUT>';
                break;

            case "simnao":
                $this->array = array(array(1, "Sim"), array(0, "Não"));

                echo '>';
                foreach ($this->array as $field) {
                    echo '<option value="' . $field[0] . '"';
                    if ($field[0] == $this->valor) {
                        echo ' selected>';
                    } else {
                        echo '>';
                    }
                    echo $field[1];
                    echo '</option>';
                }

                echo '</select>';
                break;

            case "combo":
                #echo ' size="'.($this->size).'"';
                echo '>';
                foreach ($this->array as $field) {
                    if (is_array($field)) {
                        echo '<option value="' . $field[0] . '"';
                        if ($field[0] == $this->valor) {
                            echo ' selected>';
                        } else {
                            echo '>';
                        }

                        echo $field[1];
                        echo '</option>';
                    } else {
                        echo ' <option value="' . $field . '"';
                        if ($field == $this->valor) {
                            echo ' selected>';
                        } else {
                            echo '>';
                        }

                        echo $field;
                        echo '</option>';
                    }
                }

                echo '</select>';
                break;

            case "checkbox":
                echo ' type="' . $this->tipo . '"';
                echo ' size="' . ($this->size) . '"';
                #echo ' class="checkbox"';
                echo ' value="' . $this->nome . '"';
                if ($this->valor == $this->nome) { # se for TRUE, ou seja valor igual a 1
                    echo ' checked>';
                } else {
                    echo '>';
                }
                break;

            #<INPUT TYPE="radio" NAME="OPCAO" VALUE="op1" CHECKED> opção1   
            case "radio":
                echo ' type="' . $this->tipo . '"';
                echo ' nome="' . $this->nome . '"';
                echo ' value="' . $this->valor . '"';
                if ($this->checked) {
                    echo ' checked>';
                } else {
                    echo '>';
                }
                break;

            case "date":
            case "data":
                echo ' type="date"';
                echo ' value="' . $this->valor . '"';
                if (!vazio($this->max)) {
                    echo ' max="' . $this->max . '"';
                }

                if (!vazio($this->min)) {
                    echo ' min="' . $this->min . '"';
                }
                echo '/>';
                break;

            case "hora":
                $mascara = '99:99';
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onkeypress="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onkeyup="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onblur="mask(this, \'' . $mascara . '\',1,this)" ';
                echo '/>';
                break;

            case "telefone":
                $mascara = '9999-9999';
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onkeypress="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onkeyup="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onblur="mask(this, \'' . $mascara . '\',1,this)" ';
                echo '/>';
                break;

            case "celular":
                $mascara = '99999-9999';
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onkeypress="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onkeyup="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onblur="mask(this, \'' . $mascara . '\',1,this)" ';
                echo '/>';
                break;

            case "processo":
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo '/>';
                break;
            
            case "sei":
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo '/>';
                echo '</div>';
                break;

            case "cpf":
                $mascara = '999.999.999-99';
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onkeypress="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onkeyup="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onblur="mask(this, \'' . $mascara . '\',1,this)" ';
                echo '/>';
                break;

            case "numero":
                echo ' size="' . $this->size . '"';
                echo ' type="number"';
                echo ' value="' . $this->valor . '"';

                if (!vazio($this->max)) {
                    echo ' max="' . $this->max . '"';
                }

                if (!vazio($this->min)) {
                    echo ' min="' . $this->min . '"';
                }

                echo '/>';
                break;

            case "cep":
                $mascara = '99999-999';
                echo ' size="' . $this->size . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onkeypress="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onkeyup="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onblur="mask(this, \'' . $mascara . '\',1,this)" ';
                echo '/>';
                break;

            case "moeda":
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . formataMoeda($this->valor) . '"';
                echo ' onkeypress="return formatarMoeda(this,\'.\',\',\',event);" ';
                echo '/>';
                echo '</div>';
                break;

            case "password":
                echo ' size="' . ($this->size) . '"';
                echo ' type="password"';
                #echo ' name="'.$this->nome.'"';
                #echo ' id="'.$this->nome.'"';
                echo '/>';
                break;

            case "submit":
                echo ' size="' . $this->size . '"';
                echo ' type="submit"';
                echo ' value="' . $this->valor . '"';
                echo ' class="button"';
                echo ' accesskey="' . $this->accessKey . '"';
                #echo ' onclick="this.disabled=true;form.submit();"';
                echo " onsubmit=\"if (this.getAttribute('submitted')) return false; this.setAttribute('submitted','true');\"";  // Tenta evitar duplo cliques
                echo '/>';
                break;

            case "reset":
                echo ' size="' . $this->size . '"';
                echo ' type="reset"';
                echo ' value="' . $this->valor . '"';
                #echo ' name="'.$this->nome.'"';
                echo ' accesskey="' . $this->accessKey . '"';
                echo '/>';
                break;

            case "button":
                echo ' size="' . $this->size . '"';
                echo ' type="button"';
                echo ' value="' . $this->valor . '"';
                #echo ' name="'.$this->nome.'"';
                echo ' class="button"';
                echo ' onClick="' . $this->onClick . '"';
                echo ' accesskey="' . $this->accessKey . '"';
                echo '/>';
                break;

            case "file":
                echo ' size="' . $this->size . '"';
                echo ' type="file"';
                echo ' value="' . $this->valor . '"';
                #echo ' name="'.$this->nome.'"';
                #echo ' id="'.$this->nome.'"';
                echo ' onFocus="this.select();"';
                echo '/>';
                break;

            case "porcentacem":
            case "percentagem":
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onFocus="this.select();"';
                echo '/>';
                echo '<span class="input-group-label">%</span>';
                echo '</div>';
                break;

            default:
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onFocus="this.select();"';
                echo '/>';
                break;
        }

        # Fecha a div da pesquisa
        if ($this->pesquisa) {
            echo '</div>';
        }

        # Fecha a div interna
        if (!is_null($this->inLine)) {
            echo '</div>';
        }

        switch ($this->tipoLabel) {
            case 3:
                echo '<label id="label' . $this->nome . '" for="' . $this->nome . '">';
                echo $this->label;
                echo '</label>';
                break;
        }

        # Coloca a lista quando tem datalist
        if (!is_null($this->datalist)) {

            echo '<datalist id="lista' . $this->nome . '">';
            foreach ($this->datalist as $field) {
                if (is_array($field)) {
                    echo ' <option value="' . $field[0] . '">';
                } else {
                    echo ' <option value="' . $field . '">';
                }
            }
            echo '</datalist>';
        }
    }

###########################################################
}
