<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Record extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'dni',
        'plate',
        'parking',
        'user_id',
        'parking_id',
        'driver_id',
        'type'
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
