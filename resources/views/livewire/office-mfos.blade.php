<div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">
                {{$office->name}}
                <br>
                <small>
                    <i>Created at {{$office->created_at}} </i>
                </small>
                <br>
                <small>
                    <i>
                    </i>
                </small>
            </h3>
            <div class="card-tools">
            <button  type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
          
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="pertreeview" class="form-group">
                                <ul id="bs_main" class="main_ul">
                                    <li class="mainlevel">
                                        <span class="plus">&nbsp;</span>
                                        <ul id="bs_l_2" style="display: none" class="sub_ul">
                                            @foreach ($mfos as $mfo)
                                                <li 
                                                style="padding-left: 21px;">
                                                    <!-- <span class="plus">&nbsp;</span> -->
                                                    <input 
                                                    class="specific-permission" type="checkbox"

                                                    value="{{$mfo->id}}"
                                                   
                                                    @if($activeMfos->where('id', $mfo->id)->count() === 1)
                                                        checked
                                                    @endif
                                                    />
                                                    <span>{{$mfo->desc}}
                                                </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Details -->
                </div>
                <!-- Details -->
            </div>


        </div>
        <!-- /.card-body -->
    </div>
</div>
<script>
      
</script>


