<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Admin
 *
 * @property int $admin_id
 * @property string $name
 * @property string $password
 * @property int $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Admin extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'admins';
    protected $primaryKey = 'admin_id';

    protected $casts = [
        'role' => 'int'
    ];

    protected $hidden = [
        'password'
    ];

    protected $fillable = [
        'name',
        'password',
        'role'
    ];
}
