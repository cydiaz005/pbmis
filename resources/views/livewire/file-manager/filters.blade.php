<div id="file-mngr-filter">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <input id="filter_search" wire:model="filter_search" type="search" class="form-control form-control-lg form-input" placeholder="Search ...">
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col">
            <div class="form-group">
                <select  id="filter_stage" wire:model="filter_stage" class="form-control form-input">
                <option selected disabled>Select Stage</option>
                <option value="">All stages</option>
                @foreach ($stages as $stage)
                <option 
                    value="{{  $stage->id }}">
                    [ {{  $stage->accronym  }} ]
                    {{  $stage->name  }} 
                </option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <select wire:model="filter_serreg" id="filter_serreg" class="form-control form-input">
                <option disabled>Select Service/Region</option>
                <option selected value="*">All Offices</option>
                <option value="co">Central Office</option>
                <option value="ro">Regional Office</option>            
                @foreach ($service_regions as $service_region)
                    <option value="{{  $service_region->id }}">
                    {{  $service_region->service_region }} 
                    </option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <select wire:model="filter_month" id="filter_month" class="form-control form-input">
                <option disabled selected>Select Month</option>
                <option value="">All Months</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>            
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <select wire:model="filter_year" id="filter_year" class="form-control form-input">
                <option disabled>Select Year</option>
                <option value="">All Year</option>
                <option selected value="{{date('Y')}}">{{date('Y')}}</option>
                </select>
            </div>
        </div>
    </div>
</div>
  