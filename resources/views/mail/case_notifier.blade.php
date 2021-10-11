Hi, <br>
<p>
    You have been notified by the Case Management of POLO-KSA.
    For more information, Please read details below:
</p><br>
<b>Case Officer:</b><br>
<p>{{ $request->case_officer }}</p><br>
<b>Nature of Complaint:</b><br>
<p>{{ $request->complaint }}</p><br>
<b>Remarks:</b><br>
<p>{{ $request->remarks }}</p><br>
<b>Status:</b><br>
<p>{{ $request->status }}</p>
@if($request->status == 'suspended')
    <i>{{ $request->days_suspended }}</i>
@elseif($request->status == 'warning')
    <i>{{ $request->days_warning }}</i>
@endif
<br><br>
