<?php
$sessionKey = Session::isInvalid();
if (!function_exists('formError')) {
    $err = Session::flash($sessionKey . "_errors");
    function formError($fieldName, $beffore = null, $after = null)
    {
        global $err;
        if (!empty($err) && array_key_exists($fieldName, $err)) {
            echo $beffore . $err[$fieldName] . $after;
        }
        return null;
    }
}
if (!function_exists('form_error')) {
    $cur = Session::flash($sessionKey . "_cur");
    function formCurrentValue($fieldName, $deflaut = null)
    {
        global $cur;
        if (!empty($cur) && array_key_exists($fieldName, $cur)) {
            return $cur[$fieldName];
        }
        return $deflaut;
    }
}