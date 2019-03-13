@foreach($emails as $mail)
<hr>

{{$mail->Alert->name}}
<p> {{$mail->email}}</p>
<p> {{$mail->subject}}</p>
	
<p> {{extractDateTime('d-M-Y h:i A',$mail->send_date)}}</p>
	
{!! $mail->message !!}

<hr>

@endforeach