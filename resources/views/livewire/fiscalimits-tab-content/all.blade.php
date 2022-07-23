@livewire('file-manager.header')
<div class="row" style="padding: 0 10px;">
    
    <div class="col-md-12">

       
        @if($fiscal_limit_list)
        @foreach ($fiscal_limit_list as $list)

        <div class="card frmcard">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="row align-items-center">
                            <div class="col-md-2 frmcardivimg">
                                <img class="frmcard_img" src="{{ asset('images/fiscalicon.png') }}">
                            </div>
                            <div class="col-md-10 frmcardivname">
                                <!-- <p class="frmcard_service">Service/Region: <span class="text-uppercase">Region I</span></p> -->
                                <h4 class="frmcard_title text-truncate">Working Fiscal Limit FY-{{ date('Y', strtotime($list->created_at)) }}</h4>
                                <!-- <p class="frmcard_author">MOOE - GAS</p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row align-items-center">
                            <!-- <div class="col-md-7 text-right">
                                <p class="frmcard_date"><i class="fas fa-pencil-alt"></i>&nbsp;
                                6mins ago</p>
                                <p class="frmcard_edited text-truncate">juan dela cruz</p>
                            </div> -->
                            <div class="col-md-5 text-right">
                                <h4 class="frmcard_date">Date Created:</h4>
                                <p class="frmcard_date">{{date('M-d-Y', strtotime($list->created_at));}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="frmcard_btns">
                <!-- <a href="/form/working-fiscal-limit/create" type="button" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye"></i>&nbsp; View Form</a> &nbsp; -->
                <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmEdit">
                    <i class="fas fa-edit"></i>&nbsp; 
                        Edit Fiscal Limit
                </a> &nbsp;
                <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmDelete">
                    <i class="fas fa-trash"></i></a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

@livewire('file-manager.footer')
@section('card-scripts')
<script>    
    let year = "{{ date('Y', strtotime(@$list->created_at)) }}";
    let modal_edit = $('#confirmEdit .btn-pos');
    let modal_delete = $('#confirmDelete');

    modal_edit.on('click', function () {
        let url = window.location.origin + "/form/working-fiscal-limit/create/?fiscal_year="+year;
        location.replace(url);
    })
    $('#btn_create_fiscal').on('click', function () {
        let url = window.location.origin + "/form/working-fiscal-limit/create/?fiscal_year=2022";
        location.replace(url);
    })
    
</script>   
@endsection