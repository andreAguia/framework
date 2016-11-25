<?php
 /**
 * Funções Gerais
 * Rotinas simples demais para serem classes 
 */
 
 ###########################################################

function post($nome,$padrao=NULL){
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
 * @param $padrao string null Valor retornado caso seja NULL.
 * 
 * @example exemplo.post.php
 */
    
    if(filter_has_var(INPUT_POST,$nome)){
        $valor = filter_input(INPUT_POST,$nome);
    }else{
        $valor = $padrao;
    }
    return $valor;
}

###########################################################

function get($nome,$padrao=NULL){
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
 * @param $padrao string null Valor retornado caso seja NULL.
 * 
 * @example exemplo.get.php 
 */

    if(filter_has_var(INPUT_GET,$nome)){
        $valor = filter_input(INPUT_GET,$nome);
    }else{
        $valor = $padrao;
    }
    return $valor;
}

###########################################################

function loadPage($url,$target=null,$parametros='menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=750,height=600'){
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
    
    if (is_null($target)){
        echo '<meta http-equiv="refresh" content="0; URL='.$url.'">';
    }
    else{ 
        echo "<script>window.open('$url','$target','$parametros');</script>";	
    }
}

###########################################################

function ajaxLoadPage($url=null,$div=null){
/**
 * Abre um outra página php dentro de uma div sem faze reload da página inteira. Somente a div é atualizada.
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

function set_session($nome=null,$valor=NULL){
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

function get_session($nome,$padrao=NULL){
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
 * @param $padrao string O valor retornado caso seja NULL
 * 
 * @example exemplo.set_session.php 
 */

    if(isset($_SESSION[$nome])){
        $valor = $_SESSION[$nome];
    }else{  
        $valor = $padrao;  
    }
    
    return $valor;
}

###########################################################

function date_to_bd($data,$separador = '/'){
   /**
    * Transforma uma data do formato brasileiro DD/MM/AAAA para o formato americano AAAA/MM/DD.
    * 
    * @syntax date_to_bd($data,[$separador]);
    * 
    * @return string com a data no formato AAAA/MM/DD.
    * 
    * @category Data
    *  
    * @note Utilizado para converter as data ao formato de gravação do banco de dados.
    * 
    * @param $data      date   null A data a ser transformada no formato DD/MM/AAAA
    * @param $separador string /    O separador da data
    * 
    * @example exemplo.date_to_bd.php  
    */
    
    if ((is_null($data)) or ($data == '')){
        return false;
    }else{
        $dt1 = explode($separador,$data);
        $dt2 = $dt1[2].'/'.$dt1[1].'/'.$dt1[0];
        return $dt2;
    }
}

###########################################################

function date_to_php($data,$separador = '-'){
    
/**
 * Transforma uma data do formato americano AAAA_MM_DD para o formato brasileiro DD/MM/AAAA.
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
 

    if((is_null($data)) or ($data == "")){
        return null;
    }else{	
        $dt1 = explode($separador,$data);
        $dt2 = $dt1[2].'/'.$dt1[1].'/'.$dt1[0];
        return $dt2;
    }
}

###########################################################

function datetime_to_php($data,$separadorData = '-',$separadorHora = ':')
{
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

    if(is_null($data) or ($data == "")){
        return null;
    }else{
        # Separa data da hora
        $dt1 = explode($separadorData,$data);
        $espaco = explode(' ',$dt1[2]);
        $hora = explode($separadorHora,$espaco[1]);

        $dt2 = $espaco[0].'/'.$dt1[1].'/'.$dt1[0].' '.$hora[0].':'.$hora[1].':'.$hora[2];
        return $dt2;
    }
}

###########################################################

function back($numPaginas){	
    /**
 * Retorna um número de páginas a partir do histórico do browser.
 * 
 * @syntax back($numPaginas);
 * 
 * @note Utilizado para voltar uma ou duas páginas anteriores e refazer alguma tarefa.
 *   
 * @param $numPaginas integer null O número de páginas para voltar.
 */

    echo '<script>javascript:history.go(-'.$numPaginas.');</script>';
}

###########################################################

function get_so(){
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
    
    if(strstr($so, 'Linux')){
        return 'Linux';
    }elseif(strstr($so, 'Windows')){
        return 'Windows';
    }else{
        return 'Não Identificado';
    }
}

###########################################################

function get_browserName(){
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
    $browser = array ("MSIE","OPR","FIREFOX","VIVALDI","CHROME","SAFARI");

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
        $version = preg_replace('/[^0-9,.]/','',substr($var, $f, 5));
        if (strpos(strtoupper($var), $parent) !== FALSE){
            $info['browser'] = $parent;
            $info['version'] = $version;
            return $info;
        }
    }
    return $info;
}
	
###########################################################

function get_nomeMes($numero = NULL){
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
    if(is_null($numero)){
        $numero = date('m');
    }
    
    # Valida o número do mês
    if(($numero > 12) OR ($numero < 1)){
        return "ERRO !! - Mês Inexistente";
    }else{
        # Cria array dos meses
        $mes = array(array("1","Janeiro"),
               array("2","Fevereiro"),
               array("3","Março"),
               array("4","Abril"),
               array("5","Maio"),
               array("6","Junho"),
               array("7","Julho"),
               array("8","Agosto"),
               array("9","Setembro"),
               array("10","Outubro"),
               array("11","Novembro"),
               array("12","Dezembro"));

        return $mes[$numero-1][1];
    }
}

###########################################################

function retiraAspas($texto){	
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
    $troca1 = str_replace("'",'"',$texto);
    $parametro = str_replace('"','',$troca1);
    return $parametro;
}

###########################################################

function bold($texto,$destaque){	
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

    # Coloca o destaque em maiúsculas
    $destaqueMaiusculo = strtoupper($destaque);
    
    # Cria 2 destaques: um com acento e outro sem
    $destaqueComAcentos = $destaqueMaiusculo;
    $destaqueSemAcentos = retiraAcento($destaqueMaiusculo);
    
    #$destaque = strtoupper(retiraAcento($destaque));
    #$texto = retiraAcento($texto);
    
    # Verifica primeiro com acento    
    # Verifica se tem mais de uma palavra
    $palavras = explode(" ", $destaqueComAcentos);  // separa as palavras e as coloca em um array
    $numPalavras = count($palavras);
    
    # Faz o texto ressaltado ficar em bold no texto
    if($numPalavras == 1)
        $texto = str_ireplace($destaqueComAcentos,"<span id='ressaltado' class='warning label'>$destaqueComAcentos</span>",$texto);
    else{
        foreach ($palavras as $termos){
            $texto = str_ireplace($termos,"<span id='ressaltado' class='warning label'>$termos</span>",$texto);             
        }
    }
    
    # Verifica agora sem acentos    
    # Verifica se tem mais de uma palavra
    $palavras = explode(" ", $destaqueSemAcentos);  // separa as palavras e as coloca em um array
    $numPalavras = count($palavras);
   
    # Faz o texto ressaltado ficar em bold no texto
    if($numPalavras == 1)
        $texto = str_ireplace($destaqueSemAcentos,"<span id='ressaltado' class='warning label'>$destaqueSemAcentos</span>",$texto);
    else{
        foreach ($palavras as $termos){
            $texto = str_ireplace($termos,"<span id='ressaltado' class='warning label'>$termos</span>",$texto);             
        }
    }    
    return $texto;
}

###########################################################

function retiraAcento($texto){
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

    $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
                     , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
    $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
    
    return str_replace( $array1, $array2, $texto );
}

###########################################################

function soNumeros($texto){    
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

    if(is_null($texto)){
        return null;
    }else{
        return preg_replace("/[^0-9]/", "",$texto);
    }
}

###########################################################

function abreDiv($nome){
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

    echo '<script>abreDiv("'.$nome.'");</script>';
}

###########################################################

function extenso($valor = 0, $maiusculas = false){ 
/**
 * Retorna escrito por extenso o número fornecido em valores monetários (REAIS).
 * 
 * @syntax extenso($valor, [$maiusculas]);
 * 
 * @return string Texto com o número em extenso em formato monetário.
 * 
 * @note Usado para fornecer, por extenso, o valor monetário (dinheiro) de alguma transação.   
 * 
 * @param $valor      string  null O valor a ser transformado.
 * @param $maiusculas boolean Quando true as primeiras letras são maiúsculas.
 * 
 * @example exemplo.extenso.php  
 */

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
    for($i=0;$i<count($inteiro);$i++){ 
        for($ii=strlen($inteiro[$i]);$ii<3;$ii++){ 
            $inteiro[$i] = "0".$inteiro[$i]; 
        }
    }
    
    $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2); 

    for($i=0;$i<count($inteiro);$i++){ 
        $valor = $inteiro[$i]; 
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]]; 
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]]; 
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : ""; 

        $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru; 
        $t = count($inteiro)-1-$i; 
        $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : ""; 

        if($valor == "000"){
            $z++;
        }elseif($z > 0){
            $z--;
        }

        if(($t==1) && ($z>0) && ($inteiro[0] > 0)){
            $r .= (($z>1) ? " de " : "").$plural[$t];
        }

        if($r){ 
            $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r; 
        }
    } 

    if(!$maiusculas){
        return($rt ? $rt : "zero"); 
    }else{ 
        if ($rt){
            $rt=ereg_replace(" E "," e ",ucwords($rt));
        }
        return (($rt) ? ($rt) : "Zero"); 
    }
} 

###########################################################

function br($linhas = 1){	
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

    for ($i = 1; $i <= $linhas; $i++){
        echo '<br />';
    }
}

###########################################################

function anti_injection($str){
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
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|%|\\\\)/"),"",$str);
    return trim(strip_tags(addslashes($sql)));
}

###########################################################

function hr(){	
/**
 * Insere uma linha
 * 
 * @syntax hr();
 * 
 * @note Essa função apenas executa um echo <hr>
 * 
 * @example exemplo.hr.php   
 */

    echo '<hr>';   
}

###########################################################

function alert($mensagem){   
/** 
 * Abre uma janela popup com uma mensagem de alert
 * 
 * @syntax alert($mensagem);
 * 
 * @param $mensagem string null A mensagem a ser exibida.
 */

    echo '<script>alert("'.$mensagem.'");</script>'; 
}

###########################################################

function p($mensagem = NULL,$id = NULL,$class = NULL,$title = null){
/** 
 * Simula o comando P do HTML com vantagens
 * 
 * @syntax p($mensagem, [$id], [$class], [$title]);
 * 
 * @param $mensagem string NULL A mensagem a ser exibida.
 * @param $id       string NULL O id para o css.
 * @param $class    string NULL A classe para o css.
 * @param $title    string NULL A title do texto.
 * 
 * @example exemplo.p.php    
 */

    echo '<p';

    # id
    if (!is_null($id)){
        echo ' id="'.$id.'"';
    }

    # class
    if (!is_null($class)){
        echo ' class="'.$class.'"';
    }
    
    # title
    if (!is_null($title)){
        echo ' title="'.$title.'"';
    }

    echo '>';
    echo $mensagem;
    echo '</p>';
}

###########################################################

function titulo($mensagem = null,$title = null){
/**
 * Exibe um texto centralizado dentro de um painel com fundo azul escuro. Utilizado para títulos de páginas.
 * 
 * @syntax titulo($mensagem, [$title]); 
 * 
 * @param $titulo string NULL O Título a ser exibido
 * 
 * @example exemplo.titulo.php     
 */
   
    if(is_null($title)){
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
    
function botaoVoltar($url,$label = 'Voltar',$title = 'Volta para a página anterior'){
/**
 * Rotina que exibe o botão de Voltar
 * 
 * @syntax botaoVoltar($url, [$label], [$title] );  
 * 
 * @param $url   string NULL     A url do botão
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
    $linkBotaoVoltar->set_accessKey('V');
    $menu->add_link($linkBotaoVoltar,"left");

    $menu->show();        

    $grid->fechaColuna();
    $grid->fechaGrid();
}

###########################################################  
      
function aguarde(){

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
        $Imagem = new Imagem(PASTA_FIGURAS_GERAIS.'carregando.gif','Aguarde',90,90);
        $Imagem->show();
    $div->fecha();
}

###########################################################

function formataMoeda($valor,$formato = 1){
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
 * @param $valor   string  NULL O valor a ser alterado
 * @param $formato integer 1    O formato sendo: 1 - formato brasileiro | 2 - formato americano para gravação no bd
 * 
 * @example exemplo.formataMoeda.php  
 */
    
    if($formato == 1){ 
        # Formato americano para o brasileiro
        $moeda = number_format($valor, 2, ',', '.');
    }else{ 
        # Formato brasileiro para o americano
        $moeda = str_replace(".", "", $valor);
        $moeda = str_replace(",", ".", $moeda); 
    }    
    return $moeda;
}

###########################################################

function formataNumLinha($numero){
/**
 * Tabula a exibição de números Para exibição na rotina que lista códigos.
 * 
 * @syntax formataNumLinha($numero); 
 * 
 * @param $numero string NULL O número da linha a ser formatada.
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
    $numero = str_repeat(" ",$quantidadeEspaco).$numero;
    
    return $numero;    
}

###########################################################

function callout($mensagem, $tipo = "warning"){
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
    
    $callout = new Callout($tipo);
    $callout->abre();
        p($mensagem);
    $callout->fecha();
}

###########################################################

function label($mensagem, $tipo = "warning", $id = null){
/**
 * Cria uma mensagem com fundo colorido.
 * 
 * @note Utiliza a funcionalidade label do Foundation
 *
 * @param $mensagem string null    A mensagem a ser exibida: 
 * @param $tipo     string warning O tipo: secondary | primary | success | warning | alert 
 * 
 * @syntax label($mensagem, [$tipo], [$id]);
 * 
 * @example exemplo.label.php  
 */

    span($mensagem,$id,$tipo.' label');
}

###########################################################

function badge($mensagem, $tipo = "warning", $id = NULL, $title = NULL){
/**
 * Semelhante a função label mas com bordas arredondadas
 *
 * @note É indicado quando se quer chamar atenção para um ou dois caracteres no máximo. 
 * @note Os caracteres ficam dentro de um círculo. Com palavras de mais de 2 caracteres o efeito não é bom.
 * @note Utiliza a funcionalidade badge do Foundation 
 * 
 * @param $mensagem string NULL    A mensagem a ser exibida
 * @param $tipo     string warning O tipo: secondary | primary | success | warning | alert
 * @param $id       string NULL    O id para a função P usada na impressão da memsagem.
 * @param $title    string NULL    Mensagem para o mouseover
 * 
 * @syntax badge($mensagem, [$tipo], [$id], [$title]);
 * 
 * @example exemplo.badge.php 
 */

    span($mensagem,$id,$tipo.' badge',$title);
}

##########################################################

function span($mensagem,$id = NULL,$class = NULL,$title = NULL){
/**
 * Cria um span com uma mensagem.
 * 
 * @note Função criada para facilitar a escrita do código.
 * @note Apenas monta um elemento span com uma mensagem dentro.
 * @note Só tem utilidade quando está vinculado a alguma formatação css.
 *
 * @param $mensagem string NULL    A mensagem a ser exibida: 
 * @param $id       string NULL    O id para o css.
 * @param $class    string NULL    A classe para o css. 
 * 
 * @syntax span($mensagem, [$id], [$class]);
 */

    echo '<span';
    
    # id
    if (!is_null($id)){
        echo ' id="'.$id.'"';
    }

    # class
    if (!is_null($class)){
        echo ' class="'.$class.'"';
    }
    
    # title
    if (!is_null($title)){
        echo ' title="'.$title.'"';
    }
    
    echo '>';
    echo $mensagem;
    echo '</span>';
}

###########################################################

function validaData($data){
/**
 * Verifica se uma data é válida ou não retorna true or false
 * 
 * @return bool TRUE (1) para datas válidas e FALSE (0) para as inválidas.
 * 
 * @category Data
 * 
 * @param $data string NULL A data a ser validada no formato brasileiro
 * 
 * @note Essa função é uma melhoria da função checkdate do php.
 * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
 * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
 * 
 * @syntax validaData($data);
 * 
 * @example exemplo.validaData.php  
 */

    # Verifica se o tamanho da data é menor que 8
    if (strlen($data) < 8){
        return FALSE;
    }else{
        # Verifica se a data possui a barra (/) de separação
        if(strpos($data, "/") !== FALSE){
            $partes = explode("/", $data);
            
            # pega o dia da data
            $dia = $partes[0];
            # pega o mês da data
            $mes = $partes[1];
            
            # prevenindo Notice: Undefined offset: 2
            # caso informe data com uma única barra (/)
            $ano = isset($partes[2]) ? $partes[2] : 0;
 
            if(strlen($ano) < 4){
                return 1;
            }else{
                # verifica se a data é válida
                if(checkdate($mes, $dia, $ano)) {
                    return TRUE;
                }else{
                    return FALSE;
                }
            }
        }else{
            return FALSE;
        }
    }
}

###########################################################

function addDias($data = NULL,$dias = 0,$primeiroDia = TRUE){
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
 * 
 * @param $data        string  NULL A data inicial 
 * @param $dias        integer 0    O número de dias a serem adicionados
 * @param $primeiroDia bool    TRUE Se inclui o primeiro dia ou não
 * 
 * @example exemplo.addDias.php 
 */

    if($primeiroDia){
        $dias--;
    }
    
    if(validaData($data)){
        $dia=substr($data,0,2);
        $mes=substr($data,3,2);
        $ano=substr($data,6,4);
        $dataFinal = date('d/m/Y',mktime(24*$dias, 0, 0, $mes, $dia, $ano));
        return $dataFinal;
    }else{ 
        alert('Data Inválida');
        return FALSE;
    }
}

###########################################################	

function entre($data,$dtInicial,$dtFinal){
/**
 * Verifica se a data está entre duas datas.
 * 
 * @syntax entre($data,$dtInicial,$dtFinal);
 * 
 * @category Data
 * 
 * @return bool TRUE para confirmar e FALSE para negar
 * 
 * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
 * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
 * 
 * @param $data      date NULL A data a ser verificada.
 * @param $dtInicial date NULL A data inicial do período.
 * @param $dtFinal   date NULL A data final do período.
 * 
 * @example exemplo.entre.php 
 */

    if(validaData($data)){
        if ((date_to_bd($data) < date_to_bd($dtInicial)) or (date_to_bd($data) > date_to_bd($dtFinal))){
            return FALSE;
        }else{ 
            return TRUE;
        }
    }else{ 
        alert('Data Inválida');
        return FALSE;
    }    						
}

###########################################################	

function jaPassou($data){
/**
 * Verifica se a data já passou da data atual
 * 
 * @syntax jaPassou($data);
 * 
 * @category Data
 * 
 * @return bool TRUE para confirmar e FALSE para negar
 * 
 * @note Observe que o formato de entrada da data é o brasileiro e o divisor é o /.
 * @note Se a data estiver no formato americano ou o divisor for diferente, a data deverá ser convertida.
 * 
 * @param $data      date NULL A data a ser verificada.
 * 
 * @example exemplo.jaPassou.php 
 */ 
    if(validaData($data)){
        if(date("Y/m/d") > date_to_bd($data)){
            return TRUE;
        }else{ 
            return FALSE;
        }
    }else{ 
        alert('Data Inválida');
        return FALSE;
    }    						
}

###########################################################	

function dataDif($dataInicial, $dataFinal = null){
/**
 * Informa, em dias, o período entre duas datas
 *
 * @param $dataInicial date NULL  A data inicial do período.
 * @param $dataFinal   date NULL  A data final do período. Se for nula usa-se a data atual.
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
 * 
 * @example exemplo.dataDif.php 
 */ 
    # Se for nula coloca a data atual
    if(is_null($dataFinal)){
        $dataFinal = date("m/d/Y");
    }else{
        # Passa para o padrão americano
        $dataFinal = date_to_bd($dataFinal);
    }

    # Verifica a validade das datas
    if((validaData($dataInicial)) AND (validaData($dataFinal))){
        
        # Passa para o padrão americano
        $dataInicial = date_to_bd($dataInicial);
        
        # Calcula a diferença
        $diferenca = round((strtotime($dataFinal) - strtotime($dataInicial)) / (24 * 60 * 60), 0);
        return $diferenca;
    }else{
        alert('Data Inválida');
        return FALSE;
    }
}

###########################################################	

function porExtenso($data){
/**
 * Método porExtenso
 *  
 * Exibe a data armazenada na classe na seguinte forma:
 * DD, de MM de AAAA
 * 
 * @param	$data	string	A data a ser transformada
 * @return	$string			A data por extenso 
 * 
 */ 
        $dt1 = explode('/',$data);
        switch ($dt1[1])
        {
                case 1:
                        $mm = "Janeiro";
                        break;

                case 2:
                        $mm = "Fevereiro";
                        break;

                case 3:
                        $mm = "Março";
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

        $dt2 = $dt1[0].' de '.$mm.' de '.$dt1[2];
        return $dt2;
}

###########################################################

function addMeses($data,$meses){
/**
 * Método que adiciona meses a uma data
 * 
 * @param 	$data 		string	-> a data 
 * @param 	$meses 		integer	-> os meses a serem adicionados
 * 
 */
       if(validaData($data))
        {
            $dia=substr($data,0,2);
            $mes=substr($data,3,2);
            $ano=substr($data,6,4);
            $dataFinal = date('d/m/Y',mktime(0, 0, 0, $mes+$meses, $dia, $ano));
            return $dataFinal;
        }
        else
        { 
            alert('Data Inválida');
            return false;
        }
}

###########################################################

function addAnos($data,$anos){
/**
 * Método que adiciona anos a uma data
 * 
 * @param 	$data 		string	-> a data 
 * @param 	$anos 		integer	-> os meses a serem adicionados
 * 
 */
		
        if(validaData($data))
        {
            $dia=substr($data,0,2);
            $mes=substr($data,3,2);
            $ano=substr($data,6,4);
            $dataFinal = date('d/m/Y',mktime(0, 0, 0, $mes, $dia, $ano+$anos));
            return $dataFinal;
        }
        else
        { 
            alert('Data Inválida');
            return false;
        }
}