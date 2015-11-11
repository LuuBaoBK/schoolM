<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('admin/dashboard', function () {
    return view('adminpage.dashboard');
});

// Authentication routes...
Route::get('/', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\MyAuthController@authenticate');
Route::get('auth/logout', 'Auth\MyAuthController@logout');

// Registration routes...
/*
Use this later
Route::get('admin/adduser', [
	'middleware' => 'authrole',
	'uses' => 'Admin\AdduserController@index',
	]);
*/
Route::get ('admin/manage-user/admin', 'Admin\UserManageController@get_ad');
Route::post('admin/manage-user/admin', 'Admin\UserManageController@store_ad');
Route::get ('admin/manage-user/admin/delete/{id}', 'Admin\UserManageController@delete_ad');
Route::get ('admin/manage-user/admin/edit/{id}', 'Admin\UserManageController@get_edit_form');
Route::post ('admin/manage-user/admin/edit/{id}', 'Admin\UserManageController@edit_ad');

Route::get ('admin/manage-user/teacher', 'Admin\UserManageController@get_te');
Route::post('admin/manage-user/teacher', 'Admin\UserManageController@store_te');
Route::get ('admin/manage-user/teacher/delete/{id}', 'Admin\UserManageController@delete_te');

Route::get ('admin/manage-user/student', 'Admin\UserManageController@get_stu');
Route::post('admin/manage-user/student', 'Admin\UserManageController@store_stu');

Route::get ('admin/manage-user/parent', 'Admin\UserManageController@get_pa');
Route::post('admin/manage-user/parent', 'Admin\UserManageController@store_pa');

Route::get ('admin/manage-user/userlist', 'Admin\UserManageController@get_userlist');

//Manage class

Route::get('admin/classinfo', 'Classes\ClassController@view');

Route::get('admin/form', 'Classes\ClassController@form');

Route::post('admin/save', 'Classes\ClassController@save');

Route::post('admin/update', 'Classes\ClassController@update');

Route::get('admin/delete/{id}', 'Classes\ClassController@delete');

Route::get('admin/edit/{id}', 'Classes\ClassController@edit');


//Manage student of class

Route::get('admin/studentclassinfo', 'StudentInClass\StudentInClassController@view');

Route::get('admin/studentclassinfo1', 'StudentInClass\StudentInClassController@view1');

Route::get('admin/studentclassform', 'StudentInClass\StudentInClassController@form');

Route::post('admin/studentclasssave', 'StudentInClass\StudentInClassController@save');

Route::post('admin/studentclassupdate', 'StudentInClass\StudentInClassController@update');

Route::get('admin/studentclassdelete/{class_id}/{student_id}', 'StudentInClass\StudentInClassController@delete');

Route::get('admin/studentclassedit/{class_id}/{student_id}', 'StudentInClass\StudentInClassController@edit');





Route::get('admin/adduser', [
	'middleware' => 'authrole',
	'uses' => 'Admin\AdduserController@index',
	]);

Route::post('admin/adduser', 'Admin\AdduserController@store');

Route::get('admin/adduser', 'Admin\AdduserController@index');
Route::post('admin/adduser', 'Admin\AdduserController@store');


//Manage subject
Route::get('admin/addsubject', 'Admin\AddsubjectController@index');
Route::post('admin/addsubject', 'Admin\AddsubjectController@store');

Route::get('admin/editsubject/{id}', 'Admin\EditsubjectController@edit');
Route::post('admin/editsubject{id}', 'Admin\EditsubjectController@update');
Route::get('admin/deletesubject/{id}', 'Admin\EditsubjectController@delete');

Route::get('admin/schedule', 'Admin\ScheduleController@index');
Route::post('admin/schedule', 'Admin\ScheduleController@store');

Route::get('admin/transcript', 'Admin\TranscriptController@index');
Route::post('admin/transcript', 'Admin\TranscriptController@store');