@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')
@section('content')  
<style>
.exam_notes{
    font-size:17px;
}

.best_wish{
    margin-top:10px;
    color: #1ba73c;
    text-transform: capitalize;
    text-decoration: dashed;
    text-indent: inherit;
}
.clear{
    clear: both;
}
</style>
  <div class="maincontent">
    <section class="section">
      <div class="container">
	 	<div class="row justify-content-start">
           <div class = "col align-self-center ">
              <div class = "exam_notes"> 
               <?php echo htmlspecialchars_decode($examData->notes); ?> 
               <div  class="alert alert-success col-sm-6"> 
                    <h3 class = "best_wish"> ALL THE BEST <?php $userData = Auth::User(); echo $userData['fname'].' '.$userData['lname']; ?></h3>
                </div>
            </div>
            <div class = "clear"> </div>
          
            <form action = "{{route('get-exam', ['id' => Crypt::encrypt($examData->id)])}}" method = "GET">
                <input class = "btn btn-success" type = "Submit" value =  "I AGREE">
            </form>
          
        </div>
      </section>    
</div>
@endsection