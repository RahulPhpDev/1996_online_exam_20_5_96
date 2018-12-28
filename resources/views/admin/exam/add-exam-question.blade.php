@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content') 


<script src="{{ asset('/js/common/extra_validate.js') }}"></script>
<style type="text/css">
 .option_ra textarea{
  margin: 0px;
   width: 381px;
    height: 26px;
 }
.text_alert a{
    font-weight: 700;
    color: blue;
    font-style: italic;
    font-size: 19px;
  }
</style>
   
<script type="text/javascript">
 
$(document).ready(function(){
$('#basic_validate').validate({
  ignore: [], 
    rules: {
        sample_file: {
            required: true,
            checkExcel: true
        },messages: {
                     required: "File is Required ",
                     checkExcel: "Only Excel File "
                  }
    },
    submitHandler: function(form) {
                document.basic_validate.submit();
            },
});   

     $('#edit_1').on('click', function() {
      if (CKEDITOR.instances.txt_area) {
        CKEDITOR.instances.txt_area.destroy();
      } else {
        CKEDITOR.replace( 'textarea_1',
            {
            height: '110px',
            width: '80%',
            } );
      }
  });


    var i = 1;
    $(".btn_add_more_cls").on("click", function(){
      var thisId = $(this).attr("id");
      i++;
      if(i < 6){
      $.ajax({
        type : "get",
        url: "/more-question/"+i,
        success:function(data){
          $("#more_question").append(data);
          }
        });
      }else{
        alert('can not add more than 5 question At One Time Please Click Save and Continue Button');
      }
    });
  });
</script>



<script type="text/javascript">
$(document).ready(function () {
  $("#excel_file_download").on("click",function(){
    window.location.href = '/download-file'; //Will take you to Google.

  });


  $(".option_style").on( "click", function(){
  var txt =     $(this).parent('.controls').find('textarea').attr('id');
  
  $(this).parent('.controls').css({'margin-left': '230px',});
    $(this).hide();
  if (CKEDITOR.instances.txt_area) {
        CKEDITOR.instances.txt_area.destroy();
      } else {
        CKEDITOR.replace( txt,{height: '90px', width: '70%', } );
      }

    $(this).parent('.controls').find('.checkmark').css({'top': '-72px','left': '-34px', });
  });

    $('#basic_validate2').validate({ // initialize the plugin
        ignore: [],
              debug: false,
        rules: { "option[]": { required: true,minlength: 3 },
        },
        messages: {"option[]": { required :"Select Package"  },
                  }
    });

    $(".total_mark_input").rules("add", { 
    required:true, 
     messages: {
        required: "Mark for question is required"
      }
  });

$(".option_input").each(function(){
    $(".option_input").rules("add", { 
    required:true, 
     messages: {
        required: "Option is required"
      }
  });
});

$(".question_textarea").each(function(){
    $(".question_textarea").rules("add", { 
    required:true, 
     messages: {
        required: "Question is Missing"
      }
  });
});
});

</script>

<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')
    <div class="row-fluid">
      <div class="span8">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>{{$title}}</h5>
          </div>
          
          <div class="widget-content nopadding">
       <div class = "form-horizontal">
                <div class="control-group">
                       <label class="control-label">  <strong> Import File ? </strong></label>
                     <div class="controls">
                        <input type="checkbox" name="is_file" class = "is_file" />
                     </div>
                  </div>

                <div class="hide file_sec"  style="display: inline-block;margin-left:20px"> 
                  {{ Form::open(array('route' => ['importQuestion', Crypt::encrypt($id)],'class' => '', 'id'=>'basic_validate','enctype'=>'multipart/form-data'))}}
                  <div class = "text_alert" style ="padding: 16px 0px;  font-size: 14px;" >
                    <span class = "text-danger pull-right"> Please Uplode File in proper Format.You can check format and upload this file 
                    <a href = "javascript:void(0);" id = "excel_file_download" > Download File Format </a>
                  </span>
                 
                  </div>
                  <div class="control-group">
                  <label class="control-label">  <strong> File </strong></label>
                     <div class="controls">
                       <input type = "file" id = "sample_files" name = "sample_file">
                     </div>
                  </div>
                     <div class="controls" style="margin-top:20px ">
                      <input name="save_file" type = "submit" value = "Save" class="save_file btn btn-success">
                  </div>
              {{ Form::close() }}
                </div>  
                </div>


              <div class = "question_hardcoded">
                {{ Form::open(array('route' => ['save-exam-question', $id],'class' => 'form-horizontal', 'id'=>'basic_validate2','enctype'=>'multipart/form-data'))}}

                <div class="control-group">
                  {{ Form::label('question','Question 1',array('class' => 'control-label question_label'))}}
                <div class="controls">
                    <span class = "span_style pull-right" id="edit_1">+STYLE+</span><br>
                    {{ Form::textarea('question[1][]',' ', array('class' => 'question editor question_textarea', 'id'=> 'textarea_1','rows' => '3')) }}
                </div>
              </div>
              <div class ="options_group">
               <div class="control-group">
                 <div class="controls">
                      <span class = "span_style option_style pull-right">+STYLE+</span>
                    <label class="option_ra">
                    <input type="radio" checked name="answer[1]" value = "0" />
                        {{ Form::textarea('option[1][]',' ', array('class' => 'option_txtarea', 'id'=> 'option_1_0','cols' => '80%')) }}
                  <span class="checkmark"></span>
                </label>
              </div>              
            </div>


               <div class="controls">
                      <span class = "span_style option_style pull-right">+STYLE+</span>
                    <label class="option_ra">
                    <input type="radio" name="answer[1]" value = "1" />
                        {{ Form::textarea('option[1][]',' ', array('class' => 'option_txtarea', 'id'=> 'option_1_1','cols' => '80%')) }}
                  <span class="checkmark"></span>
                </label>
              </div>

               <div class="controls">
                      <span class = "span_style option_style pull-right">+STYLE+</span>
                    <label class="option_ra">
                    <input type="radio" name="answer[1]" value = "2" />
                        {{ Form::textarea('option[1][]',' ', array('class' => 'option_txtarea', 'id'=> 'option_1_2','cols' => '80%')) }}
                  <span class="checkmark"></span>
                </label>
              </div>

               <div class="controls">
                      <span class = "span_style option_style pull-right">+STYLE+</span>
                    <label class="option_ra">
                    <input type="radio" name="answer[1]" value = "3" />
                        {{ Form::textarea('option[1][]',' ', array('class' => 'option_txtarea', 'id'=> 'option_1_3','cols' => '80%')) }}
                  <span class="checkmark"></span>
                </label>
              </div>
        </div>


               



              <!-- <div  class="" style="display: inline-block;margin-left:20px"> 
                 <label class="control-label"  style="font-size: 16px"> Required </label>
               <div class="controls">
                  <input type="checkbox" name="is_required[1]" value="1" />
               </div>
             </div> -->

            <div  class="" style="display: inline-block"> 
              <label class="control-label">Marks :</label>
               <div class="controls">
                <input type="text" class ="total_mark_input" name="total_mark[1]" style = "width: 20%"/>
              </div>
             </div>


           <div  class="">
              <div  class=""  style="display: inline-block;margin-left:20px"> 
                 <label class="control-label"  style="font-size: 16px"> Is Negative Marking </label>
               <div class="controls">
                  <input type="checkbox" name="is_negative[1]" class = "is_negative" />
               </div>
            </div>

            <div  class="" style="display: none"> 
              <label class="control-label">Negative Marks :</label>
               <div class="controls">
                <input type="text"  name="negative_mark[1]"  style = "width: 20%" class=""  />
              </div>
             </div>
           </div>

             <button  id = "btn_add_more_1" class="btn btn-primary btn-sm btn_add_more_cls pull-right" type ="button" >Add More</button>

           <div id = "more_question"> </div>

             <div class="controls" style="margin-top:20px ">
                    <button name="save" type="submit" class="btn btn-success" value="save">Save</button>
                    <button name="save" type="submit" value="continue" class="btn btn-success">Save And Continue</button>
                </div>
              {{ Form::close() }}
               </div> 
            </div>
          </div>
         </div>

         <div class="span4">
            @php $componentData = array('title' => $title,
              'getExamData' => $getExamData,
            ); @endphp
            @component('admin.exam.template.exam-details', $componentData)
            @endcomponent
         </div>
       </div>
    </div>
</div>

<script>
      $(document).ready(function(){

      $(".is_negative").click(function(){
       if ($(this).is(':checked')) {
        var id = $(this).parent().parent().next('div').css("display", "inline-block");
       }else{
        var id = $(this).parent().parent().next('div').css("display", "none");
       }
      });

      $(".is_file").click(function(){
       if ($(this).is(':checked')) {
        var id = $(".question_hardcoded").css("display", "none");
         $('.file_sec').removeClass('hide');
       }else{
        var id = $(".question_hardcoded").css("display", "inline-block");
         $('.file_sec').addClass('hide');
       }
      });
        
    });
  </script>
@endsection