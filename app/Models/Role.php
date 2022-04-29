<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function roleData($username)
    {
        return (object)DB::select("SELECT a.`id`, a.`name`, a.`description`,
        IF (c.id <> '', 'true', 'false') AS selected
        FROM roles a
        LEFT JOIN (
            SELECT *
            FROM user_roles b
            WHERE b.`username` = ?
        ) AS c ON c.role_id = a.`id`
        WHERE a.`is_active` = ?
        ORDER BY a.id", [$username,true]);
    }
}
