<?php

namespace Frikishaan\Autonumber\Tests\Unit;

use Frikishaan\Autonumber\Tests\Models\Invoice;
use Frikishaan\Autonumber\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenerateAutonumberTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function it_generates_autonumber()
    {
        // Create autonumber
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
            ->assertExitCode(0);
        
        $invoice = Invoice::create([
            'customer' => 'John Doe', 
            'amount' => 1499.00
        ]);

        $this->assertEquals('INV-0025', $invoice->invoice_no);

        $invoice = Invoice::create([
            'customer' => 'Alan Donald', 
            'amount' => 499.00
        ]);

        $this->assertEquals('INV-0026', $invoice->invoice_no);
    }
}