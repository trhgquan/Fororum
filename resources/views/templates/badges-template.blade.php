{{-- $userPermission = App\UserInformation::userPermissions(App\User->id) --}}
@if ($userPermission['banned'])
    <span class="label label-danger">lock</span>
@elseif ($userPermission['admin'])
    <span class="label label-success">root</span>
@elseif ($userPermission['mod'])
    <span class="label label-primary">cops</span>
@elseif ($userPermission['confirmed'])
    <span class="label label-primary">auth</span>
@else
    <span class="label label-default">user</span>
@endif
