/**
* Funcao de mascara. 
* 
* Esta funcao recebe como parametro o  campo (this) no qual a
* mascara sera aplicada, o formato da mascara ex.(99/99/9999),
* 
* o conteúdo (1 numeros, 2 letras e 3 letras e numeros) 
* o evento passa-se o this.
* 
*/
function mask(campo, formato, conteudo, event) {

 valor = campo.value;

 var i, j;
 var caracs = [ '.', '/', '-', ':', '(', ')', ',' ];
 var auxPonto = formato;
 var auxBarra = formato;
 var auxHifen = formato;
 var auxDblPonto = formato;
 var auxAbrePar = formato;
 var auxFechaPar = formato;
 var auxVirgula = formato;
 var tamanho = formato.length;
 var posPonto = new Array(tamanho);
 var posBarra = new Array(tamanho);
 var posHifen = new Array(tamanho);
 var posDblPonto = new Array(tamanho);
 var posAbrePar = new Array(tamanho);
 var posFechaPar = new Array(tamanho);
 var posVirgula = new Array(tamanho);
 var keyPress = event;

 campo.maxLength = tamanho;

 if (event.keyCode != 17) {
  switch (conteudo) {
  case 1: // Verifica se soh podem ser entrados valores numericos
   if (!(event.keyCode >= 48 && (event.keyCode <= 57)))
    event.keyCode = 0;
   break;
  case 2: // Somente Letras
   if (!((event.keyCode >= 97 && event.keyCode <= 122)
     || event.keyCode >= 65
     && event.keyCode <= 90))
    event.keyCode = 0;
   break;
  case 3: // Letras e numeros
   if (!((event.keyCode >= 48 && event.keyCode <= 57)
     || (event.keyCode >= 97 && event.keyCode <= 122)
     || (event.keyCode >= 65 && event.keyCode <= 90)))
    event.keyCode = 0;
   break;
  }
 }

 // -- PEGA A FORMATACAO DA MASCARA
 // ------------------
 for (i = 0; i < tamanho; i++) {

  posPonto[i] = auxPonto.indexOf('.');
  posBarra[i] = auxBarra.indexOf('/');
  posHifen[i] = auxHifen.indexOf('-');
  posDblPonto[i] = auxDblPonto.indexOf(':');
  posAbrePar[i] = auxAbrePar.indexOf('(');
  posFechaPar[i] = auxFechaPar.indexOf(')');
  posVirgula[i] = auxVirgula.indexOf(',');

  auxPonto = auxPonto.substring(posPonto[i] + 1, tamanho);
  auxBarra = auxBarra.substring(posBarra[i] + 1, tamanho);
  auxHifen = auxHifen.substring(posHifen[i] + 1, tamanho);
  auxDblPonto = auxDblPonto.substring(posDblPonto[i] + 1, tamanho);
  auxAbrePar = auxAbrePar.substring(posAbrePar[i] + 1, tamanho);
  auxFechaPar = auxFechaPar.substring(posFechaPar[i] + 1, tamanho);
  auxVirgula = auxVirgula.substring(posVirgula[i] + 1, tamanho);

  if (i > 0) {
   posPonto[i] = posPonto[i] + posPonto[i - 1];
   posBarra[i] = posBarra[i] + posBarra[i - 1];
   posHifen[i] = posHifen[i] + posHifen[i - 1];
   posDblPonto[i] = posDblPonto[i] + posDblPonto[i - 1];
   posAbrePar[i] = posAbrePar[i] + posAbrePar[i - 1];
   posFechaPar[i] = posFechaPar[i] + posFechaPar[i - 1];
   posVirgula[i] = posVirgula[i] + posVirgula[i - 1];
   posPonto[i] = posPonto[i] + 1;
   posBarra[i] = posBarra[i] + 1;
   posHifen[i] = posHifen[i] + 1;
   posDblPonto[i] = posDblPonto[i] + 1;
   posAbrePar[i] = posAbrePar[i] + 1;
   posFechaPar[i] = posFechaPar[i] + 1;
   posVirgula[i] = posVirgula[i] + 1;
  }
 }

 // Retirando a máscara
 for (i = 0; i < campo.value.length; i++) {
  valor = valor.replace('-', '');
  valor = valor.replace('(', '');
  valor = valor.replace(')', '');
  valor = valor.replace(':', '');
  valor = valor.replace('/', '');
  valor = valor.replace('.', '');
  valor = valor.replace(',', '');
 }

 // Faz a validação se for apenas número
 // utilizado para fazer a validação de Ctrl+V
 if (conteudo == 1) {
  if (isNaN(valor)) {
   if (isNaN(valor.charAt(valor.length - 2)))
    valor = "";
   else
    valor = valor.substring(0, valor.length - 1);
  }
 }

 indicePonto = 0;
 indiceBarra = 0;
 indiceHifen = 0;
 indiceDblPonto = 0;
 indiceVirgula = 0;
 indiceAbrePar = 0;
 indiceFechaPar = 0;

 // Varre o campo aplicando a máscara
 for (i = 0; i < valor.length; i++) {
  if (i == posPonto[indicePonto]) {
   if (valor.charAt(i) != '.') {
    if (i == 0) {
     valor = '.' + valor;
    } else if (i == valor.length) {
     valor = valor + '.';
    } else {
     valor = valor.substring(0, i) + '.' + valor.substring(i);
    }
    indicePonto++;
   }
  }
  if (i == posBarra[indiceBarra]) {
   if (valor.charAt(i) != '/') {
    if (i == 0) {
     valor = '/' + valor;
    } else if (i == valor.length) {
     valor = valor + '/';
    } else {
     valor = valor.substring(0, i) + '/' + valor.substring(i);
    }
    indiceBarra++;
   }
  }

  if (i == posHifen[indiceHifen]) {
   if (valor.charAt(i) != '-') {
    if (i == 0) {
     valor = '-' + valor;
    } else if (i == valor.length) {
     valor = valor + '-';
    } else {
     valor = valor.substring(0, i) + '-' + valor.substring(i);
    }
    indiceHifen++;
   }
  }

  if (i == posDblPonto[indiceDblPonto]) {
   if (valor.charAt(i) != ':') {
    if (i == 0) {
     valor = ':' + valor;
    } else if (i == valor.length) {
     valor = valor + ':';
    } else {
     valor = valor.substring(0, i) + ':' + valor.substring(i);
    }
    indiceDblPonto++;
   }
  }

  if (i == posAbrePar[indiceAbrePar]) {
   if (valor.charAt(i) != '(') {
    if (i == 0) {
     valor = '(' + valor;
    } else if (i == valor.length) {
     valor = valor + '(';
    } else {
     valor = valor.substring(0, i) + '(' + valor.substring(i);
    }
    indiceAbrePar++;
   }
  }

  if (i == posFechaPar[indiceFechaPar]) {
   if (valor.charAt(i) != ')') {
    if (i == 0) {
     valor = ')' + valor;
    } else if (i == valor.length) {
     valor = valor + ')';
    } else {
     valor = valor.substring(0, i) + ')' + valor.substring(i);
    }
    indiceFechaPar++;
   }
  }

  if (i == posVirgula[indiceVirgula]) {
   if (valor.charAt(i) != ',') {
    if (i == 0) {
     valor = ',' + valor;
    } else if (i == valor.length) {
     valor = valor + ',';
    } else {
     valor = valor.substring(0, i) + ',' + valor.substring(i);
    }
    indiceVirgula++;
   }
  }
 }

 if (campo.value.length > tamanho) {
  campo.value = campo.value.substring(0, tamanho);
 }

 campo.value = valor;
}