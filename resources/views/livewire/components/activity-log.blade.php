<div class="card">
    <div class="card-body">
        <h3 class="text-center" style="margin: 25px 0;margin-top:0px;">
            <strong>ACTIVITY LOG</strong>
        </h3>
        <div class="timeline timeline-inverse">
            @foreach($activity_logs as $key => $val)
            <div class="time-label">
                <span class="tertiary-dark bg-secondary">
                    {{\Carbon\Carbon::parse($val->created_at)->format('F d, Y h:i:s A')}}
                </span>
            </div>
            <div>
                <i class="far fa-clock bg-secondary"></i>
                <div class="timeline-item">
                    <span class="time"><i class="far fa-clock"></i> {{\Carbon\Carbon::parse($val->updated_at)->diffForHumans()}}</span>
                    <h3 class="timeline-header">
                        @if(isset($val->causer))
                        <a href="#" style="text-transform: capitalize">{{ $val->causer->firstname . " " . $val->causer->lastname }}</a>
                        @else
                        <a href="#" style="text-transform: capitalize">System</a>
                        @endif
                    </h3>
                    <div class="timeline-body">
                        {{$val->description}}
                    </div>
                    <div class="timeline-footer">
                        <button wire:click="openActivityLogViewModal({{json_encode($val)}})" class="btn btn-primary btn-sm">Show more</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if (auth()->user()->hasPermissionTo('audit-trail-access'))
            <a href="/audit-trail" class="">Show all logs</a>
        @endif
    </div>
</div>
<div class="modal fade" id="activity-log-modal" role="dialog">
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

<script defer src="{{ asset('js/set_activity_log_modal.js')}}"></script>
<script>
    window.addEventListener('openActivityLogViewModal', (event) => {
        //check if properties exist then return if not
        if (!event.detail.hasOwnProperty('properties')) return;

        const properties = event.detail.properties;

        //show modal
        $('#activity-log-modal').modal({
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
</script>