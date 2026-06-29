<form>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="customRadio1" value="Super Admin" name="selrole">
                    <label for="customRadio1" class="custom-control-label">Super Admin</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="customRadio2" value="Regional Admin" name="selrole">
                    <label for="customRadio2" class="custom-control-label">Regional Admin</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="customRadio3" value="User" name="selrole">
                    <label for="customRadio3" class="custom-control-label">User</label>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="selregion">
            <div class="form-group">
                <select class="form-control form-input custom-forminpt">
                    <option>Select Region</option>
                    <option value="Region 1">Region 1</option>
                    <option value="Region 1">Region 2</option>
                </select>
            </div>
        </div>
    </div>
    <a style="margin-top: 35px; width: 150px;" type="button" href="/onboarding5" class="btn btn-primary">
        Save
    </a>
</form>

