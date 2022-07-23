<x-app-layout>
    @section('style')
    <link href="{{asset("sweetalert2/sweetalert2.css")}}"/>
    <link href="{{asset("sweetalert2/sweetalert2.min.css")}}"/>
@endsection

    @section('content')

@livewire('partials.content-header', [
'pageTitle' => 'Sent',
'breadcrumb' => [
    ['name' => 'Home', 'route' => '/dashboard/admin'],
    ['name' => 'Mail', 'route' => '#'],
    ['name' => 'Sent', 'route' => '#'],
]
])
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
                @include('pages.mail.mail-navs')
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Sent</h3>

                            <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-input" placeholder="Search Mail" id="search-input">
                                <div class="input-group-append" style="padding-top:4px;">
                                <div class="btn btn-primary"  id="search_query">
                                    <i class="fas fa-search"></i>
                                </div>
                                </div>
                            </div>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle" id="checkAll">
                                <i class="far fa-square" id="fas-check"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" id="delete-email">
                                <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm" id="reload">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <!-- /.float-right -->
                            </div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody id="sentbox-container">
                                    </tbody>
                                </table>
                            <!-- /.table -->
                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer p-0">
                            <div class="mailbox-controls">
                                <div class="text-center"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>


            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    @endsection
    @section('script')

    <script src="{{asset('js/mail/mail.js')}}"></script>
    <script src="{{asset('sweetalert2/sweetalert2.all.js')}}"></script>
    <script src="{{asset('sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script>
        const token = `{{ csrf_token() }}`;
        const header= 'X-CSRF-TOKEN';

         let mail = new Mail('sent',{
            url: '/mail/get/sent',
            container: '#sentbox-container', 
            query:$("#search-input").val()
        });
        
        $("#reload").on("click", (e) => {
            new Mail('sent',{
            url: '/mail/get/sent',
            container: '#sentbox-container', 
            query:$("#search-input").val()
        });
        })
        $("#search_query").on("click", (e) => {
            mail = new  Mail('sent',{
                    url: '/mail/get/sent',
                    container: '#sentbox-container', 
                    query: $("#search-input").val()
            });
        });
        $("#search-input").on("keypress", (e) => {
            mail = new  Mail('sent',{
                    url: '/mail/get/sent',
                    container: '#sentbox-container', 
                    query: e.target.value
            });
        });
        let checkingBox = false;
        $("#checkAll").on("click", (e) => {
            mail.clickAll();
            const checking = document.getElementById("fas-check");
            if(!checkingBox){
                checking.className = "fas fa-check text-warning"
            }else{
                checking.className = "far fa-square"
            }
            checkingBox = !checkingBox
        })
        $("#delete-email").on("click", () => {
            mail.deleted()
                if(Object.keys(mail.deleted()).length < 1){
                    Swal.fire("Warning", "Please Select Atleast One", "warning")
                    return;
                }
                Swal.fire({
                    icon: "warning",
                    title: 'Are You sure?',
                    text: "You wont revert this action!",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Proceed',
                    denyButtonText: `Cancel`,
                    reverseButtons: true
                    }).then(async(result) => {
                    /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                              url: "/mail/trash-sent-data",
                              data: {ids: mail.deleted(), type: "sentbox"},
                              type: "POST",
                              beforeSend: function(xhr){
                                xhr.setRequestHeader('X-CSRF-TOKEN', token)
                                xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest")
                              ;},
                                success: function (result) {
                                    Swal.fire("Successfully", "Successfully Updated", "success")
                                    window.location.reload();
                                    $.ajax({
                                        url: "/mail/recount-mail",
                                        data: {
                                            type: "sender"
                                        },
                                        type: "POST",
                                        beforeSend: function(xhr) {
                                            xhr.setRequestHeader('X-CSRF-TOKEN', token)
                                            xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                                        },
                                        success: function(result) {
                                          
                                           $("#sent-badge").text(result)
                                        }
                                    });
                            }});
                         
                        }
                })
                
        })
        $("#li_mail").addClass('active');

    </script>
    @endsection
</x-app-layout>
{{-- {ids: Object.keys(mail.deleted()).map(key => {
    return  {id:key, type: "sentbox"}
})} --}}