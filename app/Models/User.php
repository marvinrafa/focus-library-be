<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLES = ['librarian', 'student'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_checkouts', 'user_id', 'book_id')->withTimestamps();
    }

    public function activeBooks()
    {
        return $this
            ->belongsToMany(Book::class, 'book_checkouts', 'user_id', 'book_id')
            ->wherePivot('active', '=', true);
    }

    public function bookCheckouts()
    {
        return $this->hasMany(BookCheckout::class, 'user_id');
    }

    // FILTER SECTION 

    public static function filters()
    {
        return [

            [
                "type" => "text",
                "name" => "first_name",
                "label" => "First Name"
            ],
            [
                "type" => "text",
                "name" => "last_name",
                "label" => "Last Name"
            ],
            [
                "type" => "text",
                "name" => "email",
                "label" => "Email"
            ]
        ];
    }
}
