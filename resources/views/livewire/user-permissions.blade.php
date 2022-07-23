<div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">
                {{$user->firstname}} <br>
                <small>
                    <i>Created at {{$user->created_at}}</i>
                </small>
                <br>
                <small>
                    <i>
                    {{($role[0])}}
                    </i>
                </small>
            </h3>
            <div class="card-tools">
            <button  type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
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
                                        <input userid="<?php echo $user['id']?>" class="select-all-permission"  type="checkbox"/>
                                        <span><strong>SELECT ALL</strong></span>
                                        <ul id="bs_l_2" style="display: none" class="sub_ul">
                                            @foreach ($permissions as $permission)
                                                @if(array_key_exists("subs", $permission))
                                                @php
                                                    $permissionTag = str_replace(' ', '', @$permission['label'].$user['id']);
                                                    $isBatchChecked = false; 
                                                    $isRolePermission = in_array($permission['key'],$permissionsViaRoles)?true:false;

                                                @endphp
                                             
                                                <li>
                                                    <span class="plus">&nbsp;</span>
                                                        <input  userid="<?php echo $user['id']?>" name="<?php echo $permissionTag?>" class="batch-permission <?php echo $isRolePermission?'bg-gray':'' ?> " type="checkbox" value="{{@$permission['key']}}" 
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
                                                                @if($isRolePermission)
                                                                    disabled
                                                                @endif
                                                                @if($isRolePermission)
                                                                    withKey="false"
                                                                @else
                                                                    withKey="true"
                                                                @endif
                                                            @endforeach
                                                        />
                                                        <span> 
                                                            @if($isRolePermission)  
                                                            <del>
                                                            @endif
                                                                {{ $permission['label'] }}
                                                            @if($isRolePermission)  
                                                            <del>
                                                            @endif
                                                        </span>
                                                    <ul style="display: none" class="inner_ul">
                                                        @foreach ($permission['subs'] as $sub)
                                                            @php
                                                                $isRolePermission = in_array($sub['key'],$permissionsViaRoles)?true:false;
                                                            @endphp
                                                            <li>
                                                                <input isBatchChecked="{{$isBatchChecked}}" userid="<?php echo $user['id']?>" class="<?php echo $permissionTag ?> specific-permission <?php echo $isRolePermission?'bg-gray':'' ?>"  type="checkbox" value="{{@$sub['key']}}" 
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
                                                                @if($isRolePermission)
                                                                    disabled
                                                                @endif
                                                                @if($isRolePermission)
                                                                    withKey="false"
                                                                @else
                                                                    withKey="true"
                                                                @endif
                                                              
                                                                />
                                                                <span> 
                                                                    @if($isRolePermission)  
                                                                    <del>
                                                                    @endif
                                                                     {{ $sub['label'] }}
                                                                    @if($isRolePermission)  
                                                                    <del>
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @else
                                                <li style="padding-left: 21px;">
                                                    <!-- <span class="plus">&nbsp;</span> -->

                                                    @php
                                                        $isRolePermission = in_array($permission['key'],$permissionsViaRoles)?true:false;
                                                    @endphp
                                                 
                                                    <input isBatchChecked="false" userid="<?php echo $user['id']?>"  class="specific-permission <?php echo $isRolePermission?'bg-gray':'' ?>"  type="checkbox" value="{{@$permission['key']}}"
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
                                                        @if($isRolePermission)
                                                            disabled
                                                        @endif
                                                        @if($isRolePermission)
                                                            withKey="false"
                                                        @else
                                                            withKey="true"
                                                        @endif
                                                    />
                                                    <span>
                                                    @if($isRolePermission)  
                                                    <del>
                                                    @endif

                                                    {{ $permission['label'] }}
                                                    @if($isRolePermission)  
                                                    <del>
                                                    @endif
                                                </span>
                                                </li>
                                                @endif

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


