<div id="file-mngr-filter">
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <input id="filter-search" type="search" class="form-control form-control-lg form-input" placeholder="Search ...">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
          <select id="filter-stage" class="form-control form-input" >
            <option selected disabled>Select Stage</option>
            @foreach ($stages as $stage)
            <option 
                @if($stage->active == 1) selected @endif
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
          <select id="filter-serreg" class="form-control form-input">
            <option disabled>Select Service/Region</option>
            <option selected value="*">All Offices</option>
            <option value="*co">Central Office</option>
            <option value="*ro">Regional Office</option>            
            @foreach ($service_regions as $service_region)
                <option 
                    @if($service_region->id == auth()->user()->serreg_id) selected @endif
                    value="{{  $service_region->id }}">
                {{  $service_region->service_region }} 
                </option>
            @endforeach
          </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
          <select id="filter-serreg" class="form-control form-input">
            <option disabled>Select Service/Region</option>
            <option selected value="*">All Months</option>
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
          <select id="filter-year" class="form-control form-input">
              <option disabled>Select Year</option>
              <option selected value="{{date('Y')}}">{{date('Y')}}</option>
          </select>
        </div>
    </div>
    <div class="col d-none">
        <div class="form-group">
            <div class="input-group input-group">
                <button type="button" class="btn btn-default" id="daterange-btn" style>
                    <i class="far fa-calendar-alt"></i> Date range picker
                    <i class="fas fa-caret-down"></i>
                </button>
            </div>
        </div>
    </div>
</div>
</div>
