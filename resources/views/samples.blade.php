<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Uploader</title>
    @vite(['resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
    <h1>Spreadsheet Uploader</h1>

    <div id="drop-area">
        <form id="upload-form" action="{{ route('samples.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <p>Drag & drop a CSV file or click below</p>
            <input type="file" id="file" name="file" accept=".csv">
            <label for="file" id="file-label" class="file-label">Choose File</label>

            <span id="file-name" style="display:none;"></span>

            <button type="submit" id="submit-btn" style="display:none;">Upload</button>
            <button type="button" id="remove-btn" style="display:none;">Remove file</button>
        </form>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('import_success'))
        <div class="alert alert-success">
            {{ session('import_success') }} rows imported successfully!
        </div>
    @endif

    @if(session('import_error'))
        <div class="alert alert-error">
            <ul>
                @foreach(session('import_error') as $rowNumber => $rowErrors)
                    <li>Row {{ $rowNumber }}:
                        <ul>
                            @foreach($rowErrors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            @if(session('imported'))
                <p>{{ session('imported') }} rows imported successfully.</p>
            @endif
        </div>
    @endif

    @if($samples->count())
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Location</th>
            </tr>
            </thead>
            <tbody>
            @foreach($samples as $sample)
                <tr>
                    <td>{{ $sample->id }}</td>
                    <td>{{ $sample->name }}</td>
                    <td>{{ $sample->type }}</td>
                    <td>{{ $sample->location }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h2>No files were uploaded yet.</h2>
    @endif
</div>
</body>
</html>
