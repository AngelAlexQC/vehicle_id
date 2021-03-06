<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = ['dni', 'name', 'photoURL', 'surname', 'email', 'phone', 'placas'];

    protected $searchableFields = ['*'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'owner_id');
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
