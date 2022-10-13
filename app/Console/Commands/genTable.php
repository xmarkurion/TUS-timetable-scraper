<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\TableGetterService;

class genTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:genTable {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates timetable from given course name';

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
//      $tableName = $this->argument("tableName");
        $a = new TableGetterService();
        $a->gettable(null);
        return 0;
    }
}
