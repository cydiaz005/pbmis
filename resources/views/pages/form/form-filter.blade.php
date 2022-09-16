<div id="file-mngr-filter" >
    @if(@in_array("search", @$filters))
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <input id="filter-search" type="search" class="form-control form-control-lg form-input" placeholder="Search ...">
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        @if(@in_array("stage", @$filters))
        <div class="col">
            <div class="form-group">
                <select id="filter-stage" class="form-control form-input">
                    @foreach (\App\Models\Stage::all() as $stage)
                        <option {{$stage->active ? "selected":""}} value="{{$stage->id}}">[ {{$stage->accronym}} ] {{$stage->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        @if(@in_array("region", @$filters))
        <div class="col">
            <div class="form-group">
                <select id="filter-serreg" class="form-control form-input">
                    <option selected value="*">All Offices</option>
                    @foreach (\App\Models\ServiceRegion::all() as $region)
                        {{-- <option value="{{$region->id}}">{{$region->service_region}}</option> --}}
                        <option {{Auth::user()->serreg_id == $region->id ? "selected":""}} value="{{$region->id}}">{{$region->service_region}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        @if(@in_array("month", @$filters))
        <div class="col">
            <div class="form-group">
              <select id="filter-month" class="form-control form-input">
                <option selected value="*">All Months</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>            
              </select>
            </div>
        </div>
        @endif
        @if(@in_array("semester", @$filters))
        <div class="col">
            <div class="form-group">
              <select id="filter-semester" class="form-control form-input">
                <option selected value="*">All Semester</option>
                <option value="1">1st Semester</option>
                <option value="2">2nd Semester</option>        
              </select>
            </div>
        </div>
        @endif
        @if(@in_array("year", @$filters))
        <div class="col">
            <div class="form-group">
              <select id="filter-year" class="form-control form-input">
                  {{-- @for($i = 2022; $i <= \Carbon\Carbon::now()->format('Y'); $i++)
                        <option {{$i == \Carbon\Carbon::now()->format('Y') ? "selected":""}} value="{{$i}}">{{$i}}</option>
                  @endfor --}}
                  @for($i = 2022; $i <= \Carbon\Carbon::now()->format('Y') + 3; $i++)
                        <option {{$i == \Carbon\Carbon::now()->format('Y') ? "selected":""}} value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>
        </div>
        @endif
    </div>
</div>