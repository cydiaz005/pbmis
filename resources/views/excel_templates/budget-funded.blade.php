<link rel="stylesheet" href="{{asset('theme-alte3/dist/css/adminlte.min.css')}}">
@livewire('reports.views.budget-form-view',[
        'year' => $year,
        'serreg_id' => $serreg_id,
        'funded_status' => $funded_status,
    ])

