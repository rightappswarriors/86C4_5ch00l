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
$route['default_controller'] = 'login';
$route['academics'] = 'academics/index';
$route['academics/gradebook'] = 'gradebook/index';
$route['classroom'] = 'classroom/teacher_index';
$route['classroom/teacher'] = 'classroom/teacher_index';
$route['classroom/create_class'] = 'classroom/create_class';
$route['classroom/teacher_class/(:num)'] = 'classroom/teacher_class_view/$1';
$route['classroom/student_class/(:num)'] = 'classroom/student_class_view/$1';
$route['classroom/activity_submissions/(:num)'] = 'classroom/activity_submissions/$1';
$route['classroom/student_join'] = 'classroom/student_join';
$route['classroom/student_classes'] = 'classroom/student_classes';
$route['classroom/student_notifications'] = 'classroom/student_notifications';
$route['enroll/view_student_info/(:num)'] = 'students/view_student_info/$1';
$route['enroll/enrollment_receipt/(:num)'] = 'students/enrollment_receipt/$1';
$route['enroll/assessment/(:num)'] = 'students/assessment/$1';
$route['enroll/enrollnew_success/(:num)'] = 'students/enrollnew_success/$1';
$route['enroll/enroll_readhandbook'] = 'students/enroll_readhandbook';
$route['enroll/enrollnew_form'] = 'students/enrollnew_form';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
