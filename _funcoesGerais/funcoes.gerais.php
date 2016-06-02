<?php
 /**
 * Funções Gerais
 * Rotinas simples demais para serem classes 
 */
 
 ###########################################################

/**
 * @function post
 * 
 * Retorna o valor de um post
 * 
 * @syntax post($postName,$default);
 * 
 * @param $postName string null Nome do post a ser lido.
 * @param $default  string null Valor retornado caso seja NULL.
 * 
 * @codeInicio * 
 * <?php
 * 
 * $default = "teste" ;
 * post("telerfone",$default);   
 * @codeFim
 */

function post($postName,$default=NULL){

    if(isset($_POST[$postName]))
        $value = $_POST[$postName];
    else  
        $value = $default;  

    return $value;
}

###########################################################

/**
 * @function get
 * 
 * Retorna o valor de um get
 * 
 * @syntax get($getName,$default);
 * 
 * @param $getName string null Nome do get a ser lido.
 * @param $default string null Valor retornado caso seja NULL.
 */

function get($getName,$default=NULL){

    if(isset($_GET[$getName]))
        $value = $_GET[$getName];
    else  
        $value = $default;  

    return $value;
}

###########################################################

/**
 * @function loadPage
 * 
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

function loadPage($url,$target=null,$parametros='menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=750,height=600'){

    if (is_null($target)){
        echo '<meta http-equiv="refresh" content="0; URL='.$url.'">';
    }
    else{ 
        echo "<script>window.open('$url','$target','$parametros');</script>";	
    }
}

###########################################################

/**
 * @function ajaxLoadPage
 * 
 * Abre um outra página php dentro de uma div sem faze reload da página inteira. Somente a div é atualizada.
 *  
 * @syntax ajaxLoadPage($url,$div);
 *
 * @param $url string null A página que será carrregada.
 * @param $div string null O id da div onde a página será aberta.
 */

function ajaxLoadPage($url=null,$div=null){
    echo "<script>ajaxloadPage('$url','$div','');</script>";	
}

###########################################################

/**
 * @function set_session
 * 
 * Escreve um valor em uma variável de sessão para ser usada em outras páginas sem a necessidade de repassá-la com post ou get.
 * 
 * @syntax set_session($nome,$valor);
 *
 * @note Se a variável não existe ela será criada, se ela já existe o valor será atualizado.
 * 
 * @param $nome  string null O nome da variável se sessão a ser criada ou alterada.
 * @param $valor string null O valor a ser inserido.
 */

function set_session($nome=null,$valor=NULL){
    $_SESSION[$nome] = $valor;
}

###########################################################

/**
 * @function get_session
 * 
 * Retorna uma string com o conteúdo da variável de sessao.
 * 
 * @syntax get_session($nome,$padrao);
 * 
 * @note Se o valor retornado for nulo será retornado o valor padrão.
 * 
 * @param $nome   string O nome da variável de sessão
 * @param $padrao string O valor retornado caso seja NULL
 */

function get_session($nome,$padrao=NULL){
    if(isset($_SESSION[$nome]))
        $valor = $_SESSION[$nome];
    else  
        $valor = $padrao;  

    return $valor;
}

###########################################################

/**
 * @function date_to_bd
 * 
 * Transforma uma data do formato brasileiro DD/MM/AAAA para o formato americano AAAA/MM/DD.
 * 
 * @syntax date_to_bd($data,$separador);
 * 
 * @note Muito utilizado para adaptar as data ao formato de gravação do banco de dados.
 * 
 * @param $data      date   null A data a ser transformada
 * @param $separador string /    O separador da data
 */

function date_to_bd($data,$separador = '/'){
    if ((is_null($data)) or ($data == ''))
        return false;
    else{
        $dt1 = explode($separador,$data);
        $dt2 = $dt1[2].'/'.$dt1[1].'/'.$dt1[0];
        return $dt2;
    }
}

###########################################################

/**
 * @function date_to_php
 * 
 * Transforma uma data do formato americano AAAA/MM/DD para o formato brasileiro DD/MM/AAAA.
 * 
 * @syntax date_to_php($data,$separador);
 * 
 * @note Muito utilizado para recuperar datas do banco de dados.
 *   
 * @param $data      date   null A data a ser transformada
 * @param $separador string -    O separador da data
 */
 
function date_to_php($data,$separador = '-'){
    if((is_null($data)) or ($data == ""))
        return null;
    else{	
        $dt1 = explode($separador,$data);
        $dt2 = $dt1[2].'/'.$dt1[1].'/'.$dt1[0];
        return $dt2;
    }
}

###########################################################

/**
 * @function datetime_to_php
 * 
 * Transforma uma data com hora do formato americano AAAA/MM/DD para o formato brasileiro DD/MM/AAAA.
 * 
 * @syntax datetime_to_php($data,$separadorData,$separadorHora);
 * 
 * @note Muito utilizado para recuperar datas com horas do banco de dados.
 *   
 * @param $data          date   null A data a ser transformada
 * @param $separadorData string -    O separador da data
 * @param $separadorHora string :    O separador da hora
 */

function datetime_to_php($data,$separadorData = '-',$separadorHora = ':')
{
    if(is_null($data) or ($data == ""))
        return null;
    else {	
        $dt1 = explode($separadorData,$data);
        $espaco = explode(' ',$dt1[2]);
        $hora = explode($separadorHora,$espaco[1]);

        $dt2 = $espaco[0].'/'.$dt1[1].'/'.$dt1[0].' '.$hora[0].':'.$hora[1].':'.$hora[2];
        return $dt2;
    }
}

###########################################################

/**
 * @function back
 * 
 * Retorna um número de páginas a partir do histórico do browser.
 * 
 * @syntax back($numPaginas);
 * 
 * @note Utilizado para voltar uma ou duas páginas anteriores e refazer alguma tarefa.
 *   
 * @param $numPaginas integer null O número de páginas para voltar.
 */
function back($numPaginas){	
    echo '<script>javascript:history.go(-'.$numPaginas.');</script>';
}

###########################################################

/**
 * @function get_so
 * 
 * Retorna string com o nome do Sistema Operacional.
 * 
 * @syntax get_so();
 */

function get_so(){
    if(strstr($_SERVER['HTTP_USER_AGENT'], 'Linux'))
        return 'Linux';
    elseif(strstr($_SERVER['HTTP_USER_AGENT'], 'Windows'))
        return 'Windows';
    else
        return 'Não Identificado';
}

###########################################################

/**
 * @function get_browser
 * 
 * Retorna array com informações sobre o browser: [0] nome do btrowser [1] versão.
 * 
 * @syntax get_browser();
 */

function get_browserName(){
    $var = $_SERVER['HTTP_USER_AGENT'];
    $info['browser'] = "OTHER";
    $info['version'] = "";

    // valid brosers array
    $browser = array ("MSIE", "OPERA","CHROME", "FIREFOX", "SAFARI");

    // bots = ignore
    $bots = array('GOOGLEBOT', 'MSNBOT', 'SLURP');

    foreach ($bots as $bot){
        // if bot, returns OTHER
        if (strpos(strtoupper($var), $bot) !== FALSE){
            return $info;
        }
    }

    // loop the valid browsers
    foreach ($browser as $parent){
        $s = strpos(strtoupper($var), $parent);
        $f = $s + strlen($parent);
        $version = substr($var, $f, 5);
        $version = preg_replace('/[^0-9,.]/','',$version);
        if (strpos(strtoupper($var), $parent) !== FALSE){
            $info['browser'] = $parent;
            $info['version'] = $version;
            return $info;
        }
    }
    return $info;
}
	
###########################################################
/**
 * @function get_nomeMes
 * 
 * Informa o nome do mês cujo número foi informado
 * 
 * @syntax get_nomeMes($mes);
 * 
 * @param $mes integer null Número inteiro entre 1 e 12 representando um mês do ano.
 * 
 * @deprecated
 * 
 * @note Está função deverá der removida pois o sistema já conta o array $mes iniciado na configuração do sistema que já fornece essa informação.
 */

function get_nomeMes($mes){	
	
    switch ($mes){
        case 1:
            $mm = "Janeiro";
            break;

        case 2:
            $mm = "Fevereiro";
            break;

        case 3:
            $mm = "Mar�o";
            break;	

        case 4:
            $mm = "Abril";
            break;

        case 5:
            $mm = "Maio";
            break;

        case 6:
            $mm = "Junho";
            break;	

        case 7:
            $mm = "Julho";
            break;

        case 8:
            $mm = "Agosto";
            break;

        case 9:
            $mm = "Setembro";
            break;	

        case 10:
            $mm = "Outubro";
            break;

        case 11:
            $mm = "Novembro";
            break;

        case 12:
            $mm = "Dezembro";
            break;	
    }
    return $mm;
}

###########################################################

/**
 * @function retiraAspas
 * 
 * Retorna a string sem as aspas simples e duplas.
 * 
 * @syntax retiraAspas($texto);
 * 
 * @note Esta função é o conjunto de 2 funções em php e foi criada para facilitar o código.
 * 
 * @deprecated
 * 
 * @note Uso muito específico que acredito não precisará existir em futuras versões.
 * 
 * @param $texto string null O texto a ser trabalhado.
 */

function retiraAspas($texto){	
    $parametro = str_replace("'",'"',$texto);
    $parametro = str_replace('"','',$parametro);
    return $parametro;
}

###########################################################

/**
 * @function get_bold
 * 
 * Retorna uma string com uma parte em bold.
 * 
 * @syntax get_bold($texto, $ressaltado);
 * 
 * @note Retorna o Texto inserido com um texto menor ressaltado em bold, se contiver dentro do texto maior. Usado na rotina de pesquisa para ressaltar o texto pesquisado.
 * 
 * @param $texto      string null O texto principal de onde se tirará o ressaltado.
 * @param $ressaltado string null O texto menor a ser ressaltado em bold.
 */

function get_bold($texto,$ressaltado){	
    # retira os acentos
    $ressaltado = strtoupper(retiraAcento($ressaltado));
    $texto = retiraAcento($texto);
    
    # verifica se tem mais de uma palavra
    $palavras = explode(" ", $ressaltado);  // separa as palavras e as coloca em um array
    $numPalavras = count($palavras);
    
    # Faz o texto ressaltado ficar em bold no texto
    if($numPalavras == 1)
        $texto = str_ireplace($ressaltado,'<B>'.$ressaltado.'</B>',$texto);
    else{
        foreach ($palavras as $termos){
            $texto = str_ireplace($termos,'<B>'.$termos.'</B>',$texto);             
        }
    }
    return $texto;
}

###########################################################

/**
 * @function retiraAcento
 * 
 * Retorna uma string sem acentos. Troca as letras acentuadas pela mesma letra sem acento.
 * 
 * @syntax retiraAcento($texto);
 * 
 * @note Usado para ajudar a função get_bold que não consegue fazer o bold nas strings com acentos
 *  
 * @param $texto string O texto acentuado.
 */

function retiraAcento($texto){
    $array1 = array(   "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�"
                     , "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�" );
    $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
    
    return str_replace( $array1, $array2, $texto );
}

###########################################################

/**
 * @function soNumeros
 * 
 * Retorna somente os números de uma string
 * 
 * @syntax soNumeros($texto);
 * 
 * @note Usado para garantir que somente número sejam digitados.
 *  
 * @param $texto string null O string a ser trabalhado.
 */

function soNumeros($texto){    
    if(is_null($texto))
        return null;
    else
        return preg_replace("/[^0-9]/", "",$texto);
}

###########################################################

/**
 * @function abreDiv
 * 
 * Torna visível uma div que está oculta (abre).
 * 
 * @syntax abreDiv($nome);
 *
 * @param $nome string null O id da div a ser exibida.
 */

function abreDiv($nome){	
    echo '<script>abreDiv("'.$nome.'");</script>';
}

###########################################################

/**
 * @function extenso
 * 
 * Retorna escrito por extenso o número fornecido.
 * 
 * @syntax extenso($valor, $maiusculas);
 * 
 * @param $valor      string  null O valor a ser transformado.
 * @param $maiusculas boolean Quando true as primeiras letras são maiúsculas.
 */

function extenso($valor = 0, $maiusculas = false){ 
    $singular = array("centavo", "real", "mil", "milh�o", "bilh�o", "trilh�o", "quatrilh�o"); 
    $plural = array("centavos", "reais", "mil", "milh�es", "bilh�es", "trilh�es","quatrilh�es"); 

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"); 
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"); 
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"); 
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"); 

    $z = 0; 
    $rt = "";

    $valor = number_format($valor, 2, ".", "."); 
    $inteiro = explode(".", $valor); 
    for($i=0;$i<count($inteiro);$i++) 
        for($ii=strlen($inteiro[$i]);$ii<3;$ii++) 
            $inteiro[$i] = "0".$inteiro[$i]; 

    $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2); 

    for ($i=0;$i<count($inteiro);$i++){ 
        $valor = $inteiro[$i]; 
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]]; 
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]]; 
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : ""; 

        $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru; 
        $t = count($inteiro)-1-$i; 
        $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : ""; 

        if ($valor == "000")
            $z++;
        elseif ($z > 0)
            $z--;

        if (($t==1) && ($z>0) && ($inteiro[0] > 0))
            $r .= (($z>1) ? " de " : "").$plural[$t];

        if ($r) 
            $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r; 
    } 

    if(!$maiusculas)
        return($rt ? $rt : "zero"); 
    else{ 
        if ($rt)
            $rt=ereg_replace(" E "," e ",ucwords($rt));

        return (($rt) ? ($rt) : "Zero"); 
    }
} 

###########################################################

/**
 * @function br
 * 
 * Gera tantos saltos de linha quanto for o nímero fornecido.
 * 
 * @syntax br($linhas);
 *
 * @param $linhas integer null Número de linhas a serem puladas.
 * 
 * @note Essa função apenas executa um echo <br/> quantas vezes for $linhas.
 */

function br($linhas = 1){	
    for ($i = 1; $i <= $linhas; $i++){
        echo '<br />';
    }
}

###########################################################
/**
 * @function anti_injection
 * 
 * Função que retira comandos sql de uma string
 *
 * @param $str string null a string a ser tratada
 * 
 * @note Ainda não está sendo usada. Verificar seu uso em todo get e post.
 */

function anti_injection($str){
    // remove palavras que contenham sintaxe sql
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|%|\\\\)/"),"",$str);
    return trim(strip_tags(addslashes($str)));
}

###########################################################

/**
 * @function hr
 * 
 * Insere uma linha
 * 
 * @syntax hr();
 * 
 * @note Essa função apenas executa um echo <hr>
 */

function hr(){	
    echo '<hr>';   
}

###########################################################

/** 
 * @function alert
 * 
 * Abre uma janela popup com uma mensagem de alert
 * 
 * @syntax alert($mensagem);
 * 
 * @param $mensagem string null A mensagem a ser exibida
 */

function alert($mensagem){   
    echo '<script>alert("'.$mensagem.'");</script>'; 
}

###########################################################

/** 
 * @function p
 * 
 * Simula o comando P do HTLM
 * 
 * @syntax p($mensagem, [$id], [$class]);
 * 
 * @param $mensagem string NULL A mensagem a ser exibida.
 * @param $id       string NULL O id para o css.
 * @param $class    string NULL A classe para o css.
 */

function p($mensagem = NULL,$id = NULL,$class = NULL){
    echo '<p';

    # id
    if (!is_null($id)){
        echo ' id="'.$id.'"';
    }

    # class
    if (!is_null($class)){
        echo ' class="'.$class.'"';
    }

    echo '>';
    echo $mensagem;
    echo '</p>';
}

###########################################################

/**
 * @function titulo
 * 
 * Exibe um título 
 * 
 * @param $titulo string NULL O Título a ser exibido
 */

function titulo($titulo = null,$title = null){
    
    if(is_null($title))
        $title = $titulo;

    # cria a div
    $div = new Div("titulo");
    $div->set_title($title);
    $div->abre();
        echo $titulo;
    $div->fecha();
}

###########################################################
    
/**
 * funçao botaoVoltar
 * Rotina que exibe o botão de Voltar
 * 
 * @param   string	$url	url do botão
 * @param   string  $title  title para o botão
 */

function botaoVoltar($url,$label = 'Voltar',$title = 'Volta para a página anterior')
{
    # Botão voltar
    $grid = new Grid();
    $grid->abreColuna(12);
    $menu = new MenuBar();

    # Botão Administração
    $linkBotaoVoltar = new Button($label);
    $linkBotaoVoltar->set_title($title);
    $linkBotaoVoltar->set_url($url);
    $linkBotaoVoltar->set_accessKey('V');
    $menu->add_link($linkBotaoVoltar,"left");

    $menu->show();        

    $grid->fechaColuna();
    $grid->fechaGrid();
}

###########################################################  
      
function mensagemAguarde()

/**
* função mensagemAguarde
* Exibe uma mensagem de Aguarde
* 
*/    
{
    # Exibe uma mensagem de aguarde
    $div = new Div("center");
    $div->abre();
        br();
        $Imagem = new Imagem(PASTA_FIGURAS_GERAIS.'carregando.gif','Aguarde',90,90);
        $Imagem->show();
    $div->fecha();
}

###########################################################
/**
 * Função que retorna um valor no formato especificado
 * 
 * @param   $valor      O valor a ser alterado
 * @param   $formato    o formato sendo: 1 - formato brasileiro 
 *                                       2 - formato americano para gravação no bd
 */

function formataMoeda($valor,$formato = 1)
{	
    if($formato == 1)
        $moeda = number_format($valor, 2, ',', '.');
    else
    { 
        $moeda = str_replace(".", "", $valor);
        $moeda = str_replace(",", ".", $moeda); 
    }
    
    return $moeda;
}

###########################################################

/**
 * @function formataNumLinha
 * 
 * Formata o número da linha do código na rotina de exibição do código da documentação.
 *
 * @param $numero string null O número da linha a ser formatada.
 * 
 * @syntax formataNumLinha($numero);
 */

function formataNumLinha($numero){
    
    # Tamanho do numero
    $tamanho = strlen($numero);
    
    # Tamanho que deveria ter
    $tamanhoIdeal = 4;
    
    # Calcula a quantidade de espaços para alcançar o tamanho correto;
    $quantidadeEspaco = $tamanhoIdeal - $tamanho;
    
    # Monta a string
    $numero = str_repeat(" ",$quantidadeEspaco).$numero;
    
    return $numero;    
}


