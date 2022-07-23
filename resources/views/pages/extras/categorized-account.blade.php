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
       'pageTitle' => 'Categorized Accounts',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Field Dependency', 'route' => '#'],
            ['name' => 'Data Entry', 'route' => '#'],
            ['name' => 'Categorized Accounts', 'route' => '#'],
        ]
    ])

@php
$ac_data = App\Models\AllotmentClass::all();
$fc_data = App\Models\FundChargeability::all();
$fcc_data = App\Models\FundChargeabilityClass::all();
$coa_data = App\Models\ChartOfAccounts::all();
$kdpkpks_data = App\Models\KdpKpKs::all();
$mfo_data = App\Models\Mfo::all();
@endphp

    <blockquote>
    <h1 style="font-size: 25px">Allotment Class and Fund Chargeability Categorization</h1>
    </blockquote>

    {{-- CATEGORIES --}}

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Category</h3>
            <div class="card-tools">
                <a href="#createCategoryModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
                    Create Category
                </a>
            </div>
        </div>
      <div class="card-body">
        @livewire('components.flash-messages', ["parent_id" => "allotment_class"])
        @livewire('category-table')
      </div>
    </div>
    <div class="modal fade" id="createCategoryModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/field-dependency/data-entry/categorized-account" method="POST" >
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="input-label" for="target_sector">Fund Chargeability</label><br>
                        <select name="fc_id" class="select2 form-control" for="target_sector" id="pc_id" required>
                            <option value="">Select FC</option>
                            @foreach ($fc_data as $fc)
                                <option value="{{$fc->id}}">{{$fc->accronym}}-{{$fc->type}}</option>
                            @endforeach
                        </select>
                    </div>
                   <div class="form-group">
                        <label class="input-label" for="target_sector">Allotment Class</label><br>
                        <select name="ac_id" class="select2 form-control" for="target_sector" id="pc_id" required>
                            <option value="">Select AC</option>
                            @foreach ($ac_data as $ac)
                                <option value="{{$ac->id}}">{{$ac->accronym}}-{{$ac->class}}</option>
                            @endforeach
                        </select>
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



    

    <blockquote style="margin-top: 20px;">
    <h1 style="font-size: 25px">Chart of Accounts per Category</h1>
    </blockquote>


    {{-- COA CATEGORY --}}

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Coa FC Category</h3>
            <div class="card-tools">
                <a href="#createCoaCategoryModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
                    Create Coa Per Category
                </a>
            </div>
        </div>
      <div class="card-body">
        @livewire('components.flash-messages', ["parent_id" => "coa_fc"])
        @livewire('afc-table')
      </div>
    </div>

    <div class="modal fade" id="createCoaCategoryModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/field-dependency/data-entry/categorized-fcc-coa" method="POST" >
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Coa Fcc Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="input-label" for="target_sector">Chart of Accounts</label><br>
                        <select name="coa_id" class="select2 form-control" for="target_sector" id="pc_id" required>
                            <option value="">Select Coa</option>
                            @foreach ($coa_data as $coa)
                                <option value="{{$coa->id}}">{{$coa->code}}-{{$coa->expense_object}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="target_sector">Fund Chargeability Category</label><br>
                        <select name="fcc_id" class="select2 form-control" for="target_sector" id="pc_id" required>
                            <option value="">Select FCC</option>
                            @foreach ($fcc_data as $fcc)
                                <option value="{{$fcc->id}}">{{$fcc->allotmentClass->accronym}}-{{$fcc->fundChargeability->accronym}}</option>
                            @endforeach
                        </select>
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

    <blockquote style="margin-top: 20px;">
        <h1 style="font-size: 25px">Kdp/kp/ks and MFO Categorization</h1>
        </blockquote>

    {{-- KM Class Category --}}
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Key Document Product/ Key Product/ Key Service - Major Final Output Category</h3>
            <div class="card-tools">
                <a href="#createKdpkpksMfoModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
                Create Kdp/kp/ks - MFO Category</a>
            </div>
        </div>
      <div class="card-body">
        @livewire('components.flash-messages', ["parent_id" => "kmc"])
        @livewire('kmc-table')
      </div>
    </div>
    <div class="modal fade" id="createKdpkpksMfoModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/field-dependency/data-entry/categorized-kdpkpks-mfo" method="POST" >
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Kdp/kp/ks - MFO Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="input-label" for="target_sector">Kdp/Kp/Ks</label><br>
                        <select name="kdpkpks_id" class="select2 form-control" for="target_sector" id="kdpkpks_id" required>
                            <option value="">Select Kdp/Kp/Ks</option>
                            @foreach ($kdpkpks_data as $el)
                                <option value="{{$el->id}}">{{$el->desc}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="target_sector">MFO</label><br>
                        <select name="mfo_id" class="select2 form-control" for="target_sector" id="mfo_id" required>
                            <option value="">Select MFO</option>
                            @foreach ($mfo_data as $el)
                                <option value="{{$el->id}}">{{$el->desc}}</option>
                            @endforeach
                        </select>
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


Livewire.on('onDeleteFcAcItem', async ({key}) => {
    if(key){
        try {
            await $.ajax({
                type:'DELETE',
                url: window.location.origin+"/field-dependency/data-entry/categorized-account/"+key,
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

Livewire.on('onDeleteCoaFCCItem', async ({key}) => {
    if(key){
        try {
            await $.ajax({
                type:'DELETE',
                url: window.location.origin+"/field-dependency/data-entry/categorized-fcc-coa/"+key,
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


Livewire.on('onDeleteKdpkpksMfoItem', async ({key}) => {
    if(key){
        try {
            await $.ajax({
                type:'DELETE',
                url: window.location.origin+"/field-dependency/data-entry/categorized-kdpkpks-mfo/"+key,
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
        $("#li_categorized").addClass('active');
    </script>
    @endsection
</x-app-layout>
