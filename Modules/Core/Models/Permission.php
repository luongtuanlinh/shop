<?php

namespace Modules\Core\Models;

class Permission
{
    //TODO remove Not use
    const INDEX_SCORE = 0;
    const ADD_SCORE = 1;
    const UPDATE_SCORE = 2;
    const DELETE_SCORE = 3;

    public static function getActionName($indexScore) {
        if ($indexScore == Permission::INDEX_SCORE)
            $str = 'Xem thông tin';
        elseif ($indexScore == Permission::ADD_SCORE)
            $str = "Thêm mới";
        elseif ($indexScore == Permission::UPDATE_SCORE)
            $str = "Chỉnh sửa";
        else
            $str = "Xóa1";
        return $str;
    }

    public static function getActionScore($action) {
        $arrIndex = ["index", "show"];
        $arrAdd = ["create", "store"];
        $arrDelete = ["destroy"];
        $arrEdit = ["edit", "update"];

        if (in_array($action, $arrIndex))
            return Permission::INDEX_SCORE;
        elseif (in_array($action, $arrAdd))
            return Permission::ADD_SCORE;
        elseif (in_array($action, $arrDelete))
            return Permission::DELETE_SCORE;
        else
            return Permission::UPDATE_SCORE;
    }
    //TODO remove Not use

    public static function getRequestPermissionScore($controller, $action) {
        $listPermissions = Permission::getListPermissions();
        //dd($listPermissions[$controller]);
        if (isset($listPermissions[$controller]["actions"][$action])) {
            // Default action is update
            $scorePermission = $listPermissions[$controller]['actions'][$action]['id'];
            return $scorePermission;
        }
        return null;
    }

    public static function getListPermissions()
    {
        return [
            'Modules\Core\Http\Controllers\UserController' => [
                'id' => 2,
                'actions' => [
                    "index" => [
                        "id" => 8,
                        "name" => trans('core::listPermission.view')
                    ],
                    "show" => [
                        "id" => 8,
                        "name" => trans('core::listPermission.view')
                    ],
                    "create" => [
                        "id" => 9,
                        "name" => trans('core::listPermission.create')
                    ],
                    "store" => [
                        "id" => 9,
                        "name" => trans('core::listPermission.create')
                    ],
                    "edit" => [
                        "id" => 10,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "update" => [
                        "id" => 10,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "destroy" => [
                        "id" => 11,
                        "name" => trans('core::listPermission.delete')
                    ],
                ],
                'name' => trans('core::listPermission.name_user')
            ],
            'Modules\Core\Http\Controllers\RoleController' => [
                'id' => 3,
                'actions' => [
                    "index" => [
                        "id" => 12,
                        "name" => trans('core::listPermission.view')
                    ],
                    "show" => [
                        "id" => 12,
                        "name" => trans('core::listPermission.view')
                    ],
                    "create" => [
                        "id" => 13,
                        "name" => trans('core::listPermission.create')
                    ],
                    "store" => [
                        "id" => 13,
                        "name" => trans('core::listPermission.create')
                    ],
                    "edit" => [
                        "id" => 14,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "update" => [
                        "id" => 14,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "destroy" => [
                        "id" => 15,
                        "name" => trans('core::listPermission.delete')
                    ]
                ],
                'name' => trans('core::listPermission.name_role')
            ],
            'Modules\Core\Http\Controllers\GroupController' => [
                'id' => 4,
                'actions' => [
                    "index" => [
                        "id" => 16,
                        "name" => trans('core::listPermission.view')
                    ],
                    "show" => [
                        "id" => 16,
                        "name" => trans('core::listPermission.view')
                    ],
                    "create" => [
                        "id" => 17,
                        "name" => trans('core::listPermission.create')
                    ],
                    "store" => [
                        "id" => 17,
                        "name" => trans('core::listPermission.create')
                    ],
                    "edit" => [
                        "id" => 18,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "update" => [
                        "id" => 18,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "destroy" => [
                        "id" => 19,
                        "name" => trans('core::listPermission.delete')
                    ]
                ],
                'name' => trans('core::listPermission.name_group')
            ],
            'Modules\Agency\Http\Controllers\AgencyController' => [
                'id' => 5,
                'actions' => [
                    "index" => [
                        "id" => 20,
                        "name" => trans('core::listPermission.view')
                    ],
                    "show" => [
                        "id" => 20,
                        "name" => trans('core::listPermission.view')
                    ],
                    "create" => [
                        "id" => 21,
                        "name" => trans('core::listPermission.create')
                    ],
                    "store" => [
                        "id" => 21,
                        "name" => trans('core::listPermission.create')
                    ],
                    "edit" => [
                        "id" => 22,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "update" => [
                        "id" => 22,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "destroy" => [
                        "id" => 23,
                        "name" => trans('core::listPermission.delete')
                    ]
                ],
                'name' => "Đại lý"
            ],
            'Modules\Product\Http\Controllers\ProductController' => [
                'id' => 6,
                'actions' => [
                    "index" => [
                        "id" => 24,
                        "name" => trans('core::listPermission.view')
                    ],
                    "show" => [
                        "id" => 24,
                        "name" => trans('core::listPermission.view')
                    ],
                    "create" => [
                        "id" => 25,
                        "name" => trans('core::listPermission.create')
                    ],
                    "store" => [
                        "id" => 25,
                        "name" => trans('core::listPermission.create')
                    ],
                    "edit" => [
                        "id" => 26,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "update" => [
                        "id" => 26,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "destroy" => [
                        "id" => 27,
                        "name" => trans('core::listPermission.delete')
                    ]
                ],
                'name' => "Sản phẩm"
            ],
            'Modules\Product\Http\Controllers\ColorCodeController' => [
                'id' => 6,
                'actions' => [
                    "index" => [
                        "id" => 28,
                        "name" => trans('core::listPermission.view')
                    ],
                    "show" => [
                        "id" => 28,
                        "name" => trans('core::listPermission.view')
                    ],
                    "create" => [
                        "id" => 29,
                        "name" => trans('core::listPermission.create')
                    ],
                    "store" => [
                        "id" => 29,
                        "name" => trans('core::listPermission.create')
                    ],
                    "edit" => [
                        "id" => 30,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "update" => [
                        "id" => 30,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "destroy" => [
                        "id" => 31,
                        "name" => trans('core::listPermission.delete')
                    ]
                ],
                'name' => "Màu sản phẩm"
            ],
            'Modules\Product\Http\Controllers\WareHouseController' => [
                'id' => 6,
                'actions' => [
                    "index" => [
                        "id" => 32,
                        "name" => trans('core::listPermission.view')
                    ],
                    "show" => [
                        "id" => 32,
                        "name" => trans('core::listPermission.view')
                    ],
                    "create" => [
                        "id" => 33,
                        "name" => trans('core::listPermission.create')
                    ],
                    "store" => [
                        "id" => 33,
                        "name" => trans('core::listPermission.create')
                    ],
                ],
                'name' => "Kho hàng"
            ],
            'Modules\Orders\Http\Controllers\OrdersController' => [
                'id' => 7,
                'actions' => [
                    "index" => [
                        "id" => 34,
                        "name" => trans('core::listPermission.view')
                    ],
                    "show" => [
                        "id" => 34,
                        "name" => trans('core::listPermission.view')
                    ],
                    "create" => [
                        "id" => 36,
                        "name" => trans('core::listPermission.create')
                    ],
                    "store" => [
                        "id" => 36,
                        "name" => trans('core::listPermission.create')
                    ],
                    "edit" => [
                        "id" => 35,
                        "name" => trans('core::listPermission.edit')
                    ],
                    "update" => [
                        "id" => 35,
                        "name" => trans('core::listPermission.edit')
                    ],
                ],
                'name' => "Đơn hàng"
            ],
        ];
    }
}
