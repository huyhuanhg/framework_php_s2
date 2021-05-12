<?php


class ProductModel extends Model
{
    public function get($id){
        $data = [
            '1',
            '2',
            '3'
        ];
        return $data[$id];
    }
}