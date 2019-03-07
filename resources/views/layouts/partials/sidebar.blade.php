
@section('sidebar')
<!--sidebar-menu-->
<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-file"></i> Addons</a>
  <ul>
    <li><a href="{{route('dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"><a href="#" ><i class="icon icon-user"></i> <span>Users</span></a>
  
    <ul>
        <li><a href="{{route('users')}}">View Users</a></li>
        <li><a href="{{route('add-user')}}">Add User</a></li>
      </ul>
  
  </li>

    <li><a href="{{route('institution')}}"><i class="icon icon-signal"></i> <span>Institution</span></a> </li>
   
    <li class="submenu"><a href="#"><i class="icon icon-signal"></i> <span>Course</span></a> 
    <ul>
        <li><a href="{{route('course')}}">View Course</a></li>
        <li><a href="{{route('add-course')}}">Add Course</a></li>
      </ul>
  </li>

    <li  class="submenu"><a href="#"><i class="icon  icon-reorder"></i> <span>Subscription</span></a>
    <ul>
        <li><a  href="{{route('subscription')}}">View Subscription</a></li>
        <li><a href="{{route('add-subscription')}}">Add Subscription</a></li>
      </ul>
  </li>

    <li class="submenu"><a href="#"><i class="icon  icon-book"></i> <span>Exams</span></a>
    <ul>
        <li><a  href="{{route('exam')}}">Exam</a></li>
        <li><a  href="{{route('add-exam')}}">Add Exam</a></li>
      </ul>
  </li>


   
   

      <li><a href="{{route('result')}}"><i class="icon  icon-hdd"></i> <span>Result</span></a></li>

      <li class="submenu"><a href="#"><i class="icon  icon-book"></i> <span>Question File</span></a>
    <ul>
        <li><a  href="{{route('download-file')}}">Download</a></li>
      </ul>
  </li>
<!-- 
   <li ><a href="{{--route('feedback')--}}"><i class="icon  icon-book"></i> <span>Feedback</span></a>
      -->
    </li>
  <li ><a href="{{route('announcement')}}"><i class="icon  icon-book"></i> <span>Announcement</span></a>
     
    </li>
   
   <!--  
    <li><a href="grid.html"><i class="icon icon-fullscreen"></i> <span>Full width</span></a></li>
    <li class="submenu"> <a href="#"><i class="icon icon-list"></i> <span>Forms</span> <span class="label label-important">3</span></a>
      <ul>
        <li><a href="form-common.html">Basic Form</a></li>
        <li><a href="form-validation.html">Form with Validation</a></li>
        <li><a href="form-wizard.html">Form with Wizard</a></li>
      </ul>
    </li>
    <li><a href="buttons.html"><i class="icon icon-tint"></i> <span>Buttons &amp; icons</span></a></li>
    <li><a href="interface.html"><i class="icon icon-pencil"></i> <span>Eelements</span></a></li>
    <li class="submenu active"> <a href="#"><i class="icon icon-file"></i> <span>Addons</span> <span class="label label-important">5</span></a>
      <ul>
        <li><a href="index2.html">Dashboard2</a></li>
        <li><a href="gallery.html">Gallery</a></li>
        <li><a href="calendar.html">Calendar</a></li>
        <li><a href="invoice.html">Invoice</a></li>
        <li><a href="chat.html">Chat option</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Error</span> <span class="label label-important">4</span></a>
      <ul>
        <li><a href="error403.html">Error 403</a></li>
        <li><a href="error404.html">Error 404</a></li>
        <li><a href="error405.html">Error 405</a></li>
        <li><a href="error500.html">Error 500</a></li>
      </ul>
    </li>
    <li class="content"> <span>Monthly Bandwidth Transfer</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content"> <span>Disk Space Usage</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: 87%;" class="bar"></div>
      </div>
      <span class="percent">87%</span>
      <div class="stat">604.44 / 4000 MB</div>
    </li> -->
  </ul>
</div>

@endsection