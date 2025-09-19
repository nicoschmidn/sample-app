<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadCsvRequest;
use App\Services\CsvImportService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Sample;

class SampleController extends Controller
{
    private CsvImportService $csvImportService;

    public function __construct(CsvImportService $csvImportService)
    {
        $this->csvImportService = $csvImportService;
    }
    /**
     * @return Factory|View
     */
    public function index(): Factory|View
    {
        $samples = Sample::all();
        return view('samples', compact('samples'));
    }

    /**
     * @param UploadCsvRequest $request
     * @return RedirectResponse
     */
    public function upload(UploadCsvRequest $request): RedirectResponse
    {
        $result = $this->csvImportService->import($request->file('file')->getRealPath());

        if($result->hasErrors()) {
            return redirect()->route('samples.index')
                ->with('import_error', $result->getErrors())
                ->with('imported', $result->getImportedCount());
        }
        return redirect()->route('samples.index')
            ->with('import_success', $result->getImportedCount());
    }
}
