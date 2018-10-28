@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<div id="content">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Exam</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Visible To</th>
                  <th>Total Question</th>
                  <th>Total Mark</th>
                  <th>Passing Mark</th>
                  <th> Other Details </th>
                  <th> View/Edit Question </th>
                  <th> Edit </th>
                  <th> Disable </th>
                </tr>
              </thead>
              <tbody>
           <?php foreach($examDetails as $data) { ?>     
                <tr class="odd">
                  <td>{{$data['exam_name']}}</td>
                  <td> <button type = "button"class ="btn btn-success"> Visible To </button> </td>
                  <td> {{$data['total_question']}} </td>
                  <td> {{$data['total_marks']}}</td>
                  <td> {{$data['minimum_passing_marks']}} </td>
                  <td> <button type = "button" class ="btn btn-success"> Other </button></td>
                  <td> <a class ="btn btn-success" href="{{ route('exam-question', ['id' => Crypt::encrypt($data['id']) ]) }}">Questions <i class="fa fa-fw fa-arrow-circle-right"></i></a>&nbsp&nbsp
                   </td>
                  <td> <button type = "button"class ="btn btn-success"> Edit </button> </td>
                  <td> <button type = "button"class ="btn btn-success"> Disable </button> </td>
                </tr>
                
           <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        </div>
        </div>
</div>
</div>
@endsection