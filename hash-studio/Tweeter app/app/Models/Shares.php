<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tweets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shares extends Model
{
    use HasFactory;

    
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'tweet_id',
        'user_id',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'created_at',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function Tweets()  
    {
        return $this->belongsTo(Tweets::class, 'tweet_id')->with('media');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->with('media');
    }

    



}
