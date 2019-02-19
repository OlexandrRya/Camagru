<?php
namespace App\Repositories;

class SessionRepository
{
    private $session;

    public function __construct()
    {
        $this->session = $_SESSION;
    }

    public function setArrayToSessionInJsonForm($name, $array)
    {
        $json = json_encode($array);
        $this->session[$name] = $json;
    }

    public function getArrayFromSessionByName($name)
    {
        if (isset($this->session[$name])) {
            return json_decode($this->session[$name], true);
        }
        return NULL;
    }

    public  function sessionDestroy()
    {
        session_destroy();
    }
}