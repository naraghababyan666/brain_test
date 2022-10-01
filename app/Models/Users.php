<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
//use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class Users extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public function userswithrole() {
        return $this->hasOne(UsersWithRole::class,'role_id', 'id');
    }

    public function student(){
        return $this->hasOne(Student::class);
    }

    public function trainer(){
        return $this->hasOne(Trainer::class, 'user_id', 'id');
    }

    public function trainingcenter(){
        return $this->hasOne(TrainingCenter::class);
    }

//
//    public function role(){
//        return $this->hasMany(Roles::class);
//    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }


}
