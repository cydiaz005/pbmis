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
       'pageTitle' => 'Major Final Output (MFO)',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Field Dependency', 'route' => '#'],
            ['name' => 'Data Entry', 'route' => '#'],
            ['name' => 'MFO', 'route' => '#'],
        ]
    ])

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">MFO</h3>
        <div class="card-tools">
            <a href="#createMFOModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
            Create MFO</a>
        </div>
    </div>
  <div class="card-body">
    @livewire('tables.mfo-table')
  </div>
</div>

@php
$pc_data = App\Models\PriorityClass::all();
@endphp
<div class="modal fade" id="createMFOModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/field-dependency/data-entry/mfo" method="POST" >
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create MFO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="input-label" for="target_sector">PC</label><br>
                    <select name="pc_id" class="select2 form-control" for="target_sector" id="pc_id" required>
                        <option value="">Select PC</option>
                        @foreach ($pc_data as $pc)
                            <option value="{{$pc->id}}">{{$pc->accronym}}-{{$pc->class}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">DESC</label>
                    <input type="text" name="desc" id="desc" class="form-control form-input" required>
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
                url: window.location.origin+"/field-dependency/data-entry/mfo/"+key,
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
        $("#li_mfo").addClass('active');
    </script>
    @endsection
</x-app-layout>
