 <div id="file-mngr-filter">
  <div class="row">
      <div class="col-12">
          <div class="form-group">
              <input id="filter-search" wire:model="filter.search" wire:keydown="getForms" type="search" class="form-control form-control-lg form-input" placeholder="Search ...">
          </div>
      </div>
  </div>
  <div class="row ">
      <div class="col">
          <div class="form-group">
            <select wire:model="filter.stage" wire:change="getFilter" id="filter-stage" class="form-control form-input">
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
            <select wire:model="filter.region" wire:change="getForms" id="filter-serreg" class="form-control form-input">
              <option disabled>Select Service/Region</option>
              <option selected value="*">All Offices</option>
              <option value="co">Central Office</option>
              <option value="ro">Regional Office</option>            
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
            <select wire:model="filter.month" wire:change="getForms" id="filter-serreg" class="form-control form-input">
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
            <select wire:model="filter.year" wire:change="getForms" id="filter-year" class="form-control form-input">
              <option disabled>Select Year</option>
              <option value="">All Year</option>
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
<div class="card card-default">
        <div class="card-body">
            <div class="row" style="padding: 0 10px;">
                <div class="col-md-12">
                    @foreach ($lists as $list)
                    @livewire('partials.file-cards', [
                        'params' => [
                            "icon" => 'budget',
                            "origin" => @$list->serviceRegion->accronym,
                            "title" => "Budget Form Funded 2022",
                            "category" => "MOOE-CDE",
                            "return_reason" => null,
                            "date" =>  $list->created_at,
                            "amount" => number_format($list->total, 2),
                            "last_editor" =>  "Gabriel Arellano",
                            "updated_at" =>  "2022-03-28 03:41:53",
                            'options' => [
                                'view_url' => '/reports/budget/funded/get/'.date("Y", strtotime($list->created_at)).'/'.$list->service_region_id,
                                'edit_url' => null,
                                'delete_url' => null,
                                'publish_url' => null,
                                'lock_enabled' => false,
                                'resolve_enabled' => false,
                                'download_enabled' => false,
                            ],
                        ],
                    ])
                    @endforeach
                </div>
            </div>
            @livewire('file-manager.footer')
        </div>
        <!-- /.card -->
    </div>
