<div class="content-header" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-8">
                <!-- <h1 class="m-0">Welcome to OCD {{Auth::user()->name}}</h1> -->
                <h1 style="margin-bottom: 5px;"><strong>{{strtoupper($pageTitle)}}</strong></h1>
                <!-- @foreach (Auth::user()->getRoleNames() as $r)
                <span class="badge badge-primary">{{$r}}</span>
                @endforeach -->
                <ol class="breadcrumb float-sm-left">

                @foreach ($breadcrumb as $link)
                    <li class="breadcrumb-item"><a href="{{$link['route']}}">{{strtoupper($link['name'])}}</a></li>
                @endforeach

                {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li> --}}
                </ol>
               
            </div><!-- /.col -->
            <div class="col-sm-4 text-right">
                <div class="row align-items-center justify-content-end">
                    <!-- <div class="col-sm-2">
                        <i style="color:var(--ocd-primary);font-size: 30px;" class="far fa-clock"></i>
                    </div> -->
                    <div>
                    {{-- <div class="col-sm-6" style="max-width:143px;"> --}}
                        {{-- <h5 wire:poll.1000ms style="color:var(--ocd-primary);font-size: 21px;">
                            <strong><small class="d-block">{{ strtoupper(date("d F Y")); }} </small></strong>
                            <strong>{{ date("h:i:s a"); }}</strong>
                        </h5> --}}
                        <div class="d-table" style="color:var(--ocd-primary)">
                            <div class="d-table-row">
                                <div class="d-table-cell px-2 text-right">
                                    Fiscal Limit:
                                </div>
                                <div class="d-table-cell text-left">
                                    <strong>₱{{number_format($fiscal_limit, 2, '.', ',')}}</strong>
                                </div>
                            </div>
                            <div class="d-table-row">
                                <div class="d-table-cell px-2 text-right">
                                    Total Programmed Budget:
                                </div>
                                <div class="d-table-cell text-left">
                                    <strong>₱{{number_format($total_programmed_budget, 2, '.', ',')}}</strong>
                                </div>
                            </div>
                        </div>
                        {{-- <span class="font-weight-normal">Fiscal Limit:</span> <strong>₱30,586,835.46</strong>
                        <br>
                        <span class="font-weight-normal">Total Programmed Budget:</span> <strong>₱168,631,646.77</strong> --}}
                        
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        {{-- <span class="workingbadge badge badge-success">Page Under Construction</span> --}}

      
     
    </div><!-- /.container-fluid -->
</div>
