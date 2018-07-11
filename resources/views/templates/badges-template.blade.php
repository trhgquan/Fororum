@if ($o['banned'])
    <span class="label label-danger">lock</span>
@elseif ($o['admin'])
    <span class="label label-success">root</span>
@elseif ($o['mod'])
    <span class="label label-primary">cops</span>
@elseif ($o['confirmed'])
    <span class="label label-primary">auth</span>
@else
    <span class="label label-default">user</span>
@endif
