<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Box;
class StudentTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }

     public function testHasItemInBox()
    {
       $arr = 'Rahul';
        $this->assertTrue( $arr, 'Rahul');
    }

   
}
