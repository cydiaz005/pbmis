<div class="card frmcard">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="row align-items-center">
                    <div class="col-md-2 frmcardivimg">
                        @if (@$params['icon'] == 'poe') <img class="frmcard_img" src="{{ asset('/images/poeicon.png') }}"> @endif
                        @if (@$params['icon'] == 'ppmp') <img class="frmcard_img" src="{{ asset('/images/ppmpicon.png') }}"> @endif
                        @if (@$params['icon'] == 'opc') <img class="frmcard_img" src="{{ asset('/images/opcicon.png') }}"> @endif
                        @if (@$params['icon'] == 'fiscal') <img class="frmcard_img" src="{{ asset('/images/fiscalicon.png') }}"> @endif
                        @if (@$params['icon'] == 'budget') <img class="frmcard_img" src="{{ asset('/images/budgeticon.png') }}"> @endif
                    </div>
                    <div class="col-md-10 frmcardivname">
                        <p class="frmcard_service">
                            @if(@$params['origin']) Service/Region: @endif
                            <span class="text-uppercase"> {{ @$params['origin'] }} </span>
                        </p>
                        <h4 class="frmcard_title text-truncate">  {{ @$params['title'] }} </h4>
                        <p class="frmcard_amount">{{ @$params['amount'] }}</p>
                        <p class="frmcard_author">{{ @$params['category'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row align-items-center">
                    <div class="col-md-7 text-right">
                        @if(@$params['updated_at']) 
                            <p class="frmcard_date"><i class="fas fa-pencil-alt"></i>&nbsp;
                            {{ \Carbon\Carbon::parse(@$params['updated_at'])->diffForHumans() }} 
                            </p>
                        @endif
                        <p class="frmcard_edited text-truncate"> {{ @$params['last_editor'] }} </p>
                    </div>
                    <div class="col-md-5 text-right">
                        @if(@$params['date']) 
                        <h4 class="frmcard_date">Date Created:</h4>
                        {{ \Carbon\Carbon::parse(@$params['date'])->format('d/m/Y') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="frmcard_btns">
        <a href="#" type="button" class="btn btn-sm btn-primary"><i class="fas fa-download"></i>&nbsp;
            Download Report</a> &nbsp;
        {{@$params['options']['view_url']}}
        @if(@$params['options']['view_url'])  
        <a href="{{@$params['options']['view_url']}}" type="button" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
        @endif
    </div>
</div>