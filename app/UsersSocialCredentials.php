<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class UsersSocialCredentials extends Model
{
    use Notifiable;
    protected $table = 'userssocial_credentials';
}
