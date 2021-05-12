<?php


class HtmlBuilder
{

    private $tag;
    private $atrribute;
    private $content;
    private function __construct($tag)
    {
        $this->tag = $tag;
    }

    public static function tag($tag){
        return new self($tag);
    }
    public function className($class){

    }
    public function id($id){

    }
    public function attr($attribute, $value = ''){

    }
    public function style($rule, $value){

    }
    public function show(){

    }

}