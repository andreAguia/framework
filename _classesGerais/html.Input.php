<?php

class Input {

    /**
     * Cria um controle para um formulário
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @group do controle
     * @var private $nome string null    O nome do controle
     * @var private $tipo string 'texto' O tipo do controle: texto|numero|cpf|data|hora|cep|hidden|password|combo|checkbox|textarea|submit|reset|button
     *
     * @group do label
     * @var private $label     string null    O label do controle
     * @var private $tipoLabel string integer O tipo do label: 0 - sem label, 1 - label em cima, 2 - label do lado direito e 3 - label do lado esquerdo
     * @var private $inLine    string null    Um texto que aparece em frente do input (Zurb Foundation)
     *   
     * @group do tamanho
     * @var private $size      integer 0  O tamanho do controle
     * @var private $maxlength integer 0  O tamanho máximo do valor do controle
     * @var private $col       integer 12 Define, para o Grid do Foundation, o tamanho da coluna onde o controle se encontra (1 a 12)
     * 
     * @group das dicas
     * @var private $title       string null  Informa texto a ser exibido no evento mouseover
     * @var private $placeholder string null  Informa texto a ser exibido dentro do controle quando não tiver valor
     * 
     * @group outros
     * @var private $readonly  bool    false Informa se o controle será somente leitura
     * @var private $disabled  bool    false Informa se o controle será desabilitado. Se ficará oculto.
     * @var private $valor     string  null  Informa o valor desse controle
     * @var private $tabindex  integer null  Informa um número que ordena os controles dentro do form para a navegação pela tecla TAB.
     * @var private $accessKey string  null  Informa uma letra de atalho para quando o controle for um botão.
     * @var private $autofocus bool    false Informa se o controle será o primeiro a receber foco quando a página carregar. Deverá se ter somente um controle com autofocus habilitado por página.
     * @var private $required  bool    false Informa se o conterole deverá obrigatoriamente ser preenchido. Requerido. Not null
     * @var private $array     array   null  Informa o array de valores para uma combo.
     * @var private $datalist  array   null  Informa o array de valore para o datalist de um controle de texto 
     * 
     * @var private $id        string  null  Informa o id do input para o css ou jscript
     * 
     * @group dos eventos
     * @var private $onClick   string  null  Informa rotina do evento OnClick
     * @var private $onChange  string  null  Informa rotina do evento OnChange
     * 
     * @group do form
     * @var private $linha    integer null Informa a linha do formulário onde o o controle ficará 
     * @var private $fieldset string  null Texto do fieldset interno que começará antes desse controle 
     * 
     * @group do ratio e checkbox
     * @var private $checked   bool   false Informa se o radio ou o checkbox está ticado
     *  
     * @example exemplo.input.php
     */
    # do controle
    private $nome = null;
    private $tipo = 'texto';

    # do label
    private $label = null;
    private $tipoLabel = 0;
    private $inLine = null;

    # do tamanho
    private $size = 0;
    private $maxlength = 0;
    private $col = 12;

    # do limite do input numero
    private $max = null;
    private $min = null;

    # da dica
    private $title = null;
    private $placeholder = null;
    private $helptext = null;

    # outros
    private $readonly = false;
    private $disabled = false;
    private $valor = null;
    private $tabindex = null;
    private $tagHtml = false;
    private $accessKey = null;
    private $autofocus = false;
    private $required = false;
    private $array = null;
    private $datalist = null;
    private $bloqueadoEsconde = false;  // Esconde o controle quando o forma está bloqueado
    private $pesquisa = false;          // exibe um gráfico com lupa antes do controle
    private $formation = null;
    private $id = null;
    private $class = null;
    private $multiple = false;       // aceita multiplas escolhas em um select (combo)
    private $optgroup = false;    // habilita ou não um grupo para uma combo (select)
    # dos eventos
    private $onClick = null;        // Evento ao clicar
    private $onChange = null;       // Evento ao alterar. Obs não funciona corretamente em campos date
    private $onBlur = null;         // Evento ao sair do controle
    # do form
    private $linha = null;      // informa a linha do controle
    private $fieldset = null;   // cria um fieldset dentro do form
    # do ratio ou do checkbos
    private $checked = false;

    # Rotinas para modificar valores digitados antes da gravaçao
    private $plm = false;     # Primeira Letra Maiusculas - Habilita, se true, a converter o digitado a minusculas com as primeiras letras de cada palavra maiusculas.

###########################################################

    public function __construct($nome, $tipo = "texto", $label = null, $tipoLabel = 0) {
        /**
         * Cria um controle
         * 
         * @param $nome      string null    O nome do controle
         * @param $tipo      string "texto" O tipo do controle: texto|numero|cpf|data|hora|cep|hidden|password|combo|checkbox|textarea|submit|reset|button
         * @param $label     string null    O label do controle
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

    public function set_size($size, $maxlength = null) {
        /**
         * Informa o tamanho do controle
         * 
         * @param $size      integer null O tamanho do input
         * @param $maxlength integer null A quantidade máxima de caracteres que poderá ser digitado dentro do input
         * @note Quando o maxlength não é informado ele assume o valor da variavel size.
         * 
         * @syntax $input->set_size($size,[$maxlength]);  
         */
        $this->size = $size;
        $this->maxlength = $maxlength;
    }

###########################################################

    public function set_max($max = null) {
        /**
         * Informa o maximo de um controle numerico
         * 
         * @param $max      integer null O valor máximo do campo
         * 
         * @syntax $input->set_max($max);  
         */
        $this->max = $max;
    }

###########################################################

    public function set_min($min = null) {
        /**
         * Informa o mininmo de um controle numerico
         * 
         * @param $min      integer null O valor mínimo do campo
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
         * @param $id      string null O id do input
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
         * @param $inLine string null O texto para o inLine
         * 
         * @syntax $input->set_inLine($inLine);  
         */
        $this->inLine = $inLine;
    }

###########################################################

    public function set_col($col = null) {
        /**
         * Informa o tamanho da coluna do controle para o grid do Foundation
         * 
         * @param $col integer null O tamanho da coluna (1 a 12)
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

    public function set_title($title = null) {
        /**
         * Informa o texto no mouse over
         * 
         * @syntax $input->set_title($title);
         * 
         * @param $title string null O texto a ser exibido
         */
        $this->title = $title;
    }

###########################################################       

    public function set_placeholder($placeholder = null) {
        /**
         * Informa o texto a ser exibido dentro do controle quando não tiver valor
         * 
         * @syntax $input->set_placeholder($placeholder);
         * 
         * @note Quando o placeholder não é informado ele assume o valor do nome.
         * 
         * @param $placeholder string null Informa texto a ser exibido dentro do controle quando não tiver valor
         */
        $this->placeholder = $placeholder;
    }

###########################################################       

    public function set_helptext($helptext = null) {
        /**
         * Informa o texto a ser exibido embaixo do controle
         * 
         * @syntax $input->set_helptext($helptext);
         * 
         * @param $helptext string null Informa texto a ser exibido 
         */
        $this->helptext = $helptext;
    }

###########################################################       

    public function set_readonly($readonly = false) {
        /**
         * Informa se o controle será somente leitura
         * 
         * @syntax $input->set_readonly($readonly);
         * 
         * @param $readonly string false true se for somente leitura ou false se for habilitado para edição
         */
        $this->readonly = $readonly;
    }

###########################################################       

    public function set_disabled($disabled = false) {
        /**
         * Informa se o controle será desabilitado. Se ficará oculto.
         * 
         * @syntax $input->set_disabled($disabled);
         * 
         * @param $disabled string false true se estiver desabilitado e oculto ou false se for habilitado e visível
         */
        $this->disabled = $disabled;
    }

###########################################################       

    public function set_valor($valor = null) {
        /**
         * Informa o valor do controle
         * 
         * @syntax $input->set_valor($valor);
         * 
         * @param $valor string null O valor do controle
         */
        $this->valor = $valor;
    }

###########################################################       

    public function set_tabindex($tabindex = null) {
        /**
         * Informa um número que ordena os controles dentro do form para a navegação pela tecla TAB.
         * 
         * @syntax $input->set_tabindex($tabindex);
         * 
         * @param $tabindex integer null O número de ordem desse controle
         */
        $this->tabindex = $tabindex;
    }

###########################################################       

    public function set_accessKey($accessKey = null) {
        /**
         * Informa uma letra de atalho para quando o controle for um botão.
         * 
         * @syntax $input->set_accessKey($accessKey);
         * 
         * @param $accessKey string null A letra para o atalho
         */
        $this->accessKey = $accessKey;
    }

###########################################################       

    public function set_autofocus($autofocus = null) {
        /**
         * Informa se o controle será o primeiro a receber foco quando a página carregar. Deverá se ter somente um controle com autofocus habilitado por página.
         * 
         * @syntax $input->set_autofocus($autofocus);
         * 
         * @param $accessKey bool false A letra para o atalho
         */
        $this->autofocus = $autofocus;
    }

###########################################################       

    public function set_required($required = null) {
        /**
         * Informa se o conterole deverá obrigatoriamente ser preenchido. Requerido. Not null
         * 
         * @syntax $input->set_required($required);
         * 
         * @note Quando o controle for marcado como required, aparecerá um asterísco para informar que é obrigatório.
         * 
         * @param $required bool false Indica se é requerido true ou não false
         */
        $this->required = $required;
    }

###########################################################       

    public function set_array($array = null) {
        /**
         * Informa o array de valores para uma combo.
         * 
         * @syntax $input->set_array($array);
         * 
         * @param $array array null O array da combo.
         */
        $this->array = $array;
    }

###########################################################       

    public function set_onClick($onClick = null) {
        /**
         * Informa rotina do evento OnClick
         * 
         * @syntax $input->set_onClick($onClick);
         * 
         * @param $onClick string null A rotina a ser inserida
         */
        $this->onClick = $onClick;
    }

###########################################################       

    public function set_onBlur($onBlur = null) {
        /**
         * Informa rotina do evento onBlur
         * 
         * @syntax $input->set_onBlur($onBlur);
         * 
         * @param $onBlur string null A rotina a ser inserida
         */
        $this->onBlur = $onBlur;
    }

###########################################################         

    public function set_onChange($onChange = null) {
        /**
         * Informa rotina do evento onChange
         * 
         * @syntax $input->$onChange($onChange);
         * 
         * @param $onChange string null A rotina a ser inserida
         */
        $this->onChange = $onChange;
    }

########################################################### 

    public function set_linha($linha = null) {
        /**
         * Informa a linha do formulário onde o o controle ficará 
         * 
         * @syntax $input->set_linha($linha);
         * 
         * @note As variaveis col e linha só funcionam quando são vinculas a um formulário.
         * 
         * @param $linha integer null O número da linha
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

    public function set_fieldset($fieldset = null) {
        /**
         * Texto do fieldset interno que começará antes desse controle 
         * 
         * @syntax $input->set_fieldset($fieldset);
         * 
         * @param $fieldset integer null O texto
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
         * Habilita, se true, a converter o digitado a minusculas com as primeiras letras de cada palavra maiusculas.
         * 
         * @syntax $input->set_plm($plm);
         * 
         * @param $plm BOLL false true ou false - Habilita ou nao o plm
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
         * @param $datalist array null informa a lista de valores
         */
        $this->datalist = $datalist;
    }

##########################################################       

    public function set_bloqueadoEsconde($bloqueadoEsconde) {
        /**
         * Esconde, se true, o controle quando o from estiver bloqueado para edição
         * 
         * @syntax $input->set_bloqueadoEsconde($bloqueadoEsconde);
         * 
         * @param $bloqueadoEsconde bool false true ou false - Esconde o não o controle
         */
        $this->bloqueadoEsconde = $bloqueadoEsconde;
    }

##########################################################       

    public function set_pesquisa($pesquisa) {
        /**
         * Exibe, se true, o uma lupa decorativa na frente do controle
         * 
         * @syntax $input->set_pesquisa($pesquisa);
         * 
         * @param $pesquisa bool false true ou false - Exibe ou não a lupa
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
         * @param $formation texto null O valor a ser atribuído 
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
         * @param $tagHtml texto null O valor a ser atribuído 
         */
        $this->tagHtml = $tagHtml;
    }

##########################################################       

    public function set_multiple($multiple) {
        /**
         * Altera o atributo multiple do controle
         * 
         * @syntax $input->set_multiple($multiple);
         * 
         * @param $multiple true|false Se aceita ou não valores multiplos em um select 
         */
        $this->multiple = $multiple;
    }

##########################################################       

    public function set_optgroup($optgroup) {
        /**
         * Altera o atributo optgroup do controle
         * 
         * @syntax $input->set_optgroup($optgroup);
         * 
         * @param $optgroup true|false Se tem ou não agrupamentos em uma combot 
         */
        $this->optgroup = $optgroup;
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
            case "idFuncional":
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
                echo '<div id="div'.$this->nome.'" class="input-group">';
                echo '<span class="input-group-label">SEI</span>';
                echo '<input class="input-group-field"';
                break;
            case "processoAntigo":
                echo '<div id="div'.$this->nome.'" class="input-group">';
                echo '<span class="input-group-label">E-26/009/</span>';
                echo '<input class="input-group-field"';
                break;
            case "processoAntigo2":
                echo '<div id="div'.$this->nome.'" class="input-group">';
                echo '<span class="input-group-label">E-26</span>';
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
                echo '<INPUT onPaste="return false;"';
                $this->tipo = 'password';
                break;
            case "combo":
            case "simnao2":
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
            case "simnao":
                echo '<div class="switch">
                        <input class="switch-input" type="checkbox"';
                break;
        }

        # id
        if (!empty($this->id)) {
            echo ' id="' . $this->id . '"';
        } else {
            echo ' id="' . $this->nome . '"';
            $this->id = $this->nome;
        }

        # class
        if (!empty($this->class)) {
            echo ' class="' . $this->class . '"';
        }
        # tabulação
        if (!empty($this->tabindex)) {
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
        if (!empty($this->title)) {
            echo ' title="' . $this->title . '"';
        }

        # placeholder
        if (!empty($this->placeholder)) {
            echo ' placeholder="' . $this->placeholder . '"';
        }

        # formation
        if (!empty($this->formation)) {
            echo ' formation="' . $this->formation . '"';
        }

        # onChange	
        if (!empty($this->onChange)) {
            echo ' onchange="' . $this->onChange . '"';
        }

        # onBlur	
        if (!empty($this->onBlur)) {
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

        # nome do controle (deve ser o mesmo que o do banco de dados)
        if ($this->multiple) {
            # Se for multiple é necessário informar (pelo nome) que o retorno é array
            echo ' name="' . $this->nome . '[]"';
        } else {
            # Se não for multiple o nome fica normal
            echo ' name="' . $this->nome . '"';
        }

        # Verifica se tem datalist
        if (!empty($this->datalist)) {
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
                echo '</textarea>';
                echo '<br/>';

                /* Coloque no início do página para funcionar
                 * $page = new Page();
                 * $page->set_jscript('<script>CKEDITOR.replace("***textareaid***");</script>');
                 */
                break;

            case "hidden":
                echo ' type="' . $this->tipo . '"';
                echo ' value="' . $this->valor . '" />';
                #echo '</INPUT>';
                break;

            case "simnao":
                if ($this->valor) {
                    echo ' checked>';
                } else {
                    echo '>';
                }
                echo '<label class="switch-paddle" title="' . $this->title . '" for="' . $this->nome . '">';
                echo '<span class="show-for-sr" title="' . $this->title . '"></span>';
                echo '<span class="switch-active" aria-hidden="true" title="' . $this->title . '">Sim</span>';
                echo '<span class="switch-inactive" aria-hidden="true" title="' . $this->title . '">Não</span>';
                echo '</label></div>';
                break;

            case "simnao2":
                $this->array = array(
                    array(1, "Sim"),
                    array(0, "Não"),
                    array(null, ""));

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
                if ($this->multiple) {
                    echo ' multiple';
                    echo ' size="' . ($this->size) . '"';
                    echo '>';
                } else {
                    echo '>';
                }

                # Inicia o group (de tiver)
                if ($this->optgroup) {
                    $optgroupAnterior = null;
                }

                # Percorre p array
                foreach ($this->array as $field) {

                    # Verifica se é array multi
                    if (is_array($field)) {

                        # Verifica se tem optgroup
                        if ($this->optgroup) {

                            # Verifica se mudou o grupo
                            if ($optgroupAnterior <> $field[2]) {

                                # Varifica se não é o prmeiro grupo                            
                                if (is_null($optgroupAnterior)) {
                                    echo '</optgroup>';
                                }

                                echo '<optgroup label="' . $field[2] . '">';

                                $optgroupAnterior = $field[2];
                            }
                        }

                        echo '<option value="' . $field[0] . '"';
                        if (is_array($this->valor)) {
                            if (in_array($field[0], $this->valor)) {
                                echo ' selected>';
                            } else {
                                echo '>';
                            }
                        } else {
                            if ($field[0] == $this->valor) {
                                echo ' selected>';
                            } else {
                                echo '>';
                            }
                        }

                        echo $field[1];
                        echo '</option>';
                    } else {
                        echo ' <option value="' . $field . '"';
                        if (is_array($this->valor)) {
                            if (in_array($field, $this->valor)) {
                                echo ' selected>';
                            } else {
                                echo '>';
                            }
                        } else {
                            if ($field == $this->valor) {
                                echo ' selected>';
                            } else {
                                echo '>';
                            }
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
                if ($this->valor == $this->nome) { # se for true, ou seja valor igual a 1
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
                if (!empty($this->max)) {
                    echo ' max="' . $this->max . '"';
                }

                if (!empty($this->min)) {
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
                $mascara = '999999/999999/9999';
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onkeypress="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onkeyup="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onblur="mask(this, \'' . $mascara . '\',1,this)" ';
                echo '/>';
                echo '</div>';
                break;
            
            case "processoAntigo":
            case "processoAntigo2":
                $mascara = '999.999/9999';
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onkeypress="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onkeyup="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onblur="mask(this, \'' . $mascara . '\',1,this)" ';
                echo '/>';
                echo '</div>';
                break;

            case "email":
                echo ' size="' . ($this->size) . '"';
                echo ' type="email"';
                echo ' value="' . $this->valor . '"';
                echo ' onFocus="this.select();"';
                echo '/>';
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

            case "idFuncional":
                $mascara = '9999999999';
                echo ' size="' . $this->size . '"';
                echo ' type="text"';
                echo ' value="' . $this->valor . '"';
                echo ' onkeypress="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onkeyup="mask(this, \'' . $mascara . '\',1,this)" ';
                echo ' onblur="mask(this, \'' . $mascara . '\',1,this)" ';
                echo '/>';
                break;

            default:
                echo ' size="' . ($this->size) . '"';
                echo ' type="text"'; 
                echo ' value="' . $this->valor . '"';
                echo ' onFocus="this.select();"';
                echo '/>';
                break;
        }

        if (!empty($this->helptext)) {
            echo '<p class="help-text" id="passwordHelpText">' . $this->helptext . '</p>';
        }

        # Fecha a div da pesquisa
        if ($this->pesquisa) {
            echo '</div>';
        }

        # Fecha a div interna
        if (!empty($this->inLine)) {
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
        if (!empty($this->datalist)) {

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
