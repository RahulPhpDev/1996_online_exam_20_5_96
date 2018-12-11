

<script src="{{ asset('js/backend_js/jquery.min.js') }}"></script>

<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  

<script type="">
  MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
</script>

<script type="text/javascript">
$(function(){

$(document).on("click",".opt_data",function(){
    
    $(this).find('input[type="radio"]').prop('checked', true);
  });


  $(document).on("click",".savebtn",function(){
    var btnVal = $(this).val();
    $("#saveu").val(btnVal);
  });

  //  $(document).on("click",".numberic",function(){
  //   var questionId = $(this).attr('id');
  //   questionRedirect(questionId);
  // });

  // function questionRedirect(questionId){
  //   alert(questionId);
  //   $.ajax({
  //     url: "/get-question",
  //     type: 'POST',
  //     // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
  //     data: {
  //       _method: 'POST',
  //       que_id : questionId,
  //       _token:     '{{ csrf_token() }}'
  //     },
  //     success: function (data) {
  //       console.log(data);
  //                   if(data === 'view-result'){
  //                   window.location = '/view-result' ;

  //                   }else{
  //                   $("#question_list").html(data);
  //                   }
  //                 },
  //                 error: function (data) {
  //                     console.log('An error occurred.');
  //                    // console.log(data);
  //                 },
  //   })
  // }


  var frm = $('#basic_validate');

$(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
     frm.submit();
});
    frm.submit(function (e) {
      console.log('submit');
              e.preventDefault();
              $.ajax({
                  type: frm.attr('method'),
                  url: frm.attr('action'),
                  data: frm.serialize(),
                  success: function (data) {
                    if(data === 'view-result'){
                    window.location = '/view-result' ;

                    }else{
                    $("#question_list").html(data);
                    }
                  },
                  error: function (data) {
                      console.log('An error occurred.');
                  },
              });
          });
        });
</script>
         

         <div class = "col-md-8" >
        <div class="mycontainer question_section">
       
            {{ Form::open(array('route' => 'save-answer','class' => 'form-horizontal', 'id'=>'basic_validate'))}} 
            <div class = "questions">
                <span> <?php echo htmlspecialchars_decode($questionDetails->question); ?> </span>
             </div> 
              <div class = "options">
                @foreach($questionDetails->Options as $data)
                 <div class = "opt_data">
                    <input type ="radio" class ="rdo_opt" name = "answer" value = "{{$data['id']}}"> 
                    <span class = "options_span"> 
                       {{$data->question_option}}
                      </span> 
                </div>
                @endforeach
              </div>
             <div class = "mt-10"> </div>
             <div class="controls">
              
             
                <input type = "hidden" name = "save" id = "saveu">

                <button name="save" type="submit" value="continue" class="btn btn-success savebtn">Save</button>

                <button name="save" type="submit" value="preview" class="btn btn-primary savebtn">Preview</button>
                 </div>
                {{ Form::close() }}
              </div>
             </div>

              
     <div class = "col-md-4 hidden-sm report">
      <div class = "question_process_color">
           <div> <a class="answered_count current">C </a> <span> Current </span> </div>
           <div> <a class="answered_count answered"> A </a> <span> Answered </span> </div>
           <div> <a class="answered_count review">R </a> <span> Review </span> </div>
           <div> <a class="answered_count not_visited">NV </a> <span>Not Visited </span> </div>

           <div> <a class="answered_count not_answered">NA</a> <span>Not Answered </span> </div>
     </div>
     <div class = "question_count_div panel"> <h2>  Question </h2> </div>
       <?php 
          $i = 1;
          foreach($all_questions_class as $question_id => $class) { ?>
           <a href = "JavaScript:void(0);" id = "{{$question_id}}" class = "numberic {{$class}} ">
              <span  >   {{$i}} </span>
            </a> 
          <?php $i++; } ?>
        </div>