<?php

use demaya\Route\Route;

Route::add('/:controller/:action/*');
Route::add('/', ['controller' => 'index', 'action' => 'index']);
