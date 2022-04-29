<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    public static function menuData($role, $parent = 0)
    {
        return (object)DB::select("SELECT a.`id`, a.`label`, a.`url`, a.`icon`,
        a.`parent`, a.`index`, IFNULL(c.jumlah, 0) AS jumlah,
        IF (e.id <> '', 'true', 'false') AS selected
        FROM menus a
        LEFT JOIN (
            SELECT b.id, b.`parent`, COUNT(b.`id`) AS jumlah
            FROM menus b
            WHERE b.`is_active` = true
            GROUP BY b.`parent`
        ) AS c ON c.parent = a.`id`
        LEFT JOIN (
            SELECT *
            FROM user_menus d
            WHERE d.`role_id` = ?
        ) AS e ON e.menu_id = a.`id`
        WHERE a.`is_active` = true
        AND a.`parent` = ?
        ORDER BY a.`index` ASC", [$role, $parent]);
    }
}
