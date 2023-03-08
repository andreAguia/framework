<?php

class Historico {

    /**
     * Exibe histórico de atividades no sistema
     * 
     * @author André Águia (Alat) - alataguia@gmail.com
     * 
     */
    private $tabela = null;
    private $idServidor = null;
    private $titulo = 'Histórico de Alterações';

###########################################################    

    public function __construct($tabela, $idServidor) {
        /**
         * Inicia a classe 
         * 
         * @syntax $hist = new Historico();
         */
        $this->tabela = $tabela;
        $this->idServidor = $idServidor;
    }

###########################################################

    public function set_titulo($titulo = null) {
        /**
         * Informa o nome da tabela
         * 
         * @syntax $field->set_class($class);
         */
        $this->titulo = $titulo;
    }

###########################################################

    public function show() {

        $select = 'SELECT idValor,
                          data,
                          idLog,
                          usuario,                          
                          ip
                     FROM tblog
                     LEFT JOIN tbusuario USING (idUsuario)
                    WHERE tabela="' . $this->tabela . '"
                      AND tblog.idServidor=' . $this->idServidor . '
                 ORDER BY idValor DESC, data';

        # Conecta com o banco de dados
        $intra = new Intra();
        $result = $intra->select($select);
        $contadorHistorico = $intra->count($select);

        if ($contadorHistorico > 0) {

            # Monta a tabela
            $tabela = new Tabela();
            $tabela->set_conteudo($result);
            $tabela->set_label(["Id", "Data", "Atividade", "Usuário", "IP"]);
            $tabela->set_align(["center", "center", "left"]);
            $tabela->set_funcao([null, "datetime_to_php"]);
            $tabela->set_titulo($this->titulo);
            $tabela->set_classe([null, null, "Log"]);
            $tabela->set_metodo([null, null, "getAtividades"]);
            $tabela->set_width([15, 25, 30, 15, 15]);
            $tabela->set_rowspan(0);
            $tabela->set_grupoCorColuna(0);

            $tabela->show();
        } else {
            tituloTable($this->titulo);

            $box = new Callout();
            $box->abre();

            p('Nenhum item encontrado !!', 'center');

            $box->fecha();
        }
    }

    ###########################################################
}
