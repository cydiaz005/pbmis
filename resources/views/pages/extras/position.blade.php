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
       'pageTitle' => 'Position',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Field Dependency', 'route' => '#'],
            ['name' => 'Profile', 'route' => '#'],
            ['name' => 'Position', 'route' => '#'],
        ]
    ])



<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Position</h3>
        <div class="card-tools">
            <a href="#createPositionModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
            Create Position</a>
        </div>
    </div>
  <div class="card-body">
    @livewire('table.position-table')


  </div>
</div>

<div class="modal fade" id="createPositionModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/field-dependency/profile/position" method="POST" >
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Job Title</label>
                    <input type="text" name="job_title" id="job_title" class="form-control form-input" required>
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
                        url: window.location.origin+"/field-dependency/profile/position/"+key,
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
        $("#li_position").addClass('active');
    </script>
    @endsection
</x-app-layout>
