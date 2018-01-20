<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-docker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed docker DB container';

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
        $dumpStatement = "docker exec app_aset /usr/local/bin/php artisan db:seed";

        shell_exec($dumpStatement);
        $this->info('DB seeded successfully!');
    }
}
