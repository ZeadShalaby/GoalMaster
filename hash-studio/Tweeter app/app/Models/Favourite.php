<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
    public function tweet()  
    {
        return $this->belongsTo(Tweets::class, 'tweet_id');
    }

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }


    public function getCreationDateFormattedAttribute()
    {
        return $this->created_at->format('d-m'); // Format as day-month
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


   // ! to return the total num of Likes for tweet // 
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
    
    



    //? Add a custom attribute to include user media
    protected $appends = ['user_media','tweet_media'];

    public function getUserMediaAttribute()
    {
        return $this->user ? $this->user->media : [];
    }

    public function getTweetMediaAttribute()
    {
        return $this->Tweet ? $this->Tweet->media : [];
    }



}
