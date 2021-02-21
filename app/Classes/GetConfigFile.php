<?php

namespace App\Classes;

use App\Exceptions\FileNotFoundException;

class GetConfigFile
{
    public function __construct(
        private string $directory = 'Config',
        private string $file = '',
        private string $ext = '.php'
    ) {
    }

    public function getConfigFile(): array|string
    {
        $file = file_exists($this->getFilePath()) ? include $this->getFilePath() : '';

        if (empty($file)) {
            throw new FileNotFoundException(message:"No File Found for {$this->file}{$this->ext} in {$this->directory} directory");
        }

        return $file;
    }

    public function getFilePath(): string
    {
        return __DIR__ . "/../{$this->directory}/{$this->file}{$this->ext}";
    }

}
