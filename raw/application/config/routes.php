<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = true;
$route['gardu/pengukuran'] = '/gardu/pengukuran/index';

$route['api/gardu/induk/find'] = '/api/gardu/induk_find';
$route['api/gardu/induk/register'] = '/api/gardu/induk_register';
$route['api/gardu/induk/delete'] = '/api/gardu/induk_delete';
$route['api/gardu/induk/update'] = '/api/gardu/induk_update';
$route['api/gardu/penyulang/find'] = '/api/gardu/penyulang_find';
$route['api/gardu/penyulang/register'] = '/api/gardu/penyulang_register';
$route['api/gardu/penyulang/delete'] = '/api/gardu/penyulang_delete';
$route['api/gardu/penyulang/update'] = '/api/gardu/penyulang_update';
$route['api/gardu/index/find'] = '/api/gardu/index_find';
$route['api/gardu/index/detail'] = '/api/gardu/index_detail';
$route['api/gardu/index/register'] = '/api/gardu/index_register';
$route['api/gardu/index/delete'] = '/api/gardu/index_delete';
$route['api/gardu/index/update'] = '/api/gardu/index_update';

$route['api/mobile/gardu/induk/find'] = '/api/mobile/gardu/induk_find';
$route['api/mobile/gardu/penyulang/find'] = '/api/mobile/gardu/penyulang_find';
$route['api/mobile/gardu/index/insert'] = '/api/mobile/gardu/index_register';

$route['api/gardu/pengukuran/index/register'] = '/api/gardu/pengukuran_index_register';


/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['apiapi/example/users/(:num)'] = 'apiapi/example/users/id/$1'; // Example 4
$route['apiapi/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'apiapi/example/users/id/$1/format/$3$4'; // Example 8
