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
        'confirm/success' => 'AuthController@successConfirm',
        'confirm' => 'AuthController@confirmUser',
        'success-register' => 'AuthController@successRegister',

        'settings/change/password' => 'UserController@changePassword',
        'settings/change/email' => 'UserController@changeEmail',
        'settings/change/user-name' => 'UserController@changeUserName',
        'settings' => 'UserController@settingShow',

        'photo/create/snapshot-post' => 'PhotoController@photoCreatePostSnapshotFile',
        'photo/create/post' => 'PhotoController@photoCreatePostUploadFile',
        'photo/create/show' => 'PhotoController@photoShowCreatePage',

        'home' => 'HomeController@index',
        '' => 'HomeController@index'
    );