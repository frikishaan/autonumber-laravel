<?php

namespace Frikishaan\Autonumber\Console;

use Frikishaan\Autonumber\Models\Autonumber;
use Illuminate\Console\Command;

class ListAllAutonumbersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autonumber:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all autonumbers you have created';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $autonumbers = Autonumber::select('table_name', 'column_name', 'prefix', 'suffix', 'min_digits')->get();

        if (count($autonumbers) > 0) {
            $this->info('Below is the list of all autonumbers you have created');

            $this->table(
                ['Table Name', 'Column Name', 'Prefix', 'Suffix', 'Min Digits'],
                $autonumbers
            );
        } else {
            $this->info('You have not created any autonumbers yet. Create one using the command `php artisan autonumber:create`');
        }
    }
}
