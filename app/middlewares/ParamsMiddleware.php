<?php


class ParamsMiddleware extends Middleware
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    function handle($repuest)
    {
        if (!empty($_SERVER['QUERY_STRING'])) {
            $response = new Response();
            $response->redirect($repuest);
        }
    }
}