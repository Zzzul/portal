<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category_id', 'user_id', 'start_time', 'finish_time', 'location', 'price', 'max_audience', 'slug', 'description', 'thumbnail'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function performers()
    {
        return $this->belongsToMany(Performer::class);
    }

    public function audiences()
    {
        return $this->belongsToMany(User::class, 'audience_event')->withPivot('payment_status', 'user_id', 'transaction_code');
    }
}
