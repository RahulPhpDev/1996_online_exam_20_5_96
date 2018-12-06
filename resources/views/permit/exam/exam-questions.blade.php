
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 
<!-- tex2jax: {
      inlineMath: [['$','$'], ['\\(','\\)']],
      ignoreClass: "math-editor", // put this here
      ShowMathMenu: false,
    } -->
<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({
   
     showMathMenu: false,
  extensions: ["tex2jax.js"],
  jax: ["input/TeX", "output/HTML-CSS"],
  tex2jax: {
      skipTags: ["body"],
      processClass: "equation"
  }
  });
</script>
<script type="text/javascript">
  
  $(function () {

    // Never assume one widget is just used once in the page. You might
    // think of adding a second one. So, we adjust accordingly.
    $('.stopwatch').each(function () {

        // Cache very important elements, especially the ones used always
        var element = $(this);
        var running = element.data('autostart');
        var hoursElement = element.find('.hours');
        var minutesElement = element.find('.minutes');
        var secondsElement = element.find('.seconds');
        var millisecondsElement = element.find('.milliseconds');
        var toggleElement = element.find('.toggle');
        var resetElement = element.find('.reset');
        var pauseText = toggleElement.data('pausetext');
        var resumeText = toggleElement.data('resumetext');
        var startText = toggleElement.text();

        // And it's better to keep the state of time in variables 
        // than parsing them from the html.
        var hours, minutes, seconds, milliseconds, timer;

        function prependZero(time, length) {
            // Quick way to turn number to string is to prepend it with a string
            // Also, a quick way to turn floats to integers is to complement with 0
            time = '' + (time | 0);
            // And strings have length too. Prepend 0 until right.
            while (time.length < length) time = '0' + time;
            return time;
        }

        function setStopwatch(hours, minutes, seconds, milliseconds) {
            // Using text(). html() will construct HTML when it finds one, overhead.
            hoursElement.text(prependZero(hours, 2));
            minutesElement.text(prependZero(minutes, 2));
            secondsElement.text(prependZero(seconds, 2));
            millisecondsElement.text(prependZero(milliseconds, 3));
        }

        // Update time in stopwatch periodically - every 25ms
        function runTimer() {
            // Using ES5 Date.now() to get current timestamp            
            var startTime = Date.now();
            var prevHours = hours;
            var prevMinutes = minutes;
            var prevSeconds = seconds;
            var prevMilliseconds = milliseconds;

            timer = setInterval(function () {
                var timeElapsed = Date.now() - startTime;
               
                hours = (timeElapsed / 3600000) + prevHours;
                minutes = ((timeElapsed / 60000) + prevMinutes) % 60;
                seconds = ((timeElapsed / 1000) + prevSeconds) % 60;
                milliseconds = (timeElapsed + prevMilliseconds) % 1000;

                setStopwatch(hours, minutes, seconds, milliseconds);
            }, 25);
        }

        // Split out timer functions into functions.
        // Easier to read and write down responsibilities
        function run() {
            running = true;
            runTimer();
            toggleElement.text(pauseText);
        }

        function pause() {
            running = false;
            clearTimeout(timer);
            toggleElement.text(resumeText);
        }

        function reset() {
            running = false;
            pause();
            hours = minutes = seconds = milliseconds = 0;
            setStopwatch(hours, minutes, seconds, milliseconds);
            toggleElement.text(startText);
        }

        // And button handlers merely call out the responsibilities
        toggleElement.on('click', function () {
            (running) ? pause() : run();
        });

        resetElement.on('click', function () {
            reset();
        });

        // Another advantageous thing about factoring out functions is that
        // They are reusable, callable elsewhere.
        reset();
        if(running == false) run();
    });

});


</script>


<style type="text/css">
  
  .time {
    position: relative;
    top: 36px;
}
.timer_data{
       background: rgba(226,226,226,1);
    border-radius: 50%;
    height: 120px;
    width: 120px;
    text-align: center;
    border: 3px solid #f4a909c4;
    font-weight: bold;
    font-size: 16px;
    color: #000;
    }
</style>
  <div class="maincontent">
    <section class="section">
      <div class="container">
	 	<div class="col-md-12">

<div class = " col-sm-2  col-sm-offset-10">
      <div class="timer_data alert alert-danger alert-dismissible " id="myAlert">

<div class="stopwatch" data-autostart="false">
    <div class="time">
        <span class="hours"></span> : 
        <span class="minutes"></span> : 
        <span class="seconds"></span> 
    </div>
    <div class="controls">
        
    </div>
</div>
</div>
    
  </div>


           <div class = "col-md-7">
           <div class="mycontainer question_section">
             <div class = "questions">
                <span> <?php echo htmlspecialchars_decode($questionDetails->question); ?> </span>
             </div> 
           
          {{-- Form::open(array('route' => ['save-answer',$examId],'class' => 'form-horizontal', 'id'=>'basic_validate'))--}} 

            {{ Form::open(array('route' => 'save-answer','class' => 'form-horizontal', 'id'=>'basic_validate'))}} 
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
             <div class = "mt-10"> </div>
             <div class="controls">
                @if($questionDetails->is_required == 0)
                 <button name="save" type="submit" class="btn btn-success" value="skip">Skip</button>
		           @endif
                <button name="save" type="submit" value="continue" class="btn btn-success">Save And Next Question</button>
            </div>

             </div>

             {{ Form::close() }}
           </div>

           <div class = "col-md-5 report hidden-sm">
        
        <div class="report_section">
         <span class=""> <h2> Total Question </h2> </span>
       <?php 
       $i = 1;
      //  dd($all_questions_class);
       foreach($all_questions_class as $question_id => $class) { ?>
         
         <div class="col-md-3">
            <a class="{{$class}}"> {{$i}} </a>
         </div>
         <?php $i++; } ?>
        </div>
          </div>
        </div>
      </section>    
</div>
@endsection
