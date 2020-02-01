<?php

    namespace App\Models;

    use Illuminate\Auth\Authenticatable;
    use Laravel\Lumen\Auth\Authorizable;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
    use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContracts;
    use Tymon\JWTAuth\Contracts\JWTSubject;
    
    class User extends Model implements AuthenticatableContracts, AuthorizableContracts, JWTSubject
    {
        use Authenticatable, Authorizable;
        
        protected $fillable =[
            'email','password','no_telp','alamat','role',
        ];
        protected $hidden = [
            'password',
        ];

        public $timestamps = true;

        public function getJWTIdentifier(){
            return $this->getKey();
        }
        public function getJWTCustomClaims(){
            return [];
        }
    }