<?php

namespace App\Models;

use App\Models\User;
use App\Models\Media;
use App\Models\Tweets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tweets extends Model
{
    use HasFactory , SoftDeletes;


     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'view',
        'user_id',
        'report',
        'created_at'
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    //? format data to day & month
    public function getCreationDateFormattedAttribute()
    {
        return $this->created_at->format('d-m'); // Format as day-month
    }

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // ! check the user add fav | ^ to change color
    public function isFavoritedBy(User $user)
    {
        return $this->favourites()->where('user_id', $user->id)->exists();
    }
    //? relation fav
    public function favourites()
    {
        return $this->belongsToMany(User::class, 'favourites', 'tweet_id', 'user_id')->withTimestamps();
    }
    // ! //
    

    // ! check the user add like | ^ to change color
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // ? relation like
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'tweet_id', 'user_id')->withTimestamps();
    }
    // ! //

    
    // ! to return the total num of favourite for tweet // 
    // ? total favorites for tweet
    public function getFavoritesCount()
    {
        return $this->favorite()->count();
    }

    public function favorite()
    {
        return $this->belongsToMany(User::class, 'favourites', 'tweet_id')->withTimestamps();
    }
   // ! //

   // ! to return the total num of Likes for tweet // 
    // ? total likes for tweet
    public function getLikesCount()
    {
        return $this->like()->count();
    }

    public function like()
    {
        return $this->belongsToMany(User::class, 'likes', 'tweet_id')->withTimestamps();
    }
   // ! //


   // ! to return the total num of share for tweet // 
    // ? total share for tweet
    public function getShareCount()
    {
        return $this->share()->count();
    }

    public function share()
    {
        return $this->belongsToMany(User::class, 'shares', 'tweet_id')->withTimestamps();
    }
   // ! //


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function media_one()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }


    //? Add a custom attribute to include user media
    protected $appends = ['user_media'];

    public function getUserMediaAttribute()
    {
        return $this->user ? $this->user->media : null;
    }





    
    
}
