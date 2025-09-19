<?php

namespace Tests\Unit;

use App\Services\CsvImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CsvImportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CsvImportService();
        $this->tmpFiles = [];
    }

    #[Test]
    public function test_import_imports_valid_csv_correctly()
    {
        $tmpFile = $this->createCsvFile("name,type,location\nNameA,TypeA,LocationA\nJane,TypeB,LocationB");

        $result = $this->service->import($tmpFile);

        $this->assertEquals(2, $result->getImportedCount());
        $this->assertEmpty($result->errors);
    }

    #[Test]
    public function test_import_returns_errors_for_invalid_rows()
    {
        $tmpFile = $this->createCsvFile("name,type,location\n,TypeA,LocationA\nJane,,LocationB");

        $result = $this->service->import($tmpFile);

        $this->assertEquals(0, $result->getImportedCount());
        $this->assertCount(2, $result->errors);
    }

    #[Test]
    public function test_import_returns_error_for_wrong_header()
    {
        $tmpFile = $this->createCsvFile("wrong,header,location\nNameA,TypeA,LocationA");

        $result = $this->service->import($tmpFile);

        $this->assertEquals(0, $result->getImportedCount());
        $this->assertNotEmpty($result->errors);
    }

    #[Test]
    public function test_import_skips_invalid_rows_but_imports_valid_ones()
    {
        $tmpFile = $this->createCsvFile("name,type,location\nNameA,TypeA,LocationA\n,TypeB,LocationB\nNameC,TypeC,LocationC");

        $result = $this->service->import($tmpFile);

        $this->assertEquals(2, $result->getImportedCount());
        $this->assertCount(1, $result->errors);
    }

    private function createCsvFile(string $content): string
    {
        $tmpFile = tmpfile();
        fwrite($tmpFile, $content);
        $meta = stream_get_meta_data($tmpFile);

        $this->tmpFiles[] = $tmpFile;

        return $meta['uri'];
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        if (!empty($this->tmpFiles)) {
            foreach ($this->tmpFiles as $file) {
                fclose($file);
            }
        }
    }
}
