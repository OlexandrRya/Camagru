<?php
    /**
     * @return array routes
     */
    return array(
        'setup' => 'SetupController@setup',
        'login/post' => 'UserController@login',
        'login' => 'UserController@getLogin',
        'logout' => 'UserController@logout',
        'sign-up/create' => 'UserController@createUser',
        'sign-up' => 'UserController@signUp',
        'home' => 'HomeController@index',
        'success-register' => 'UserController@successRegister',
        'confirm' => 'UserController@confirmUser',

        '' => 'HomeController@index'
    );