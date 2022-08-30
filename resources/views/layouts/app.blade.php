<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback')}}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('theme-alte3/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- Not Local -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap')}}">
    {{-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/searchable/searchable.css')}}">
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme-alte3/plugins/chart.js/Chart.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('theme-alte3/plugins/chart.js/Chart-Utils.js')}}"> -->

    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{asset('css/ocd.css')}}">

    @livewire('livewire-ui-modal')
    @livewireStyles
    @powerGridStyles
    @yield('style')
    <style>
      .sidebar::-webkit-scrollbar{
        width:3px;
      }
      /* Track */
      .sidebar::-webkit-scrollbar-track {
          background: #5256d7a3;
        }

        /* Handle */
        .sidebar::-webkit-scrollbar-thumb {
          background: #d2e3f3;
          border-radius: 10px;
        }

        /* Handle on hover */
        .sidebar::-webkit-scrollbar-thumb:hover {
          background: #555;
        }
        .name-div{
          max-width: 8rem !important;
        }
    </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed" style="overflow-x: hidden;">
  <div class="wrapper" style="background-color: #f4f6f9;">
  
      @livewire('partials.navbar')
      @livewire('partials.sidebar-left')
    
  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      {{--
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Starter Page</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      --}}
      <!-- /.content-header -->
  
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          @yield('content')
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->
    <div class="modal spinner_modal" style="box-shadow: none" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-sm" style="display: table; position: relative; margin: 0 auto; top: calc(50% - 24px);">
            <div class="modal-content" style="width: 48px; box-shadow:none !important; background-color: transparent; border:none">
                <span class="fa fa-spinner fa-spin fa-3x"></span>
            </div>
        </div>
    </div>
    @livewire('partials.footer')
    
  </div>

  

  @livewireScripts
  @powerGridScripts
  <script>
    const typeUser = @json(@Auth::user()->rol->role->name);
    console.log(typeUser)
  </script>
  <script src="{{asset('js/scripts.js')}}"></script>
  <script>
     let server_date_time_in_seconds = "{{Carbon\Carbon::now()->addHours(8)->timestamp}}";
  </script>
  <!-- Alpine v2 -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

<!-- Alpine v3 -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <script src="{{asset('theme-alte3/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('theme-alte3/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('theme-alte3/dist/js/adminlte.min.js')}}"></script>
  <script src="{{asset('theme-alte3/plugins/summernote/summernote-bs4.min.js')}}"></script>
  
  <script src="{{asset('/theme-alte3/plugins/chart.js/Chart.js')}}"></script>
  <script src="{{asset('/theme-alte3/plugins/chart.js/Chart-Utils.js')}}"></script>
  <script src="{{asset('theme-alte3/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('theme-alte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('theme-alte3/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('theme-alte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{asset('theme-alte3/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
  
  <script src="{{asset('theme-alte3/plugins/toastr/toastr.min.js')}}"></script>


  
  <script src="{{asset('theme-alte3/plugins/searchable/searchable.js')}}"></script>
  <script src="{{asset('theme-alte3/plugins/select2/js/select2.min.js')}}"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
  <script src="{{asset('js/confirmation_promt.js')}}"></script>
  <script>const server_time_now = {{strtotime('now')}};</script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

 
  {{-- <script src="{{asset("js/jquery-ui/jquery-ui.js")}}"></script> --}}
  <script src="{{asset("js/fetchscroll.js")}}"></script>
  <script src="{{asset("js/notification.js")}}"></script>
 
  @yield('script')
</body>
</html>
