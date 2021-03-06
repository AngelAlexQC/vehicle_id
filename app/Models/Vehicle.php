<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'plate',
        'brand',
        'registration',
        'owner_id',
        'model',
    ];

    protected $searchableFields = ['*'];

    public function owner()
    {
        return $this->belongsTo(Driver::class, 'owner_id');
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
