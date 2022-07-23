<div>
<!-- <h1>{{$roleList}}</h1> -->

@foreach ($roleList as $rl)

     @livewire('roles-and-permissions.permission-list', ['role'=>$rl]) 
@endforeach

</div>
