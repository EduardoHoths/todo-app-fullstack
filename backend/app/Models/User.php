<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use \Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    public function tasks()
    {
        return $this->hasMany(Tasks::class);
    }

   

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
