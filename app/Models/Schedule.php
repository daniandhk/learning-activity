<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use IntlDateFormatter;

class Schedule extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'method_id',
        'name',
        'date_start',
        'date_end',
    ];

    public function method() {
        return $this->belongsTo(Method::class);
    }

    protected $appends = [
        'month_start',
        'status',
    ];

    public function getMonthStartAttribute() {
        $start = DateTime::createFromFormat("d/m/Y", $this->date_start);
        $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $formatter->setPattern('MMMM');
        return $formatter->format($start);
    }

    public function getStatusAttribute() {
        if($this->date_start && $this->date_end){
            $start = DateTime::createFromFormat("d/m/Y", $this->date_start);
            $end = DateTime::createFromFormat("d/m/Y", $this->date_end);
            $now = new DateTime;

            if($now >= $start && $now <= $end){
                return "now";
            }
            else if($now < $start && $now < $end){
                return "soon";
            }
            else if($now > $start && $now > $end){
                return "done";
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }
}
