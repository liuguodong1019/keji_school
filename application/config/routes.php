<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'course/course_list';
$route['404_override'] = '';
$route['course/(\d+)(.*)'] = "course/index/$1$2";
$route['classroom/(\d+)(.*)'] = "classroom/index/$1$2";
$route['(\w+)'] = "home/$1";
$route['group'] = "group/index";
$route['group/(\d+)(.*)'] = "group/index/$1$2";
$route['classroom'] = "classroom/index";
$route['user/(.*)'] = "user/index/$1";
$route['article'] = 'article/index';
$route['article/(\d+)'] = 'article/content/$1';
$route['translate_uri_dashes'] = FALSE;

