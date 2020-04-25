<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\API\TestController;

class CallRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:call';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       
        $f = fopen( 'php://stdin', 'r' );

        while( $line = fgets( $f ) ) {
            $line = preg_split("/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[\s,]+/", $line, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            // print_r($line);
            // return;
            if(!empty($line)){
                $case = $line[0];
                switch ($case) {
                    case 'SET':
                        echo "GET1";
                        if($line[1] == "empdata"){
                            TestController::addEmployee($line);
                        }else if($line[1] == "empwebhistory"){
                            TestController::addEmpWebHistory($line);
                        }
                        break;

                    case 'GET':
                        if($line[1] == "empdata"){
                            TestController::getEmployee($line);
                        }else if($line[1] == "empwebhistory"){
                            TestController::getEmpWebHistory($line);
                        }
                        break;

                    case 'UNSET':
                        if($line[1] == "empdata"){
                            TestController::delEmployee($line);
                        }else if($line[1] == "empwebhistory"){
                            TestController::delEmpWebHistory($line);
                        }
                        
                        break;
                    
                    default:
                        echo "Command not found!..";
                        break;
                }
            }

          return;
        }

        fclose( $f );

        exit;
        TestController::insert();
        echo "called...";
    }
}
