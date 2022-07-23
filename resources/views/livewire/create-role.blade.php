
<form>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Create Role</h3>
            <div class="card-tools">
                <a href="#" type="button" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;
                Save</a> &nbsp;
                <a href="#" type="button" class="btn btn-outline-primary">
                Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Details -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control form-input" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea row="2" class="form-control form-input" placeholder="Description" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Permission Type</label>
                                <select id="selpermission" class="form-control form-input">
                                    <option value="All">All</option>
                                    <option value="Custom" selected>Custom</option>
                                </select>
                            </div>
                            <div id="pertreeview" class="form-group">
                                <ul id="bs_main" class="main_ul">
                                    <li class="mainlevel">
                                        <span class="plus">&nbsp;</span>
                                        <input type="checkbox"/>
                                        <span><strong>Main Level 1</strong></span>
                                        <ul id="bs_l_1" style="display: none">
                                            <li>
                                                <input type="checkbox" id="c_bf_1" />
                                                <span>Sub Level 1 </span>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="c_bf_2" />
                                                <span>Sub Level 2</span>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="mainlevel">
                                        <span class="plus">&nbsp;</span>
                                        <input type="checkbox"/>
                                        <span><strong>Main Level 2 </strong></span>
                                        <ul id="bs_l_2" style="display: none" class="sub_ul">
                                            <li>
                                                <span class="plus">&nbsp;</span>
                                                <input type="checkbox" id="c_bf_3" />
                                                <span>Sub Level 3 </span>
                                                <ul id="bf_l_3" style="display: none" class="inner_ul">
                                                    <li id="io_9">
                                                        <input type="checkbox" id="c_io_9" /><span>Last Level 9 </span></li>
                                                    <li id="io_10">
                                                        <input type="checkbox" id="c_io_10" /><span>Last Level 10 </span></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <span class="plus">&nbsp;</span>
                                                <input type="checkbox" id="c_bf_4" />
                                                <span>Sub Level 4 </span>
                                                <ul id="bf_l_4" style="display: none" class="inner_ul">
                                                    <li id="io_13">
                                                        <input type="checkbox" id="c_io_13" /><span>Last Level 13 </span></li>
                                                    <li id="io_14">
                                                        <input type="checkbox" id="c_io_14" /><span>Last Level 14 </span></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="mainlevel">
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
        <div class="card-footer">
            <div class="card-tools">
                <a href="#" type="button" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;
                Save</a> &nbsp;
                <a href="/roles" type="button" class="btn btn-outline-primary">
                Back</a>
            </div>
        </div>
    </div>
</form>
