<div class="row custrow">
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" name="firstname" class="form-control form-input" placeholder="First Name" value="{{Auth::user()->firstname}}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" name="middlename" class="form-control form-input" placeholder="Middle Name" value="{{Auth::user()->middlename}}" >
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
            <select class="form-control form-input" name="gender" required>
                <option>Gender</option>
                <option value="Male" >Male</option>
                <option value="Female" >Female</option>
            </select>
        </div>
    </div>
    
    
    <div class="col-md-12">
        <div class="form-group">
            <select class="form-control form-input" name="divsec_id">
                <option value="">Division/Section</option>
                @foreach(\App\Models\DivisionSection::all() as $divsec)
                    <option value="{{$divsec->id}}" >{{$divsec->name}} ({{$divsec->accronym}})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <select class="form-control form-input" name="pos_id">
                <option value="">Position</option>
                @foreach(\App\Models\Position::all() as $pos)
                    <option value="{{$pos->id}}">{{$pos->job_title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <select class="form-control form-input" name="serreg_id">
                <option value="">Service/Region</option>
                @foreach(\App\Models\ServiceRegion::all() as $serreg)
                    <option value="{{$serreg->id}}" >{{$serreg->service_region}} ({{$serreg->accronym}})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input name="email" type="email" class="form-control form-input" placeholder="Email"  required >
        </div>
        
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input name="password" type="password" class="form-control form-input" placeholder="Password"  required >
        </div>
        <div class="form-group d-flex flex-row ">
            <button onclick="generatePassword()" type="button" class="btn btn-sm btn-secondary mr-2">Generate</button>
            <button id="showButton" onclick="showPassword()" type="button" class="btn btn-sm btn-secondary mr-2">Show Password</button>
            <button onclick="copyPassword()" type="button" class="btn btn-sm btn-secondary">Copy</button>
         </div>
    </div>
 
</div>
</form>


<script>

    function generatePassword(){
        var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var passwordLength = 12;
        var password = "";
        for (var i = 0; i <= passwordLength; i++) {
            var randomNumber = Math.floor(Math.random() * chars.length);
            password += chars.substring(randomNumber, randomNumber +1);
        }
        document.getElementsByName("password")[0].value = password;
    }

    function showPassword(){
        const showButton = document.getElementById('showButton');
        const passwordInput = document.getElementsByName("password")[0];
        if(passwordInput.type==='text'){
            passwordInput.type="password"
            showButton.innerHTML = 'Show Password'
        }
        else{
            passwordInput.type='text';
            showButton.innerHTML = 'Hide Password'
        }

    }

    function copyPassword() {
        var copyText = document.getElementsByName("password")[0];
        copyText.select();
        document.execCommand("copy");  
    }


</script>
