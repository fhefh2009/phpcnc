<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['captcha'] = 'auth/captcha';
$route['active'] = 'auth/active';
$route['active/(:any)'] = 'auth/active/$1/$2';
$route['logout'] = 'auth/logout';
$route['forgotten/password'] = 'auth/forgotten_password';
$route['reset/password'] = 'auth/reset_password';
$route['reset/password/(:any)'] = 'auth/reset_password/$1/$2';

$route['members'] = 'users/top108';
$route['member/(:num)'] = 'users/detail/$1';
$route['member/(:num)/page/(:num)'] = 'users/detail/$1/$2';
$route['settings/profile'] = 'users/profile';
$route['settings/avatar'] = 'users/avatar';
$route['settings/password'] = 'users/password';

$route['page/(:num)'] = 'topics/topic_list/$1';
$route['topics/(:num)'] = 'topics/subject_topics/$1';
$route['topics/(:num)/page/(:num)'] = 'topics/subject_topics/$1/$2';
$route['topic/create/(:num)'] = 'topics/create/$1';
$route['topic/(:num)'] = 'topics/detail/$1';
$route['topic/(:num)/page/(:num)'] = 'topics/detail/$1/$2';
$route['topic/edit/(:num)'] = 'topics/edit/$1';

$route['api/comments/create'] = 'comments/create';

$route['subjects'] = 'subjects/subject_list';

$route['notifications'] = 'notifications/notification_list';
$route['notifications/page/(:num)'] = 'notifications/notification_list/$1';
$route['api/notifications/delete'] = 'notifications/delete';
$route['notifications/empty'] = 'notifications/delete_all';

$route['collections'] = 'collections/collection_list';
$route['collections/page/(:num)'] = 'collections/collection_list/$1';
$route['api/collections/status/(:num)'] = 'collections/get_status/$1';
$route['api/collections/create'] = 'collections/create';
$route['api/collections/delete'] = 'collections/delete';
$route['collections/empty'] = 'collections/delete_all';

$route['about'] = 'common/about';

$route['default_controller'] = 'topics/topic_list';
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */