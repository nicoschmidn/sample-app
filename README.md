# README – CSV Upload Implementation

For this small web application, I implemented the file upload functionality using **CSV files**, since the assignment mentioned a “spreadsheet file” but did not specify a particular format (e.g., Excel `.xlsx`, etc.).

## Current Implementation Details

- The backend expects a **CSV file** in the following format:

    name,type,location

    SomeName,SomeType,SomeLocation

    AnotherName,AnotherType,AnotherLocation

    ...


- The `id` field in the `sample` table is currently **auto-incremented** and not part of the CSV file.
- The system validates that each row has values for `name`, `type`, and `location` before inserting it into the database.
- After uploading, all rows from the `sample` table are displayed on the web page.

## Questions / Clarifications

1. Could you please clarify **which spreadsheet/file format** you would like the application to support? If it should support `.xlsx` or other formats, I can implement that.
2. Should the `id` field be **fillable via the upload file**, or is auto-increment sufficient?
3. The instructions mention example data with “≥5 rows.” Should the application **enforce a minimum of 5 rows per CSV file**, or is it acceptable to import files with fewer rows?


