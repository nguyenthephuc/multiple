<?php
namespace Multiple\Backend\Plugins;

class Validator {

    private static $requireErr = ' không được để trống\n';
    private static $invalidErr = ' không hợp lệ\n';

    public static function validate($data)
    {
        $err = array();
        if(!is_array($data)) return false;
        foreach ($data as $field) {
            $mycheck = self::check($field);
            $err = array_merge($err, $mycheck);
        }
        return $err;
    }

    public static function errorback( $arr = null, $path = null )
    {
        if (!$arr) return false;
        $err = implode("", $arr);
        $back = ($path) ? "location.href = '$path';" : 'history.back();';
        $html = '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
        $html .= "<script language='JavaScript'> alert('".$err."'); ".$back."</script>";
        echo $html; exit;
    }

    public static function isEmail($string)
    {
        $pattern = '/\A[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*\z/i' . 'u';
        return preg_match($pattern, $string);
    }

    public static function isPhone($phone)
    {
        $pattern = "/^[0-9]{3}-[0-9]{4}-[0-9]{3,4}|[0-9]{10,11}|[0-9]{2}-[0-9]{4}-[0-9]{3,4}|[0-9]{2}-[0-9]{4}-[0-9]{4,5}|[0-9]{3}-[0-9]{3}-[0-9]{4,5}$/";
        return preg_match($pattern, $phone);
    }

    public static function isHankaku($string)
    {
        return preg_match('/\A[!-~]*\z/' . 'u', $string);
    }

    public static function isHankakuEisu($string)
    {
        return preg_match('/\A[a-zA-Z0-9]*\z/' . 'u', $string);
    }

    public static function isHankakuEiji($string)
    {
        return preg_match('/\A[a-zA-Z]*\z/' . 'u', $string);
    }

    public static function isNum($string)
    {
        return preg_match('/\A[0-9]*\z/' . 'u', $string);
    }

    public static function isNumHyphen($string)
    {
        return preg_match('/\A[0-9-]*\z/' . 'u', $string);
    }

    public static function isHiragana($string)
    {
        return preg_match('/\A[ぁ-ゞ]*\z/' . 'u', $string);
    }

    public static function isZenkakuKatakana($string)
    {
        return preg_match('/\A[ァ-ヶー]*\z/' . 'u', $string);
    }

    public static function isZenkaku($string)
    {
        return preg_match('/[^ -~｡-ﾟ]/' . 'u', $string);
    }

    public static function isZenkakuAll($string)
    {
        return preg_match('/\A[^\x01-\x7E]*\z/' . 'u', $string);
    }

    private static function check($data)
    {
        $mycheck = array();
        if(!is_array($data)) return false;
        switch ($data[2]) {
            case 'require':
                if($data[1]==='')
                    $mycheck[$data[0]] = $data[0].self::$requireErr;
                break;
            case 'email':
                if(!self::isEmail($data[1]))
                    $mycheck[$data[0]] = $data[0].self::$invalidErr;
                break;
            case 'phone':
                if(!self::isPhone($data[1]))
                    $mycheck[$data[0]] = $data[0].self::$invalidErr;
                break;
            default:
                return false;
                break;
        }
        return $mycheck;
    }
}