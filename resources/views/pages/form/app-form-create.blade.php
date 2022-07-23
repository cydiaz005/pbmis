<x-app-layout>
    @section('style')
    <style>
        .table-1 thead tr th{
            padding: .5rem;
            border: 1px solid grey;
            text-align: center;
            min-width: 9rem !important;
        }
        .table-1 tbody tr td{
            padding: .5rem;
            border: 1px solid grey;
            text-align: center;
            position: relative;
        }
        .text-area-td{
            width: 100%;
            height: 100%;
            resize: none;
            position: absolute;
            top: 0;
            left: 0;
            border: none !important;
            outline: none !important;
        }
        .date-td{
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            border: none !important;
            outline: none !important;
            font-size: .9rem;
        }
        
        td input:focus{
            outline: none !important;
        }
        .read-only{
            background: #e1e1e1 !important;
        }
    </style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Forms', 'route' => '#'],
            ['name' => 'APP Form', 'route' => '#'],
        ],
        'pageTitle' => '(APP)',
    ])
    


   
    <div class="card card-default">
        <div class="card-body">
            <div class="d-flex justify-content-end align-items-center mb-3">
                <div>
                    <button class="btn btn-primary" id="save-app-form-btn">Save</button>
                </div>
            </div>
            <div class="overflow-auto pb-4">
                <table class="table-1" id="app-table">
                    <thead>
                        <tr>
                            <th rowspan="2">Code (PAP)</th>
                            <th rowspan="2">Account Code</th>
                            <th rowspan="2">Item Requirement</th>
                            <th rowspan="2">Procurement Program/Project</th>
                            <th rowspan="2">PMO/End-User</th>
                            <th rowspan="2">Mode of Procurement</th>

                            <th colspan="4">Schedule for Each Procurement Activity</th>

                            <th rowspan="2">Source of Funds</th>

                            <th colspan="3">Estimated Budget (PhP)</th>
                            <th rowspan="2">Remarks (brief description of Program/Activity/Project)</th>
                        </tr>
                        <tr>
                            <th>Advertisement/Posting of IB/REI</th>
                            <th>Submission/Opening of Bids</th>
                            <th>Notice of Award</th>
                            <th>Contract Signing</th>

                            <th>Total</th>
                            <th>MOOE</th>
                            <th>CO</th>
                        </tr>
                    </thead>
                    <tbody><tr><td colspan="15" class="text-center">Loading...</td></tr></tbody>
                </table>
            </div>
        </div>
    </div>
    
    
    @endsection
    
    @section('script')
    <script src="{{asset('js/xlsx-export/xlsx.full.min.js')}}"></script>
    <script src="{{asset('js/xlsx-export/xlsx.bundle.js')}}"></script>
    <script src="{{asset('js/app-form.js')}}"></script>
    <script>
        const appForm = new AppForm({
            table: "#app-table",
            params: {
                year: '{{$year}}',
            }
        });
        appForm.getItems();
        document.querySelector('#save-app-form-btn').onclick=function(){
            // appForm.generateReport();
            // return;
            $('.spinner_modal').modal('show');
            const app_rows = appForm.getRowsData()
            fetch("/form/app-form/save", {       
                method: "POST",
                headers: {
                    Accept: "application/json, text/plain, */*",
                    "Content-Type": "application/json",
                    "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
                },
                body: JSON.stringify({rows: app_rows, year: '{{$year}}'}),
            }).then(function (response) {
                if (!response.ok) {
                    throw new Error("HTTP status " + response.status);
                }
                return response.text();
            })
            .then(function(res){
                $('.spinner_modal').modal('hide');
                window.location.href="/form/app-form";
            });
            console.log("app_rows",app_rows);
        }

    </script>









    <script>
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_appform").addClass('active');
    </script>
    @endsection
</x-app-layout>