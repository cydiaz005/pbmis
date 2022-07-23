<div>

    <div class="row">
        <div class="col-2">
            

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Office</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <div class="form-group">
                    @foreach($service_regions as $sr)
                        <div class="form-check">
                        <input class="form-check-input sr-filter" type="checkbox" value="{{$sr->accronym}}" checked>
                        <label class="form-check-label">{{$sr->accronym}}</label>
                        </div>
                    @endforeach
                    </div>
              </div>
              <!-- /.card-body -->
            </div>

        </div>
        <div class="col-10">
            {{--print_r($data_entry['ro'])--}}
            <div class="card">
                <div class="card-body table-sticky-wrapper p-0 wfl-form">
                    @php $cat_column = [] @endphp
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="sticky-col office-column" rowspan="2">
                                Office
                            </th>
                            @foreach($categories as $category)    
                            <th colspan="{{count($category->fundChargeabilityClass)}}">{{$category->accronym}}</th>
                            @endforeach
                            <th class="sticky-col total-column" rowspan="2">Total</th>
                        </tr>
                        <tr>
                            @foreach($categories as $category)    
                                @foreach($category->fundChargeabilityClass as $class)
                                <th>{{$class->fundChargeability->accronym}}</th>
                                @php array_push($cat_column, $category->accronym."-".$class->fundChargeability->accronym) @endphp
                                @endforeach   
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="sticky-col office-column fiscal-header">Regional Office</td>
                            <td class="fiscal-header" colspan="{{count($cat_column)}}"></td>
                            <td class="sticky-col total-column fiscal-header"></td>
                        </tr>
                  
                        {{--print_r()--}}
                        @foreach(array_keys($data_entry['ro']) as $regional_key)
                        <tr class="{{$regional_key}}">
                            <td class="sticky-col office-column">{{$regional_key}}</td>
                            @foreach(array_keys($data_entry['ro'][$regional_key]) as $category_key)
                            
                            @if ($loop->last)
                            <td class="sticky-col total-column"><input type="number" readonly/></td>
                            @else
                            <td>
                                <input 
                                type="text" 
                                class="ro_{{$regional_key}}_{{$category_key}}"
                                wire:model="data_entry.ro.ROI.ROI-CO-GASS">
                            </td>
                            @endif
                            @endforeach
                        </tr>
                        @endforeach

                        <tr>
                            <td class="sticky-col office-column fiscal-header">RO's Total</td>
                            <td class="fiscal-header" colspan="{{count($cat_column)}}"></td>
                            <td class="sticky-col total-column fiscal-header"></td>
                        </tr>
                        <tr>
                            <td class="sticky-col office-column fiscal-header">Central Office</td>
                            <td class="fiscal-header" colspan="{{count($cat_column)}}"></td>
                            <td class="sticky-col total-column fiscal-header"></td>
                        </tr>

                        @foreach(array_keys($data_entry['co']) as $central_key)
                        <tr class="{{$central_key}}">
                            <td class="sticky-col office-column">{{$central_key}}</td>
                            @foreach(array_keys($data_entry['co'][$central_key]) as $category_key)
                            
                            @if ($loop->last)
                            <td class="sticky-col total-column"><input type="number" readonly/></td>
                            @else

                            <td>
                                <input type="number"/>
                            </td>
                            @endif
                            @endforeach
                        </tr>
                        @endforeach

                        <tr>
                            <td class="sticky-col office-column fiscal-header">CO's Total</td>
                            <td class="fiscal-header" colspan="{{count($cat_column)}}"></td>
                            <td class="sticky-col total-column fiscal-header"></td>
                        </tr>
                        <tr>
                            <td class="sticky-col office-column fiscal-header">Grand Total</td>
                            <td class="fiscal-header" colspan="{{count($cat_column)}}"></td>
                            <td class="sticky-col total-column fiscal-header"></td>
                        </tr>
                        
                    </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
