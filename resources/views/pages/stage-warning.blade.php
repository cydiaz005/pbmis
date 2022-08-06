<x-app-layout>
    @section('style')
    <style>
      
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @endsection

    @section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="height: 100vh">
                <div class="card-header p-0" style="background-image: linear-gradient(135deg, #ff9911 27.78%, #000000 27.78%, #000000 50%, #ff9911 50%, #ff9911 77.78%, #000000 77.78%, #000000 100%);background-size: 63.64px 63.64px; min-height: 1.5rem"> 
                    <!-- no content -->
                </div>
                <div class="card-body " style="background-color: #EF1625; position: relative; ">
                    <div class="body-header d-flex align-items-center px-3 pb-3">
                        <p class="text" style="color: #FFF; font-size: 30px; font-weight: 600 ">WARNING</p>
                    </div>
                    <div class="body-content px-2" style=" min-height: 20rem">
                        <div class="container">
                            <img src="{{asset('images/warning-bg.png')}}" alt="" style="position: absolute; width: 400px;top:0 ;right: 195px;opacity: 10%; transform: rotate(338deg);">
                            <p class="text" style="color: #FFF; width: 50rem;">
                                You're about to perform an action that cannot be reversed.
                                When the active stage is changed, this causes all published forms to be re-evaluated as drafts.
                                The remaining unpublished forms are discarded automatically.
                            </p>
                        </div>
                        <div class="col-6 row align-items-center pt-5">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="filter-stage" style="color: #FFF; margin: 0">Select Stage</label>
                                    <select id="filter-stage" class="form-control form-input" style="margin-top: 0">
                                    @foreach($stages as $stage)
                                        <option value="{{$stage->id}}">[{{$stage->accronym}}] {{$stage->name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <button class="btn btn-primary" id="stage-confirm">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- warning modal message -->
        <div class="modal fade" id="stage-warning-confirmation" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="color: #FFF">
                    <div class="modal-body" style="background-color: #EF1625; ">
                        <div class="body-header mb-3">
                            <p class="header-text" style="font-size: 25px; font-weight: 600">Reminder</p>
                        </div>
                        <div class="body-content">
                            <div class="text-container mb-5">
                                <p> By entering your password, you approve the change of active stages in all regional and central offices. </p>
                            </div>
                            <div class="froup-group">
                                <label for="confirm-password">Enter your password to complete action:</label>
                                <input type="password" name="papname" id="confirm-password" class="form-control form-input" autocomplete="off">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: #9d9d9d; border-color: #9d9d9d; color: #FFF; width: 120px; font-weight: 500;">Cancel</button>
                        <button type="button" class="btn btn-primary" id="stage-submit" style="background-color: #EF1625; border-color: #EF1625; width: 120px;">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')

    <script>
    $("#li_stage_warning").addClass('active');
    (function () {
        var filter_stage = $('#filter-stage');
        var stage_confirm = $('#stage-confirm');
        var stage_password = $('#confirm-password');
        var submit = $('#stage-submit');
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        
        stage_confirm.on('click', openModal);
        submit.on('click', changeStage);

        function openModal() {
            $('#stage-warning-confirmation').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            })
        }

        function changeStage() {
            let data = {
                stage : filter_stage.val(),
                password : stage_password.val(),
            }

            if (!data.password) {
                toastr.error('Password is required.')
            }
            else{
                $(".spinner_modal").modal({
                    backdrop: 'static',
                keyboard: false,
                show: true
                })
                $('#stage-warning-confirmation').modal("hide");
                $.ajax({
                    type:'POST',
                    url: window.location.origin+"/manage/stage/set",
                    data: data,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(response){
                        $('#stage-warning-confirmation').modal('hide');
                        $(".spinner_modal").modal("hide")
                        toastr.success("Action has been taken successfully.");
                       
                    },
                    error: function(data){
                        var error = data.responseJSON;
                        $(".spinner_modal").modal("hide")
                        toastr.error(error.message);
                       
                    }
                });
            }
            console.log({data});
        }

        function name(params) {
            
        }


        // 
    })();
    </script>
    @endsection
</x-app-layout>
