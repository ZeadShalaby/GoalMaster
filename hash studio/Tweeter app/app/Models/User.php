<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Media;
use App\Models\Tweets;
use App\Enums\GenderEnums;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'gender',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'updated_at',
    ];

    protected $casts = [
        'gender' => GenderEnums::class,
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    


    public function favoriteTweets()
    {
        return $this->belongsToMany(Tweet::class, 'favourites')->withTimestamps();
    }

    // User model
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'followers_id', 'following_id');
    }



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


     // ! to return the total num of followers for users // 
    // ? total share for tweet
    public function getFollowersCount()
    {
        return $this->followers()->count();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id','followers_id')->withTimestamps();

    }
            
   // ! //

    // ! to return the total num of following for users // 
    // ? total share for tweet
    public function getFollowingCount()
    {
        return $this->followings()->count();
    }

    public function followings()
    {

        return $this->belongsToMany(User::class, 'follows',  'followers_id','following_id')->withTimestamps();

    }        
   // ! //

   // ! to return the total num of tweets for users // 
    // ? total share for tweet
    public function getTweetsCount()
    {
        return $this->tweets()->count();
    }

    public function tweets()
    {
        
        return $this->belongsToMany(User::class, 'tweets', 'user_id')->withTimestamps();
    }        
   // ! //

    

}
