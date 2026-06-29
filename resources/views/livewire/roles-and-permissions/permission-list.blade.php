<div>
    <div class="card card-outline card-primary collapsed-card">
        <div class="card-header">
            <h3 class="card-title">
                <!-- {{ var_dump($role) }} -->
                {{ $role->name }} <br>
                <small>
                    <i>Created at {{ $role->created_at }}</i>
                </small>
            </h3>

            <div class="card-tools">
            @if($role->id>6)
                <button onclick="onDeleteRole('<?php echo $role->id ?>')" type="button" class="btn btn-tool" >
                    <i class="fas text-danger fa-trash"></i>
                </button>
            @endif
            <button  type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
            </button>
          
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="pertreeview" class="form-group">
                                <ul id="bs_main" class="main_ul">
                                    <!-- <li class="mainlevel">
                                        <span class="plus">&nbsp;</span>
                                        <input type="checkbox"/>
                                        <span><strong>Main Level 1</strong></span>
                                        <ul id="bs_l_1" style="display: none">
                                            <li>

                                                <span>Sub L                                                <input type="checkbox" id="c_bf_1" />evel 1 </span>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="c_bf_2" />
                                                <span>Sub Level 2</span>
                                            </li>
                                        </ul>
                                    </li> -->
                                    <li class="mainlevel">
                                        <span class="plus">&nbsp;</span>
                                        <input role="<?php echo $role['id']?>" class="select-all-permission"  type="checkbox"/>
                                        <span><strong>SELECT ALL</strong></span>
                                        <ul id="bs_l_2" style="display: none" class="sub_ul">
                                            @foreach ($permissions as $permission)

                                                @if(array_key_exists("subs", $permission))
                                                @php
                                                    $permissionTag = str_replace(' ', '', @$permission['label'].$role['id']);
                                                    $isBatchChecked = false; 
                                                @endphp
                                                <li>
                                                    <span class="plus">&nbsp;</span>
                                                        <input withKey="true" role="<?php echo $role['id']?>" name="<?php echo $permissionTag?>" class="batch-permission" type="checkbox" value="{{@$permission['key']}}" 
                                                            @foreach (@$active as $current)
                                                                @if(@$current->name == @$permission['key'])
                                                                    checked
                                                                @endif
                                                                @if(@$current->name == @$permission['key'])
                                                                    def_value="true"
                                                                    @php
                                                                        $isBatchChecked = true;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        />
                                                        <span>{{ $permission['label'] }}</span>

                                                    <ul style="display: none" class="inner_ul">
                                                        @foreach ($permission['subs'] as $sub)
                                                            <li>
                                                                <input isBatchChecked="{{$isBatchChecked}}" withKey="true" role="<?php echo $role['id']?>" class="<?php echo $permissionTag ?> specific-permission"  type="checkbox" value="{{@$sub['key']}}" 
                                                                @foreach (@$active as $current)
                                                                    @if(@$current->name == @$sub['key'])
                                                                        checked 
                                                                    @endif
                                                                    @if(@$current->name == @$sub['key'])
                                                                        def_value="true"
                                                                    @endif
                                                                    
                                                                @endforeach
                                                                @if(!$isBatchChecked)
                                                                        disabled
                                                                @endif
                                                              
                                                                /><span>{{ $sub['label'] }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @else
                                                <li style="padding-left: 21px;">
                                                    <!-- <span class="plus">&nbsp;</span> -->
                                                 
                                                    <input isBatchChecked="false"  withKey="true" role="<?php echo $role['id']?>"  class="specific-permission"  type="checkbox" value="{{@$permission['key']}}"
                                                        @foreach (@$active as $current)
                                                            @if(@$current->name == @$permission['key'])
                                                                checked
                                                            @endif
                                                            @if(@$current->name == @$permission['key'])
                                                                def_value="true"
                                                            @endif
                                                            @if(@$current->name == @$permission['key'])
                                                                isBatchChecked="true"
                                                            @endif
                                                        @endforeach
                                                    />
                                                    <span>{{ $permission['label'] }}</span>
                                                </li>
                                                @endif

                                            @endforeach
                                        </ul>
                                    </li>
                                    <!-- <li class="mainlevel">
                                        <span class="plus">&nbsp;</span>
                                        <input type="checkbox"/>
                                        <span><strong>Main Level 3</strong></span>
                                        <ul id="bs_l_3" style="display: none" class="sub_ul">
                                            <li>
                                                <span class="plus">&nbsp;</span>
                                                <input type="checkbox" id="c_bf_5" />
                                                <span>Sub Level 5 </span>
                                                <ul id="bf_l_5" style="display: none" class="inner_ul">
                                                    <li id="io_11">
                                                        <input type="checkbox" id="c_io_11" /><span>Last Level 9 </span></li>
                                                    <li id="io_12">
                                                        <input type="checkbox" id="c_io_12" /><span>Last Level 10 </span></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <span class="plus">&nbsp;</span>
                                                <input type="checkbox" id="c_bf_6" />
                                                <span>Sub Level 4 </span>
                                                <ul id="bf_l_6" style="display: none" class="inner_ul">
                                                    <li id="io_15">
                                                        <input type="checkbox" id="c_io_13" /><span>Last Level 13 </span></li>
                                                    <li id="io_16">
                                                        <input type="checkbox" id="c_io_14" /><span>Last Level 14 </span></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li> -->
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
async function onDeleteRole (id){
   await $.ajax({
        type:'DELETE',
        url: window.location.origin+"/data-guard/roles-permissions/roles/"+id,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(response){
            console.log({response});
        }
    });
    location.reload()
}


  
</script>
