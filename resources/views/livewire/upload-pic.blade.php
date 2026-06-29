<form>
    <div>
        <img id="previewImg" class="img_profilegroup" src="{{asset('images/default.png')}}" />       
        <input id="file-input" type="file" name="image" style="display: none" onchange="previewFile(this);" />
        <div class="image-upload" style="height: 0;">
            <label for="file-input">
                <i id="uploadicon" class="fas fa-camera"></i>
            </label>
        </div>
    </div>
    <a style="margin-top: 35px; width: 150px;" type="button" href="/onboarding3" class="btn btn-primary">Continue</a>
</form>
