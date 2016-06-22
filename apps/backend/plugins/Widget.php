<?php
namespace Multiple\Backend\Plugins;

class Widget
{
    public static function load($widget, $data = null)
    {
        if(empty($widget)) return false;
        $WG = ucwords(strtolower($widget));
        $file = '../apps/common/widget/'.$WG.'.php';
        if(!file_exists($file)){
            return "Widget '$widget' not found";
        }
        require $file;
        if(class_exists($WG)){
            if(method_exists($WG, 'active')){
                $WG::active($data);
            }else{
                return "Widget '$widget' not found method active";
            }
        }else{
            return "Widget '$widget' not yet define";
        }
    }
}