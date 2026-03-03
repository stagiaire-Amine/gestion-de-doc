<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

<<<<<<< HEAD
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
=======
>>>>>>> ba423d4ca8b0b93271da5dafa3e306809b3ffcde
    protected $fillable = [
        'name',
        'email',
        'password',
<<<<<<< HEAD
=======
        'is_admin',
        'is_active',
        'must_change_password',
>>>>>>> ba423d4ca8b0b93271da5dafa3e306809b3ffcde
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
=======
>>>>>>> ba423d4ca8b0b93271da5dafa3e306809b3ffcde
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
<<<<<<< HEAD
        ];
    }
=======
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
            'must_change_password' => 'boolean',
        ];
    }
    /**
     * Get the documents for the user.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
>>>>>>> ba423d4ca8b0b93271da5dafa3e306809b3ffcde
}
