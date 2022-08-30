<x-app-layout>
    @section('style')
    <style>
       .text-padding{
        padding-top: 8rem;
        padding-bottom: 8rem;
       }
    </style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => @$breadcrumb,
        'pageTitle' => @$page_title,
    ])
   
    <div class="card card-default">
        <div class="card-body">
            <div class="text-padding">
                <h4 class="text-center">Form not available (@livewire('jobs.change-stage-percentage'))</h4>
            </div>
        </div>
        <!-- /.card -->
    </div>
    @endsection
    
    @section('script')
    <script>
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("{{@$sidebar_id}}").addClass('active');
    </script>
    @endsection
</x-app-layout>
