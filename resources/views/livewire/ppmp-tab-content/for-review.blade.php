@livewire('file-manager.header')

<div class="row" style="padding: 0 10px;">
    <div class="col-md-12">
        <!-- list -->
        @for ($i = 1; $i <= 5; $i++)
        <div class="card frmcard">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="row align-items-center">
                            <div class="col-md-2 frmcardivimg">
                                <img class="frmcard_img" src="{{ asset('images/ppmpicon.png') }}">
                            </div>
                            <div class="col-md-10 frmcardivname">
                                <p class="frmcard_service">Service/Region: <span class="text-uppercase">Region I</span></p>
                                <h4 class="frmcard_title text-truncate">PPMP Title here</h4>
                                <p class="frmcard_author">MOOE - GAS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row align-items-center">
                            <div class="col-md-7 text-right">
                                <p class="frmcard_date"><i class="fas fa-pencil-alt"></i>&nbsp;
                                6mins ago</p>
                                <p class="frmcard_edited text-truncate">juan dela cruz</p>
                            </div>
                            <div class="col-md-5 text-right">
                                <h4 class="frmcard_date">Date Created:</h4>
                                <p class="frmcard_date">12/12/2021</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="frmcard_btns">
                <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmApprove">
                    <i class="fas fa-check"></i>&nbsp; Approve</a> &nbsp;
                <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmEdit">
                    <i class="fas fa-edit"></i></a> &nbsp;
                <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmDelete">
                    <i class="fas fa-trash"></i></a>
            </div>
        </div>
        @endfor
    </div>
</div>

@livewire('file-manager.footer')