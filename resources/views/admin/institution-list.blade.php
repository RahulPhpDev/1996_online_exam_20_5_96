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
            <h5>Instution</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
           <?php foreach($allData as $data) { ?>     
                <tr class="odd gradeX">
                  <td>{{$data['name']}}</td>
                  <td>
                  <a href="{{ route('editinstitution', ['id' => Crypt::encrypt($data['id']) ]) }}">Edit <i class="fa fa-fw fa-arrow-circle-right"></i></a>&nbsp&nbsp
                  </td>
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