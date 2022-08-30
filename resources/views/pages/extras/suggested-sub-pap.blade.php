<x-app-layout>
    @section('style')
    <script>
    </script>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
        'pageTitle' => 'Default Sub - Program, Activity and Project (PAP)',
 'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Field Dependency', 'route' => '#'],
            ['name' => 'Data Entry', 'route' => '#'],
            ['name' => 'Default Sub-PAPs', 'route' => '#'],
        ]
    ])

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Suggested Sub PAP</h3>
        <div class="card-tools">
            <a href="#createSuggestedSubPAPModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
            Create Suggested Sub PAP</a>
        </div>
    </div>
  <div class="card-body">
    @livewire('tables.list-of-sub-pap-table')


  </div>
</div>

<div class="modal fade" id="createSuggestedSubPAPModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/field-dependency/data-entry/default-sub-pap" method="POST" >
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Suggested Sub PAP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Sub Paps</label>
                    <input type="text" name="subpaps" id="subpaps" class="form-control form-input">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
        </form>
    </div>
</div>




    @endsection
    
    @section('script')
    <script>
        
Livewire.on('onDeleteItem', async ({key}) => {
    if(key){
        try {
            await $.ajax({
                type:'DELETE',
                url: window.location.origin+"/field-dependency/data-entry/default-sub-pap/"+key,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(response){
                    console.log({response});
                }
            });
        } catch (error) {
            
        }
        finally{
            location.reload();
        }
    }
})
        $("#li_field").addClass('menu-open');
        $("#li_field>a.li_parent").addClass('active');
        $("#li_defaultsub").addClass('active');
    </script>
    @endsection
</x-app-layout>
