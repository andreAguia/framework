<?php
Class Backup
{   
    /**
     * Classe que execute o Backup de um banco de dados inteiro
     * 
     * @author Raul Souza Silva - raul.3k@gmail.com e André Águia (Alat) - alataguia@gmail.com
     *
     * @group da conexão
     * @var private $host     string localhost O sevidor do banco de dados
     * @var private $driver   string mysql     O driver (sgdb) que será usado na conexão
     * @var private $user     string root      O usuário a ser usado na conexão
     * @var private $password string NULL      A senha
     * @var private $dbName   string NULL      O Nome do banco que sofrerá o backup
     * @var private $dsn      string NULL      A string de conexão do banco usando o PDO
     * @var private $tables   string NULL      Array de tabelas do banco de dados
     * @var private $handler  string NULL      O objeto da conexão
     * 
     * @group do backup
     * @var private $pastaDestino string NULL A pasta onde vai gravar o arquivo .sql
     * @var private $final        string NULL A string com o sql 
     * @var private $relatorio    string NULL O relatório (arquivo .txt) que será gravado junto com o backup
     * @var private $error        string NULL Array com os erros
     * 
     * @group de uso interno
     * @var private $numRegistros       integer 0    Contador de número de registro de uma determinada tabela
     * @var private $numTotalRegistros  integer 0    Contador dos registros de todas as tabelas
     * @var private $numTables          integer 0    Número de tabelas do banco de dados 
     * @var private $manual             boolean TRUE Infotma se é backup manual (TRUE) ou automático (FALSE)   
     */

    private $host = "localhost";
    private $driver = "mysql";
    private $user = "root";
    private $password = "";
    #private $password = "DSvuEtwz6h9HfLCF";
    private $dbName = NULL;
    private $pastaDestino = NULL;

    private $dsn = NULL;
    private $tables = array();
    private $handler = NULL;
    private $error = array();
    private $final = NULL;
    private $relatorio = NULL;
    private $numRegistros = 0;
    private $numTotalRegistros = 0;
    private $numTables = 0;
    private $manual = TRUE;

###########################################################    

    public function __construct($dbName = NULL,$manual = TRUE,$usuarioLogado = NULL){
    /**
     * Inicia a classe
     *  
     * @param $dbName        string  NULL O nome do banco de dados que sofrerá o backup
     * @param $manual        boolean TRUE Informa se o backup é manual (TRUE) ou automático (FALSE)
     * @param $usuarioLogado string  NULL Informa o nome do usuário que executou o backup quando for manual
     * 
     * @syntax $backup = new Backup($dbName,[$manual],[$usuarioLogado]);
     * 
     * @note Importante ressaltar que a diferença entre o backup manual e o automático é que no manual existe um usuário que efetivamente executa a rotina e no automático é o sistema que executa esse backup.
     */

        if(!$dbName) $this->error[] = 'Parameter database missing';

        if(count($this->error)>0){
            return;
        }

        $this->dbName = $dbName;
        $this->manual = $manual;

        # Pega a pasta de backup
        $intra = new Intra();
        $pastaBackup = $intra->get_variavel('pastaBackup');
        $this->pastaDestino = "../$pastaBackup/";

        # Escreve na string o cabeçalho
        $this->final = "-- UENF - Universidade do Norte Fluminense\n";
        $this->final .= "-- GRH - Gerência de Recursos Humanos\n";
        $this->final .= "-- Rotina de Backup de Sistema\n";

        if($this->manual){
            $this->final .= "-- Backup Manual\n";
            $this->final .= "-- Realizado em: ".date("d-m-Y, g:i a")." pelo usuário: ".$usuarioLogado."\n";
        }else{
            $this->final .= "-- Backup Automático\n";
            $this->final .= "-- Realizado em: ".date("d-m-Y, g:i a")."\n";
        }
        $this->final .= "\n--";
        $this->final .= "\n--  Backup do Banco: ".$this->dbName;
        $this->final .= "\n--\n\n";
        $this->final .= 'CREATE DATABASE IF NOT EXISTS '.$this->dbName.";\n";

        # Escreve relatório
        $this->relatorio = "-- UENF - Universidade do Norte Fluminense\n";
        $this->relatorio .= "-- GRH - Gerência de Recursos Humanos\n";
        $this->relatorio .= "-- Relatório de Backup de Sistema\n";
        if($this->manual){
            $this->relatorio .= "-- Backup Manual\n";
            $this->relatorio .= "-- Realizado em: ".date("d-m-Y, g:i a")." pelo usuário: ".$usuarioLogado."\n";
        }else{
            $this->relatorio .= "-- Backup Automático\n";
            $this->relatorio .= "-- Realizado em: ".date("d-m-Y, g:i a")."\n";
        }
        $this->relatorio .= "\n--  Backup do Banco: ".$this->dbName;    
        $this->relatorio .= "\n-- ---------------------------------------------------";


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

    public function backup(){

        /**
         * Executa o backup
         * 
         * @syntax $backup->backup();
         */

        //return $this->final;
        if(count($this->error)>0){
            return array('error'=>true, 'msg'=>$this->error);
        }else{
            # cria uma pasta para o backup
            $pasta = $this->pastaDestino.'/'.date('Y.m.d');
            if(!file_exists($pasta)){
                    mkdir($pasta);
            }

            # Abre o arquivo texto com o nome do banco.txt
            if($this->manual){
                $nomeArquivo = $pasta.'/'.date('Y.m.d.H.i').'.M.'.$this->dbName;
            }else{
                $nomeArquivo = $pasta.'/'.date('Y.m.d.H.i').'.A.'.$this->dbName;
            }

            # Arquivo sql
            $back = fopen($nomeArquivo.'.sql','w');    

            # Arquivo txt (relatório)
            $rel = fopen($nomeArquivo.'.txt','w');    

            # Escreve nos arquivos
            fwrite($back,$this->final);
            fwrite($rel,$this->relatorio);

            # Fecha o arquivo
            fclose($back);
            fclose($rel);

            #return array('error'=>false, 'msg'=>$this->final);
        }
    }

###########################################################   

    protected function generate(){

        /**
         * Gera a string do backup
         * 
         * @syntax $this->generate();
         */

        foreach ($this->tables as $tbl) {
            # Arquivo sql
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

            # arquivo txt (relatório)

            $this->relatorio .= "\n-- Tabela: ".$tbl['name'];
            $tamanhoNome = strlen($tbl['name']);
            if($tamanhoNome < 8){
                $this->relatorio .= "\t";
            }

            if($tamanhoNome < 16){
                $this->relatorio .= "\t";
            }

            $this->relatorio .= "\t- Registros copiados: ".$tbl['numReg'];
        }
        $this->final .= "\n-- ---------------------------------------------------";
        $this->final .= "\n--   FIM DO ARQUIVO";
        $this->final .= "\n-- ---------------------------------------------------";

        $this->relatorio .= "\n-- ---------------------------------------------------";
        $this->relatorio .= "\n-- ".$this->numTables ." tabelas copiadas\t\t- Registros copiados: ".$this->numTotalRegistros;
        $this->relatorio .= "\n-- ---------------------------------------------------";

    }

###########################################################   

    protected function connect(){

        /**
         * Conecta a um banco de dados
         * 
         * @syntax $this->connect();
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

    protected function getTables(){

        /**
         * Pega a lista de tabelas
         * 
         * @syntax $this->getTables();
         */

        try {
            $stmt = $this->handler->query('SHOW TABLES');
            $tbs = $stmt->fetchAll();
            $i=0;
            foreach($tbs as $table){
                $this->tables[$i]['name'] = $table[0];
                $this->tables[$i]['create'] = $this->getColumns($table[0]);
                $this->tables[$i]['data'] = $this->getData($table[0]);
                $this->tables[$i]['numReg'] = $this->numRegistros;
                $this->numTotalRegistros += $this->numRegistros;
                $this->numRegistros = 0; // zera o contador de registro para a próxima tabela
                $i++;
            }
            $this->numTables = $i;
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

    protected function getColumns($tableName){

        /**
         * Pega a lista de colunas de uma tabela
         * 
         * @param $tableName string NULL O nome da tabela
         * 
         * @syntax $this->getColumns($tableName);
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

    protected function getData($tableName){

        /**
         * Pega os dados da tabela
         * 
         * @param $tableName string NULL O nome da tabela
         * 
         * @syntax $this->getData([$tableName]);
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
                $this->numRegistros++;
            }
            return $data;
        } catch (PDOException $e){
            $this->handler = null;
            $this->error[] = $e->getMessage();
            return false;
        }
    }
}