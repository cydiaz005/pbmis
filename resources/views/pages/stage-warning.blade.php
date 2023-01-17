<x-app-layout>
    @section('style')
    <style>
      
    </style>
    @endsection

    @section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="height: 100vh">
                <div class="card-header p-0" style="background-image: linear-gradient(135deg, #ff9911 27.78%, #000000 27.78%, #000000 50%, #ff9911 50%, #ff9911 77.78%, #000000 77.78%, #000000 100%);background-size: 63.64px 63.64px; min-height: 1.5rem"> 
                    <!-- no content -->
                </div>
                @if (!$changing_stage)
                {{-- <div class="card-body" style="background-color: #1c20ab; position: relative; "> --}}
                <div class="card-body" style="background-color: #EF1625; position: relative; ">
                    <div class="body-header d-flex align-items-center px-3 pb-3">
                        <p class="text" style="color: #FFF; font-size: 30px; font-weight: 600 ">WARNING</p>
                    </div>
                    <div class="body-content px-2" style=" min-height: 20rem">
                        <div class="container">
                            <img src="{{asset('images/warning-bg.png')}}" alt="" style="position: absolute; width: 400px;top:0 ;right: 195px;opacity: 10%; transform: rotate(338deg);">
                            <p class="text" style="color: #FFF;">
                                You're about to perform an action that cannot be reversed.
                                When the active stage is changed, this causes all published forms to be re-evaluated as drafts.
                                The remaining unpublished forms are discarded automatically.
                            </p>
                            <p class="text mt-3" style="color: #FFF;">
                                Affected Fiscal Year: <strong>{{date("Y") + 1}}</strong>
                            </p>
                        </div>
                        <div class="col-12 pt-4">
                            <p class="text" style="color: #FFF;">Are you sure you want to change the stage from <strong>{{$active_stage->name}} ({{$active_stage->accronym}})</strong> to <strong>{{$next_stage->name}} ({{$next_stage->accronym}})</strong>?</p>
                            <button class="btn btn-primary mt-2" id="stage-confirm">Confirm</button>
                        </div>
                    </div>
                </div>
                @else
                <div class="card-body" style="background-color: #1c20ab; position: relative; ">
                    <div class="body-header d-flex align-items-center px-3 pb-3">
                        <p class="text" style="color: #FFF; font-size: 30px; font-weight: 600 ">WARNING</p>
                    </div>
                    <h1 class="px-3 text-light h5">@livewire('jobs.change-stage-percentage')</h1>
                    <div class="body-content px-2" style=" min-height: 20rem">
                        <div class="container">
                            <img src="{{asset('images/warning-bg.png')}}" alt="" style="position: absolute; width: 400px;top:0 ;right: 195px;opacity: 10%; transform: rotate(338deg);">
                            <p class="text" style="color: #FFF; width: 50rem;">
                                Stage is currently changing to <strong>{{$next_stage->name}} ({{$next_stage->accronym}})</strong>
                            </p>
                        </div>
                    </div>
                </div>
                @endif
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
    $("#li_stage").addClass('active');
    @if (!$changing_stage)
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
                        window.location.reload();
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
    @endif

    </script>
    @endsection
</x-app-layout>
