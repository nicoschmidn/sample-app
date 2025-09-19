<?php

namespace App\DTOs;

readonly class CsvImportResult
{
    public function __construct(
        public int   $importedCount,
        public array $errors = [],
    ) {}

    /**
     * @return int
     */
    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
