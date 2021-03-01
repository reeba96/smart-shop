<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class importXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importXml';

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

        $bar = $this->output->createProgressBar(2);

        $url='http://api.ewe.rs/share/backend/?user=go2networx&secretcode=58b30&attributes=1&images=1';

        $ch =curl_init();

        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_HEADER, false);
        $return = curl_exec ($ch);
        $info = curl_getinfo($ch);
        Storage::disk('local')->put('data\ewe.xml', $return);
        curl_close ($ch);
    }
}
