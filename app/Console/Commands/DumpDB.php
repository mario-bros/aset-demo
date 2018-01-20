<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DumpDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump-schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump DB to path database/backup-schema.sql';

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
        $DB_DATABASE = escapeshellarg(env('DB_DATABASE'));
        $DB_USERNAME = escapeshellarg(env('DB_USERNAME'));
        $DB_PASSWORD = escapeshellarg(env('DB_PASSWORD'));

        $userParam = "-u$DB_USERNAME ";
        $passwordParam = "-p$DB_PASSWORD ";
        $noDataParam = "--no-data ";

        $dumpStatement = "docker exec db_aset /usr/bin/mysqldump ";
        $dumpStatement .= $userParam;
        $dumpStatement .= $passwordParam;
        $dumpStatement .= $noDataParam;
        $dumpStatement .= "$DB_DATABASE > ./database/backup-schema.sql";

        shell_exec($dumpStatement);
        $this->info('DB exported successfully!');
    }
}
