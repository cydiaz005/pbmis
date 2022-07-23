<div class="row" style="padding: 0 10px;">
    <div class="col-md-6">
        <!-- budget form -->
        @livewire('file-manager.sort-search')
        <div class="card frmcard budgetselected">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="row align-items-center">
                            <div class="col-md-2 frmcardivimg">
                                <img class="frmcard_img" src="{{ asset('images/budgeticon.png') }}">
                            </div>
                            <div class="col-md-10 frmcardivname">
                                <p class="frmcard_service">Service/Region: <span class="text-uppercase">Region I</span></p>
                                <h4 class="frmcard_title text-truncate">Budget Form (Unfunded) 2022</h4>
                                <p class="frmcard_author">MOOE - GAS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @livewire('file-manager.footer') --}}
    </div>
    <!-- pap -->
    <div class="col-md-6" style="padding-left: 30px;">
        <div class="card card-default bdugetpapfrmheight">
            <div class="card-body" style="padding: 20px;">
                <p style="margin-bottom: 30px;font-size: 18px;">
                    <strong>Budget Form (Unfunded) 2022</strong>
                </p>
                <div id="unfunded-forms">
                    <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                </div>     
            </div>
        </div>
    </div>
    
</div>