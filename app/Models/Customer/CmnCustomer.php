<?php

namespace App\Models\Customer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking\SchServiceBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\UserType;
class CmnCustomer extends Model
{
    protected $fillable = [
        // 'id',
        'user_id',
        'created_by',
        'full_name',
        'phone_no',
        'is_phone_verified',
        'otp',
        // 'email',
        // 'dob',
        // 'country',
        // 'state',
        // 'postal_code',
        // 'city',
        // 'street_address',
        // 'street_number',
        // 'remarks'
    ];
  

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            // إنشاء اليوزر
            $user = User::create([
                'name' => $customer->full_name,
                'username' =>   $customer->full_name . uniqid(),
                'phone_number' => $customer->phone_no,
                'password' => bcrypt('123456789'),
                'user_type' => UserType::WebsiteUser,
                'status' => 1,
            ]);

            // ربط الكستومر باليوزر
            $customer->user_id = $user->id;
        });
    }



    public function managers()
    {
        return $this->belongsToMany(User::class, 'manager_customer', 'customer_id', 'manager_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(SchServiceBooking::class, 'cmn_customer_id');
    }
}
