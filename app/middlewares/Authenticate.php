<?php


class Authenticate extends Middleware
{
public function __construct($db)
{
    $this->db = $db;
}

    function handle($request = '')
    {
        if (Session::data("test") === null) {
            $response = new Response();
            $response->redirect($request);
        }
    }
}