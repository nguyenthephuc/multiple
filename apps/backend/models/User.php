<?php

namespace Multiple\Backend\Models;

class User extends ModelBase
{
    public function getSource()
    {
        return 'user';
    }

    public static function insert($params)
    {
        $obj = new self;
        foreach ($params as $key => $value){
            if($value !== '')
                $obj->$key = $value;
        }
        $obj->create();
    }

    public static function updated($id, $params)
    {
        $obj = self::findFirstById($id);
        if(!$obj) return false;
        foreach ($params as $key => $value){
            if($value !== '')
                $obj->$key = $value;
        }
        $obj->save();
    }
}