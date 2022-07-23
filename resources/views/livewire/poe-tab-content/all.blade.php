@livewire('file-manager.header')
<div class="row" style="padding: 0 10px;">
    <div class="col-md-12">
        <!-- published -->
        <div class="card frmcard">
            <span class="badge badge-primary badge_published">Published</span>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="row align-items-center">
                            <div class="col-md-2 frmcardivimg">
                                <img class="frmcard_img" src="{{ asset('images/poeicon.png') }}">
                            </div>
                            <div class="col-md-10 frmcardivname">
                                <p class="frmcard_service">Service/Region: <span class="text-uppercase">Region I</span></p>
                                <h4 class="frmcard_title text-truncate">PAP Title here</h4>
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
                <a href="#" type="button" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i>&nbsp; View Form</a> &nbsp;
                <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmDelete">
                    <i class="fas fa-trash"></i></a>
            </div>
        </div>
        <!-- draft -->
        <div class="card frmcard">
            <span class="badge badge-primary badge_draft">Draft</span>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="row align-items-center">
                            <div class="col-md-2 frmcardivimg">
                                <img class="frmcard_img" src="{{ asset('images/poeicon.png') }}">
                            </div>
                            <div class="col-md-10 frmcardivname">
                                <p class="frmcard_service">Service/Region: <span class="text-uppercase">Region I</span></p>
                                <h4 class="frmcard_title text-truncate">PAP Title here</h4>
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
                <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmPublish">
                    <i class="fas fa-check"></i>&nbsp; Publish</a> &nbsp;
                <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmEdit">
                    <i class="fas fa-edit"></i></a> &nbsp;
                <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmDelete">
                    <i class="fas fa-trash"></i></a>
            </div>
        </div>
        <!-- returned -->
        <div class="card frmcard">
            <span class="badge badge-primary badge_returned">Returned</span>
            <!-- locked -->
            <img class="frmlocked" src="{{ asset('images/lock.png') }}">
            <!-- /locked -->
            <div class="card-body" data-toggle="collapse" data-target="#returned1">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2 frmcardivimg">
                                <img class="frmcard_img" src="{{ asset('images/poeicon.png') }}">
                            </div>
                            <div class="col-md-10 frmcardivname">
                                <p class="frmcard_service">Service/Region: <span class="text-uppercase">Region I</span></p>
                                <h4 class="frmcard_title text-truncate">PAP Title here</h4>
                                <p class="frmcard_author">MOOE - GAS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-left">
                                <h4 class="frmcard_date">Date Returned:</h4>
                                <p class="frmcard_date">12/12/2021</p>
                            </div>
                            <div class="col-md-8 text-left">
                                <h4 class="frmcard_accreason">Reason of Return:</h4>
                                <p class="frmcard_accreason text-truncate">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium 
                                    doloremque laudantium
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="returned1" class="collapse" data-parent="#accordion">
                <div class="accord_body">
                    <h4 class="frmcard_accrtitle">Reason of Return</h4>
                    <p class="frmcard_accrauthor">
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
                        totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae 
                        dicta sunt explicabo.
                        <br>
                        
                    </p>
                    <div class="row">
                        <div class="col">
                            <p class="frmcard_edited">- <strong>juan dela cruz</strong></p>
                        </div>
                        <div class="col text-right">
                            <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmUnlock">
                                <i class="fas fa-lock"></i>&nbsp; Unlock Form</a> &nbsp;
                            <a href="#" type="button" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i></a> &nbsp;
                            <a href="#" type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#confirmDelete">
                                <i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- resolved -->
        <div class="card frmcard">
            <span class="badge badge-primary badge_resolved">Resolved</span>
            <div class="card-body" data-toggle="collapse" data-target="#resolved3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2 frmcardivimg">
                                <img class="frmcard_img" src="{{ asset('images/poeicon.png') }}">
                            </div>
                            <div class="col-md-10 frmcardivname">
                                <p class="frmcard_service">Service/Region: <span class="text-uppercase">Region I</span></p>
                                <h4 class="frmcard_title text-truncate">PAP Title here</h4>
                                <p class="frmcard_author">MOOE - GAS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-left">
                                <h4 class="frmcard_date">Date Resolved:</h4>
                                <p class="frmcard_date">12/12/2021</p>
                            </div>
                            <div class="col-md-8 text-left">
                                <h4 class="frmcard_accreason">Reason of Return:</h4>
                                <p class="frmcard_accreason text-truncate">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium 
                                    doloremque laudantium
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="resolved3" class="collapse" data-parent="#accordn_resolved">
                <div class="accord_body">
                    <h4 class="frmcard_accrtitle">Reason of Return</h4>
                    <p class="frmcard_accrauthor">
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
                        totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae 
                        dicta sunt explicabo.
                    </p>
                    <div class="row">
                        <div class="col">
                            <p class="frmcard_edited">- <strong>juan dela cruz</strong></p>
                        </div>
                        <div class="col text-right">
                            <a href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmLock">
                                <i class="fas fa-lock"></i>&nbsp; Lock Form</a> &nbsp;
                            <a href="#" type="button" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i></a> &nbsp;
                            <a href="#" type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#confirmDelete">
                                <i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@livewire('file-manager.footer')
