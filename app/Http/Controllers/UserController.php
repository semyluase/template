<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('master.user.index',[
            'title' =>  'User',
            'pageHead'  =>  'Managemen User',
            'js'    =>  ['assets/js/apps/master/user/app.js']
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username'  =>  'required',
            'password'  =>  'required'
        ],[
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        } else {
            $insertData = User::insertData($request->username, $request->password);

            if ($insertData) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  true,
                        'message'   =>  'Data berhasil disimpan'
                    ]
                ]);
            } else {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'Data gagal disimpan'
                    ]
                ]);
            }
        }
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(),[
            'username'  =>  'required',
            'password'  =>  'required'
        ],[
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        } else {
            $updateData = User::updateData($request->username, $request->password);

            if ($updateData) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  true,
                        'message'   =>  'Data berhasil diubah'
                    ]
                ]);
            } else {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'Data gagal diubah'
                    ]
                ]);
            }
        }
    }

    public function destroy(User $user)
    {
        //
    }

    public function getAllData(Request $request)
    {
        $dataUser = User::all();

        $results = [];

        $no = 1;

        $action = '';

        if ($request->data === 'role') {
            $action = 'managementRole';
        } elseif ($request->data === 'menu') {
            $action = 'managementMenu';
        } elseif ($request->data === 'user') {
            $action = 'user';
        }

        if ($dataUser) {
            foreach ($dataUser as $row) {
                switch ($action) {
                    case 'user':
                        $results[] = [
                            $no,
                            $row->kategori,
                            $row->username,
                            $row->nik,
                            $row->profil_nama,
                            '<div class="d-flex hstack gap-3">'
                            .'<button class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Ubah Password" onclick="'.$action.'.setUser(\''.$row->username.'\')"><i class="fas fa-key"></i></button>'
                            .'<button class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Ubah User" onclick="'.$action.'.settingUser(\''.$row->username.'\')"><i class="fas fa-cog"></i></button></div>',
                        ];
                        break;

                    case 'managementRole':
                    case 'managementMenu':
                        $results[] = [
                            $no,
                            $row->kategori,
                            '<a href="javascript:;" data-username="'.$row->username.'" onclick="'.$action.'.setUser(\''.$row->username.'\')">'.$row->username.'</a>',
                        ];
                        break;
                }

                $no++;
            }
        }

        return response()->json($results);
    }

    public function myProfile()
    {
        return view('management.profile.index',[
            'title' =>  'Profile',
            'pageHead'  =>  'My Profile',
            'js'    =>  ['assets/js/apps/management/profile/app.js']
        ]);
    }

    public function myProfileUpdate(Request $request)
    {
        $updateProfile = User::myProfileUpdate($request->username, $request->profileName, $request->nik);

        if ($updateProfile) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Profil berhasil diubah'
                ]
            ]);
        } else {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Profil gagal diubah'
                ]
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        $passwordLama = User::findValidPassword($request->username, $request->oldPassword);

        if ($passwordLama === false) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Password lama salah'
                ]
                ]);
        }

        if ($request->newPassword !== $request->confirmPassword) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Password baru tidak sama'
                ]
                ]);
        }

        $updateData = User::updateData($request->username, $request->newPassword);

        if ($updateData) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Password berhasil diubah'
                ]
            ]);
        } else {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Password gagal diubah'
                ]
            ]);
        }
    }

    public function updateProfile(Request $request, User $user)
    {
        $data = [
            'profil_nama'   =>  ucwords($request->profilName),
            'nik'   =>  $request->nik
        ];

        if (User::find($user->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data User berhasil diubah'
                ]
            ]);
        } else {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Data User gagal diubah'
                ]
            ]);
        }
    }
}
