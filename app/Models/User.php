<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'sqlsrv';
    protected $table = 'general_affair.dbo.admin';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

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

    public function getAuthPassword()
    {
        return Hash::make($this->password);
    }

    public function getRememberToken()
    {
        return $this->session;
    }

    public function setRememberToken($value)
    {
        $this->session = $value;
    }

    public function getRememberTokenName()
    {
        return 'session';
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    static public function getPassword($username, $password)
    {
        $user = DB::connection('sqlsrv')->select("select password from general_affair.dbo.admin where username = '$username' and password=HashBytes('MD5','$password')");

        return $user;
    }

    public static function role($username)
    {
        $query = DB::connection('mysql')->select("select a.username as username, b.id as id, b.name as name, b.description as description from user_roles a JOIN roles b on a.role_id = b.id where a.username = '$username'");

        return (object) $query[0];
    }

    public static function menu($username)
    {
        return (object)DB::connection('mysql')->select("select a.username, b.* from user_menus a JOIN menus b on a.menu_id = b.id where a.username = '$username' order by b.index");
    }

    public static function insertData($username, $password)
    {
        $session = auth()->user()->username;
        return (object) DB::connection('sqlsrv')->insert("INSERT INTO admin (kategori, username, password, status, userid, usertgl, kearsipan, edit, tambah, hapus, kearsipan_y, ga_y, kearsipan_office, kearsipan_produksi, approve_dokumen, lvl, superuser, nama_ttd, jabatan_ttd, beacukai, qa, hrd, sage_mutasi, edp, sage_stok, accounting)
        VALUES ('UMUM', '$username', HashBytes('MD5', '$password'), '1', '$session', CURRENT_TIMESTAMP, '0000000', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '0', '0', '0', '0', '0', '0000', '0' )");
    }

    public static function updateData($username, $password)
    {
        $session = auth()->user()->username;

        return (object) DB::connection('sqlsrv')->update("
            UPDATE admin
            SET password = HashBytes('MD5','$password'),
            userid_u = '$session',
            usertgl_u = CURRENT_TIMESTAMP
            where username = '$username'
        ");
    }

    public static function findValidPassword($username, $password)
    {
        $sql = DB::connection('sqlsrv')->select("SELECT *
            FROM admin a
            WHERE a.username = '$username'
            AND a.password = HashBytes('MD5', '$password')
            AND a.status = 1 ");

        return $sql ? true : false;
    }

    public static function myProfileUpdate($username, $profileName, $nik)
    {
        $session = auth()->user()->username;

        return (object) DB::connection('sqlsrv')->update("
            UPDATE admin
            SET profil_nama = '$profileName',
            nik = '$nik',
            userid_u = '$session',
            usertgl_u = CURRENT_TIMESTAMP
            where username = '$username'
        ");
    }
}
