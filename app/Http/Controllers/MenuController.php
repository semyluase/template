<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getMenuTree(Request $request)
    {
        $dataMenu = Menu::menuData($request->role,0);

        $menu = [];

        if ($dataMenu) {
            foreach ($dataMenu as $row => $val) {
                $menu[$row] = [
                    'id' => $val->id,
					'text' => $val->label,
                    'icon' => $val->icon
                ];

                if ($val->selected == 'true') {
					$menu[$row]['state'] = [
						'selected' => true,
                        'opened'    =>  true
					];
				}

                if ($val->jumlah > 0) {
					$children = Menu::menuData($request->role, $val->id);

					if ($children) {
						$child_menu = [];
						foreach ($children as $child => $child_val) {
							$child_menu[$child] = [
								'id' => $child_val->id,
								'text' => $child_val->label,
								'icon' => $child_val->icon
							];

							if ($child_val->selected == 'true') {
								$child_menu[$child]['state'] = [
									'selected' => true,
									'opened' => true
								];
							}

                            $grandChildren = Menu::menuData($request->role, $child_val->id);

                            if ($grandChildren) {
                                $grand_child_menu = [];
                                foreach ($grandChildren as $grandChild => $grand_child_val) {
                                    $grand_child_menu[$grandChild] = [
                                        'id' => $grand_child_val->id,
                                        'text' => $grand_child_val->label,
                                        'icon' => $grand_child_val->icon
                                    ];

                                    if ($grand_child_val->selected == 'true') {
                                        $grand_child_menu[$grandChild]['state'] = [
                                            'selected' => true,
                                            'opened' => true
                                        ];
                                    }
                                }
                            }
                            $child_menu[$child]['children'] = $grand_child_menu;
						}

						$menu[$row]['children'] = $child_menu;
					}
				}
            }
        }

        return response()->json($menu);
    }
}
