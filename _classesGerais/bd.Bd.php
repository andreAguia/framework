<?php

abstract class Bd {

    /**
     * Classe mãe de acesso ao banco de dados
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     * @note Todas as outras classes que acessam os banco de dados devem herdar da classe Bd
     */
    private $host = null;   // string O nome do servidor
    private $user = null;   // string O nome do usuário para o login no servidor de banco de dados
    private $pass = null;   // string O password (senha) para o login no servidor de banco de dados
    private $name = null;   // string O nome do Banco de dados
    private $type = null;   // string O tipo do SGDB: pgsql | mysql | sqlite | ibase | oci8 | mssql
    private $conn = null;   // object O objeto de conexão
    private $lastId = null; // string Guarda o último id de uma gravação

###########################################################

    public function __construct($host = null, // string O nome do servidor
            $user = null, // string O nome do usuário para o login no servidor de banco de dados
            $pass = null, // string O password (senha) para o login no servidor de banco de dados
            $name = null, // string O nome do Banco de dados
            $type = null) {  // string O tipo do SGDB: pgsql | mysql | sqlite | ibase | oci8 | mssql
        /**
         * Inicia a classe informando os dados da conexão
         *  
         * Preenche as variáveis de conexão
         * 
         * @syntax $bd = new Bd($host,$user,$pass,$name,$type);
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

    public function conecta() {
        /**
         * Conecta efetivamente
         * 
         * Inicia uma conexão com o SGBD
         * 
         * @syntax $bd->conecta();
         */
        switch ($this->type) {
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

    public function select($select = null, // string O select do banco de dados
            $many = true, // bool   Se true retorna uma array com vários registros, se falso retorna um array simples com apenas um registro
            $assoc = false) {              // bool   Se o retorno é somente associativo  
        /**
         * Retorna um array multidimenssional, se many is true, com os registros do banco de dados, ou um valor único dependendo do formato do campo no banco de dados, quando $many is false.
         * 
         * @syntax $bd->select($select, [$many]);    
         */

        try {
            $this->conecta();

            if ($many) {
                if ($assoc) {
                    $row = $this->conn->query($select)->fetchall(PDO::FETCH_ASSOC);
                } else {
                    $row = $this->conn->query($select)->fetchall();
                }
            } else {
                if ($assoc) {
                    $row = $this->conn->query($select)->fetch(PDO::FETCH_ASSOC);
                } else {
                    $row = $this->conn->query($select)->fetch();
                }
            }

            $this->conn = null;
            return $row;
        } catch (PDOException $e) {
            print "ERRO! " . $e->getMessage() . "<br />";
            die();
        }
    }

###########################################################

    public function gravar($campos = null, // array   Array com o nome dos campos a serem gravados
            $valor = null, // array   Array com os valores a serem gravados na sequencia identica ao array de campos
            $idValor = null, // string  Se preenchido a gravação será update no id informado, se for nulo será insert
            $tabela = null, // string  O Nome da Tabela a ser gravada
            $idCampo = null, // string  O Nome do campo chave da tabela
            $alerta = false) {    // bool    Exibe o não um alert informando se houve gravação com sucesso
        /**
         * Grava no banco de dados
         *
         * @syntax $bd->gravar($campos, $valor, [$idValor], $tabela, [$idCampo], [$alerta]);
         */

        try {
            $this->conecta();

            if (is_null($idValor) or ($idValor == "")) {

                # Novo registro (insert)
                $sql = 'INSERT INTO ' . $tabela . ' (';

                $count = count($campos);
                $a = 0; // usado para resolver um curioso problema com o rtrim que não funcionou

                foreach ($campos as $field) {
                    $sql .= $field . ',';
                }

                # Retira o último ',' de $sql
                $sql = rtrim($sql, ',');

                $sql .= ') VALUES (';

                foreach ($valor as $field) {
                    $a++;
                    if (is_null($field)) {
                        $sql .= 'null';
                    } else {
                        #$field = utf8_encode($field); // garante que será gravado em utf-8
                        $sql .= "'$field'";
                    }

                    if ($a < $count) {
                        $sql .= ",";
                    }
                }

                #$sql = trim($sql,","); # Retira o último ',' de $sql (não funcionou !!)
                $sql .= ')';
            } else {
                # Atualiza registro (update)    	}
                $sql = 'UPDATE ' . $tabela . ' SET ';

                if (is_array($campos)) {
                    $contador = count($campos);
                    for ($a = 0; $a < $contador; $a++) {
                        if (is_null($valor[$a])) {
                            $sql .= $campos[$a] . " = null,";
                        } else {
                            $sql .= $campos[$a] . " = '" . $valor[$a] . "',";
                        }
                    }

                    # Retira o último ',' de $sql
                    $sql = rtrim($sql, ',');
                } else {
                    $sql .= $campos . " = '" . $valor . "' ";
                }

                $sql .= ' WHERE ' . $idCampo . ' = ' . $idValor;
            }
            echo $sql,"<br>";
            # Executa o sql
            $this->conn->exec($sql);
            $this->lastId = $this->conn->lastInsertId();

            if ($alerta) {
                alert("Registro salvo com sucesso!");
            }
        } catch (PDOException $e) {
            print "ERRO! " . $e->getMessage() . "<br />";
            die();
        }
    }

###########################################################

    public function excluir($idValor = null, // integer O id a ser excluído
            $tabela = null, // string  O nome da tabela
            $idCampo = null) {   // string  O nome do campo id nessa tabela
        /**
         * Exclui um registro do banco de dados
         *
         * @syntax $bd->excluir($idValor, $tabela, [$idCampo]);
         */

        try {
            $this->conecta();
            $sql = 'DELETE FROM ' . $tabela . ' WHERE ' . $idCampo . ' = ' . $idValor;
            #echo $sql;
            # Executa o sql
            $this->conn->exec($sql);

            #alert("Registro excluído com sucesso!"); //Silencio é de ouro
        } catch (PDOException $e) {
            print "ERRO! " . $e->getMessage() . "<br />";
            die();
        }
    }

###########################################################

    public function count($select = null) {     // string O select que será contado os registros
        /**
         * Informa o número inteiro com a quantidade de rows de um select
         * 
         * @syntax $bd->count($select);
         * 
         * @return Inteiro com o número de linhas de um select
         */

        try {
            $this->conecta();

            $row = $this->conn->query($select)->fetchall();
            $num_rows = $this->conn->query($select)->rowCount();

            $this->conn = null;

            return $num_rows;
        } catch (PDOException $e) {
            print "ERRO! " . $e->getMessage() . "<br />";
            die();
        }
    }

    ###########################################################

    public function get_lastId() {
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

    public function set_lastId($lastId = null) { // integer O número do id a ser gravado
        /**
         * Grava a variável lastId
         * 
         * @syntax $bd->set_lastId($lastId);
         * 
         * @note Essa função é usada na tabela de movimento que, sempre, faz duas gravações ao efetuar uma inclusão e usa esta função para resgatar o last id da primeira gravação
         */
        $this->lastId = $lastId;
    }

    ###########################################################

    public function update($sql = null) {    // string O sql para o update
        /**
         * Executa um update no banco de Dados
         * 
         * @note Essa função é usada para update de diversos registros ao mesmo tempo. Para update de apenas um registro recomenda-se o uso do método gravar.
         * 
         * @deprecated 
         */
        try {
            # conecta
            $this->conecta();

            # Executa o sql
            $this->conn->exec($sql);
        } catch (PDOException $e) {
            print "ERRO! " . $e->getMessage() . "<br />";
            die();
        }
    }

    ###########################################################
}