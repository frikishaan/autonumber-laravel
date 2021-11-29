<?php

namespace Frikishaan\Autonumber\Tests\Unit;

use Frikishaan\Autonumber\Models\Autonumber;
use Frikishaan\Autonumber\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListAutonumbersTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function it_lists_all_autonumbers()
    {
        // Create autonumbers
        Autonumber::create([
            'table_name' => 'orders',
            'column_name' => 'order_no',
            'prefix' => 'ORD-',
            'suffix' => '',
            'min_digits' => 4,
            'next_number' => 25
        ]);

        Autonumber::create([
            'table_name' => 'cases',
            'column_name' => 'case_no',
            'prefix' => 'CASE-',
            'suffix' => '-SERVICE',
            'min_digits' => 4,
            'next_number' => 256
        ]);

        $this->assertDatabaseCount('autonumbers', 2);

        $this->artisan('autonumber:list')
            ->expectsTable(
                ['Table Name', 'Column Name', 'Prefix', 'Suffix', 'Min Digits'],
                [
                    ['orders', 'order_no', 'ORD-', '', '4'],
                    ['cases', 'case_no', 'CASE-', '-SERVICE', '4']
                ]
            )
            ->assertExitCode(0);        
    }
}