<?php

namespace App\Tests\Unit;

use App\Exceptions\FileNotFoundException;
use PHPUnit\Framework\TestCase;
use App\Classes\GetConfigFile;

class CanGetConfigTest extends TestCase
{
    /** @test */
    public function can_get_instance(): void
    {
        $config = new GetConfigFile();
        $this->assertInstanceOf(expected: GetConfigFile::class, actual: $config);
    }

    /** @test */
    public function can_get_file_path()
    {
        $config = new GetConfigFile(file: 'app');
        $path = $config->getFilePath();
        $this->assertStringContainsString(needle: 'Config/app.php', haystack: $path);
    }

    /**
     * @test
     * @throws FileNotFoundException
     */
    public function can_get_app_config()
    {
        $config = new GetConfigFile(file:'app');
        $getFile = $config->getConfigFile();
        $this->assertNotEmpty(actual: $getFile);
        $this->assertIsArray(actual: $getFile);
    }

    /** @test */
    public function if_file_is_not_found_throw_exception()
    {
        $config = new GetConfigFile(file:'testfile');
        $this->expectException(exception: FileNotFoundException::class);
        $this->expectExceptionMessage(message: "No File Found for testfile.php in Config directory");
        $config->getConfigFile();
    }
}
