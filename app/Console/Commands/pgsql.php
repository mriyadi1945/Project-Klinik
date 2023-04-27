<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class pgsql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pgsql:createdb';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schema = env('DB_SCHEMA');
        try {
            $connectionName = config('database.default');
            $databaseName = config("database.connections.{$connectionName}.database");
            $query = "CREATE SCHEMA $schema;";
            DB::statement($query);
            config(["database.connections.pgsql.database" => $schema]);
            $this->info(sprintf('Successfully created %s database schema', $schema));
        }
        catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
