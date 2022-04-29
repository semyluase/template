<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UserMenu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['menu'];

    public function menu()
    {
        return $this->belongsTo(Menu::class,'menu_id','id');
    }

    public static function data_menu($parent = 0)
    {
        $role = User::role(auth()->user()->username);
        // $username = Auth::user()->username;
        return (object) DB::select("
        SELECT a.*, IFNULL(menu.jumlah, 0) AS jumlah
			FROM menus a
			LEFT JOIN (
				SELECT b.id, COUNT(b.`id`) AS jumlah, b.`parent`
				FROM menus b
				GROUP BY b.`parent`
			) AS menu ON menu.parent = a.`id`
			INNER JOIN user_menus c ON a.id = c.menu_id
			WHERE a.parent = '$parent'
			AND a.is_active = 1
			AND c.role_id = '$role->id'
			ORDER BY a.index ASC
        ");
    }

    public static function createMenu()
    {
        $menu = '';
        $active = '';
        $dataMenu = static::data_menu();
        $header = false;

        if ($dataMenu) {
            foreach ($dataMenu as $row) {
                $active = Request::is($row->active_value) ? 'active' : '';

                switch ($row->url) {
                    case '#':
                        $url = $row->url;
                        break;

                    case null:
                        $url = 'javascript:;';
                        break;

                    default:
                        $url = url('').$row->url;
                        break;
                }

                $hasSub = $row->jumlah > 0 ? 'has-sub' : '';

                $logout = $row->label === 'Logout' ? 'onclick="loggedOut(\''.csrf_token().'\')"' : '';

                if ($row->is_header) {
                    $item = '<li class="sidebar-title">'.$row->label.'</li>';

                    if ($row->jumlah > 0) {
                        $child_menu = static::data_menu($row->id);

                        $header = true;

                        if ($child_menu) {
                            foreach ($child_menu as $row_child) {
                                $child = static::listChildMenu($row_child, $header);
                            }
                            $item .= $child;
                        }

                        $header = false;
                    }
                } else {
                    $item = '<li class="sidebar-item '.$active.' '.$hasSub.'">
                                <a href="'.$url.'" class="sidebar-link" '.$logout.'>
                                    <i class="'.$row->icon.'"></i>
                                    <span>'.$row->label.'</span>
                                </a>';
                    if ($row->jumlah > 0) {
                        $child_menu = static::data_menu($row->id);

                        if ($child_menu) {
                            $child = '<ul class="submenu '.$active.'">';
                            foreach ($child_menu as $row_child) {
                                $child .= static::listChildMenu($row_child, $header);
                            }
                            $child .= '</ul>';
                            $item .= $child;
                        }
                    }
                    $item .= '</li>';
                }
                $menu .= $item;
            }
        }

        return $menu;
    }

    public static function listChildMenu($menu, $header)
    {
        $active = Request::is($menu->active_value) ? 'active' : '';

        switch ($menu->url) {
            case '#':
                $url = $menu->url;
                break;

            case null:
                $url = 'javascript:;';
                break;

            default:
                $url = url('').$menu->url;
                break;
        }

        $hasSub = $menu->jumlah > 0 ? 'has-sub' : '';

        $dataHead = $header ? 'sidebar' : 'submenu';

        if ($header) {
            $item = '<li class="sidebar-item '.$active.' '.$hasSub.'">
                        <a href="'.$url.'" class="sidebar-link">
                            <i class="'.$menu->icon.'"></i>
                            <span>'.$menu->label.'</span>
                        </a>';
        } else {
            $item = '<li class="submenu-item '.$active.' '.$hasSub.'">
                        <a href="'.$url.'" class="submenu-link">
                            <span>'.$menu->label.'</span>
                        </a>';

        }


        if ($menu->jumlah > 0) {
            $child_menu = static::data_menu($menu->id);

            if ($child_menu) {
                $child = '<ul class="submenu '.$active.'">';
                foreach ($child_menu as $row_child) {
                    $child .= static::listGrandChildMenu($row_child);
                }
                $child .= '</ul>';
                $item .= $child;
            }
        }

        $item .= '</li>';

        return $item;
    }

    public static function listGrandChildMenu($menu)
    {
        $active = Request::is($menu->active_value) ? 'active' : '';

        switch ($menu->url) {
            case '#':
                $url = $menu->url;
                break;

            case null:
                $url = 'javascript:;';
                break;

            default:
                $url = url('').$menu->url;
                break;
        }

        $hasSub = $menu->jumlah > 0 ? 'has-sub' : '';

        $item = '<li class="submenu-item '.$active.' '.$hasSub.'">
                    <a href="'.$url.'" class="submenu-link">
                        <span>'.$menu->label.'</span>
                    </a></li>';

        return $item;
    }
}
