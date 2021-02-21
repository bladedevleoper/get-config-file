<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Models\Roaster;
use PHPUnit\Framework\TestCase;
use \Mockery;

class RoasterModelTest extends TestCase
{
    /** @test */
    public function can_inject_stub_into_model_constructor()
    {
        $db = Mockery::mock(QueryFactory::class);
        $roaster = new Roaster($db);

        $this->assertNotEmpty($roaster->db);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}