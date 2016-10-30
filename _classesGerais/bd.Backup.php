<?php
Class Backup {
    
/**
 * Classe de Backup do banco de dados
 * 
 * @author Raul Souza Silva (raul.3k@gmail.com)
 *
 * @var private $host     string O sevidor do banco de dados
 * @var private $driver   string O driver (sgdb) que será usado na conexão
 * @var private $user     string O usuário a ser usado na conexão
 * @var private $password string A senha
 * @var private $dbName   string O Nome do banco que sofrerá o backup
 * @var private $pastaDestino string A pasta onde vai gravar o arquivo .sql;
 * 
 * @var private $dsn      string A string de conexão do banco usando o PDO
 * @var private $tables   string Array de tabelas do banco de dados
 * @var private $handler  string O objeto da conexã0
 * @var private $error    string Array com os erros
 * @var private $final    string A string com o sql
 * 
 
 */
    
    private $host = "localhost";
    private $driver = "mysql";
    private $user = "root";
    private $password = "";
    private $dbName;
    private $pastaDestino = "../_backup/";
   
    private $dsn;
    private $tables = array();
    private $handler;
    private $error = array();
    private $final;
    
###########################################################    
    
    public function __construct($args){
        /**
         * The main function
         * @method DBBackup
         * @uses Constructor
         * @param Array $args{host, driver, user, password, database}
         * @example $db = new DBBackup(array('host'=>'my_host', 'driver'=>'bd_type(mysql)', 'user'=>'db_user', 'password'=>'db_password', 'database'=>'db_name'));
         */
     
        if(!$args['host']) $this->error[] = 'Parameter host missing';
        if(!$args['user']) $this->error[] = 'Parameter user missing';
        if(!isset($args['password'])) $this->error[] = 'Parameter password missing';
        if(!$args['database']) $this->error[] = 'Parameter database missing';
        if(!$args['driver']) $this->error[] = 'Parameter driver missing';

        if(count($this->error)>0){
            return;
        }

        $this->host = $args['host'];
        $this->driver = $args['driver'];
        $this->user = $args['user'];
        $this->password = $args['password'];
        $this->dbName = $args['database'];

        # Escreve na string o cabeçalho
        $this->final = "-- UENF - Universidade do Norte Fluminense\n";
        $this->final .= "-- GRH - Gerência de Recursos Humanos\n";
        $this->final .= "-- Rotina de Backup de Sistema\n";
        $this->final .= "-- Realizado em: ".date("d-m-Y, g:i a\n");
        $this->final .= "\n--";
        $this->final .= "\n--  Backup do Banco: ".$this->dbName;
        $this->final .= "\n--\n\n";
        $this->final .= 'CREATE DATABASE IF NOT EXISTS '.$this->dbName.";\n";

        if($this->host=='localhost'){
            // We have a little issue in unix systems when you set the host as localhost
            $this->host = '127.0.0.1';
        }
        $this->dsn = $this->driver.':host='.$this->host.';dbname='.$this->dbName;

        $this->connect();
        $this->getTables();
        $this->generate();
    }
    
###########################################################    
    
    public function backup($manual = FALSE){
        
        /**
         * Call this function to get the database backup
         * @example DBBackup::backup();
         */

        //return $this->final;
        if(count($this->error)>0){
            return array('error'=>true, 'msg'=>$this->error);
        }else{
            # cria uma pasta para o backup
            $pasta = $this->pastaDestino.'\\'.date('Y.m.d');
            if(!file_exists($pasta))
                    mkdir($pasta);
            
            # Abre o arquivo texto com o nome do banco.txt
            if($manual){
                $back = fopen($pasta.'\\'.date('Y.m.d.H.i').'.M.'.$this->dbName.'.sql','w');
            }else{
                $back = fopen($pasta.'\\'.date('Y.m.d.H.i').'.A.'.$this->dbName.'.sql','w');
            }
                
            
            # Escreve no arquivo
            fwrite($back,$this->final);
				
            # Fecha o arquivo
            fclose($back);
            
            #return array('error'=>false, 'msg'=>$this->final);
        }
    }
    
###########################################################   

    private function generate(){
        
        /**
         * Generate backup string
         * @uses Private use
         */
    
        foreach ($this->tables as $tbl) {
            $this->final .= "\n-- ---------------------------------------------------";
            $this->final .= "\n";
            $this->final .= "\n--";
            $this->final .= "\n--  Estrutura da Tabela: ".$tbl['name'];
            $this->final .= "\n--\n\n";
            $this->final .= $tbl['create'] . ";\n";
            $this->final .= "\n--";
            $this->final .= "\n--  Extraindo dados da Tabela: ".$tbl['name'];
            $this->final .= "\n--\n\n";
            $this->final .= $tbl['data'];
        }
        $this->final .= "\n-- ---------------------------------------------------";
        $this->final .= "\n--   FIM DO ARQUIVO";
        $this->final .= "\n-- ---------------------------------------------------";
        
    }
    
###########################################################   
    
    private function connect(){
        
        /**
         * Connect to a database
         * @uses Private use
         */
    
        try {
            $this->handler = new PDO($this->dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            $this->handler = null;
            $this->error[] = $e->getMessage();
            return false;
        }
    }

###########################################################
    
    private function getTables(){
        
        /**
         * Get the list of tables
         * @uses Private use
         */
    
        try {
            $stmt = $this->handler->query('SHOW TABLES');
            $tbs = $stmt->fetchAll();
            $i=0;
            foreach($tbs as $table){
                $this->tables[$i]['name'] = $table[0];
                $this->tables[$i]['create'] = $this->getColumns($table[0]);
                $this->tables[$i]['data'] = $this->getData($table[0]);
                $i++;
            }
            unset($stmt);
            unset($tbs);
            unset($i);

            return true;
        } catch (PDOException $e) {
            $this->handler = null;
            $this->error[] = $e->getMessage();
            return false;
        }
}

###########################################################

    private function getColumns($tableName){
        
        /**
         * Get the list of Columns
         * @uses Private use
         */
    
        try {
            $stmt = $this->handler->query('SHOW CREATE TABLE '.$tableName);
            $q = $stmt->fetchAll();
            $q[0][1] = preg_replace("/AUTO_INCREMENT=[\w]*./", '', $q[0][1]);
            return $q[0][1];
        } catch (PDOException $e){
            $this->handler = null;
            $this->error[] = $e->getMessage();
            return false;
        }
    }

###########################################################
    
    private function getData($tableName){
        
        /**
         * Get the insert data of tables
         * @uses Private use
         */

        try {
            $stmt = $this->handler->query('SELECT * FROM '.$tableName);
            $q = $stmt->fetchAll(PDO::FETCH_NUM);
            $data = '';
            foreach ($q as $pieces){
                foreach($pieces as &$value){
                        $value = htmlentities(addslashes($value));
                }
                $data .= 'INSERT INTO '. $tableName .' VALUES (\'' . implode('\',\'', $pieces) . '\');'."\n";
            }
            return $data;
        } catch (PDOException $e){
            $this->handler = null;
            $this->error[] = $e->getMessage();
            return false;
        }
    }
}