@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="http://www.pointscontrol.com/img/logo.png" class="logo" alt="POINTS Control Logo">
@else
<img src="http://www.pointscontrol.com/img/logo.png" class="logo" alt="POINTS Control Logo"><br>
{{ $slot }}
@endif
</a>
</td>
</tr>
