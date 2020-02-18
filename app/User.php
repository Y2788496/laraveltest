<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 */
class User extends Model
{
    const UPDATED_AT = null;

    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'avatar_url',
        'is_hide',
    ];
}
