<x-app-layout>
    @section('style')
    <style>
        /* .main-footer {
          margin-left: 0 !important;
      } */
    </style>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
    'pageTitle' => 'Audit Trail',
    'breadcrumb' => [
    ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
    ['name' => 'Audit Trail', 'route' => '#'],
    ]
    ])

    @livewire('audit-trail-table')

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Activity Log Properties</h4>
                </div>
                <div id="modal-body" class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                New properties
                            </h3>
                        </div>
                        <div class="card-body">
                            <dl id="new-properties-row" class="row">
                            </dl>
                        </div>
                    </div>
                    <div id="old-properties-card" class="card hidden">
                        <div class="card-header">
                            <h3 class="card-title">
                                Old properties
                            </h3>
                        </div>
                        <div class="card-body">
                            <dl id="old-properties-row" class="row">
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script defer src="{{ asset('js/set_activity_log_modal.js')}}"></script>
    <script>
        Livewire.on('onOpenViewModal', async ({
            key,
            properties
        }) => {
            //check if properties prop is present
            if (!properties) return;

            //show modal
            $('#myModal').modal({
                show: true
            });

            //date options for created at
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
            };

            //append the rows from the return value  of setModalRows function from properties.attributes
            $('#new-properties-row').empty().append(setModalRows(properties.attributes, options));

            //check if has old prop
            if (properties.old) {

                //append the rows from the return value  of setModalRows function from properties.old
                $('#old-properties-row').empty().append(setModalRows(properties.old, options))

                //remove hidden class from the old prop card
                $('#old-properties-card').removeClass(`hidden`)
            } else {

                //else hide the old prop from the dom
                $('#old-properties-card').addClass(`hidden`)
                $('#old-properties-row').empty()
            }
        });

        $("#li_audit").addClass('active');
    </script>
    @endsection
</x-app-layout>