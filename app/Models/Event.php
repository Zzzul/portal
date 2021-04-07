<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category_id', 'user_id', 'start_time', 'finish_time', 'location', 'price', 'max_audience', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function performers()
    {
        return $this->belongsToMany(Performer::class);
    }
}
