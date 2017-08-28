<?php
// Routes
//  GET ROUTES
$app->get('/', 'Application\\Controllers\HomeController:Index');
$app->get('/getChatList', 'Application\\Controllers\HomeController:getChatList');
$app->get('/getAvatarList', 'Application\\Controllers\AccountController:getAvatarList');
$app->get('/getActiveUserList', 'Application\\Controllers\AccountController:getActiveUserList');
$app->get('/getModelDebug', 'Application\\Controllers\AccountController:getModelDebug');

// POST ROUTES
$app->post('/messageSend', 'Application\\Controllers\HomeController:messageSend');
$app->post('/saveUser', 'Application\\Controllers\AccountController:saveUser');
$app->post('/saveActivity', 'Application\\Controllers\HomeController:saveActivity');
