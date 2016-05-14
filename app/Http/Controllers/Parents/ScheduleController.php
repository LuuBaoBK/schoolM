<?php

namespace App\Http\Controllers\Parents;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Student;
use App\Model\Parents;
use App\Model\Sysvar;
use App\Model\StudentClass;
use App\Model\Classes;
use App\Model\Phancong;
use App\Model\tkb;
use App\User;

class ScheduleController extends Controller
{
    public function get_view(){
        $student_list = Parents::find(Auth::user()->id)->student;
        if(count($student_list) == 1){
            return redirect('parents/schedule/student_schedule/'.$student_list[0]->user->id);
        }
        foreach ($student_list as $key => $value) {
            $value->user;
        } 
        $tkb = "select_student";
        $updatetime = "No Student Selected";
        return view('parentpage.Schedule', ['tkb' => $tkb, 'student_list' => $student_list, 'updatetime' => $updatetime]);
    }

    public function show_student_schedule($student_id){
        $student_list = Parents::find(Auth::user()->id)->student;
        foreach ($student_list as $key => $value) {
            $value->user;
        } 
        $year = substr(date('Y'),2,2);
        $month = date('m');
        $year = ($month < 8 ) ? $year - 1 : $year ;
        $tkb = [];
        $check = StudentClass::where('student_id','=',$student_id)
                             ->where('class_id','like', $year."_%")
                             ->first();
        if($check == null){
            $tkb = "no_class";
            $class = null;
            $student_name = User::find($student_id)->fullname;
        }
        else{
            $class = Classes::find($check->class_id);
            $student_name = User::find($student_id)->fullname;
            $check = tkb::all();
            if(count($check) == 0){
                $tkb =  "no_schedule";
                return view('parentpage.Schedule', ['tkb' => $tkb, 'student_list' => $student_list, 'updatetime' => $updatetime, 'class' => $class, 'student_name' => $student_name, 'student_id' => $student_id]);  
            }
            for($i = 0; $i<=49; $i++){
                if($i == 0 || $i == 9){
                    $tiet['subject'] = "Chào cờ";
                }
                else if($i == 44 || $i == 49){
                    $tiet['subject'] = "SHCD";
                }
                else{
                    $temp = tkb::where("T".$i,"=",$class->classname)->first();
                    if($temp == null){
                        $tiet['subject'] = "";
                    }
                    else{
                        $tiet['subject'] = $temp->subject_name;
                    }
                }
                array_push($tkb, $tiet);
            }
        }
        $updatetime = Sysvar::find('tkb_date')->value;
        return view('parentpage.Schedule', ['tkb' => $tkb, 'student_list' => $student_list, 'updatetime' => $updatetime, 'class' => $class, 'student_name' => $student_name, 'student_id' => $student_id]);
    }
}
