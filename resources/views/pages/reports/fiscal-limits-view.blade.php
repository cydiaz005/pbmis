<style>
    .fiscal-limit-table {
        overflow-x: auto;
    }
    #fiscal-table{
        width: 100%;
        max-height: 60rem;
        transition: width 0.2s ease-in;
    }
    .fiscal-limit-table.active {
        background: rgba(255,255,255,0.3);
        cursor: grabbing;
        cursor: -webkit-grabbing;
        transform: scale(1);
    }
    .fiscal-limit-table table {
        position: relative;
        border-collapse: collapse;
    }
    /* .fiscal-limit-table table thead {
        background-color: #1c20ab;
        color: #c2c7d0;
        position: sticky;
        position: -webkit-sticky;
        z-index: 999;
        top: 0;
    } */
    .cell.active {
        background-color: #1c20ab1a;
    }
    .fiscal-limit-table::-webkit-scrollbar {
        width: 3px;
        height: 3px;
    }
    .fiscal-limit-table::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
    }

    .fiscal-limit-table {
        height: 50rem;
    }

</style>
<x-app-layout>
    @section('style')

    @endsection

    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/'],
            ['name' => 'Reports', 'route' => '#'],
            ['name' => 'FISCAL LIMIT', 'route' => '#'],
        ],
        'pageTitle' => 'FISCAL LIMIT FY-'.$year
    ])


    <div id="fiscal-table"  class="card">
        <div class="card-body table-sticky-wrapper">
            <div class="mb-2">
                <button id="export-excel" class="btn btn-success btn-sm">Export Excel</button>
                <button id="export-pdf" class="btn btn-danger btn-sm">Export PDF</button>
            </div>
        </div>
            <div class="fiscal-limit-table">
                @livewire('reports.views.fiscal-limit-form-view',[
                    'stage' => $stage,
                    'year' => $year,
                ])
            </div>

        </div>
    </div>

    @endsection

    @section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
        <script src="{{asset('js/xlsx-export/xlsx.full.min.js')}}"></script>
        <script src="{{asset('js/xlsx-export/xlsx.bundle.js')}}"></script>
        <script src="{{asset('js/poe.js')}}"></script>
        <script>
            document.querySelector('#export-excel').onclick=function(){
                let _this = this;
                _this.innerHTML='Exporting...';
                exportFiscalLimitExcel({
                    year: '{{$year}}',
                    stage_id: '{{$stage}}',
                },function(){
                    _this.innerHTML='Export Excel';
                });
            }
            document.querySelector('#export-pdf').onclick=function(){
                let _this = this;
                _this.innerHTML='Exporting...';
                exportFiscalLimitPDF({
                    year: '{{$year}}',
                    stage_id: '{{$stage}}',
                },function(){
                    _this.innerHTML='Export PDF';
                });
            }
        </script>
    <script>
        // draggable table
			let table_con = document.querySelector('.fiscal-limit-table');
			let isDown = false;
			let startX;
			let scrollLeft;

			table_con.addEventListener('mousedown', (e) => {
				isDown = true;
				table_con.classList.add('active');
				startX = e.pageX - table_con.offsetLeft;
				scrollLeft = table_con.scrollLeft;
			});
			table_con.addEventListener('mouseleave', () => {
				isDown = false;
				table_con.classList.remove('active');
			});
			table_con.addEventListener('mouseup', () => {
				isDown = false;
				table_con.classList.remove('active');
			});
			table_con.addEventListener('mousemove', (e) => {
				if(!isDown) return;
				e.preventDefault();
				const x = e.pageX - table_con.offsetLeft;
				const walk = (x - startX) * 2; //scroll-fast
				table_con.scrollLeft = scrollLeft - walk;

			});
			$(function() {
				$('td').dblclick(function() {
					$('tr').removeClass('active');
					$(this).parent().addClass('active');
				});
			});
    </script>
    @yield('fl-view-script')
    @endsection
</x-app-layout>


