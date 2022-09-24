<x-app-layout>
    @section('style')
    <style>
        .main-footer {
            margin-left: 0 !important;
        }
    </style>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
       'pageTitle' => 'Program, Activity and Project (PAP) Tagging',
 'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Field Dependency', 'route' => '#'],
            ['name' => 'Data Entry', 'route' => '#'],
            ['name' => 'PAP Tagging', 'route' => '#'],
        ]
    ])

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">PAP Tag</h3>
        <div class="card-tools">
            <a href="#createPAPTagModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
            Create PAP Tag</a>
        </div>
    </div>
  <div class="card-body">
    @livewire('tables.pap-tag-table')


  </div>
</div>

<div class="modal fade" id="createPAPTagModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/field-dependency/data-entry/pap-tagging" method="POST" >
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create PAP Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Tag</label>
                    <input type="text" name="tag" id="tag" class="form-control form-input" required>
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
                url: window.location.origin+"/field-dependency/data-entry/pap-tagging/"+key,
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
        $("#li_paptagging").addClass('active');
    </script>
    @endsection
</x-app-layout>
