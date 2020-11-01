<?php

namespace App\Tests;



use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    /**
     * Premier test qui permet de valider que phpunit fonctionne
     */
    public function testTestsAreWorking()
    {
        $this->assertEquals(2, 1+1);
    }
}