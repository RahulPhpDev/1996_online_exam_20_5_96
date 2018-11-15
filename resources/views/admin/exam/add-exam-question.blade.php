@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content') 

 

<style type="text/css">
  .editor{
    width: 30x;
    height:40px;
  }

</style>
   
<script type="text/javascript">
 
  $(document).ready(function(){

     $('#edit_1').on('click', function() {
      if (CKEDITOR.instances.txt_area) {
        CKEDITOR.instances.txt_area.destroy();
      } else {
        CKEDITOR.replace('textarea_1');
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
          // alert('data');
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

    $('#basic_validate').validate({ // initialize the plugin
        rules: {
          // "total_mark[1]": { required: true},
          "option[]": { required: true,minlength: 3 },

        },
        messages: {
                  
                     // "total_mark[1]": {
                     //    required :"Select Mark"
                     //  }, 
                      "option[]": {
                        required :"Select Package"
                      },
                  }
    });

    $(".total_mark_input").rules("add", { 
    required:true, 
     messages: {
        required: "Enter something else"
      }
  });

$(".option_input").each(function(){
    $(".option_input").rules("add", { 
    required:true, 
     messages: {
        required: "Enter something eldfasdfse"
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
            
                {{ Form::open(array('route' => ['save-exam-question', $id],'class' => 'form-horizontal', 'id'=>'basic_validate'))}}

                <div class="control-group">
                  {{ Form::label('question','Question 1',array('class' => 'control-label'))}}
                <div class="controls">
                    <button type = "button" id="edit_1">Editor</button>
<br/>

                    {{ Form::textarea('question[1][]',' ', array('class' => 'question editor', 'id'=> 'textarea_1')) }}
                </div>
              </div>

              
              <div class="option_div mt-10" style="text-align: center;">
               <input checked type="radio" name="answer[1]" value = "0"/>
               <input type="text" placeholder="option 1" name = "option[1][]" class="span5 option_input">
              <div class = "mt-15">
                  <input type="radio" name="answer[1]" value = "1" />
               <input type="text"  placeholder="Option 2"  name = "option[1][]" class="span5 option_input">
              </div>

               <div class = "mt-15">
                <input type="radio" name="answer[1]" value = "2" />
                <input type="text" placeholder="Option 3" class="span5 m-wrap option_input"  name = "option[1][]">

             </div>
                <div class = "mt-15">
                 <input type="radio" name="answer[1]" value = "3"/>
                 <input type="text" placeholder="Option 4" class="span5 m-wrap option_input"  name = "option[1][]">
               </div>
             </div>


              <div  class="" style="display: inline-block;margin-left:20px"> 
                 <label class="control-label"  style="font-size: 16px"> Required </label>
               <div class="controls">
                  <input type="checkbox" name="is_required[1]" value="1" />
               </div>
             </div>

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
        
    });
  </script>
@endsection