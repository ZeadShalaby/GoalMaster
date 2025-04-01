<?php

namespace App\Models;

use App\Models\User;
use App\Models\Follows;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follows extends Model
{
    use HasFactory;
    
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'following_id',
        'followers_id',
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
    public function userfollowing()
    {
        return $this->belongsTo(User::class, 'following_id')->with('media_one');
    }

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function userfollowers()
    {
        return $this->belongsTo(User::class, 'followers_id')->with('media_one');
    }


    
}
