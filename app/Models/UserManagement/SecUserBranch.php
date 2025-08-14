<?php

namespace App\Models\UserManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class SecUserBranch extends Model
{
    protected $fillable = [
        'user_id',
        'cmn_branch_id',
        'created_by',
        'updated_by'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


}
