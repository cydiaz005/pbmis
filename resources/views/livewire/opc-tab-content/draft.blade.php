@livewire('file-manager.header')

<div class="row" style="padding: 0 10px;">
    <div class="col-md-12">
        <!-- list -->

        @foreach ($opcs as $opc)
        <div class="card frmcard">
            @if($opc->status_id==1)
            <span class="badge badge-primary badge_draft">Draft</span>
            @elseif($opc->status_id==2)
            <span class="badge badge-primary badge_published">Published</span>
            @elseif($opc->status_id==3)
            <span class="badge badge-primary badge_draft">For Review</span>
            @elseif($opc->status_id==4)
            <span class="badge badge-primary badge_returned">Returned</span>
            @elseif($opc->status_id==5)
            <span class="badge badge-primary badge_resolved">Resolved</span>
            @endif

            @if($opc->locked==1)
                <img class="frmlocked" src="{{ asset('images/lock.png') }}">
            @endif

            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="row align-items-center">
                            <div class="col-md-2 frmcardivimg">
                                <img class="frmcard_img" src="{{ asset('images/opcicon.png') }}">
                            </div>
                            <div class="col-md-10 frmcardivname">
                                <p class="frmcard_service">Service/Region: <span class="text-uppercase">{{$opc->serviceRegion->service_region}}</span></p>
                                <h4 class="frmcard_title text-truncate">OPC/OPS Form</h4>
                                <p class="frmcard_author">{{$opc->semester==1?'1st':'2nd'}} Semester ({{$opc->year}})</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row align-items-center">
                            <div class="col-md-7 text-right">
                                {{-- <p class="frmcard_date"><i class="fas fa-pencil-alt"></i>&nbsp;
                                6mins ago</p> --}}
                                <p class="frmcard_edited text-truncate">{{$opc->creator->firstname}} {{$opc->creator->lastname}}</p>
                            </div>
                            <div class="col-md-5 text-right">
                                <h4 class="frmcard_date">Date Created:</h4>
                                <p class="frmcard_date">{{$opc->created_at}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="frmcard_btns">
                @if($opc->locked==1&&$opc->locker_user_id==auth()->user()->id)
                <a  onclick="onUnlock({{$opc->id}})" href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmUnlock">
                    <i class="fas fa-lock"></i>&nbsp; Unlock Form</a> &nbsp;
                @endif

                @if($opc->status_id==3)
                <a onclick="onPublish({{$opc->id}})" href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmPublish">
                    <i class="fas fa-check"></i>&nbsp; Publish</a> &nbsp;
                <a onclick="onReturn({{$opc->id}})" href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmReturn">
                        <i class="fas fa-check"></i>&nbsp; Return</a> &nbsp;
                @endif

                @if($opc->status_id==1||$opc->status_id==4)
                <a onclick="onSubmit({{$opc->id}})" href="#" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmSubmit">
                    <i class="fas fa-check"></i>&nbsp; Submit</a> &nbsp;
                @endif
               
                <a href="/form/opc/{{$opc->id}}" type="button" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i>&nbsp; View Form</a> &nbsp;
                <a onclick="onEdit({{$opc->id}})" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmEdit">
                    <i class="fas fa-edit"></i></a> &nbsp;
                <a onclick="onDelete({{$opc->id}})" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmDelete">
                    <i class="fas fa-trash"></i></a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@livewire('file-manager.footer')