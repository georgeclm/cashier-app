<?php

namespace App\Console\Commands;

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Illuminate\Console\Command;

class PrintReceipt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'print:receipt';

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
     * @return int
     */
    public function handle()
    {
        $connector = new FilePrintConnector("php://stdout");
        $printer = new Printer($connector);
        $printer->text("Hello World!\n");
        $printer->cut();
        $printer->close();
        return 0;
    }
}
