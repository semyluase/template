<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function role()
    {
        $dataRole = Role::where('is_active', true)
            ->get();

        $results = array();

        if ($dataRole) {
            foreach ($dataRole as $row => $valRole) {
                $results[]  =   [
                    'label' =>  $valRole->name,
                    'value' =>  $valRole->id
                ];
            }
        }

        return response()->json($results);
    }
}
