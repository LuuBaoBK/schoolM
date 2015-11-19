@extends('mytemplate.newblankpage')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Student_Class</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Student_Class</li>
    </ol>
</section>
<section class="content">
<div class="box">
    <div class="box-body">
        <div class="row">
        <div class="col-lg-6">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#search_by_class" data-toggle="tab">Search By Class</a></li>
                  <li><a href="#children" data-toggle="tab">Children</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="search_by_class">       
                        <form id="pa_info_form" method="POST" role="form">
                            {!! csrf_field() !!}
                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                                        <label for="scholastic">Scholastic</label>
                                        <select id="scholastic" name="scholastic" class="form-control">
                                            <option value="" selected>--Select--</option>;
                                            <?php
                                                $year = date("Y") + 2;
                                                for($year;$year >=2010 ;$year--){
                                                    echo ("<option value='".substr($year,2)."'>".$year." - ".($year+1)."</option>");
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="grade">Grade</label>
                                        <select id="grade" name="grade" class="form-control">
                                            <option value="0">Find All</option>;
                                            <option>6</option>;
                                            <option>7</option>;
                                            <option>8</option>;
                                            <option>9</option>;
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="group">Group</label>
                                        <select id="group" name="group" class="form-control">
                                            <option value="">Find All</option>;
                                            <option>A</option>;
                                            <option>B</option>;
                                            <option>C</option>;
                                            <option>D</option>;
                                            <option>MT</option>;
                                        </select>     
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label for="classname">Class Name</label>
                                        <select id="classname" name="classname" class="form-control">
                                            <option value="0" selected>Select Scholastic First</option>;
                                        </select> 
                                    </div>
                                     <div class="form-group col-lg-4">
                                        <label for="isPassed">Type</label>
                                        <select id="isPassed" name="isPassed" class="form-control">
                                            <option value="-1" selected>All</option>;
                                            <option value="1">Passed</option>;
                                            <option value="0">Not Passed</option>;
                                        </select> 
                                    </div>
                                </div>
                            </div><!-- /.box-body -->   
                        </form>
                        <table id="student_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Full Name</th>
                                    <th>Date Of Birth</th>
                                    <th>IsPassed</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody class="children_table_info">
                            </tbody>
                            
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Full Name</th>
                                    <th>Date Of Birth</th>
                                    <th>IsPassed</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane" id="children">
                        
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
          <!-- /.nav-tabs-custom -->
        </div> <!-- </.half right>  -->
        </div> <!-- /.row -->
    </div> <!-- /.box body -->
</div> <!-- /.box -->
</section>
<!-- DATA TABES SCRIPT -->
        <script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
        
<!-- page script -->
<script type="text/javascript">
$(document).ready(function() {
    $(function() {
        $('#student_table').dataTable();
    });

    $( "#scholastic" ).change(function() {
        updateClassname();
    });
    $( "#grade" ).change(function() {
        updateClassname();
    });
    $( "#group" ).change(function() {
        updateClassname();
    });

    $( "#classname" ).change(function() {
        showClass();
    });
    $( "#isPassed" ).change(function() {
        showClass();
    });

    function updateClassname(){
        var scholastic      = $('#scholastic').val();
        var grade           = $('#grade').val();
        var group           = $('#group').val();
        var token           = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/admin/class/studentclassinfo/updateclassname') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'scholastic'    :scholastic,
                    'grade'         :grade,
                    'group'         :group,
                    '_token'        :token
                    },
            success:function(record){
                $("#classname").empty();
                if(record.count > 0){
                    $('#classname').append("<option value='-2' selected>Find All</option>");
                    $.each(record.data, function(i, row){
                        $('#classname').append("<option value='"+row.classname+"'>"+row.id+"  |  "+row.classname+"</option>");
                    });
                }
                else{
                    $('#classname').append("<option value='-1' selected>No Record</option>");
                }
                
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }
    function showClass(){
        var scholastic      = $('#scholastic').val();
        var grade           = $('#grade').val();
        var group           = $('#group').val();
        var classname       = $('#classname').val();
        var isPassed        = $('#isPassed').val();
        var token           = $('input[name="_token"]').val();
        var button          = "";
        $.ajax({
            url     :"<?= URL::to('/admin/class/studentclassinfo/showclass') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'scholastic'    :scholastic,
                    'grade'         :grade,
                    'group'         :group,
                    'classname'     :classname,
                    'isPassed'      :isPassed,
                    '_token'        :token
                    },
            success:function(record){
                console.log(record);
                $('#student_table').dataTable().fnClearTable();
                button="";
                $.each(record, function(i, row){
                    $('#student_table').dataTable().fnAddData([
                        row.student_id,
                        row.student.user.firstname+" "+row.student.user.middlename+" "+row.student.user.lastname,
                    ]);
                });
                
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }
});
</script>

@endsection