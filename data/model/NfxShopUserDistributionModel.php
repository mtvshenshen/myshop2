<?php


namespace data\model;

use data\model\BaseModel as BaseModel;

class NfxShopUserDistributionModel extends BaseModel {

    protected $table = 'nfx_shop_user_distribution';
    protected $rule = [
        'order_id'  =>  '',
    ];
    protected $msg = [
        'order_id'  =>  '',
    ];

}