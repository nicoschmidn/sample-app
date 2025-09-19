<?php

namespace App\Services;

use App\DTOs\CsvImportResult;
use App\Models\Sample;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CsvImportService
{
    /**
     * @param string $path
     * @return CsvImportResult
     */
    public function import(string $path): CsvImportResult
    {
        if(!file_exists($path)) {
            return new CsvImportResult(0, [['File does not exist.']]);
        }

        $file = fopen($path, "r");
        $header = fgetcsv($file);

        $headerErrors = $this->validateHeader($header);

        if ($headerErrors) {
            fclose($file);
            return new CsvImportResult(0, [$headerErrors]);
        }

        $errors = [];
        $importedCount = 0;
        $rowNumber = 1;

        while (($row = fgetcsv($file)) !== false) {
            $rowNumber++;
            $data = $this->mapRowToData($row);

            $rowErrors = $this->validateRow($data);
            if ($rowErrors) {
                $errors[$rowNumber] = $rowErrors;
                continue;
            }

            $this->saveRow($data);
            $importedCount++;
        }

        fclose($file);
        return new CsvImportResult($importedCount, $errors);
    }

    /**
     * @param array $row
     * @return array
     */
    private function mapRowToData(array $row): array
    {
        return [
            Sample::CSV_HEADER_NAME => $row[0] ?? null,
            Sample::CSV_HEADER_TYPE => $row[1] ?? null,
            Sample::CSV_HEADER_LOCATION => $row[2] ?? null,
        ];
    }

    /**
     * @param array $data
     * @return array|null
     */
    private function validateRow(array $data): ?array
    {
        $validator = Validator::make($data, [
            Sample::CSV_HEADER_NAME => 'required|string',
            Sample::CSV_HEADER_TYPE => 'required|string',
            Sample::CSV_HEADER_LOCATION => 'required|string',
        ]);

        return $validator->fails() ? $validator->errors()->all() : null;
    }

    /**
     * @param array $data
     * @return void
     */
    private function saveRow(array $data): void
    {
        DB::transaction(function () use ($data) {
            Sample::create($data);
        });
    }

    /**
     * @param array $header
     * @return array|null
     */
    private function validateHeader(array $header): ?array
    {
        $expectedHeader = [
            Sample::CSV_HEADER_NAME,
            Sample::CSV_HEADER_TYPE,
            Sample::CSV_HEADER_LOCATION,
        ];

        $header = array_map('trim', $header);
        $missing = array_diff($expectedHeader, $header);
        $extra = array_diff($header, $expectedHeader);

        if (!empty($missing) || !empty($extra)) {
            $errors = [];
            if (!empty($missing)) {
                $errors[] = 'Missing columns: ' . implode(', ', $missing);
            }
            if (!empty($extra)) {
                $errors[] = 'Unexpected columns: ' . implode(', ', $extra);
            }
            return $errors;
        }
        return null;
    }
}
