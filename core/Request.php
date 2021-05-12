<?php


class Request
{
    private $__rules;
    private $__message;
    private $__errors;
    public $__dataField;
    private static $db;
    public function __construct()
    {
        if (!isset(self::$db)){
            self::$db = new Database();
        }
        $this->__dataField = $this->getFields();
    }

    private function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        if ($this->getMethod() === 'get') {
            return true;
        }
        return false;
    }

    public function isPost()
    {
        if ($this->getMethod() === 'post') {
            return true;
        }
        return false;
    }

    private function getFields()
    {
        $dataFields = [];
        if ($this->isGet()) {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        if ($this->isPost()) {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        return $dataFields;
    }

    public function rules($rules = [])
    {
        $this->__rules = array_filter($rules);
    }

    public function message($message = [])
    {
        $this->__message = $message;
    }

    public function validate()
    {
        $check = true;
        if (!empty($this->__rules)) {
            foreach ($this->__rules as $fieldName => $ruleItem) {
                $rulesArr = explode('|', $ruleItem);
                foreach ($rulesArr as $rule) {
                    $ruleName = null;
                    $ruleValue = null;
                    $ruleArr = explode(':', $rule);
                    $ruleName = reset($ruleArr);
                    if (count($ruleArr) > 1) {
                        $ruleValue = end($ruleArr);
                    }
                    if (!$this->$ruleName($this->__dataField[$fieldName], $ruleValue)) {
                        if (!isset($this->__errors[$fieldName])) {
                            $this->__errors[$fieldName] = $this->__message["$fieldName.$ruleName"];
                        }
                        $check = false;
                    }
                }
            }
        }
        $sessionKey = Session::isInvalid();
        Session::flash($sessionKey."_errors",$this->__errors);
        Session::flash($sessionKey."_cur",$this->__dataField);
        return $check;
    }

    public function errors($fieldName = '')
    {
        if (!empty($this->__errors)) {
            if (!empty($fieldName)) {
                return $this->__errors[$fieldName];
            }
            return $this->__errors;
        }
        return false;
    }

    private function required($rule, $param = true)
    {
        if (empty(trim($rule))) {
            return false;
        }
        return true;
    }

    private function min($rule, $param)
    {
        if (strlen($rule) < $param) {
            return false;
        }
        return true;
    }

    private function equal($rule, $param)
    {
        if ($rule !== $this->__dataField[$param]) {
            return false;
        }
        return true;
    }

    private function email($rule, $param = true)
    {
        if (!filter_var($rule, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    private function unique($rule, $params){
        $uniqueArr = explode(':', $params);
        $tableName = reset($uniqueArr);
        $fieldName = end($uniqueArr);
        $unique = self::$db->query("SELECT * FROM category;")->rowCount();
        return true;
    }
}