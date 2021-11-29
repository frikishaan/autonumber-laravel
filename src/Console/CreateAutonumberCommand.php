<?php

namespace Frikishaan\Autonumber\Console;

use Frikishaan\Autonumber\Models\Autonumber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class CreateAutonumberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autonumber:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create autonumber for your model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $table_name = $this->askWithValidation('Table Name (name of the table you wish to create autonumber in)', ['required'], 'table_name');

        // Check if table exist
        if (! Schema::hasTable($table_name)) {
            $this->error("Table does not exist with name '$table_name'");

            return;
        }

        $column_name = $this->askWithValidation('Name of the column in the table to be used as autonumber field', ['required'], 'column_name');

        // Check if column exist
        if (! Schema::hasColumn($table_name, $column_name)) {
            $this->error("The column with name '$column_name' does not exist in the table '$table_name'.");

            return;
        }

        // Check if a autonumber already exist for this column
        if ($this->isAutoumberExist($table_name, $column_name)) {
            $this->error('An Autonumber record already exist for this column.');
            $this->error('Use command `php artisan autonumber:list` to check all existing autonumbers');

            return;
        }

        $prefix = $this->askWithValidation('Prefix for autonumber (eg. ORD-4112, INV-7821)', ['required'], 'prefix');
        $suffix = $this->askWithValidation('Suffix for autonumber (Optional)', [], 'suffix');
        $seed_value = $this->askWithValidation('Seed Value (from where to start numbering)', ['integer'], 'seed_value');
        $min_digits = $this->askWithValidation('Minimum Digits to be included in every autonumber', ['integer', 'min:1'], 'min_digits');

        $example_autonumbers = [
            $prefix.sprintf('%0'.$min_digits.'d', $seed_value).$suffix,
            $prefix.sprintf('%0'.$min_digits.'d', $seed_value + 1).$suffix,
            $prefix.sprintf('%0'.$min_digits.'d', $seed_value + 2).$suffix,
        ];

        $this->table(
            ['Table Name', 'Column Name', 'Prefix', 'Suffix', 'Seed Value', 'Min Digits', 'Preview'],
            [[$table_name, $column_name, $prefix, $suffix, $seed_value, $min_digits, implode("\n", $example_autonumbers)]]
        );

        if ($this->confirm('Do you wish to create this autonumber?', true)) {
            $autonumber = $this->createAutonumber($table_name, $column_name, $prefix, $suffix, $min_digits, $seed_value);
            if ($autonumber) {
                $this->info("Autonumber is created for '$table_name' table");
            }
        }
    }

    /**
     * Function to ask for input and validate it.
     *
     * @param  string  $message
     * @param  array  $rules
     * @param  string  $name
     */
    public function askWithValidation(string $message, array $rules = [], string $name)
    {
        $answer = $this->ask($message);

        $validator = Validator::make([
            $name => $answer,
        ], [
            $name => $rules,
        ]);

        if ($validator->passes()) {
            return $answer;
        }

        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }

        return $this->askWithValidation($message, $rules, $name);
    }

    /**
     * Function to check if autonumber already exist for the given table.
     *
     * @param  string  $table
     * @param  string  $column
     * @return bool
     */
    public function isAutoumberExist(string $table, string $column): bool
    {
        $autonumber = Autonumber::where('table_name', $table)->where('column_name', $column)->get();

        return (bool) (count($autonumber) > 0);
    }

    /**
     * Function to create autonumber record in DB.
     *
     * @param  string  $table
     * @param  string  $column
     * @param  string  $prfix
     * @param  string  $suffix
     * @param  int  $min_digits
     * @param  int  $seed_value
     */
    public function createAutonumber($table, $column, $prefix, $suffix, $min_digits, $seed_value): Autonumber
    {
        return Autonumber::create([
            'table_name' => $table,
            'column_name' => $column,
            'prefix' => $prefix,
            'suffix' => $suffix,
            'min_digits' => $min_digits,
            'next_number' => $seed_value,
        ]);
    }
}
