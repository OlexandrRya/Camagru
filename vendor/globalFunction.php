<?php

    /**
     * @param $configFileName
     * @param $param
     *
     * @return mixed/null
     */
    function getConfigParam($configFileName, $param)
    {
        $configPath = ROOT . '/config/'. $configFileName . '.php';
        $config = include($configPath);

        return isset($config[$param]) ? $config[$param] : NULL;
    }

    /**
     * @return mixed|null
     */
    function auth()
    {
        if (isset($_SESSION['user'])) {
            return json_decode($_SESSION['user']);
        } else {
            return NULL;
        }
    }
