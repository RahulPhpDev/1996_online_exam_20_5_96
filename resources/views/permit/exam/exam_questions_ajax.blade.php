

<script src="{{ asset('js/backend_js/jquery.min.js') }}"></script>

<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  

<script type="">
  MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
</script>

<script type="text/javascript">
$(function(){

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
                     // console.log(data);
                  },
              });
          });
        });
</script>
            {{ Form::open(array('route' => 'save-answer','class' => 'form-horizontal', 'id'=>'basic_validate'))}} 
            <div class = "questions">
                <span class = "kkkk"> <?php echo htmlspecialchars_decode($questionDetails->question); ?> </span>
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
               <?php
               /*if($questionDetails->is_required == 0)
                 <button name="save" type="submit" class="btn btn-success" value="skip">Skip</button>
               endif
               */?>
               <input type = "submit" name = "save" value = "Save" class = "btn btn-success">
              <!--   <button name="save" type="submit" value="continue" class="btn btn-success">Save</button> -->
            </div>
            {{ Form::close() }}