@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<div id="content">
  <div id="content-header">
   
  </div>
  <div class="container-fluid">
    <hr>
     @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-subscription') }}">Add Subscription Package </a>
    <div class="row-fluid">
      <div class="span12">
       
       
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Subscription Package</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Duration</th>
                  <th>Price</th>
                  <!-- <th>Description</th> -->
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                @foreach($allData as $data)
                <tr class="gradeX">
                  <td>{{$data['name']}}</td>
                  <td>
                    @if($data['isDatePermit'] == 0)
                     {{$data['duration']}}
                    @else

              {{ $data['start_date'].' To '.$data['end_date']}}
                    @endif

                 </td>
                  <td>{{$data['price']}}</td>
                 <!--  <td class="center"><?php// echo htmlspecialchars_decode($data['description']); ?></td> -->
                  <td class="center">Edit</td>
                  <td class="center">Delete</td>
                  
                  
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection