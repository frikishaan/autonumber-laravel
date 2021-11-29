<?php

namespace Frikishaan\Autonumber\Tests\Unit;

use Frikishaan\Autonumber\Tests\Models\Invoice;
use Frikishaan\Autonumber\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function it_counts_users()
    {
        
        // $invoice = Invoice::all();
        // $this->assertCount(10, count($invoice));
        Invoice::create([
            'customer' => 'John Doe', 
            'amount' => 1499.00
        ]);
        Invoice::create([
            'customer' => 'Alan Donald', 
            'amount' => 3499.00
        ]);

        $this->assertDatabaseCount('invoices', 2);
        
    }
}