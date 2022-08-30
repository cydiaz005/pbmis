<x-app-layout>
    @section('style')
    <script>
    </script>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
       'pageTitle' => 'Service and Region',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Field Dependency', 'route' => '#'],
            ['name' => 'Profile', 'route' => '#'],
            ['name' => 'Service/Region', 'route' => '#'],
        ]
    ])


    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Service/Region</h3>
            <div class="card-tools">
                <a href="#createServiceRegionModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
                Create Service/Region</a>
            </div>
        </div>
      <div class="card-body">
        @livewire('tables.service-region-table')

    
    
      </div>
    </div>

    <div class="modal fade" id="createServiceRegionModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/field-dependency/profile/service-region" method="POST" >
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Service/Region</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Service/Region</label>
                        <input type="text" name="service_region" id="service_region" class="form-control form-input">
                    </div>
                    <div class="mb-3">
                        <label for="">Accronym</label>
                        <input type="text" name="accronym" id="accronym" class="form-control form-input">
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
                        url: window.location.origin+"/field-dependency/profile/service-region/"+key,
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
        $("#li_service").addClass('active');
    </script>
    @endsection
</x-app-layout>
