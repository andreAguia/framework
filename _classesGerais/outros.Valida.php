<?php
 /**
 * classe Valida
 * 
 * Classe criada para encapsular vários métodos estáticos
 * de validação da entrada de dados de formulários
 * 
 * By Alat
 */
class Valida

{
    /**
     * Método vazio
     * 
     * Verifica se o valor é vazio ou nulo
     * 
     * @param  $var 	string	-> a variavel a ser validada
     * @return true or false
     */
    static function vazio($var)
    {
            if (is_null($var) or ($var == ''))
                    return true;		
    }

    ###########################################################

    /**
     * Método cpf
     * 
     * Verifica se o cpf é válido
     * @return true or false
     */

    static function cpf($cpf)
    {
        # Retira os caracteres . e -
        $cpf = str_replace('.', '', $cpf);      // retira o .
        $cpf = str_replace('-', '', $cpf);      // retira o -

        # Verifica se sobrou somente número
        if(!is_numeric($cpf)) 	// Verifica se é número
                $status = false;
        else 
        {	
          # Verifica números que pelo padrão normal dão como válidos
          if(($cpf == '11111111111') || ($cpf == '22222222222') ||
             ($cpf == '33333333333') || ($cpf == '44444444444') ||
             ($cpf == '55555555555') || ($cpf == '66666666666') ||
             ($cpf == '77777777777') || ($cpf == '88888888888') ||
             ($cpf == '99999999999') || ($cpf == '00000000000') ) 
             $status = false;
          else
          {
             $dv_informado = substr($cpf, 9,2); // pega o digito verificador

             for($i=0; $i<=8; $i++)
             {
                $digito[$i] = substr($cpf, $i,1);
             }

             # CALCULA O VALOR DO 10º DIGITO DE VERIFICAÇÂO
             $posicao = 10;
             $soma = 0;

            for($i=0; $i<=8; $i++)
            {
                $soma = $soma + $digito[$i] * $posicao;
                $posicao = $posicao - 1;
            }

            $digito[9] = $soma % 11;

            if($digito[9] < 2)
            {
                $digito[9] = 0;
            }
            else
            {
                $digito[9] = 11 - $digito[9];
            }

            # CALCULA O VALOR DO 11º DIGITO DE VERIFICAÇÃO
            $posicao = 11;
            $soma = 0;

            for ($i=0; $i<=9; $i++)
            {
                $soma = $soma + $digito[$i] * $posicao;
                $posicao = $posicao - 1;
            }

            $digito[10] = $soma % 11;

            if ($digito[10] < 2)
            {
                $digito[10] = 0;
            }
            else
            {
                $digito[10] = 11 - $digito[10];
            }

            # VERIFICA SE O DV CALCULADO É IGUAL AO INFORMADO
            $dv = $digito[9] * 10 + $digito[10];
            if ($dv != $dv_informado)
            {
                $status = false;
            }
            else
                $status = true;
            }
        }
        return $status;	
    }
    
    ###########################################################

    /**
     * Método pis
     * 
     * @author Paulo Ricardo F. Santos <v1d4l0k4.at.gmail.dot.com>
     * @copyright Copyright © 2006, Paulo Ricardo F. Santos
     * @license http://creativecommons.org/licenses/by-nc-sa/2.0/br Commons Creative
     * @version 20070316
     * @param string $pis PIS que deseja validar
     * @return bool true caso seje válido, false caso não seje válido
     */
    
    static function pis($pis)
    {
        $pis = preg_replace('/[^0-9]/', '', $pis);
        $digito = 0;
        
        for($i = 0, $x=3; $i<=10; $i++, $x--)
        {
            $x = ($x < 2) ? 9 : $x;
            $digito += $pis[$i]*$x;
        }
        
        $calculo = (($digito%11) < 2) ? 0 : 11-($digito%11);
        if($calculo <>  $pis[10])
            return false;
        
        return true;

    }
}
?>