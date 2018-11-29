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
       
       
        <div class="">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Subscription Package</h5>
          </div>
          <div class="">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                <th> SN </th>
                  <th>Name</th>
                  <th>Duration</th>
                  <th>Price</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
              @php  $i = 1; @endphp
                @foreach($allData as $data)
              
                <tr class="gradeX">
                  <td>{{$i}}</td>
                  <td>{{$data['name']}}</td>
                  <td>
                    @if($data['isDatePermit'] == 0)
                     {{$data['duration']}}
                    @else

              {{ $data['start_date'].' To '.$data['end_date']}}
                    @endif

                 </td>
                  <td>{{$data['price']}}</td>
                  <td class="center">
                    <a class = "btn btn-danger" href = "{{route('edit-subscription', ['id' => Crypt::encrypt($data['id']) ]) }}">Edit</a></td>
                  <td class="center" ><a class = "btn btn-og">Delete </a></td>
                </tr>
                @php  $i++; @endphp
                @endforeach
              </tbody>
            </table>
            {{$allData->render()}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection