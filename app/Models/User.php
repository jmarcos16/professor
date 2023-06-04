<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * Get the questions for the user.
     * return \Illuminate\Database\Eloquent\Relations\HasMany<Vote>
     */
    public function votes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Like a question.
     */
    public function like(Question $question): void
    {
        $this->votes()->updateOrCreate(
            ['question_id' => $question->id],
            [
                'like'   => 1,
                'unlike' => 0,
            ]
        );
    }

    /**
     * Unlike a question.
     */
    public function unlike(Question $question): void
    {
        $this->votes()->updateOrCreate(
            ['question_id' => $question->id],
            [
                'like'   => 0,
                'unlike' => 1,
            ]
        );
    }
}
