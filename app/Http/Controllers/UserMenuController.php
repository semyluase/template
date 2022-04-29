<?php

namespace App\Http\Controllers;

use App\Models\UserMenu;
use Illuminate\Http\Request;

class UserMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('management.menu.index',[
            'title' =>  'Role Menu',
            'pageHead'  =>  'Managemen Role Menu',
            'js'    =>  ['assets/js/apps/management/menu/app.js']
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
        for ($i=0; $i < count($request->menu); $i++) {
            $data[] = [
                'menu_id' =>    $request->menu[$i],
                'role_id'  =>  $request->role
            ];
        }
        UserMenu::where('role_id',$request->role)->delete();

        if (UserMenu::insert($data)) {
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserMenu  $userMenu
     * @return \Illuminate\Http\Response
     */
    public function show(UserMenu $userMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserMenu  $userMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(UserMenu $userMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserMenu  $userMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserMenu $userMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserMenu  $userMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserMenu $userMenu)
    {
        //
    }
}
