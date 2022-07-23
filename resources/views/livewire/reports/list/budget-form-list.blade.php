<div>
@if(!count(@$lists)) 
    No Report found.
@endif
@foreach (@$lists as $list)
    <div class="card frmcard">
        <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
            <div class="row align-items-center">
                <div class="col-md-2 frmcardivimg">
                <img class="frmcard_img" src="http://localhost:8000/images/budgeticon.png">
                </div>
                <div class="col-md-10 frmcardivname">
                <p class="frmcard_service"> Service/Region: 
                    <span class="text-uppercase"> {{@$list->serviceRegion->accronym }}</span>
                </p>
                <h4 class="frmcard_title text-truncate"> Budget Form Funded 2022 </h4>
                <p class="frmcard_amount">{{ 'PHP '.number_format($list->total, 2) }}</p>
                </div>
            </div>
            </div>
            <div class="col-md-4">
            <div class="row align-items-center">
                <div class="col-md-7 text-right">
                    <!-- <p class="frmcard_date">
                        <i class="fas fa-pencil-alt"></i>&nbsp; 3 days ago
                    </p>
                    <p class="frmcard_edited text-truncate"> Gabriel Arellano </p> -->
                </div>
                <div class="col-md-5 text-right">
                <h4 class="frmcard_date">Date Created:</h4>
                {{ \Carbon\Carbon::parse(@$list->updated_at)->format('d/m/Y') }}
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="frmcard_btns">
        <a href="#" type="button" class="btn btn-sm btn-primary">
            <i class="fas fa-download"></i>&nbsp; Download Report </a> &nbsp;
            <a href="/reports/budget/unfunded/get/{{@$params['stage']}}/{{@$params['year']}}/{{@$list->serviceRegion->id}}" type="button" class="btn btn-sm btn-primary">
            <i class="fas fa-eye"></i>
            /reports/budget/unfunded/get/{{@$params['stage']}}/{{@$params['year']}}/{{@$list->serviceRegion->id}}
        </a>
        </div>
    </div>
@endforeach
</div>
