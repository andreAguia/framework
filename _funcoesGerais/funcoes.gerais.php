<?php

/**
 * Funções Gerais
 * Rotinas simples demais para serem classes
 */
###########################################################

function post($nome, $padrao = null) {
    /**
     * Retorna o valor de um post oriundo de um formulário
     *
     * @syntax post($nome,$padrao);
     *
     * @return string com o valor do post
     *
     * @note Quando nenhum valor é retornado a função retorna o valor $padrao.
     *
     * @param $nome   string null Nome do post a ser lido.
     * @param $padrao string null Valor retornado caso seja null.
     *
     * @example exemplo.post.php
     */
    # Verifica se o post existe
    if (isset($_POST[$nome])) {
        if (is_array($_POST[$nome])) {
            $valor = $_POST[$nome];

            # Retorna o valor padrão quando for nulo
            if (!$valor) {
                $valor = $padrao;
            }
        } else {
            # Pega o valor desse post
            $valor = filter_input(INPUT_POST, $nome); // Substitui o $_post
            ## Obs:
            ## O código abaixo foi retirado pois na rotina de pesquisa de servidor
            ## e em outras rotinas de pesquisas é desejável o valor "" diferenciado
            ## do valor nulo. Dessa forma essa "limpeza" de valor vazio foi retirada
            ## da função post, mas continua na função get e get_session.
            # Força a ser nulo quando for ""
            #if(vazio($valor)){
            #    $valor = null;
            #}
            # Retorna o valor padrão quando for nulo
            if (is_null($valor)) {
                $valor = $padrao;
            }
        }

        return $valor;
    } else {
        return $padrao;
    }
}

###########################################################

function get($nome, $padrao = null) {
    /**
     * Retorna o valor de um get
     *
     * @syntax get($nome,$default);
     *
     * @return string com o valor do get
     *
     * @note Quando nenhum valor é retornado a função retorna o valor $padrao.
     *
     * @param $nome   string null Nome do get a ser lido.
     * @param $padrao string null Valor retornado caso seja null.
     *
     * @example exemplo.get.php
     */
    if (isset($_GET[$nome])) {        // Verifica se existe esse get (substitui o isset)
        $valor = filter_input(INPUT_GET, $nome); // Pega o valor (substitui o $_get)
        # Força a ser nulo quando for ""
        if (vazio($valor)) {
            $valor = null;
        }

        # Retorna o valor padrão quando for nulo
        if (is_null($valor)) {
            $valor = $padrao;
        }

        return $valor;
    } else {
        return $padrao;
    }
}

###########################################################

function loadPage($url, $target = null, $parametros = 'menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=750,height=600') {
    /**
     * Chama outra página PHP
     *
     * @syntax loadPage($url,$target,$parametros);
     *
     * @note Muito utilizada para a abertura da janela dos relatórios.
     *
     * @param $url          string null     A página a ser aberta.
     * @param $target       string null     Informa se abrirá em uma nova janela no browser.
     * @param $parametros   string videNota Parâmetros para o java script.
     *
     * @note O valor padrão do parâmetro: parametro é: 'menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=750,height=600'
     */
    if (is_null($target)) {
        echo '<meta http-equiv="refresh" content="0; URL=' . $url . '">';
    } else {
        echo "<script>window.open('$url','$target','$parametros');</script>";
    }
}

###########################################################

function ajaxLoadPage($url = null, $div = null) {
    /**
     * Abre um outra página php dentro de uma div sem fazer reload da página inteira. Somente a div é atualizada.
     *
     * @syntax ajaxLoadPage($url,$div);
     *
     * @note Esta rotina nada mais faz que chamar uma rotina homônima em jscript que efetivamente executa a rotina.
     *
     * @param $url string null A página que será carrregada.
     * @param $div string null O id da div onde a página será aberta.
     */
    echo "<script>ajaxloadPage('$url','$div','');</script>";
}

###########################################################

function set_session($nome = null, $valor = null) {
    /**
     * Escreve um valor em uma variável de sessão para ser usada em outras páginas sem a necessidade de repassá-la com post ou get.
     *
     * @syntax set_session($nome,$valor);
     *
     * @note Se a variável não existe ela será criada, se ela já existe o valor será atualizado.
     *
     * @param $nome  string null O nome da variável se sessão a ser criada ou alterada.
     * @param $valor string null O valor a ser inserido.
     *
     * @example exemplo.set_session.php
     */
    $_SESSION[$nome] = $valor;
}

###########################################################

function get_session($nome, $padrao = null) {
    /**
     * Retorna uma string com o conteúdo da variável de sessao.
     *
     * @syntax get_session($nome,$padrao);
     *
     * @return string com o valor da sessão
     *
     * @note Se o valor retornado for nulo será retornado o valor padrão.
     *
     * @param $nome   string O nome da variável de sessão
     * @param $padrao string O valor retornado caso seja null
     *
     * @example exemplo.set_session.php
     */
    if (isset($_SESSION[$nome])) {
        $valor = $_SESSION[$nome];

        # Força a ser nulo quando for ""
        if (vazio($valor)) {
            $valor = null;
        }

        # Retorna o valor padrão quando for nulo
        if (is_null($valor)) {
            $valor = $padrao;
        }

        return $valor;
    } else {
        return $padrao;
    }
}

###########################################################

function date_to_bd($data, $separador = '/') {
    /**
     * Transforma uma data do formato brasileiro DD/MM/AAAA para o formato americano AAAA-MM-DD.
     *
     * @syntax date_to_bd($data,[$separador]);
     *
     * @return string com a data no formato AAAA/MM/DD.
     *
     * @category Data
     *
     * @note Utilizado para converter as data ao formato de gravação do banco de dados.
     * @note Interessante também observar que independente do separador de entrada o separador de saída será sempre o -
     *
     * @param $data      date   null A data a ser transformada no formato DD/MM/AAAA
     * @param $separador string /    O separador da data
     *
     * @example exemplo.date_to_bd.php
     */
    if (empty($data)) {
        return false;
    } else {
        $dt1 = explode($separador, $data);
        $dt2 = $dt1[2] . '-' . $dt1[1] . '-' . $dt1[0];
        return $dt2;
    }
}

###########################################################

function date_to_php($data, $separador = '-') {
    /**
     * Transforma uma data do formato americano AAAA-MM-DD para o formato brasileiro DD/MM/AAAA.
     *
     * @syntax date_to_php($data,[$separador]);
     *
     * @return string com a data no formato DD/MM/AAAA
     *
     * @category Data
     *
     * @note Utilizado para recuperar datas do banco de dados.
     * @note Nessa função o separador padrão difere da função date_to_bd. Isso acontece porque - é o separador padrão do mysql.
     * @note Interessante também observar que independente do separador de entrada o separador de saída será sempre o /
     *
     * @param $data      date   null A data a ser transformada no formato AAAA-MM-DD
     * @param $separador string -    O separador da data.
     *
     * @example exemplo.date_to_php.php
     */
    if (empty($data)) {
        return null;
    } else {
        $dt1 = explode($separador, $data);
        $dt2 = $dt1[2] . '/' . $dt1[1] . '/' . $dt1[0];
        return $dt2;
    }
}

###########################################################

function datetime_to_php($data, $separadorData = '-', $separadorHora = ':') {
    /**
     * Transforma uma data com hora do formato americano AAAA/MM/DD HH:MM:SS para o formato brasileiro DD/MM/AAAA HH:MM:SS.
     *
     * @syntax datetime_to_php($data,[$separadorData],[$separadorHora]);
     *
     * @category Data
     *
     * @return string com a data no formato DD/MM/AAAA HH:MM:SS
     *
     * @note Utilizado para recuperar datas com horas do banco de dados.
     *
     * @param $data          date   null A data a ser transformada
     * @param $separadorData string -    O separador da data
     * @param $separadorHora string :    O separador da hora
     *
     * @example exemplo.datetime_to_php.php
     */
    if (is_null($data) or ($data == "")) {
        return null;
    } else {
        # Separa data da hora
        $dt1 = explode($separadorData, $data);
        $espaco = explode(' ', $dt1[2]);
        $hora = explode($separadorHora, $espaco[1]);

        $dt2 = $espaco[0] . '/' . $dt1[1] . '/' . $dt1[0] . ' ' . $hora[0] . ':' . $hora[1] . ':' . $hora[2];
        return $dt2;
    }
}

###########################################################

function datetime_to_bd($data, $separadorData = '/', $separadorHora = ':') {
    /**
     * Transforma uma data com hora do formato americano AAAA/MM/DD HH:MM:SS para o formato brasileiro DD/MM/AAAA HH:MM:SS.
     *
     * @syntax datetime_to_php($data,[$separadorData],[$separadorHora]);
     *
     * @category Data
     *
     * @return string com a data no formato DD/MM/AAAA HH:MM:SS
     *
     * @note Utilizado para recuperar datas com horas do banco de dados.
     *
     * @param $data          date   null A data a ser transformada
     * @param $separadorData string -    O separador da data
     * @param $separadorHora string :    O separador da hora
     *
     * @example exemplo.datetime_to_php.php
     */
    if (is_null($data) or ($data == "")) {
        return null;
    } else {
        # Separa data da hora
        $dt1 = explode($separadorData, $data);
        $espaco = explode(' ', $dt1[2]);
        $hora = explode($separadorHora, $espaco[1]);

        $dt2 = $espaco[0] . '-' . $dt1[1] . '-' . $dt1[0] . ' ' . $hora[0] . ':' . $hora[1] . ':' . $hora[2];
        return $dt2;
    }
}

###########################################################

function back($numPaginas) {
    /**
     * Retorna um número de páginas a partir do histórico do browser.
     *
     * @syntax back($numPaginas);
     *
     * @note Utilizado para voltar uma ou duas páginas anteriores e refazer alguma tarefa.
     *
     * @param $numPaginas integer null O número de páginas para voltar.
     */
    echo '<script>javascript:history.go(-' . $numPaginas . ');</script>';
}

###########################################################

function get_so() {
    /**
     * Retorna string com o nome do Sistema Operacional.
     *
     * @syntax get_so();
     *
     * @return string informando se o sistema operacional é Windows ou Linux
     *
     * @note Utilizado na rotina de login para identificar se o usuário está usando Windows ou Linux
     *
     * @example exemplo.get_so.php
     */
    $so = $_SERVER['HTTP_USER_AGENT'];

    if (strstr($so, 'Linux')) {
        return 'Linux';
    } elseif (strstr($so, 'Windows')) {
        return 'Windows';
    } else {
        return 'Não Identificado';
    }
}

###########################################################

function get_browserName() {
    /**
     * Retorna array com informações sobre do browser.
     *
     * @syntax get_browserName();
     *
     * @return array com 2 variávaie: [browser] - com o nome do navegador e [version] - com a versão do browser
     *
     * @note Utilizado na rotina de login para identificar o browser que o usuário está usando
     *
     * @example exemplo.get_browserName.php
     */
    $var = $_SERVER['HTTP_USER_AGENT'];
    $info['browser'] = "OTHER";
    $info['version'] = "";

    // valid brosers array
    $browser = array("MSIE", "OPR", "FIREFOX", "VIVALDI", "CHROME", "SAFARI");

    // bots = ignore
    $bots = array('GOOGLEBOT', 'MSNBOT', 'SLURP');

    foreach ($bots as $bot) {
        // if bot, returns OTHER
        if (strpos(strtoupper($var), $bot) !== false) {
            return $info;
        }
    }

    // loop the valid browsers
    foreach ($browser as $parent) {
        $s = strpos(strtoupper($var), $parent);
        $f = $s + strlen($parent);
        $version = preg_replace('/[^0-9,.]/', '', substr($var, $f, 5));
        if (strpos(strtoupper($var), $parent) !== false) {
            $info['browser'] = $parent;
            $info['version'] = $version;
            return $info;
        }
    }
    return $info;
}

###########################################################

function get_nomeMes($numero = null) {
    /**
     * Retorna o nome do mês cujo número foi informado
     *
     * @syntax get_nomeMes([$mes]);
     *
     * @category Data
     *
     * @return string com o nome do mês
     *
     * @param $mes integer null Número inteiro entre 1 e 12 representando um mês do ano.
     *
     * @note Está função deverá der removida pois o sistema já conta o array $mes iniciado na configuração do sistema que já fornece essa informação.
     *
     * @example exemplo.get_nomeMes.php
     */
    # Verifica se numero é nulo
    if (is_null($numero)) {
        $numero = date('m');
    }

    # Valida o número do mês
    if (($numero > 12) OR ($numero < 1)) {
        return "ERRO !! - Mês Inexistente";
    } else {
        # Cria array dos meses
        $mes = array(array("1", "Janeiro"),
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

        return $mes[$numero - 1][1];
    }
}

###########################################################

function get_nomeMesAno($mesAno) {
    /**
     * Retorna o nome do mês e ano informando a string no formato MM/AAAA
     *
     * @syntax get_nomeMesAno([$mesAno]);
     *
     * @category Data
     *
     * @return string com o nome do mês / ano
     *
     * @param $mesAno string null string no formato MM/AAAA
     *
     * @note Está função foi criada para rotina da área de férias por ano de fruição.
     *
     * @example exemplo.get_nomeMesAno.php
     */
    # Divide o mes e ano
    $partes = explode("/", $mesAno);

    # Pega os valores
    $numero = $partes[0];
    $ano = $partes[1];

    # Valida o número do mês
    if (($numero > 12) OR ($numero < 1)) {
        return "ERRO !! - Mês Inexistente";
    } else {
        # Cria array dos meses
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

        return $mes[$numero - 1][1] . " / " . $ano;
    }
}

###########################################################

function retiraAspas($texto) {
    /**
     * Retorna a string sem as aspas simples e duplas.
     *
     * @syntax retiraAspas($texto);
     *
     * @return string do texto sem as aspas
     *
     * @note Esta função é o conjunto de 2 funções em php e foi criada para facilitar o código.
     * @note Função muito útil para se evitar problemas ao exibir textos.
     *
     * @param $texto string null O texto a ser trabalhado.
     *
     * @example exemplo.retiraAspas.php
     */
    # Verifica se veio o texto
    if (empty($texto)) {
        return null;
    } else {
        $troca1 = str_replace("'", '"', $texto);
        $parametro = str_replace('"', '', $troca1);
        return $parametro;
    }
}

###########################################################

function destaque($texto, $destaque) {
    /**
     * Retorna uma string com um trecho em destaque (bold).
     *
     * @syntax bold($texto, $destaque);
     *
     * @return string do texto com o trecho em destaque
     *
     * @note Retorna o texto principar com o trecho em maiúsculas e em destaque.
     * @note Usado na rotina de pesquisa para destacar o item pesquisado.
     * @note Quando o trecho para destacar não possui acento e o texto principal possui a palavra não é destacada.
     *
     * @param $texto    string null O texto principal de onde existe o trecho a ser destacado.
     * @param $destaque string null O trecho do texto principal a ser destacado.
     *
     * @example exemplo.bold.php
     */
    # Cria uma variável do destaque sem acento
    $destaqueSAcento = retiraAcento($destaque);

    # Cria um array com todas as possibilidades possíveis
    $arrayBusca = [
        $destaque,
        $destaqueSAcento,
        mb_strtolower($destaque),
        mb_strtolower($destaqueSAcento),
        plm(mb_strtolower($destaque)),
        plm(mb_strtolower($destaqueSAcento)),
    ];

    # Cria um array de substituição para a string com o ressaltado
    $arraySub = [
        "<span id='ressaltado' class='warning label'>" . mb_strtoupper($destaque) . "</span>",
        "<span id='ressaltado' class='warning label'>" . mb_strtoupper($destaqueSAcento) . "</span>",
        "<span id='ressaltado' class='warning label'>" . mb_strtoupper($destaque) . "</span>",
        "<span id='ressaltado' class='warning label'>" . mb_strtoupper($destaqueSAcento) . "</span>",
        "<span id='ressaltado' class='warning label'>" . mb_strtoupper($destaque) . "</span>",
        "<span id='ressaltado' class='warning label'>" . mb_strtoupper($destaqueSAcento) . "</span>"
    ];

    # Faz o texto ressaltado ficar em bold no texto
    return str_replace($arrayBusca, $arraySub, $texto);
}

############################################################

function del($texto) {
    /**
     * Retorna uma string com um trecho em tachado (del em html).
     *
     * @syntax del($texto, $destaque);
     *
     * @return string do texto tachado
     *
     * @param $texto    string null O a ser tachado
     *
     * @example exemplo.del.php
     */
    return "<del>" . $texto . "</del";
}

############################################################

function bold($texto) {
    /**
     * Retorna uma string com um trecho em negrito (bold em html).
     *
     * @syntax bold($texto);
     *
     * @return string do texto em negrito
     *
     * @param $texto    string null O a ser negritado
     */
    return "<b>{$texto}</b>";
}

###########################################################

function retiraAcento($texto) {
    /**
     * Retorna uma string sem acentos.
     *
     * @syntax retiraAcento($texto);
     *
     * @return string do texto com as letras acentuadas trocadas pela mesma letra sem acento.
     *
     * @param $texto string O texto acentuado.
     *
     * @example exemplo.retiraAcento.php
     */
    $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
        , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
    $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
        , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");

    return str_replace($array1, $array2, $texto);
}

###########################################################

function soNumeros($texto) {
    /**
     * Retorna somente os números de uma string
     *
     * @syntax soNumeros($texto);
     *
     * @return integer com os número contidos na string
     *
     * @note Usado para garantir que somente número sejam digitados.
     *
     * @param $texto string null O string a ser trabalhado.
     *
     * @example exemplo.soNumeros.php
     */
    if (is_null($texto)) {
        return null;
    } else {
        return preg_replace("/[^0-9]/", "", $texto);
    }
}

###########################################################

function abreDiv($nome) {
    /**
     * Torna visível uma div que está oculta (abre).
     *
     * @syntax abreDiv($nome);
     *
     * @note Esta função apenas executa a função homônima em jscript
     *
     * @param $nome string null O id da div a ser exibida.
     *
     * @deprecated
     */
    echo '<script>abreDiv("' . $nome . '");</script>';
}

###########################################################

function moedaExtenso($valor = 0, $maiusculas = false) {
    /**
     * Retorna escrito por extenso o número fornecido em valores monetários (REAIS).
     *
     * @syntax moedaExtenso($valor, [$maiusculas]);
     *
     * @return string Texto com o número em extenso em formato monetário.
     *
     * @note Usado para fornecer, por extenso, o valor monetário (dinheiro) de alguma transação.
     *
     * @param $valor      string  null O valor a ser transformado.
     * @param $maiusculas boolean Quando true as primeiras letras são maiúsculas.
     *
     * @example exemplo.moedaExtenso.php
     */
    $singular = array("centavo", "real", "mil", "milh�o", "bilh�o", "trilh�o", "quatrilh�o");
    $plural = array("centavos", "reais", "mil", "milh�es", "bilh�es", "trilh�es", "quatrilh�es");

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

    $z = 0;
    $rt = "";

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for ($i = 0; $i < count($inteiro); $i++) {
        for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++) {
            $inteiro[$i] = "0" . $inteiro[$i];
        }
    }

    $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);

    for ($i = 0; $i < count($inteiro); $i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
        $t = count($inteiro) - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";

        if ($valor == "000") {
            $z++;
        } elseif ($z > 0) {
            $z--;
        }

        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) {
            $r .= (($z > 1) ? " de " : "") . $plural[$t];
        }

        if ($r) {
            $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
    }

    if (!$maiusculas) {
        return($rt ? $rt : "zero");
    } else {
        if ($rt) {
            $rt = ereg_replace(" E ", " e ", ucwords($rt));
        }
        return (($rt) ? ($rt) : "Zero");
    }
}

###########################################################

function br($linhas = 1) {
    /**
     * Gera tantos saltos de linha quanto for o nímero fornecido.
     *
     * @syntax br([$linhas]);
     *
     * @param $linhas integer 1 Número de linhas a serem puladas.
     *
     * @note Essa função apenas executa um echo <br/> quantas vezes for $linhas.
     *
     * @example exemplo.br.php
     */
    for ($i = 1; $i <= $linhas; $i++) {
        echo '<br />';
    }
}

###########################################################

function anti_injection($str) {
    /**
     * Função que retira comandos sql de uma string
     *
     * @param $str string null a string a ser tratada
     *
     * @return string sem comandos sql. Caso existam.
     *
     * @note Ainda não está sendo usada. Verificar seu uso em todo get e post.
     *
     * @example exemplo.anti_injection.php
     */
    // remove palavras que contenham sintaxe sql
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|%|\\\\)/"), "", $str);
    return trim(strip_tags(addslashes($sql)));
}

###########################################################

function hr($id = null) {
    /**
     * Insere uma linha
     *
     * @param $id string null a id do hr para o css
     *
     * @syntax hr();
     *
     * @note Essa função apenas executa um echo <hr>
     *
     * @example exemplo.hr.php
     */
    echo '<hr';

    if (!is_null($id)) {
        echo ' id="' . $id . '"';
    }

    echo '>';
}

###########################################################

function alert($mensagem) {
    /**
     * Abre uma janela popup com uma mensagem de alert
     *
     * @syntax alert($mensagem);
     *
     * @param $mensagem string null A mensagem a ser exibida.
     */
    echo '<script>alert("' . $mensagem . '");</script>';
}

###########################################################

function p($mensagem = null, $id = null, $class = null, $title = null) {
    /**
     * Exibe uma mensagem.
     *
     * @syntax p($mensagem, [$id], [$class], [$title]);
     *
     * @note Essa função chama a tag p do html.
     *
     * @param $mensagem string null A mensagem a ser exibida.
     * @param $id       string null O id para o css.
     * @param $class    string null A classe para o css.
     * @param $title    string null A title do texto.
     *
     * @example exemplo.p.php
     */
    if (empty($mensagem)) {
        return null;
    } else {
        echo '<p';

        # id
        if (!is_null($id)) {
            echo ' id="' . $id . '"';
        }

        # class
        if (!is_null($class)) {
            echo ' class="' . $class . '"';
        }

        # title
        if (!is_null($title)) {
            echo ' title="' . $title . '"';
        }

        echo '>';
        echo $mensagem;
        echo '</p>';
    }
}

###########################################################

function titulo($mensagem = null, $title = null) {
    /**
     * Exibe um texto centralizado dentro de um painel com fundo azul escuro. Utilizado para títulos de páginas.
     *
     * @syntax titulo($mensagem, [$title]);
     *
     * @param $titulo string null O Título a ser exibido
     *
     * @example exemplo.titulo.php
     */
    if (is_null($title)) {
        $title = $mensagem;
    }

    # cria a div
    $div = new Div("titulo");
    $div->set_title($title);
    $div->abre();
    echo $mensagem;
    $div->fecha();
}

###########################################################

function titulo2($mensagem = null, $title = null) {
    /**
     * Exibe um texto centralizado dentro de um painel com fundo azul escuro. Utilizado para títulos de páginas.
     *
     * @syntax titulo($mensagem, [$title]);
     *
     * @param $titulo string null O Título a ser exibido
     *
     * @example exemplo.titulo.php
     */
    if (is_null($title)) {
        $title = $mensagem;
    }

    # cria a div
    $div = new Div("titulo2");
    $div->set_title($title);
    $div->abre();
    echo $mensagem;
    $div->fecha();
}

###########################################################

function tituloTable($mensagem = null, $title = null) {
    /**
     * Exibe um texto centralizado dentro de um painel com fundo igual ao titulo da tabela
     *
     * @syntax titulo($mensagem, [$title]);
     *
     * @param $titulo string null O Título a ser exibido
     *
     * @example exemplo.titulo.php
     */
    if (is_null($title)) {
        $title = $mensagem;
    }

    # cria a div
    $div = new Div("tituloTable");
    $div->set_title($title);
    $div->abre();
    echo $mensagem;
    $div->fecha();
}

###########################################################

function botaoVoltar($url, $label = 'Voltar', $title = 'Volta para a página anterior') {
    /**
     * Rotina que exibe o botão de Voltar
     *
     * @syntax botaoVoltar($url, [$label], [$title] );
     *
     * @param $url   string null     A url do botão
     * @param $label string	'Voltar' O texto que aparecerá no botão
     * @param $title string TEXTO    A mensagem no mouseover
     */
    # Botão voltar
    $grid = new Grid();
    $grid->abreColuna(12);
    $menu = new MenuBar();

    # Botão Administração
    $linkBotaoVoltar = new Button($label);
    $linkBotaoVoltar->set_title($title);
    $linkBotaoVoltar->set_url($url);
    if ($label == 'Voltar') {
        $linkBotaoVoltar->set_accessKey('V');
    }
    $menu->add_link($linkBotaoVoltar, "left");

    $menu->show();

    $grid->fechaColuna();
    $grid->fechaGrid();
}

###########################################################

function aguarde($texto = null, $tamanho = 90) {

    /**
     * Rotina que exibe uma animação sugerindo aguardar alguma tarefa ser concluída.
     *
     * @syntax aguarde();
     *
     * @example exemplo.aguarde.php
     */
    # Monta a div com a animação
    $div = new Div("center");
    $div->abre();
    br();
    $Imagem = new Imagem(PASTA_FIGURAS_GERAIS . 'carregando.gif', 'Aguarde', $tamanho, $tamanho);
    $Imagem->show();

    if (!is_null($texto)) {
        br(2);
        p($texto, "center");
    }
    $div->fecha();
}

###########################################################

function formataMoeda($valor, $formato = 1) {
    /**
     * Função que retorna um valor no formato especificado
     *
     * @syntax formataMoeda($valor,[$formato]);
     *
     * @return string do valor em formato de moeda no padrão indicado no parâmetro $formato.
     *
     * @note Observe que o formato do parâmetro valor será entendido como o formato inverso ao indicado no parâmetro formato.
     * @note Assim quando não for informado o formato o sistema irá entender que o valor que será inserido é o formato americano e será transformado para o formato brasileiro.
     * @note Da mesma forma que quando o parâmetro formato for informado com 2. Entender-se-á que o formato do parâmetro $valor é o brasileiro e será convertido para o formato americano.
     *
     * @param $valor   string  null O valor a ser alterado
     * @param $formato integer 1    O formato sendo: 1 - formato brasileiro | 2 - formato americano para gravação no bd
     *
     * @example exemplo.formataMoeda.php
     */
    if (is_null($valor)) {
        return null;
    } else {
        if ($formato == 1) {
            # Formato americano para o brasileiro
            $moeda = number_format($valor, 2, ',', '.');
        } else {
            # Formato brasileiro para o americano
            $moeda = str_replace(".", "", $valor);
            $moeda = str_replace(",", ".", $moeda);
        }
        return $moeda;
    }
}

###########################################################

function formataMoeda2($valor) {
    /**
     * Função que retorna um valor no formato especificado
     *
     * @syntax formataMoeda($valor,[$formato]);
     *
     * @return string do valor em formato de moeda no padrão indicado no parâmetro $formato.
     *
     * @note Observe que o formato do parâmetro valor será entendido como o formato inverso ao indicado no parâmetro formato.
     * @note Assim quando não for informado o formato o sistema irá entender que o valor que será inserido é o formato americano e será transformado para o formato brasileiro.
     * @note Da mesma forma que quando o parâmetro formato for informado com 2. Entender-se-á que o formato do parâmetro $valor é o brasileiro e será convertido para o formato americano.
     *
     * @param $valor   string  null O valor a ser alterado
     * @param $formato integer 1    O formato sendo: 1 - formato brasileiro | 2 - formato americano para gravação no bd
     *
     * @example exemplo.formataMoeda.php
     */
    if (empty($valor)) {
        return "R$ 0,00";
    } else {
        return "R$ " . number_format($valor, 2, ',', '.');
    }
}

###########################################################

function formataNumLinha($numero) {
    /**
     * Tabula a exibição de números Para exibição na rotina que lista códigos.
     *
     * @syntax formataNumLinha($numero);
     *
     * @param $numero string null O número da linha a ser formatada.
     *
     * @note Um exemplo dessa formatação poderá ser vista clicando no botão código desta página.
     */
    # Tamanho do numero
    $tamanho = strlen($numero);

    # Tamanho que deveria ter
    $tamanhoIdeal = 4;

    # Calcula a quantidade de espaços para alcançar o tamanho correto;
    $quantidadeEspaco = $tamanhoIdeal - $tamanho;

    # Monta a string
    $numero = str_repeat(" ", $quantidadeEspaco) . $numero;

    return $numero;
}

###########################################################

function callout($mensagem, $tipo = "warning", $id = "funcaoCallout") {
    /**
     * Exibe um painel contendo uma mensagem.
     *
     * @note Essa função é uma alternativa a função alert e utiliza a classe homônima.
     * @note Foi criada para facilitar o código quando se quer somente exibir uma mensagem dentro de um painel colorido.
     * @note Utiliza a funcionalidade callout do Foundation
     *
     * @param $mensagem string null    A mensagem a ser exibida
     * @param $tipo     string warning O tipo do callout: secondary | primary | success | warning | alert
     *
     * @syntax callout($mensagem, [$tipo]);
     *
     * @example exemplo.callout.php
     */
    # Verifica se não está vazio
    if (!vazio($mensagem)) {

        # Chama a classe callout
        $callout = new Callout($tipo);
        $callout->abre();

        # Verifica se é diversas mensagens
        if (is_array($mensagem)) {
            foreach ($mensagem as $mm) {
                p($mm, $id);
            }
        } else {
            p($mensagem, $id);
        }

        $callout->fecha();
    }
}

###########################################################

function calloutAlert($mensagem, $titulo = null, $tipo = "alert") {
    /**
     * Exibe um painel contendo um alerta
     *
     * @note Essa função é uma alternativa a função alert e utiliza a classe homônima.
     * @note Foi criada para facilitar o código quando se quer somente exibir uma mensagem dentro de um painel colorido.
     * @note Utiliza a funcionalidade callout do Foundation
     *
     * @param $mensagem string null    A mensagem a ser exibida
     * @param $tipo     string warning O tipo do callout: secondary | primary | success | warning | alert
     *
     * @syntax callout($mensagem, [$tipo]);
     *
     * @example exemplo.callout.php
     */
    # Verifica se não está vazio
    if (!vazio($mensagem)) {

        # Coloca um título (se tiver)
        if (!empty($titulo)) {
            tituloTable($titulo);
        }

        # Chama a classe callout
        $callout = new Callout($tipo);
        $callout->abre();

        # Verifica se é diversas mensagens
        if (is_array($mensagem)) {
            foreach ($mensagem as $mm) {
                p($mm, "center");
            }
        } else {
            p($mensagem, "center");
        }

        $callout->fecha();
    }
}

###########################################################

function label($mensagem, $tipo = "warning", $id = null, $title = null) {
    /**
     * Cria uma mensagem com fundo colorido.
     *
     * @note Utiliza a funcionalidade label do Foundation
     *
     * @param $mensagem string null    A mensagem a ser exibida:
     * @param $tipo     string warning O tipo: secondary | primary | success | warning | alert
     * @param $id       string null    O id para o css
     * @param $title    string null    O texto para o mouseover
     *
     * @syntax label($mensagem, [$tipo], [$id], [$title]);
     *
     * @example exemplo.label.php
     */
    # Trata o title
    if (empty($title)) {
        $title = $mensagem;
    }

    span($mensagem, $id, "label {$tipo}", $title);
}

###########################################################

function badge($mensagem, $tipo = "warning", $id = null, $title = null) {
    /**
     * Semelhante a função label mas com bordas arredondadas
     *
     * @note É indicado quando se quer chamar atenção para um ou dois caracteres no máximo.
     * @note Os caracteres ficam dentro de um círculo. Com palavras de mais de 2 caracteres o efeito não é bom.
     * @note Utiliza a funcionalidade badge do Foundation
     *
     * @param $mensagem string null    A mensagem a ser exibida
     * @param $tipo     string warning O tipo: secondary | primary | success | warning | alert
     * @param $id       string null    O id para a função P usada na impressão da memsagem.
     * @param $title    string null    Mensagem para o mouseover
     *
     * @syntax badge($mensagem, [$tipo], [$id], [$title]);
     *
     * @example exemplo.badge.php
     */
    span($mensagem, $id, "badge {$tipo}", $title);
}

###########################################################

function toolTip($word, $title) {
    /**
     * Cria uma palavre com title diferente
     *
     * @note É indicado quando se quer dar uma descrição mais detalhada sobre uma palavra
     * @note Utiliza a funcionalidade tooltip do Foundation
     *
     * @param $word  string null    A palavra que será destacada
     * @param $title string null    Mensagem para o mouseover
     *
     * @syntax toolTip($word, $title);
     */
    echo "<span data-tooltip title='{$title}'>{$word}</span>";
}

##########################################################

function span($mensagem, $id = null, $class = null, $title = null) {
    /**
     * Cria um span com uma mensagem.
     *
     * @note Função criada para facilitar a escrita do código.
     * @note Apenas monta um elemento span com uma mensagem dentro.
     * @note Só tem utilidade quando está vinculado a alguma formatação css.
     *
     * @param $mensagem string null    A mensagem a ser exibida:
     * @param $id       string null    O id para o css.
     * @param $class    string null    A classe para o css.
     * @param $title    string null    O title para o mouseover.
     *
     * @syntax span($mensagem, [$id], [$class], [title]);
     */
    echo '<span';

    # id
    if (!is_null($id)) {
        echo ' id="' . $id . '"';
    }

    # class
    if (!is_null($class)) {
        echo ' class="' . $class . '"';
    }

    # title
    if (!is_null($title)) {
        echo ' title="' . $title . '"';
    }

    echo '>';
    echo $mensagem;
    echo '</span>';
}

###########################################################

function validaData($data) {
    /**
     * Verifica se uma data é válida ou não retorna true or false
     *
     * @return bool true (1) para datas válidas e false (0) para as inválidas.
     *
     * @category Data
     *
     * @param $data string null A data a ser validada no formato brasileiro
     *
     * @note Essa função é uma melhoria da função checkdate do php.
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @syntax validaData($data);
     *
     * @example exemplo.validaData.php
     */
    # Verifica se a data foi enviada
    if (empty($data)) {
        return false;
    }

    # Verifica se o tamanho da data é menor que 8
    if (strlen($data) < 8) {
        return false;
    } else {
        # Verifica se a data possui a barra (/) de separação
        if (strpos($data, "/") !== false) {
            $partes = explode("/", $data);

            # pega o dia da data
            $dia = $partes[0];
            # pega o mês da data
            $mes = $partes[1];

            # prevenindo Notice: Undefined offset: 2
            # caso informe data com uma única barra (/)
            $ano = intval(isset($partes[2]) ? $partes[2] : 0);

            if ($mes == "00") {
                return false;
            }

            if ($dia == "00") {
                return false;
            }

            if (strlen($ano) < 4) {
                return true;
            } else {
                # verifica se a data é válida
                if (checkdate($mes, $dia, $ano)) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}

###########################################################

function addDias($data = null, $dias = 0, $primeiroDia = true) {
    /**
     * Adiciona dias a uma data
     *
     * @syntax addDias($data,$dias,[$primeiroDia]);
     *
     * @category Data
     *
     * @return date acrescida dos dias.
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     * @note Se o terceiro parâmetro estiver true, o primeiro dia será contado, senão a contagem começará apartir do dia seguinte.
     * @note Se os dias estiverem negativos o valor será subtraído.
     *
     * @param $data        string  null A data inicial
     * @param $dias        integer 0    O número de dias a serem adicionados
     * @param $primeiroDia bool    true Se inclui o primeiro dia ou não
     *
     * @example exemplo.addDias.php
     */
    if ($primeiroDia) {
        $dias--;
    }

    # Verifica se data é nula
    if (empty($data)) {
        return null;
    } else {
        if (validaData($data)) {
            $dia = substr($data, 0, 2);
            $mes = substr($data, 3, 2);
            $ano = substr($data, 6, 4);
            $dataFinal = date('d/m/Y', mktime(24 * $dias, 0, 0, $mes, $dia, $ano));
            return $dataFinal;
        } else {
            alert('Data Inválida');
            return false;
        }
    }
}

###########################################################

function entre($data, $dtInicial, $dtFinal) {
    /**
     * Verifica se a data está entre duas datas.
     *
     * @syntax entre($data,$dtInicial,$dtFinal);
     *
     * @category Data
     *
     * @return bool true para confirmar e false para negar
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @param $data      date null A data a ser verificada.
     * @param $dtInicial date null A data inicial do período.
     * @param $dtFinal   date null A data final do período.
     *
     * @example exemplo.entre.php
     */
    if (validaData($data)) {
        if ((date_to_bd($data) < date_to_bd($dtInicial)) or (date_to_bd($data) > date_to_bd($dtFinal))) {
            return false;
        } else {
            return true;
        }
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function jaPassou($data) {
    /**
     * Verifica se a data já passou da data atual
     *
     * @syntax jaPassou($data);
     *
     * @category Data
     *
     * @return bool true para confirmar e false para negar
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @param $data      date null A data a ser verificada.
     *
     * @example exemplo.jaPassou.php
     */
    if (validaData($data)) {
        if (date("Y-m-d") > date_to_bd($data)) {
            return true;
        } else {
            return false;
        }
    } else {
        alert('Data Inválida: ' . $data);
        return false;
    }
}

###########################################################

function eHoje($data) {
    /**
     * Verifica se a data é hoje
     *
     * @syntax eHoje($data);
     *
     * @category Data
     *
     * @return bool true para confirmar e false para negar
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @param $data      date null A data a ser verificada.
     *
     */
    if (validaData($data)) {
        if (date("Y/m/d") == date_to_bd($data)) {
            return true;
        } else {
            return false;
        }
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function dataDif($dataInicial, $dataFinal = null) {
    /**
     * Informa, em dias, o período entre duas datas
     *
     * @param $dataInicial date null  A data inicial do período.
     * @param $dataFinal   date null  A data final do período. Se for nula usa-se a data atual.
     *
     * @syntax dataDif($dataInicial,[$dataFinal]);
     *
     * @category Data
     *
     * @return integer Números de dias do intervalo entre as datas
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     * @note Se o parâmetro $dataFimal não for informado, a função pegará a data atual.
     * @note Essa função funciona com diária de um hotel, não considera a data final (ou inicial). Se não seseja dessa forma acrescente +1 ao resultado.
     *
     * @example exemplo.dataDif.php
     */
    # Se for nula coloca a data atual
    if (is_null($dataFinal)) {
        $dataFinal = date("d/m/Y");
    }

    # Verifica a validade das datas
    if ((validaData($dataInicial)) AND (validaData($dataFinal))) {

        # Passa para o padrão americano
        $dataInicial = date_to_bd($dataInicial);
        $dataFinal = date_to_bd($dataFinal);

        # Cria um timestamp
        $time_inicial = strtotime($dataInicial);
        $time_final = strtotime($dataFinal);

        # Calcula a diferença de segundos entre as duas datas:
        $diferenca = $time_final - $time_inicial;

        # Calcula a diferença de dias
        $dias = (int) floor($diferenca / (60 * 60 * 24));

        return $dias;
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function dataExtenso($data = null) {
    /**
     * Exibe a data por extenso no formato [dia], de [mês] de [Ano]
     *
     * @param $data	date null A data a ser transformada
     *
     * @return string A data por extenso no formato [dia], de [mês] de [Ano]
     *
     * @syntax dataExtenso([$data]);
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @example exemplo.dataExtenso.php
     */
    # Verifica a validade da data
    if (validaData($data)) {

        # Divide a data em dia, mes e ano
        $dt = explode('/', $data);

        # pega o mês
        $mes = get_nomeMes($dt[1]);

        $dataExtenso = $dt[0] . ' de ' . $mes . ' de ' . $dt[2];

        return $dataExtenso;
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function dataExtenso2($data = null) {
    /**
     * Exibe a data por extenso todo em texto
     *
     * @param $data	date null A data a ser transformada
     *
     * @return string A data por extenso totalmente em palavras
     *
     * @syntax dataExtenso2([$data]);
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @example exemplo.dataExtenso.php
     */
    # Verifica a validade da data
    if (validaData($data)) {

        # Divide a data em dia, mes e ano
        $dt = explode('/', $data);

        # Transforma em numero
        $dt[0] = intval($dt[0]);
        $dt[1] = intval($dt[1]);
        $dt[2] = intval($dt[2]);

        # Inicia variaveis
        $inicio = null;
        $dataExtenso = null;

        # pega o mês
        $mes = strtolower(get_nomeMes($dt[1]));

        # Inicio do texto
        switch ($dt[0]) {
            case 1:
                $inicio = "Ao primeiro dia";
                break;
            case 2:
                $inicio = "Ao segundo dia";
                break;
            case 3:
                $inicio = "Ao terceiro dia";
                break;
            case 4:
                $inicio = "Ao quarto dia";
                break;
            case 5:
                $inicio = "Ao quinto dia";
                break;
            default:
                $inicio = "Aos " . numero_to_letra($dt[0]) . " dias";
                break;
        }

        $dataExtenso = $inicio . ' de ' . $mes . ' de ' . numero_to_letra(intval($dt[2]));

        return $dataExtenso;
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function numero_to_letra($number) {
    /**
     * Converte um numero para palavra (extenso)
     *
     * @param $number integer null O numero a ser tratado
     *
     * @return string A palavra
     *
     * @syntax numero_to_letra($number);
     */
    $hyphen = '-';
    $conjunction = ' e ';
    $separator = ', ';
    $negative = 'menos ';
    $decimal = ' ponto ';
    $dictionary = array(
        0 => 'zero',
        1 => 'um',
        2 => 'dois',
        3 => 'três',
        4 => 'quatro',
        5 => 'cinco',
        6 => 'seis',
        7 => 'sete',
        8 => 'oito',
        9 => 'nove',
        10 => 'dez',
        11 => 'onze',
        12 => 'doze',
        13 => 'treze',
        14 => 'quatorze',
        15 => 'quinze',
        16 => 'dezesseis',
        17 => 'dezessete',
        18 => 'dezoito',
        19 => 'dezenove',
        20 => 'vinte',
        30 => 'trinta',
        40 => 'quarenta',
        50 => 'cinquenta',
        60 => 'sessenta',
        70 => 'setenta',
        80 => 'oitenta',
        90 => 'noventa',
        100 => 'cento',
        200 => 'duzentos',
        300 => 'trezentos',
        400 => 'quatrocentos',
        500 => 'quinhentos',
        600 => 'seiscentos',
        700 => 'setecentos',
        800 => 'oitocentos',
        900 => 'novecentos',
        1000 => 'mil',
        1000000 => array('milhão', 'milhões'),
        1000000000 => array('bilhão', 'bilhões'),
        1000000000000 => array('trilhão', 'trilhões'),
        1000000000000000 => array('quatrilhão', 'quatrilhões'),
        1000000000000000000 => array('quinquilhão', 'quinquilhões')
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
                'convert_number_to_words só aceita números entre ' . PHP_INT_MAX . ' à ' . PHP_INT_MAX,
                E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . numero_to_letra(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $conjunction . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = floor($number / 100) * 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds];
            if ($remainder) {
                $string .= $conjunction . numero_to_letra($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            if ($baseUnit == 1000) {
                $string = numero_to_letra($numBaseUnits) . ' ' . $dictionary[1000];
            } elseif ($numBaseUnits == 1) {
                $string = numero_to_letra($numBaseUnits) . ' ' . $dictionary[$baseUnit][0];
            } else {
                $string = numero_to_letra($numBaseUnits) . ' ' . $dictionary[$baseUnit][1];
            }
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= numero_to_letra($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

###########################################################

function addMeses($data, $meses) {
    /**
     * Adiciona meses a uma data
     *
     * @syntax addMeses($data,$meses);
     *
     * @return date A data acrescida dos meses.
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     * @note Se o parâmetro meses for negativo a data será retroagida.
     *
     * @param $data  string  null A data inicial
     * @param $meses integer null A quantidade de meses a serem adicionados
     *
     * @example exemplo.addMeses.php
     */
    if (validaData($data)) {

        # Divide a data em dia, mes e ano
        $dt = explode('/', $data);

        $dataFinal = date('d/m/Y', mktime(0, 0, 0, $dt[1] + $meses, $dt[0], $dt[2]));
        return $dataFinal;
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function addAnos($data, $anos) {
    /**
     * Função que adiciona anos a uma data
     *
     * @syntax addAnos($data,$anos);
     *
     * @return date A data acrescida dos anos.
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     * @note Se o parâmetro $anos for negativo a data será retroagida.
     *
     * @param $data string  null A data inicial
     * @param $anos integer null A quantidade de anos a serem adicionados
     *
     * @example exemplo.addAnos.php
     */
    if (validaData($data)) {

        # Divide a data em dia, mes e ano
        $dt = explode('/', $data);

        $dataFinal = date('d/m/Y', mktime(0, 0, 0, $dt[1], $dt[0], $dt[2] + $anos));
        return $dataFinal;
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function vazio($var) {
    /**
     * Verifica se o valor da variável é vazio ou nulo
     *
     * @syntax vazio($var);
     *
     * @return true or false
     *
     * @param $var 	string	null A variavel a ser validada
     *
     * @note Observe que a função somente retornará true se o valor for null ou "". Se houver algum outro dado será retornado false
     *
     * @example exemplo.vazio.php
     */
    if (is_array($var)) {
        if (is_null($var) OR ($var == '')) {
            return true;
        }
    } else {
        if (is_null($var) OR (trim($var) == '')) {
            return true;
        }
    }
}

###########################################################

function get_mac($ip) {
    /**
     * Informa o valor do número MAC de um IP
     *
     * @syntax get_Mac($ip);
     *
     * @return string com o MAC do computador
     *
     * @param $ip string null O IP do computador
     */
    $arp = null;
    exec("arp " . $ip . " -a", $arp);             // Executa o comando arp que pega na rede o mac de um ip
    $posicao = strpos($arp[3], "-");        // Do texto extraído pega o numero mac pelo traço
    $posicao = $posicao - 2;                // Volta 2 caracteres para pegar o início do mac
    $mac = substr($arp[3], $posicao, 17);   // Extrai os 17 caracteres do mac
    return $mac;
}

###########################################################

function validaCpf($cpf) {
    /**
     * Rotina de validação do CPF
     *
     * @syntax validaCpf($cpf);
     *
     * @return true or false
     *
     * @param $cpf 	string	null O CPF a ser validado
     *
     * @example exemplo.validaCpf.php
     */
    # Verifica se temos cpf
    if (empty($cpf)) {
        return false;
    }

    # Retira os caracteres . e -
    $cpf = str_replace('.', '', $cpf);
    $cpf = str_replace('-', '', $cpf);

    # Verifica se o tamanho do CPF é de 
    if (strlen($cpf) <> 11) {
        return false;
    }

    # Verifica é somente número
    if (!is_numeric($cpf)) {
        return false;
    }

    # Verifica números que pelo padrão normal dão como válidos
    if (($cpf == '11111111111') || ($cpf == '22222222222') || ($cpf == '33333333333') || ($cpf == '44444444444') ||
            ($cpf == '55555555555') || ($cpf == '66666666666') || ($cpf == '77777777777') || ($cpf == '88888888888') ||
            ($cpf == '99999999999') || ($cpf == '00000000000')) {
        $status = false;
    } else {
        $dv_informado = substr($cpf, 9, 2); // pega o digito verificador

        for ($i = 0; $i <= 8; $i++) {
            $digito[$i] = substr($cpf, $i, 1);
        }

        # CALCULA O VALOR DO 10º DIGITO DE VERIFICAÇÂO
        $posicao = 10;
        $soma = 0;

        for ($i = 0; $i <= 8; $i++) {
            $soma = $soma + $digito[$i] * $posicao;
            $posicao = $posicao - 1;
        }

        $digito[9] = $soma % 11;

        if ($digito[9] < 2) {
            $digito[9] = 0;
        } else {
            $digito[9] = 11 - $digito[9];
        }

        # CALCULA O VALOR DO 11º DIGITO DE VERIFICAÇÃO
        $posicao = 11;
        $soma = 0;

        for ($i = 0; $i <= 9; $i++) {
            $soma = $soma + $digito[$i] * $posicao;
            $posicao = $posicao - 1;
        }

        $digito[10] = $soma % 11;

        if ($digito[10] < 2) {
            $digito[10] = 0;
        } else {
            $digito[10] = 11 - $digito[10];
        }

        # VERIFICA SE O DV CALCULADO É IGUAL AO INFORMADO
        $dv = $digito[9] * 10 + $digito[10];
        if ($dv != $dv_informado) {
            $status = false;
        } else {
            $status = true;
        }
    }

    return $status;
}

###########################################################

function idade($dataNascimento) {
    /**
     * Rotina que calcula a idade a partir de uma data de nascimento
     *
     * @syntax idade($dataNascimento);
     *
     * @return integer
     *
     * @param $dataNascimento date	null A data de nascimento no formato dd/mm/aaaa
     */
    # Verifica se data é válida
    if (is_null($dataNascimento)) {
        alert("Data em branco");
        return;
    } else {
        if (!validaData($dataNascimento)) {
            alert("Data inválida");
        } else {
            // Separa em dia, mês e ano
            list($dia, $mes, $ano) = explode('/', $dataNascimento);

            // Descobre que dia é hoje e retorna a unix timestamp
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            // Descobre a unix timestamp da data de nascimento do fulano
            $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

            // Depois apenas fazemos o cálculo já citado :)
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
            return $idade;
        }
    }
}

###########################################################

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
    /**
     * Rotina que gera uma senha forte
     *
     * @author Thiago Belem <contato@thiagobelem.net>
     *
     * @syntax geraSenha([$tamanho],[$maiusculas],[$numeros],[$simbolos]);
     *
     * @return Uma string contendo uma senha criada de forma aleatória
     *
     * @param   $tamanho    integer  8      O tamanho da string gerada
     * @param   $maiusculas boolean true    Quando true gera senha também com letras maiusculas.
     * @param   $numeros    boolean true    Quando true gera senha também com números.
     * @param   $simbolos   boolean false   Quando true gera senha também com símbolos.
     *
     */
    // Caracteres de cada tipo
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';

    // Variáveis internas
    $retorno = '';
    $caracteres = '';

    // Agrupamos todos os caracteres que poderão ser utilizados
    $caracteres .= $lmin;

    if ($maiusculas) {
        $caracteres .= $lmai;
    }

    if ($numeros) {
        $caracteres .= $num;
    }

    if ($simbolos) {
        $caracteres .= $simb;
    }

    // Calculamos o total de caracteres possíveis
    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {

        // Criamos um número aleatório de 1 até $len para pegar um dos caracteres
        $rand = mt_rand(1, $len);

        // Concatenamos um dos caracteres na variável $retorno
        $retorno .= $caracteres[$rand - 1];
    }
    return $retorno;
}

###########################################################

function year($data) {
    /**
     * Função que retorna o ano de uma data
     *
     * @syntax year($data);
     *
     * @return integer do ano da data fornecida.
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @param $data data null A data a ser trabalhada
     */
    if (validaData($data)) {
        # Divide a data em dia, mes e ano
        $dt = explode('/', $data);
        return substr($dt[2], 0, 4);
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function day($data) {
    /**
     * Função que retorna o dia de uma data
     *
     * @syntax day($data);
     *
     * @return integer do dia da data fornecida.
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @param $data data null A data a ser trabalhada
     */
    if (validaData($data)) {
        # Divide a data em dia, mes e ano
        $dt = explode('/', $data);
        return $dt[0];
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function month($data) {
    /**
     * Função que retorna o mês de uma data
     *
     * @syntax month($data);
     *
     * @return integer do mês da data fornecida.
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @param $data data null A data a ser trabalhada
     */
    if (validaData($data)) {
        # Divide a data em dia, mes e ano
        $dt = explode('/', $data);
        return $dt[1];
    } else {
        alert('Data Inválida');
        return false;
    }
}

###########################################################

function createZip($path = 'arquivo.zip', $files = array()) {
    /**
     * Cria arquivos compactados .zip
     *
     * @syntax createZip($path, files);
     *
     * @author Luiz Otávio Miranda <contato@todoespacoonline.com>
     *
     * @param $path  string arquivo.zip Caminho e o nome do arquivo zip que será criado
     * @param $files array  null        Arquivos que serão adicionados ao zip
     */
    # Cria o arquivo .zip
    $zip = new ZipArchive;
    $zip->open($path, ZipArchive::CREATE);

    # Checa se o array não está vazio e adiciona os arquivos
    if (!empty($files)) {
        # Loop do(s) arquivo(s) enviado(s)
        foreach ($files as $file) {
            # Adiciona os arquivos ao zip criado
            $zip->addFile($file, basename($file));
        }
    }

    # Fecha o arquivo zip
    $zip->close();
}

###########################################################
#  Funções Estatísticas
###########################################################

function media_aritmetica(array $valores) {
    /**
     * Calcula a media de um array de numeros
     *
     * @syntax media_aritmetica($valores);
     *
     * @param $valores array Array de numeros
     * @return number A media dos valores do array
     */
    return array_sum($valores) / count($valores);
}

###########################################################

function maiorValor(array $valores) {
    /**
     * Obtem a maior valor de um array.
     *
     * @syntax maiorValor($valores);
     *
     * @param $valores array null Array de numeros
     * @return number O maior valor do array
     */
    rsort($valores);
    return $valores[0];
}

###########################################################

function menorValor(array $valores) {
    /**
     * Obtem o menor valor de um array.
     *
     * @syntax menorValor($valores);
     *
     * @param $valores array null Array de numeros
     * @return number O menor valor do array
     */
    sort($valores);
    return $valores[0];
}

###########################################################

function arrayToString($valores) {
    /**
     * Transforma um array em uma string com os valores separados por vírgula
     *
     * @param $valores array null Array de valores
     * @return string dos valores separados por vírgulas
     */
    $resultado = null;
    foreach ($valores as $stringArray) {
        $resultado .= $stringArray . ",";
    }

    # Retira a última vírgula
    $size = strlen($resultado);
    $resultado = substr($resultado, 0, $size - 1);

    return $resultado;
}

###########################################################

function arrayPreenche($valorInicial, $valorFinal, $ordem = "c", $salto = 1) {
    /**
     * Preenche um array numérico com uma faixa de valores
     *
     * @param $valorInicial integer null Valor Numérico Inicial
     * @param $valorFinal   integer null Valor Numérico Final
     * @param $ordem        string  c    c -> se for crescente e d-> se for decrescente
     * @return array com os valores preenchidos
     */
    # Inicia o array de retorno
    $resultado = array();

    # Preenche com os valores informados
    if ($ordem == "c") {
        for ($i = $valorInicial; $i <= $valorFinal; $i += $salto) {
            $resultado[] = $i;
        }
    } elseif ($ordem == "d") {
        for ($i = $valorFinal; $i >= $valorInicial; $i -= $salto) {
            $resultado[] = $i;
        }
    }

    return $resultado;
}

###########################################################

function diaSemana($data) {
    /**
     * Informa o dia da dsemana de uma data
     *
     * @param $data data null Data a ser examinada
     * @return string com o dia da semana
     *
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     *
     * @syntax diaSemana($data);
     */
    # Array com os dias da semana
    $dia = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');

    # Passa para o formato americano
    $data = date_to_bd($data);

    # Variavel que recebe o dia da semana (0 = Domingo, 1 = Segunda ...)
    $numero = date('w', strtotime($data));

    # Retorna o dia da semana com o Array
    return $dia[$numero];
}

###########################################################

function codificacao($string) {
    /**
     * Retorna a codificação da string informada
     *
     * @param $string string null A string a ser analisada
     * @return string UTF-8 ou ISO-8859-1
     *
     * @syntax codificacao($string);
     */
    return mb_detect_encoding($string . 'x', 'UTF-8, ISO-8859-1');
}

###########################################################

function dias_to_Ano($dias) {

    /**
     * Transforma uma quantidade grande de dias anos sem arredondar
     *
     * @param $dias integer null O número de dias a ser calculado
     * @return integer com os anos calculados
     *
     * @syntax dias_to_Ano($dias);
     */
    # Inicia as variáveis
    $dias = abs($dias); // retira o sinal de dias
    # Calcula os anos
    if ($dias > 364) {
        return intval($dias / 365);
    } else {
        return 0;
    };
}

###########################################################

function resto($dividendo, $divisor) {

    /**
     * Retorna o resto da divisão de 2 números inteiros
     *
     * @param $dividendo integer null O dividendo
     * @param $divisor   integer null O divisor
     * @return integer o resto da divisão
     *
     * @syntax resto($dividendo,$divisor);
     */
    $resultado = intval($dividendo / $divisor);
    $valor = $resultado * $divisor;
    $resto = $dividendo - $valor;

    return $resto;
}

###########################################################

function trataNulo($valor, $caractere = "---") {

    /**
     * Transforma o valor null ou zero em outro caractere
     *
     * @param  $valor     mixed  null O valor a ser conferido
     * @param  $caractere string --   A string a ser exibida caso o valor informado for zero ou nullo
     * @return mixed O valor ou -- quando o valor for zero ou nullo
     *
     * @syntax trataNulo($valor,[$caractere]);
     */
    # Inicia a variável de retorno
    $retorno = $valor;

    # Verifica se é nulo
    if (empty($valor)) {
        $retorno = $caractere;
    }

    # Verifica se é 0
    if ((is_numeric($valor)) AND ($valor == 0)) {
        $retorno = $caractere;
    }

    return $retorno;
}

###########################################################

function ePar($valor) {

    /**
     * TVerifica se numero e par
     *
     * @param  $valor INTEGER null O valor a ser conferido
     * @return true ou false
     *
     * @syntax ePar($valor);
     */
    # Garante que e inteiro
    $valor = intval($valor);

    # Inicia a variável de retorno
    $retorno = null;

    if ($valor % 2 == 0) {
        $retorno = true;
    } else {
        $retorno = false;
    }

    return $retorno;
}

###########################################################

function plm($texto) {

    /**
     * Passa o texto para minusculas com a primeira letra de cada palavra em maiusculas
     *
     * @param  $texto STRING null O texto a ser transformado
     * @return string O texto modificado
     *
     * @syntax plm($texto);
     */
    return mb_convert_case($texto, MB_CASE_TITLE);
}

###########################################################

function vazioPraNulo($valor = null) {

    /**
     * Passa o valor informado para nulo quando for vazio ou retorna a string enviada
     *
     * @param  $valor STRING null a string a ser tratada
     * @return string a string ou nulo
     *
     * @syntax vazioPraNulo($valor);
     */
    if ($valor == "") {
        $valor = null;
    }

    return $valor;
}

###########################################################

function verificaSobreposicao($dtInicial1, $dtFinal1, $dtInicial2, $dtFinal2) {

    /**
     * Verifica se os períodos estão com sobreposição de dias
     *
     * @param $dtInicial1 DATA    null a data inicial do primeiro período
     * @param $dias1      integer null a quantidade de dias desse período
     * @param $dtInicial2 DATA    null a data inicial do segundo período
     * @param $dias2      integer null a quantidade de dias desse período
     * @return bool                    Retorna true quando houver sobreposição e false quando não tiver
     *
     * @syntax verificaSobreposicao($dtInicial1,$periodo1,$dtInicial2,$periodo2);
     */
    # Inicia o retorno
    $retorno = false;

    # Verifica se data inicial do periodo1 está dentro do periodo2
    if (entre($dtInicial1, $dtInicial2, $dtFinal2)) {
        $retorno = true;
    }

    # Verifica se data final do periodo1 está dentro do periodo2
    if (entre($dtFinal1, $dtInicial2, $dtFinal2)) {
        $retorno = true;
    }

    # Verifica se o período1 "engole" o periodo2
    if ((date_to_bd($dtInicial1) < date_to_bd($dtInicial2)) AND (date_to_bd($dtFinal1) > date_to_bd($dtFinal2))) {
        $retorno = true;
    }

    return $retorno;
}

###########################################################

function dataMaior($data1, $data2) {

    /**
     * Retorna a data maior ou igual (mais recente)
     *
     * @param  $data1 data uma das datas
     * @param  $data2 data a outra datas
     * 
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     * 
     * @return data a data maior
     *
     * @syntax dataMaior($data1, $data2);
     */
    # Passa para formato americano
    $dataAmericano1 = strtotime(date_to_bd($data1));
    $dataAmericano2 = strtotime(date_to_bd($data2));

    # Faz a Comparação
    if ($dataAmericano1 > $dataAmericano2) {
        $dataMaior = $data1;
    } elseif ($dataAmericano1 == $dataAmericano2) {
        $dataMaior = $data1;
    } else {
        $dataMaior = $data2;
    }

    return $dataMaior;
}

###########################################################

function dataMenor($data1, $data2) {

    /**
     * Retorna a data menor - Data mais recente Futura
     *
     * @param  $data1 data uma das datas
     * @param  $data2 data a outra datas
     * 
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     * 
     * @return data a data maior
     *
     * @syntax dataMaior($data1, $data2);
     */
    # Passa para formato americano
    $dataAmericano1 = strtotime(date_to_bd($data1));
    $dataAmericano2 = strtotime(date_to_bd($data2));

    # Faz a Comparação
    if ($dataAmericano1 < $dataAmericano2) {
        $dataMenor = $data1;
    } elseif ($dataAmericano1 == $dataAmericano2) {
        $dataMenor = $data1;
    } else {
        $dataMenor = $data2;
    }

    return $dataMenor;
}

###########################################################

function dataMaiorArray($datas) {

    /**
     * Retorna a maior data de um array de datas
     *
     * @param  $datas array o array de datas
     * 
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     * 
     * @return data a data maior
     *
     * @syntax dataMaior($datas);
     */
    $dataMaior = "1000-01-01";

    foreach ($datas as $item) {
        # Verifica a validade da data
        if (validaData($item)) {
            # Passa para o modo americano
            $item = date_to_bd($item);

            # Faz a comparação
            if (strtotime($item) > strtotime($dataMaior)) {
                $dataMaior = $item;
            }
        }
    }
    return date_to_php($dataMaior);
}

###########################################################

function dataMenorArray($datas) {

    /**
     * Retorna a menor data de um array de datas
     *
     * @param  $datas array o array de datas
     * 
     * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
     * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
     * 
     * @return data a data maior
     *
     * @syntax dataMaior($datas);
     */
    $dataMenor = "1000-01-01";

    foreach ($datas as $item) {
        # Verifica a validade da data
        if (validaData($item)) {
            # Passa para o modo americano
            $item = date_to_bd($item);

            # Faz a comparação
            if (strtotime($item) < strtotime($dataMaior)) {
                $dataMenor = $item;
            }
        }
    }
    return date_to_php($dataMenor);
}

###########################################################

function get_post_action($name) {

    /**
     * Função curiosa que retorna o nome do botão de submit de um formulário que foi escolhido.
     *
     * @param  $nome array com os nomes possíveis
     * 
     * @note Essa função é utilizada quando se deseja ter multiplos botoes submit em um formulario. Dai ela informa o nome do botão escolhido.
     * @note Feito, inicialmente, para a rotina das Cis de Redução da carga horária e readaptação. Pois tem um botão para Salvar e Sair e outro para Salvar e imprimir.
     * 
     * @return string o nome escolhido
     *
     * @syntax get_post_action($name);
     */
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}

###########################################################

function limpa_numero($str) {

    /**
     * Função que limpa uma string com números e letras sobrando somente números
     *
     * @param  $str string a ser trabalhada
     * 
     * @return string o numero limpo
     *
     * @syntax limpa_numero($str);
     */
    return preg_replace("/[^0-9]/", "", $str);
}

###########################################################

function getMimeContentType($ext) {

    $mime_types = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',
        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    if (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    }
}

###########################################################

function getNumDias($dtInicial, $dtFinal, $primeiroDia = true) {
    /**
     * Informa o número de dias entre 2 datas
     *
     * @param  $dtInicial string data inicial no formato dd/mm/aaaa
     * @param  $dtFinal string data final no formato dd/mm/aaaa
     * 
     * @syntax getNumDias($dtInicial,$dtFinal)
     *
     * @return integer com o número de dias
     * 
     */
    # passa para o formado do banco de dados
    $dtInicial = date_to_bd($dtInicial);
    $dtFinal = date_to_bd($dtFinal);

    # Instancia as data
    $d1 = new DateTime($dtInicial);
    $d2 = new DateTime($dtFinal);

    # Pega o intervalo    
    $intervalo = $d1->diff($d2);
    $dias = $intervalo->days;

    # Verifica se conta o primeiro dia
    if ($primeiroDia) {
        $dias++;
    }

    return $dias;
}

###########################################################

function ultimoDiaMes($newData) {

    /**
     * Informa o ultimo dia de um mes da data informada
     *
     * @syntax ultimoDiaMes($newData)
     *
     * @return integer com o número de dias
     * 
     */
    /* Desmembrando a Data */
    list($newDia, $newMes, $newAno) = explode("/", $newData);
    return date("d/m/Y", mktime(0, 0, 0, $newMes + 1, 0, $newAno));
}

###########################################################

function pLista($linha1 = null, $linha2 = null, $linha3 = null, $linha4 = null, $linha5 = null) {

    /**
     * Lista informações padrinizadas em 3 linhas com tamanho e cores diferentes
     *
     * @syntax pLista([$linha1],[$linha2],[$linha3])
     */
    p($linha1, "pLinha1");
    p($linha2, "pLinha2");
    p($linha3, "pLinha3");
    p($linha4, "pLinha4");
    p($linha5, "pLinha5");
}

###########################################################

function emConstrucao($texto = null, $brAntes = 3) {

    /**
     * Exibe uma mensagam padrão de área em construção
     */
    $div = new Div("center");
    $div->abre();

    br($brAntes);
    $Imagem = new Imagem(PASTA_FIGURAS_GERAIS . 'construcao.png', 'Esta área do sistema está em construção. Em Breve Estará Disponível.', 300, 300);
    $Imagem->show();

    if (!is_null($texto)) {
        p($texto, "center", "f16");
    }

    $div->fecha();
}

###########################################################

function h1($mensagem) {
    /**
     * Insere uma mensagem h1
     *
     * @param $mensagem string null a mensagem a ser exibida
     *
     * @syntax h1($mensagem);
     *
     * @note Essa função apenas executa um echo <h1>
     */
    echo "<h1>{$mensagem}</h1>";
}

###########################################################

function h2($mensagem) {
    /**
     * Insere uma mensagem h2
     *
     * @param $mensagem string null a mensagem a ser exibida
     *
     * @syntax h2($mensagem);
     *
     * @note Essa função apenas executa um echo <h2>
     */
    echo "<h2>{$mensagem}</h2>";
}

###########################################################

function h3($mensagem) {
    /**
     * Insere uma mensagem h3
     *
     * @param $mensagem string null a mensagem a ser exibida
     *
     * @syntax h3($mensagem);
     *
     * @note Essa função apenas executa um echo <h3>
     */
    echo "<h3>{$mensagem}</h3>";
}

###########################################################

function h4($mensagem) {
    /**
     * Insere uma mensagem h4
     *
     * @param $mensagem string null a mensagem a ser exibida
     *
     * @syntax h4($mensagem);
     *
     * @note Essa função apenas executa um echo <h4>
     */
    echo "<h4>{$mensagem}</h4>";
}

###########################################################

function h5($mensagem) {
    /**
     * Insere uma mensagem h5
     *
     * @param $mensagem string null a mensagem a ser exibida
     *
     * @syntax h5($mensagem);
     *
     * @note Essa função apenas executa um echo <h5>
     */
    echo "<h5>{$mensagem}</h5>";
}

###########################################################

function h6($mensagem) {
    /**
     * Insere uma mensagem h6
     *
     * @param $mensagem string null a mensagem a ser exibida
     *
     * @syntax h6($mensagem);
     *
     * @note Essa função apenas executa um echo <h6>
     */
    echo "<h6>{$mensagem}</h6>";
}

###########################################################

function iframe($scr) {
    /**
     * Insere um iframe
     *
     * @param $scr string null o arquivo a ser aberto dentro do iframe
     *
     * @syntax iframe($scr);
     */
    echo "<iframe src='{$scr}' width='100%' height='900' style='border: none;'></iframe>";
}

###########################################################

//function str_contains($string = null, $search = null) {
//    /**
//     * Procura uma string dentro de outra string maior
//     */
//    if (empty($string)) {
//        return false;
//    }
//
//    if (empty($search)) {
//        return false;
//    }
//
//    if (preg_match("/{$search}/", $string)) {
//        return true;
//    } else {
//        return false;
//    }
//}
###########################################################

function anoBissexto($ano = NULL) {
    /*
     * Informa se o ano é bissexto
     */
    $year = is_numeric($ano) ? $ano : date('Y');
    return cal_days_in_month(CAL_GREGORIAN, 2, $ano) === 29;
}

############################################################

/**
 * Método get_dataIdade
 * informa a data em que terá a idade informada
 * 
 * @param data    $dtNasc data de nascimento
 * @param integer $idade  a idade
 */
function get_dataIdade($dtNasc, $idade) {

    # Calcula a data da idade
    $dia = substr($dtNasc, 0, 2);
    $mes = substr($dtNasc, 3, 2);
    $ano = substr($dtNasc, 6, 4);

    $anoSaida = $ano + $idade;
    return date_to_php($anoSaida . '-' . $mes . '-' . $dia);
}

###########################################################
/**
 * Método nl2br2
 * troca o salto de página por br
 * 
 * @param $string $texto o texto a ser alterado
 */

function nl2br2($string) {
    if (empty($string)) {
        return $string;
    } else {
        $string = str_replace(["\r\n", "\r", "\n", "&#13;&#10;"], "<br />", $string);
        return $string;
    }
}

###########################################################
/**
 * Método espaco2br
 * troca o espaço por br
 * 
 * @param $string $texto o texto a ser alterado
 */

function espaco2br($string) {
    if (empty($string)) {
        return $string;
    } else {
        return str_replace(" ", "<br/>", $string);
    }
}

###########################################################