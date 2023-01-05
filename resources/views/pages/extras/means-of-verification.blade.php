<x-app-layout>
    @section('style')
    <style>
        /* .main-footer {
            margin-left: 0 !important;
        } */
    </style>
    @endsection

    @section('content')

        @livewire('partials.content-header', [
        'pageTitle' => 'Means of Verification (MOV)',
            'breadcrumb' => [
                ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                ['name' => 'Field Dependency', 'route' => '#'],
                ['name' => 'Data Entry', 'route' => '#'],
                ['name' => 'MOV', 'route' => '#'],
            ]
        ])

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">MOV</h3>
                <div class="card-tools">
                    <a href="#createMFOModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
                    Create MOV</a>
                </div>
            </div>
            <div class="card-body">
                @livewire('mov-table')
            </div>
        </div>

        <div class="modal fade" id="createMFOModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="/field-dependency/data-entry/mov" method="POST" >
                @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create MOV</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="">MOV</label>
                            <input type="text" name="mov" id="mov" class="form-control form-input" required>
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
                        url: window.location.origin+"/field-dependency/data-entry/mov/"+key,
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

                console.log("key", key);
            }
        })
        async function onChangeOrder (mfoId,order){
            await $.ajax({
                type:'PUT',
                url: window.location.origin+"/field-dependency/data-entry/mfo/"+mfoId+"/change-order",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    order
                },
                success:function(response){
                    console.log({response});
                }
            });
            location.reload();
        }
        $("#li_field").addClass('menu-open');
        $("#li_field>a.li_parent").addClass('active');
        $("#li_mov").addClass('active');
    </script>
    @endsection
</x-app-layout>
