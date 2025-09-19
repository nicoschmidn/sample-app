<?php

namespace App\Models;

use Database\Factories\SampleFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sample extends Model
{
    public const CSV_HEADER_NAME = 'name';
    public const CSV_HEADER_TYPE = 'type';
    public const CSV_HEADER_LOCATION = 'location';

    /** @use HasFactory<SampleFactory> */
    use HasFactory;
    protected $table = 'sample';
    protected $fillable = [self::CSV_HEADER_NAME, self::CSV_HEADER_TYPE, self::CSV_HEADER_LOCATION];
}
