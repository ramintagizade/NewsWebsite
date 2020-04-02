<?php

namespace App\Service;
use Monolog\Logger;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DataFetcher  {

    private $logger; 

    public function __construct($logger) {
        $this->logger = new Logger("DataFetcher");
    }

   // lets initiate our cron job to fetch data every day and store it into the database;
   // first of all , make a mysql table 
   // check if you need to send request to server_api for resource 

    public function startCronJob() {
       // check if you need to make a request to server 
        $this->logger->info("started a cron job");
        //shell_exec(dirname(__FILE__) ."/run_cron.sh > /dev/null 2>/dev/null &");
        //$process = new Process(dirname(__FILE__) ."/run_cron.sh > /dev/null 2>/dev/null &");
        //$process->start();
        
        $this->logger->info("finished a cron job");
    }

}

$cron = new DataFetcher("index");
$cron->startCronJob();

?>