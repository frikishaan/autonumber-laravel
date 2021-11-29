<?php

namespace Frikishaan\Autonumber\Tests\Unit;

use Frikishaan\Autonumber\Tests\Models\Invoice;
use Frikishaan\Autonumber\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateAutonumberTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function it_creates_a_new_autonumber_record()
    {
        $this->artisan('autonumber:create')
            ->expectsQuestion('Table Name (name of the table you wish to create autonumber in)', 'invoices')
            ->expectsQuestion('Name of the column in the table to be used as autonumber field', 'invoice_no')
            ->expectsQuestion('Prefix for autonumber (eg. ORD-4112, INV-7821)', 'INV-')
            ->expectsQuestion('Suffix for autonumber (Optional)', '')
            ->expectsQuestion('Seed Value (from where to start numbering)', '25')
            ->expectsQuestion('Minimum Digits to be included in every autonumber', '4')
            ->expectsTable(
                ['Table Name', 'Column Name', 'Prefix', 'Suffix', 'Seed Value', 'Min Digits', 'Preview'],
                [['invoices', 'invoice_no', 'INV-', '', '25', '4', implode("\n", ['INV-0025', 'INV-0026', 'INV-0027'])]]
            )
            ->expectsConfirmation('Do you wish to create this autonumber?', 'yes')
            ->assertSuccessful();

        $this->assertDatabaseCount('autonumbers', 1);        
    }

     /** @test */
    function it_throws_table_not_found_error()
    {
        $this->artisan('autonumber:create')
            ->expectsQuestion('Table Name (name of the table you wish to create autonumber in)', 'unknown_table')
            ->expectsOutput("Table does not exist with name 'unknown_table'")
            ->assertSuccessful();
    }

     /** @test */
    function it_throws_column_not_found_error()
    {
        $this->artisan('autonumber:create')
            ->expectsQuestion('Table Name (name of the table you wish to create autonumber in)', 'invoices')
            ->expectsQuestion('Name of the column in the table to be used as autonumber field', 'unknown_column')
            ->expectsOutput("The column with name 'unknown_column' does not exist in the table 'invoices'.")
            ->assertSuccessful();
    }

     /** @test */
     function it_throws_autonumber_exist_error()
     {
        $this->artisan('autonumber:create')
            ->expectsQuestion('Table Name (name of the table you wish to create autonumber in)', 'invoices')
            ->expectsQuestion('Name of the column in the table to be used as autonumber field', 'invoice_no')
            ->expectsQuestion('Prefix for autonumber (eg. ORD-4112, INV-7821)', 'INV-')
            ->expectsQuestion('Suffix for autonumber (Optional)', '')
            ->expectsQuestion('Seed Value (from where to start numbering)', '25')
            ->expectsQuestion('Minimum Digits to be included in every autonumber', '4')
            ->expectsTable(
                ['Table Name', 'Column Name', 'Prefix', 'Suffix', 'Seed Value', 'Min Digits', 'Preview'],
                [['invoices', 'invoice_no', 'INV-', '', '25', '4', implode("\n", ['INV-0025', 'INV-0026', 'INV-0027'])]]
            )
            ->expectsConfirmation('Do you wish to create this autonumber?', 'yes')
            ->assertSuccessful();

        $this->artisan('autonumber:create')
            ->expectsQuestion('Table Name (name of the table you wish to create autonumber in)', 'invoices')
            ->expectsQuestion('Name of the column in the table to be used as autonumber field', 'invoice_no')
            ->expectsOutput("An Autonumber record already exist for this column.")
            ->assertSuccessful();
     }
}