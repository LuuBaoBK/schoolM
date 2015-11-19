<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Subject;
use App\Model\Sysvar;
use Validator;

class AddsubjectController extends Controller
{
    public function getsubject(){
        $subjectlist = Subject::orderBy('id','desc')->get();
        return view('adminpage.subjectmanage.addsubject', ['subjectlist' => $subjectlist]);
    }
    public function storesubject(Request $request)
    {
        $rules = array(
            'subject_name'     => 'required|max:40',
            'total_time'    => 'max:50',
        );
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
           $record =  $validator->messages();
           return $record;
        }
        else
        {
            $subject = new Subject;
            
            //Create ID
            $sub_next_id = Sysvar::find('sub_next_id');
            $sub_next_id->value = $sub_next_id->value + 1;
            $id = $sub_next_id->value;

            // Create User
            $subject->id = $id;
            $subject->subject_name = $request['subject_name'];
            $subject->total_time = $request['total_time'];
            $subject->save();
            
            $sub_next_id->save();

            $record = array
            (
                "id" => $id,
                "subject_name" => $request['subject_name'],
                "total_time" => $request['total_time'],
                "button" => "<i class = 'fa fa-fw fa-edit'></i><a href='/admin/editsubject/".$id."'>Edit</a>",
                "isDone" => 1 
            );  
            return $record;
        }
    }
}