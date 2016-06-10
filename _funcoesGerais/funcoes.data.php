<?php
 /**
 * Funções de data
 * Conjunto de vários métodos estáticos de manipulação de datas
 * 
 * By Alat
 */

/**
 * Metodo valida
 * 
 * Verifica se uma data é válida ou não retorna true or false
 * 
 * @param $data string -> a data a ser validada
 */
function validaData($data){
    if(Valida::vazio($data)){        
        return false;
    }else{	
        $dt1 = explode('/',$data);					// Separa a data
        return checkdate((int)$dt1[1],(int)$dt1[0],(int)$dt1[2]);	// valida
    }
}

###########################################################

/**
 * Método addDias
 * 
 * Método que adiciona dias a uma data
 * 
 * @param 	$data 		string	-> a data 
 * @param 	$dias 		integer	-> os dias a serem adicionados
 * @param 	$inclusive	bool	-> se inclui o primeiro dia ou não
 * 
 */
function addDias($data,$dias,$inclusive = true)
{
        if($inclusive)
                $dias--;

        if(validaData($data))
        {
            $dia=substr($data,0,2);
            $mes=substr($data,3,2);
            $ano=substr($data,6,4);
            $dataFinal = date('d/m/Y',mktime(24*$dias, 0, 0, $mes, $dia, $ano));
            return $dataFinal;
        }
        else
        { 
            Alert::alert('Data Inválida');
            return false;
        }
}

###########################################################	

/**
 * Método entre
 *  
 * Verifica se a data está entre (inclusive) duas datas (um período)
 * 
 * @param 	$data 		string	-> a data a ser verificada
 * @param 	$dtInicial	date	-> data inicial do período
 * @param 	$dtFinal	date	-> data final do período
 * 
 */ 
function entre($data,$dtInicial,$dtFinal)
{
    if ((date_to_bd($data) < date_to_bd($dtInicial)) or (date_to_bd($data) > date_to_bd($dtFinal)))
        return false;
    else 
        return true;						
}

###########################################################	

/**
 * Método jaPassou
 *  
 * Verifica se a data já passou da data atual
 * 
 * @param 	$data 		string	-> a data a ser verificada 
 */ 

function jaPassou($data)
{
    if (date("Y/m/d") > date_to_bd($data))
        return true;
    else 
        return false;

}

###########################################################	

/**
 * Método DataDif($dataFinal)
 *  
 * Informa em dias o período entre duas datas
 *
 * @param	$data1	string	-> data inicial do período
 * @param 	$data2	string	-> data final do período. Se for nula usa a data de hoje.
 * 
 */ 

function DataDif($data1, $data2 = null)
{
        if($data2 == null)
                $data2 = date("m/d/Y");  # Se for nula coloca a data atual

        if($data1 == null)
                return false;

        $data1 = date_to_bd($data1);

        $diferenca = round((strtotime($data2) - strtotime($data1)) / (24 * 60 * 60), 0);
        return $diferenca;	       
}


###########################################################	

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

function porExtenso($data)

{
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

/**
 * Método addMeses
 * 
 * Método que adiciona meses a uma data
 * 
 * @param 	$data 		string	-> a data 
 * @param 	$meses 		integer	-> os meses a serem adicionados
 * 
 */
function addMeses($data,$meses)
{		
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

/**
 * Método addAnos
 * 
 * Método que adiciona anos a uma data
 * 
 * @param 	$data 		string	-> a data 
 * @param 	$anos 		integer	-> os meses a serem adicionados
 * 
 */
function addAnos($data,$anos)
{		
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