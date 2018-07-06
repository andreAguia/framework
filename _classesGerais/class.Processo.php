<?php
class Processo {
 /**
  * Abriga as várias rotina de verificação e conversão de Número de processo
  * 
  * @author André Águia (Alat) - alataguia@gmail.com
  * 
  * @var private $processo      string  NULL O número de processo a ser trabalhado
  * @var private $tipoProcesso  integer NULL Informa o tipo de processo: [0 -> Indefinido | 1 -> Atual | 2 -> Antigo] 
  */
    
    private $processo = NULL;       
    private $tipoProcesso = NULL;
    
###########################################################
    
    public function __construct($processo){
    /**
    * Método Construtor
    */
        
        # Executa somente se não estiver em branco
        if (!vazio($processo)){
            
            # Verifica se o número do processo é atual ou novo
            $contaBarra = substr_count($processo, '/');
            
            if($contaBarra == 2){
                $this->tipoProcesso = 2;    // Processo antigo
            }elseif($contaBarra == 3){
                $this->tipoProcesso = 1;    // Processo novo
            }else{
                $this->tipoProcesso = 0;    // Processo indefinido
            }
            
            # Divide o processo em partes
            $partes = explode("/",$processo);

            # Preenche com zero a esquerda
            if($this->tipoProcesso == 1){
                $partes[0] = str_pad($partes[0], 2, "0", STR_PAD_LEFT); 
                $partes[1] = str_pad($partes[1], 3, "0", STR_PAD_LEFT); 
                $partes[2] = str_pad($partes[2], 6, "0", STR_PAD_LEFT); 
                $ano = $partes[3];
            }elseif($this->tipoProcesso == 2){
                $partes[0] = str_pad($partes[0], 2, "0", STR_PAD_LEFT);
                $partes[1] = str_pad($partes[1], 6, "0", STR_PAD_LEFT); 
                $ano = $partes[2];
            }

            # Verifica o ano
            if(strlen($ano) == 2){
                if($ano > 70){
                    $ano = "19".$ano;
                }else{
                    $ano = "20".$ano;
                }
            }            

            # Ano com 3 números
            if((strlen($ano) == 3) OR (strlen($ano) == 1)){
                $msgErro.='O ano deve ter 4 dígitos!\n';
                $erro = 1;
            }

            # Ano com 4 números
            if(strlen($ano) == 4){
                # Ano futuro
                if($ano > date('Y')){
                    $msgErro.='O processo não pode ter ano futuro!\n';
                    $erro = 1;
                }

                # Ano muito antigo
                if($ano < '1970'){
                    $msgErro.= 'Não se pode cadastrar processo anteriores a 1970!\n';
                    $erro = 1;
                }
            }
            
            # Passa o E para maiúscula se não tiver
            $partes[0] = strtoupper($partes[0]);

            # Acerta o processo
            $processo = $partes[0]."/".$partes[1];
            if($this->tipoProcesso == 1){
                $processo .= "/".$partes[2]."/".$ano;
            }elseif($this->tipoProcesso == 2){
                $processo .= "/".$ano;
            }
        }
        
        # Passa o número acertado para a variavel
        $this->processo = $processo;
    }

###########################################################
    
    public function get_tipoProcesso(){
    /**
     * Retorna o tipo de processo
     * 
     * @syntax $processo->get_tipoProcesso();  
     */
    
        return $this->tipoProcesso;
        
    }
    
###########################################################
    
    public function get_numero(){
    /**
     * Retorna o número do processo Acertado 
     * 
     * @syntax $processo->get_tipoProcesso();  
     */
    
        return $this->processo;
        
    }
    
###########################################################
    
}