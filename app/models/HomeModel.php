<?php


class HomeModel extends Model
{
    const _TABLE = 'category';
    public function getAll(){
        return $this->query("SELECT * FROM ".self::_TABLE.";")->fetchAll(PDO::FETCH_ASSOC);
    }
}