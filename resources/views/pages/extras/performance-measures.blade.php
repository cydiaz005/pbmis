<x-app-layout>
    @section('style')
    <style>
         .main-footer {
            margin-left: 0 !important;
        }
        .sidebar-mini.sidebar-collapse .main-footer {
            margin-left: 0 !important;
        }
    </style>
    <script>
    </script>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
       'pageTitle' => 'Performance Measures',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Field Dependency', 'route' => '#'],
            ['name' => 'Data Entry', 'route' => '#'],
            ['name' => 'Performance Measures', 'route' => '#'],
        ]
    ])


<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Performance Measures</h3>
        <div class="card-tools">
            <a href="#createPerformanceMeasuresModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
            Create Performance Measure</a>
        </div>
    </div>
  <div class="card-body">
    @livewire('tables.performance-measures-table')
  </div>
</div>

<div class="modal fade" id="createPerformanceMeasuresModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/field-dependency/data-entry/performance-measures" method="POST" >
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Performance Measure</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" class="form-control form-input">
                </div>
                <div class="mb-3">
                    <label for="">Legend</label>
                    <input type="text" name="legend" id="legend" class="form-control form-input">
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
                url: window.location.origin+"/field-dependency/data-entry/performance-measures/"+key,
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

async function onChangeStatus (stageId,active){
        await $.ajax({
            type:'PUT',
            url: window.location.origin+"/field-dependency/data-entry/Performance Measures/"+stageId+"/change-status",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
              active
            },
            success:function(response){
                console.log({response});
            }
        });
        location.reload();
      }
        $("#li_field").addClass('menu-open');
        $("#li_field>a.li_parent").addClass('active');
        $("#li_performance_measures").addClass('active');
    </script>
    @endsection
</x-app-layout>
