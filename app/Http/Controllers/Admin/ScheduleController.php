<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Schedule;
use App\Classes;

class ScheduleController extends Controller
{
    public function index()
    {
        $tkb = array();
        // for ($i=1;$i<=5;$i++)
        // {
        //     $day = Schedule::where("class_id", 1)->where("day", $i)->orderBy("start_at", 'asc')->get();
        //     foreach ($day as $key) {
                
        //         for ($z=$key->start_at;$z<$key->start_at + $key->duration;$z++)
        //             $tkb[$z][$i] = $key->subject->subject_name;
        //     }
        // }
        // return view('adminpage.schedule', ['schedulelist' => $tkb]);
        $abc = "<tr>
                    <td> abc </td>
                    <td> abc</td>

         </tr>";
         return view('adminpage.schedule', ['abc' => $abc]);
    }

    public function store(Request $request)
    {
        $Schedule = new Schedule;
        $Schedule->class_id = $request['class'];
        $Schedule->subject_id = $request['subject'];
        $Schedule->day = $request['day'];
        $Schedule->start_at = $request['start'];
        $Schedule->duration = $request['duration'];
        $Schedule->save();
        return Redirect('/admin/schedule');
    }
}
