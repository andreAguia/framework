<?php

class Processo {

    /**
     * Inicia uma rotina php em segundo plano
     *
     * @author Douglas V. Pasqua
     */
    public function run($cmd) {
        /**
         * Roda a rotina em segundo plano e retorna o seu PID
         * 
         * @syntax $processo->run($cmd);
         * 
         * @param $cmd string null O nome do arquivo .php que será executado em segundo plano
         */
        $cmd = sprintf("nohup %s >/dev/null 2>&1 & echo $!", $cmd);
        exec($cmd, $output);
        return(trim($output[0]));
    }

    ###########################################################

    public function isRunning($pid) {
        /**
         * Verifica pelo PID se o processo ainda está rodando
         * 
         * @syntax $processo->isRunning($pid);
         * 
         * @param $pid string null O PID fornecido quando se rodou o processo
         */
        $command = "/bin/ps -p $pid";
        exec($command, $output);

        if (isset($output[1])) {
            return true;
        }

        return false;
    }

    ###########################################################

    public function kill($pid) {
        /**
         * finaliza o processo
         * 
         * @syntax $processo->kill($pid);
         * 
         * @param $pid string null O PID fornecido quando se rodou o processo
         */
        $command = "/bin/kill $pid";
        exec($command);
    }

}
