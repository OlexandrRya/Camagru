<?php
    /**
     * @return array routes
     */
    return array(
        'setup' => 'SetupController@setup',
        'login/post' => 'AuthController@login',
        'login' => 'AuthController@getLogin',
        'logout' => 'AuthController@logout',

        'sign-up/create' => 'AuthController@createUser',
        'sign-up' => 'AuthController@signUp',
        'confirm' => 'AuthController@confirmUser',
        'success-register' => 'AuthController@successRegister',

        'settings/change/password' => 'UserController@changePassword',
        'settings/change/email' => 'UserController@changeEmail',
        'settings/change/user-name' => 'UserController@changeUserName',
        'settings' => 'UserController@settingShow',

        'photo/create/post' => 'PhotoController@photoCreatePost',
        'photo/create/show' => 'PhotoController@photoShowCreatePage',

        'home' => 'HomeController@index',
        '' => 'HomeController@index'
    );