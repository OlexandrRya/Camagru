<?php

    /**
     * @param $configFileName
     * @param $param
     *
     * @return string/int/null
     */
    function getConfigParam($configFileName, $param)
    {
        $configPath = ROOT . '/config/'. $configFileName . '.php';
        $config = include($configPath);

        return isset($config[$param]) ? $config[$param] : NULL;
    }
