@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://cdn.brandfetch.io/id1fkA6q8L/w/616/h/272/theme/dark/logo.png?c=1dxbfHSJFAPEGdCLU4o5B" class="logo" alt="Lintasarta" style="display: block; margin: 0 auto; height: auto; width: 150px; max-width: 100%;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
