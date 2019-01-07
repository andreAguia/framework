 <?php
 class Bd
{
    /**
     * Classe mãe de acesso so banco de dados
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @note Todas as outras classes que acessam os banco de dados devem herdar da classe Bd
     * 
     * @var private $host   string NULL O nome do servidor
     * @var private $user   string NULL O nome do usuário para o login no servidor de banco de dados
     * @var private $pass   string NULL O password (senha) para o login no servidor de banco de dados
     * @var private $name   string NULL O nome do Banco de dados
     * @var private $type   string NULL O tipo do SGDB: pgsql | mysql | sqlite | ibase | oci8 | mssql
     * @var private $conn   object NULL O objeto de conexão
     * @var private $lastId string NULL Guarda o último id de uma gravação
     *    
     */
    
    private $host = NULL;
    private $user = NULL;
    private $pass = NULL;
    private $name = NULL;
    private $type = NULL;		
    private $conn = NULL;
    private $lastId = NULL;
	
###########################################################
                
    public function __construct($host = NULL,$user = NULL,$pass = NULL,$name = NULL,$type = NULL){
    /**
     * Inicia a classe informando os dados da conexão
     *  
     * Preenche as variáveis de conexão
     * 
     * @syntax $bd = new Bd($host,$user,$pass,$name,$type);
     * 
     * @param $host string NULL O Nome do Servidor
     * @param $user string NULL O nome do usuário
     * @param $pass string NULL A senha de conexão
     * @param $name string NULL O nome do Banco de dados
     * @param $type string NULL O SGDB: pgsql | mysql | sqlite | ibase | oci8 | mssql
     * 
     * @example exemplo.bd.construtor.php
     */
    
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;
        $this->type = $type;
    }
	
###########################################################
    
    public function conecta(){
    /**
     * Conecta efetivamente
     * 
     * Inicia uma conexão com o SGBD
     * 
     * @syntax $bd->conecta();
     */
    
        switch ($this->type){
            case 'pgsql':
                $this->conn = new PDO("pgsql:dbname={$this->name};user={$this->user}; password={$this->pass};host=$this->host");
                break;
            case 'mysql':
                $this->conn = new PDO("mysql:host={$this->host};port=3306;dbname={$this->name};charset=UTF8", $this->user, $this->pass);
                $this->conn->exec("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
                break;
            case 'sqlite':
                $this->conn = new PDO("sqlite:{$this->name}");
                break;
            case 'ibase':
                $this->conn = new PDO("firebird:dbname={$this->name}", $this->user, $this->pass);
                break;
            case 'oci8':
                $this->conn = new PDO("oci:dbname={$this->name}", $this->user, $this->pass);
                break;
            case 'mssql':
                $this->conn = new PDO("mssql:host={$this->host},1433;dbname={$this->name}", $this->user, $this->pass);
                break;
        }	    
	    
        # Define para que o PDO lance exceções na ocorrência de erros
	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
	
###########################################################
    
   public function select($select = NULL,$many = TRUE,$orderCampo = NULL,$orderTipo = NULL){
    /**
     * Retorna um array multidimenssional, se many is TRUE, com os registros do banco de dados, ou um valor único dependendo do formato do campo no banco de dados, quando $many is FALSE.
     * 
     * @syntax $bd->select(select, [$many], [$orderCampo], [$orderTipo]);
     * 
     * @note Os parâmetros $orderCampo e $orderTipo só estão presentes no método para serem usados na classes filhas em caso de herança. 
     *   
     * @param $select       string NULL O select do banco de dados
     * @param $many         bool   TRUE Se TRUE retorna uma array com vários registros, se falso retorna um array simples com apenas um registro
     * @param $orderCampo   string NULL Define (se tiver) o campo do select de ordenação
     * @param $orderTipo    string NULL Define se a ordenação será ascendente ou descendente
     */    
    
    	try{
            $this->conecta();

            if ($many){
                $row = $this->conn->query($select)->fetchall();
            }else{
                $row = $this->conn->query($select)->fetch();
            }

            $this->conn = NULL;
            return $row;
    	}
    	catch(PDOException $e){
            print "ERRO! ".$e->getMessage()."<br />";
            die();
    	}
    	
    }
    
###########################################################
    
    public function gravar($campos = NULL,$valor = NULL,$idValor = NULL,$tabela = NULL,$idCampo = NULL,$alerta = FALSE){
    /**
     * Grava no banco de dados
     *
     * @syntax $bd->gravar($campos, $valor, [$idValor], $tabela, [$idCampo], [$alerta]); 
     * 
     * @param $campos   array   NULL Array com o nome dos campos a serem gravados
     * @param $valor    array   NULL Array com os valores a serem gravados na sequencia identica ao array de campos
     * @param $idValor  integer NULL Se preenchido a gravação será update no id informado, se for nulo será insert
     * @param $tabela   string  NULL Nome da Tabela a ser gravada
     * @param $idCampo  string  id   Nome do campos chave da tabela
     * @param $alerta   bool    TRUE Se TRUE informa com um alert se houve gravação com sucesso
     */
    
    	try {
            $this->conecta();

            if (is_null($idValor) or ($idValor == "")){

                # Novo registro (insert)
                $sql = 'INSERT INTO '.$tabela.' (';

                $count = count($campos);
                $a = 0;	// usado para resolver um curioso problema com o rtrim que não funcionou

                foreach ($campos as $field){
                    $sql .= $field.',';
                }

                # Retira o último ',' de $sql
                $sql = rtrim($sql,',');	

                $sql .= ') VALUES (';

                foreach ($valor as $field){	
                    $a++;
                    if (is_null($field)) {
                        $sql .= 'NULL';
                    } else {
                        #$field = utf8_encode($field); // garante que será gravado em utf-8
                        $sql .= "'$field'";
                    }

                    if ($a < $count){
                        $sql .= ",";
                    }
                }

                #$sql = trim($sql,","); # Retira o último ',' de $sql (não funcionou !!)
                $sql .=')';

            }else{
                # Atualiza registro (update)    	}
                $sql = 'UPDATE '.$tabela.' SET ';

                if (is_array($campos)) {
                    $contador = count($campos);
                    for ($a = 0; $a < $contador; $a++) {
                        if (is_null($valor[$a])) {
                            $sql .= $campos[$a] . " = NULL,";
                        } else {
                            $sql .= $campos[$a] . " = '" . $valor[$a] . "',";
                        }
                    }

                    # Retira o último ',' de $sql
                    $sql = rtrim($sql, ',');
                }else{
                    $sql .= $campos . " = '" . $valor . "' ";
                }

                $sql .= ' WHERE '.$idCampo.' = '.$idValor;		    		
            }
            #alert($sql);

            # Executa o sql
            $this->conn->exec($sql);
            $this->lastId = $this->conn->lastInsertId(); 

            if($alerta){
                alert("Registro salvo com sucesso!");
            }
        }
	    catch(PDOException $e){
            print "ERRO! ".$e->getMessage()."<br />";
            die();
    	}
    }
    
###########################################################
    
    public function excluir($idValor = NULL,$tabela = NULL,$idCampo = 'id'){
    /**
     * Exclui um registro do banco de dados
     *
     * @syntax $bd->excluir($idValor, $tabela, [$idCampo]); 
     * 
     * @param $tabela  string  NULL Informa a tabela
     * @param $idValor integer NULL Valor do id
     * @param $idCampo string  id   Nome do campo id na tabela. Normalmente é 'id'
     */
       
    	try {
            $this->conecta();
            $sql = 'DELETE FROM '.$tabela.' WHERE '.$idCampo.' = '.$idValor;	
            #echo $sql;
            
            # Executa o sql
            $this->conn->exec($sql);

            #alert("Registro excluído com sucesso!"); //Silencio é de ouro
        }
	    catch(PDOException $e){
            print "ERRO! ".$e->getMessage()."<br />";
            die();
    	}
    }
    
###########################################################
    
    public function count($select){
    /**
     * Informa o número inteiro com a quantidade de rows de um select
     * 
     * @syntax $bd->count($select);
     * 
     * @return Inteiro com o número de linhas de um select
     * 
     * @param $select string NULL O select do banco de dados
     */
    
    
    	try {
            $this->conecta();

            $row = $this->conn->query($select)->fetchall();
            $num_rows = $this->conn->query($select)->rowCount();	    	

            $this->conn = NULL;


            return $num_rows;
    	}
    	catch(PDOException $e){
            print "ERRO! ".$e->getMessage()."<br />";
            die();
    	}    	
    }
    
 ###########################################################
    
    public function get_lastId(){
    /**
     * Informa o id da última gravação
     * 
     * @syntax $bd->get_lastId();
     * 
     * @return Inteiro com o id utilizado na última gravação
     */
    
    	return $this->lastId;
    }
    
    ###########################################################
    
    public function set_lastId($lastId){
    /**
     * Grava a variável lastId
     * 
     * @syntax $bd->set_lastId($lastId);
     * 
     * @note Essa função é usada na tabela de movimento que, sempre, faz duas gravações ao efetuar uma inclusão e usa esta função para resgatar o last id da primeira gravação
     * 
     * @param $lastId integer NULL O número do id a ser gravado
     */
	$this->lastId = $lastId;
    }
    
    ###########################################################
    
    public function update($sql = NULL){
    /**
     * Executa um update no banco de Dados
     * 
     * @note Essa função é usada para update de diversos registros ao mesmo tempo. Para update de apenas um registro recomenda-se o uso do método gravar.
     * 
     * @deprecated  
     * 
     * @param $sql string NULL O sql para o update
     */
	try {
            # conecta
            $this->conecta();
            
            # Executa o sql
            $this->conn->exec($sql);
        }     
	    catch(PDOException $e){
            print "ERRO! ".$e->getMessage()."<br />";
            die();
    	}
    }
    
    ###########################################################
}
