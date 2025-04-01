<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    
    /* The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mediaable_type',
        'mediaable_id',
        'media',
        'created_at',
        'updated_at'
    ];

    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function mediaable()
    {
        return $this->morphTo();
    }

//    return $this->morphTo(__FUNCTION__, 'imageable_type', 'imageable_id');


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'created_at'
    ];


}
