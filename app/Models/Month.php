<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use IntlDateFormatter;

class Month extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number'
    ];

    protected $appends = [
        'name',
    ];

    public function getNameAttribute() {
        $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $formatter->setPattern('MMMM');
        return $formatter->format(mktime(0, 0, 0, $this->number, 1));
    }
}
