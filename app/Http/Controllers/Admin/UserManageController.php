<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Admin;
use App\Model\Teacher;
use App\Model\Student;
use App\Model\Parents;
use App\Model\Sysvar;
use Input;
use Validator;


class UserManageController extends Controller
{
    public function get_ad(){
        $adminlist = Admin::all();
        return view('adminpage.usermanage.adduser_ad', ['adminlist' => $adminlist]);
    }

    public function get_te(){
        $teacherlist = Teacher::all();
        return view('adminpage.usermanage.adduser_te', ['teacherlist' => $teacherlist]);
    }

    public function get_stu(){
        $studentlist = Student::all();
        return view('adminpage.usermanage.adduser_stu', ['studentlist' => $studentlist]);
    }

    public function get_pa(){
        $parentlist = Parents::all();
        return view('adminpage.usermanage.adduser_pa', ['parentlist' => $parentlist]);
    }

    public function get_userlist(){
        $userlist = User::all();
        return view('adminpage.usermanage.userlist', ['userlist' => $userlist]);
    }

    public function store_ad(Request $request)
    {
        $rules = array(
            'firstname'     => 'max:20',
            'middlename'    => 'max:20',
            'lastname'      => 'max:20',
            'mobilephone'   => 'digits_between:10,11',
            'dateofbirth'   => 'date_format:d/m/Y',
            'address'       => 'max:120'
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
           $record =  $validator->messages();
           return $record;
        }else{
            $user = new User;
            $admin = new Admin;
            //Create ID
            $ad_next_id = Sysvar::find('a_next_id');
            $ad_next_id->value = $ad_next_id->value + 1;
            $id = $ad_next_id->value;
            $offset = strlen($id);
            $newid = "0000000";
            $newid = substr($newid,$offset);
            $newid = "a_".$newid.$id;
            //Handle Date Format
            if($request['dateofbirth'] != "")
            {
                $dateofbirth = date_create_from_format("d/m/Y", $request['dateofbirth']);
                $dateofbirth = date_format($dateofbirth,"Y-m-d");
            }
            else{
                $dateofbirth = $request['dateofbirth'];
            }

            //Create Email & Password
            $email = $newid."@schoolm.com";
            $password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

            // Create User
            $user->id = $newid;
            $user->email = $email;
            $user->password = $password;
            $user->firstname = $request['firstname'];
            $user->middlename = $request['middlename'];
            $user->lastname = $request['lastname'];
            $user->address = $request['address'];
            $user->role = "0";
            $user->dateofbirth = $dateofbirth;
            if($user->save())
            {
                $admin->id = $newid;
                $admin->create_by = $request->user()->id;
                $admin->mobilephone = $request['mobilephone'];
                if($admin->save()){
                    $ad_next_id->save();
                    $record = array
                    (
                        "id" => $newid,
                        "fullname" => $request['firstname']." ".$request['middlename']." ".$request['lastname'],
                        "email" => $email,
                        "mobilephone" => $admin->mobilephone,
                        "dateofbirth" => $request['dateofbirth'],
                        "role" => $user->role,
                        "create_by" => $admin->create_by,
                        "address" => $request['address'],
                        "button" => "<i class = 'fa fa-fw fa-edit'></i>
                                    <a href='/admin/manage-user/admin/edit/$newid' >Edit</a>",
                        "isDone" => 1 
                    );
                    
                    return $record;
                }
                else{
                    User::where('id',$newid)->delete();
                    return "error";
                }
            }
            else{
                return "error";
            }
        }
        //return Redirect('/admin/manage-user/admin');
    }

    public function store_te(Request $request)
    {
        $user = new User;
        $teacher = new Teacher;

        $ad_next_id = Sysvar::find('t_next_id');
        $ad_next_id->value = $ad_next_id->value + 1;
        $ad_next_id->save();
        $id = $ad_next_id->value;
        $offset = strlen($id);
        $newid = "0000000";
        $newid = substr($newid,$offset);
        $newid = "te_".$newid.$id;

        $dateofbirth = date_create($request['dateofbirth']);
        $dateofbirth = date_format($dateofbirth,"Y-m-d");
        $incomingday = date_create($request['incomingday']);
        $incomingday = date_format($incomingday,"Y-m-d");
        // Create User
        $user->id = $newid;
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->firstname = $request['firstname'];
        $user->middlename = $request['middlename'];
        $user->lastname = $request['lastname'];
        $user->address = $request['address'];
        $user->role = "1";
        $user->dateofbirth = $dateofbirth;
        $user->save();

        // Create Admin
        $teacher->id = $newid;
        $teacher->mobilephone = $request['mobilephone'];
        $teacher->homephone = $request['homephone'];
        $teacher->group = $request['group'];
        $teacher->position = $request['position'];
        $teacher->specialize = $request['specialize'];
        $teacher->incomingday = $incomingday;
        $teacher->save();

        return Redirect('/admin/manage-user/teacher');
    }

    public function store_stu(Request $request)
    {
        $user = new User;
        $student = new Student;

        $ad_next_id = Sysvar::find('s_next_id');
        $ad_next_id->value = $ad_next_id->value + 1;
        $ad_next_id->save();
        $id = $ad_next_id->value;
        $offset = strlen($id);
        $newid = "0000000";
        $newid = substr($newid,$offset);
        $newid = "st_".$newid.$id;

        $dateofbirth = date_create($request['dateofbirth']);
        $dateofbirth = date_format($dateofbirth,"Y-m-d");

        // Create User
        $user->id = $newid;
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->firstname = $request['firstname'];
        $user->middlename = $request['middlename'];
        $user->lastname = $request['lastname'];
        $user->address = $request['address'];
        $user->role = "2";
        $user->dateofbirth = $dateofbirth;
        $user->save();

        // Create Student
        $student->id = $newid;
        $student->enrolled_year = $request['enrolled_year'];
        $student->graduated_year = $request['graduated_year'];
        $student->parent_id = $request['parent_id'];
        $student->save();

        return Redirect('/admin/manage-user/student');
    }

    public function store_pa(Request $request)
    {
        $user = new User;
        $parent = new Parents;

        $ad_next_id = Sysvar::find('p_next_id');
        $ad_next_id->value = $ad_next_id->value + 1;
        $ad_next_id->save();
        $id = $ad_next_id->value;
        $offset = strlen($id);
        $newid = "0000000";
        $newid = substr($newid,$offset);
        $newid = "pa_".$newid.$id;

        $dateofbirth = date_create($request['dateofbirth']);
        $dateofbirth = date_format($dateofbirth,"Y-m-d");

        // Create User
        $user->id = $newid;
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->firstname = $request['firstname'];
        $user->middlename = $request['middlename'];
        $user->lastname = $request['lastname'];
        $user->address = $request['address'];
        $user->role = "3";
        $user->dateofbirth = $dateofbirth;
        $user->save();

        // Create Student
        $parent->id = $newid;
        $parent->mobilephone = $request['mobilephone'];
        $parent->homephone = $request['homephone'];
        $parent->job = $request['job'];
        $parent->save();

        return Redirect('/admin/manage-user/parent');
    }

    public function get_edit_form($id)
    {
        $admin = Admin::find($id);
        return view('adminpage.usermanage.edit_ad')->with('admin',$admin);
    }

    public function edit_ad($id, Request $request){
        $user  = User::find($id);
        $admin = Admin::find($id);

        $user->email = $request['email'];
        $user->firstname = $request['firstname'];
        $user->middlename = $request['middlename'];
        $user->lastname = $request['lastname'];
        $user->address = $request['address'];
        $user->dateofbirth = $request['dateofbirth'];
        $user->save();

        // Create Admin
        $admin->ownername = $request['fullname'];
        $admin->mobilephone = $request['mobilephone'];
        $admin->save();

        return Redirect('/admin/manage-user/admin');
    }
}
