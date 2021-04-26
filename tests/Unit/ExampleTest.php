<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->status());
      //  $this->assertTrue(true);
    }
}
