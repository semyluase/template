<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.role.index',[
            'title' =>  'Role',
            'pageHead'  =>  'Role',
            'js'    =>  ['assets/js/apps/master/role/app.js']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'  =>  'required',
            'description'   =>  'required'
        ],[
            'name.required' =>  'Nama tidak boleh kosong',
            'description.required' =>  'Deskripsi tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        } else {
            $data = [
                'name'  =>  ucwords($request->name),
                'description'   =>  ucwords($request->description),
            ];

            if (Role::create($data)) {
                return response()->json([
                    'data' => [
                        'status'    =>  true,
                        'message'   =>  'Data berhasil disimpan'
                    ]
                ]);
            } else {
                return response()->json([
                    'data' => [
                        'status'    =>  false,
                        'message'   =>  'Data gagal disimpan'
                    ]
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(),[
            'name'  =>  'required',
            'description'   =>  'required'
        ],[
            'name.required' =>  'Nama tidak boleh kosong',
            'description.required' =>  'Deskripsi tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        } else {
            $data = [
                'name'  =>  ucwords($request->name),
                'description'   =>  ucwords($request->description),
            ];

            if (Role::find($role->id)->update($data)) {
                return response()->json([
                    'data' => [
                        'status'    =>  true,
                        'message'   =>  'Data berhasil diubah'
                    ]
                ]);
            } else {
                return response()->json([
                    'data' => [
                        'status'    =>  false,
                        'message'   =>  'Data gagal diubah'
                    ]
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $data = [
            'is_active' =>  false
        ];

        if (Role::find($role->id)->update($data)) {
            return response()->json([
                'data' => [
                    'status'    =>  true,
                    'message'   =>  'Data berhasil dihapus'
                ]
            ]);
        } else {
            return response()->json([
                'data' => [
                    'status'    =>  false,
                    'message'   =>  'Data gagal dihapus'
                ]
            ]);
        }
    }

    public function getAllData()
    {
        $dataRole = Role::where('is_active',true)
            ->get();

        $results = [];

        $no = 1;
        if ($dataRole) {
            foreach ($dataRole as $row) {
                $button = '<div class="row"><div class="col-lg-2"><a href="javascript:;" class="btn btn-outline-info" onclick="role.editData(\''.$row->id.'\')"><i class="fas fa-edit"></i></a></div><div class="col-lg-2"><a href="javascript:;" class="btn btn-outline-danger" onclick="role.deleteData(\''.$row->id.'\',\''.csrf_token().'\')"><i class="fas fa-times"></i></a></div></div>';

                $results[] = [
                    $no,
                    $row->name,
                    $row->description,
                    $button
                ];

                $no++;
            }
        }

        return response()->json($results);
    }

    public function getRoleTree(Request $request)
    {
        $dataRole = Role::roleData($request->username);

        $response = [];

        if ($dataRole) {
            foreach ($dataRole as $row => $val) {
                $response[$row] = [
                    'id' => $val->id,
					'text' => $val->description,
                ];

                if ($val->selected == 'true') {
					$response[$row]['state'] = [
						'selected' => true,
                        'opened'    =>  true
					];
				}
            }
        }

        return response()->json($response);
    }
}
