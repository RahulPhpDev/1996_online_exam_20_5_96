@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title = 'Exam Accessbilty')
@section('content') 
<style type="text/css">
	
	.save_btn_form{
		margin:20px;
    padding: 20px;
	}
  .form-horizontal span{
    /*margin-left: 190px;*/
    padding: 0px 0;
       line-height: 4;
       font-weight: bold;
}
</style>
<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')
    <div class="row-fluid">
      <div class="span12">
       <div class="span7 offset2">
        <div class="widget-box">
          <div class="widget-title"> 
            <h5> Exam Details </h5>
          </div>
          <div class="widget-content nopadding">
           <div class = "form-horizontal">
            <div class="control-group exam_visibility">
                    <label class="control-label">Exam Name</label>
                    <span class = "controls"> {{$examDetails['exam_name']}}</span>
            </div>     

              <div class="control-group exam_visibility">
                    <label class="control-label">Total Question </label>
                    <span class = "controls"> {{$examDetails['total_question']}}</span>
            </div>  

                  <div class="control-group exam_visibility">
                    <label class="control-label">Total Mark </label>
                    <span class = "controls"> {{$examDetails['total_marks']}}</span>
               </div> 

                   <div class="control-group exam_visibility">
                    <label class="control-label">Created On  </label>
                    <span class = "controls"> {{extractDateTime('d-M-Y',$examDetails['add_date'])}}</span>
               </div>  

           </div>
          </div>
        </div>
    </div>
             </div>
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span><h3> Edit Exam Accessbilty</h3>
           </div>
             <div class="widget-content nopadding">
            
             

                  {{ Form::open(array('route' => ['update-exam-accessbility', $id], 'id'=>'basic_validate','class' => 'form-horizontal'))}}
                      <div class="control-group exam_visibility">
                            <label class="control-label">Exam Visible TO: </label>
                            <div class="controls" style="display: inline-block;">
                              <label>
                                <input type="radio" name="exam_type" id = "exam_type_1" value = "1"/>
                                All</label>
                             
                              <label>
                                     <input type="radio" name="exam_type" id = "exam_type_2" value = "2"/>
                                     Register Student
                                 </label>

                                 <label>
                                    <input type="radio" name="exam_type" id = "exam_type_3" value = "3" />
                                      Subscription Package 
                                 </label>

                            </div>
                              <div class="control-group" id = "register_student" style = "width:93%;'margin:auto;display:none;">
                             </div>
                          <div class="control-group" id = "subscription_div" style="display: none"></div>
                        </div>
                   <div class = "save_btn_form sm-offset-2">
                        <input class = "save btn btn-custom btn-success btn-custom" type = "submit" value = "Add" name = "save">
                    </div>
                       {{ Form::close() }}
                  </div>
          </div>
        </div> 
      </div>
    </div>
</div>
<script type="text/javascript">
  $(function(){

     $("input[type=radio]").click(function () { 
       if($('#exam_type_3').is(':checked')){ 
          getPackageForExam();
       }else if($('#exam_type_2').is(':checked')){ 
            getStudentForExam();
       }else{
        $("#subscription_div").hide();
        $("#register_student").hide();
        $("#register_student").html('');
       }
});

    var packageId = '<?php echo $examDetails['exam_visible_status']?>';
      $("#exam_type_"+packageId).prop('checked', true);
      if(packageId == 3){
        getPackageForExam();
      }else if(packageId == 2){
        getStudentForExam();
      }
  });

  function getPackageForExam(){
  var examId = '<?php echo $id; ?>';
      $.ajax({
        type : "get",
        url: "/exam-package-accessbility/"+examId,
        success:function(data){
            $("#subscription_div").show();
            $("#subscription_div").html(data);
            $("#register_student").hide();
            $("#register_student").html('');
          }
        });
  }
  function getStudentForExam(){
    var examId = '<?php echo $id; ?>';
    $.ajax({
        type : "get",
        url: "/exam-accessbility/"+examId,
        success:function(data){
            $("#subscription_div").hide();
            $("#register_student").show();
            $("#register_student").html(data);
          }
        });
  }
</script>

@endsection