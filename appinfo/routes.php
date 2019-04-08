<?php

return ['routes' => [
	['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],

	['name' => 'log#index', 'url' => '/bplog', 'verb' => 'GET'],
	['name' => 'log#create', 'url' => '/bplog', 'verb' => 'POST'],
	['name' => 'log#update', 'url' => '/bplog/{id}', 'verb' => 'PUT'],
	['name' => 'log#destroy', 'url' => '/bplog/{id}', 'verb' => 'POST'],
	['name' => 'log#export', 'url' => '/export', 'verb' => 'GET'],
	['name' => 'log#import', 'url' => '/import', 'verb' => 'POST'],
	['name' => 'log#config', 'url' => '/config', 'verb' => 'POST'],

    ['name' => 'logapi#create', 'url' => '/api/v0.1', 'verb' => 'POST'],
]];
