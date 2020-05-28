/* 
 * Funções em Javascript
 */


/*
 * Funções de abertura e fechamento (visivel ou não) de div
 *
 * Usado para exibir ou não uma div
 */

var aba = {};


function fechaDivId(div) {
    document.getElementById(div).style.display = "none";
    aba[div] = false;
}

function abreDivId(div) {
    document.getElementById(div).style.display = "block";
    aba[div] = true;
}

function abreFechaDivId(div) {
    if (aba[div]) {
        fechaDivId(div);
    } else {
        abreDivId(div);
    }
}

/*
 * Funções para requisição ajax de uma página
 *
 * Usado para carregar uma página dentro de uma div
 */

function createXMLHttpRequest() {
    var xmlHttp = false;
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    } else {
        alert("Atualize seu navegador! O navegador atual não suporta AJAX!");
    }
    return xmlHttp;
}

function ajaxLoadPage(url, div, parametro) {
    var xmlhttp = createXMLHttpRequest();

    if (parametro != null) {
        url = url + parametro;
    }

    xmlhttp.open("GET", url, true);
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            document.getElementById(div).innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.send(null);
}

/*
 * função de confirmação do botão gráfico
 *
 * Usado na rotina do botão gráfico quando o parametro de confirmação está true
 */

function confirma(chamador, msg) {
    var opcao = confirm(msg);
    if (opcao) {
        window.location = chamador;
    }
}

/* 
 * Função de contagem regressiva
 * 
 * Usada na rotina de serviços para exibir o tempo restante para o refresh da página
 * 
 * @param   valor number  o valor a ser decrementado
 * @param   saida string  o id da div a ser impressa o velor
 * 
 * 
 */

function contagemRegressiva(valor, saida) {
    if ((valor - 1) >= 0) {
        valor = valor - 1;
        //divContagem.innerText = '00:' + valor;
        document.getElementById(saida).innerHTML = valor;
        setTimeout('contagemRegressiva(' + valor + ',"' + saida + '")', 1000);
    }
}

/*
 * Java Script da rotina de preenchimento de um input
 * 
 * Usado na rotina de notícias para transferir o nome do arquivo da figura para o campo do formulário
 */

function fillInput(input, valor) {
    input.value = valor;
}

/*
 * função loadPage 
 * 
 * Carrega uma página por jscript
 */

function loadPage(url, target, parametros) {
    if (parametros == undefined)
        parametros = 'menubar=no,scrollbars=yes,location=no,directories=no,status=no,width=750,height=600';

    if (target == undefined)
        window.open(url);
    else
        window.open(url, target, parametros);
}

/*
 * função pularCampo 
 * 
 * habilita a passagem de um campo par outro quando o total de caracteres é atingido
 */

function pularCampo(origem, tamanho, destino) {
    if (document.getElementById(origem).value.length == tamanho - 1) {
        document.getElementById(destino).focus();
    }
}

/*
 * função delay 
 * 
 * cria um dalay de alguns milisegundos
 */

function delay(ms) {
    ms += new Date().getTime();
    while (new Date() < ms) {
    }
}