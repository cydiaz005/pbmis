<form action="{{ url('onboard3/'.Auth::user()->id) }}" method="POST"> 
    @csrf
    @method('PUT')
    <div class="row custrow">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="firstname" class="form-control form-input" placeholder="First Name" value="{{Auth::user()->firstname}}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="middlename" class="form-control form-input" placeholder="Middle Name" value="{{Auth::user()->middlename}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="lastname" class="form-control form-input" placeholder="Last Name" value="{{Auth::user()->lastname}}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="ext" class="form-control form-input" placeholder="Suffix" value="{{Auth::user()->ext}}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <select class="form-control form-input" name="gender">
                    
                    <option>Gender</option>
                    <option value="Male" @if(Auth::user()->gender == 'Male') selected @endif>Male</option>
                    <option value="Female" @if(Auth::user()->gender == 'Female') selected @endif>Female</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <input type="email" class="form-control form-input" placeholder="Email" value="{{Auth::user()->email}}" required readonly>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <select class="form-control form-input" name="divsec_id" required>
                    <option value="" hidden>Division/Section</option>
                    @foreach(\App\Models\DivisionSection::all() as $divsec)
                        <option value="{{$divsec->id}}" @if(Auth::user()->divsec_id == $divsec->id) selected @endif>{{$divsec->name}} ({{$divsec->accronym}})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <select class="form-control form-input" name="pos_id" required>
                    <option value="" hidden>Position</option>
                    @foreach(\App\Models\Position::all() as $pos)
                        <option value="{{$pos->id}}" @if(Auth::user()->pos_id == $pos->id) selected @endif>{{$pos->job_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <select class="form-control form-input" name="serreg_id" required>
                    <option value="" hidden>Service/Region</option>
                    @foreach(\App\Models\ServiceRegion::all() as $serreg)
                        <option value="{{$serreg->id}}" @if(Auth::user()->serreg_id == $serreg->id) selected @endif>{{$serreg->service_region}} ({{$serreg->accronym}})</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <a style="margin-top: 35px; width: 150px;float: left;" type="button" href="/onboarding2" class="btn btn-outline-secondary">Prev</a>
    <button type="submit" style="margin-top: 35px; width: 150px;float: right;" class="btn btn-primary">Save</button>
</form>
 
