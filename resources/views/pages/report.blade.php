<x-app-layout>
    @section('style')
        <script src="http://code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="https://assets.codepen.io/975719/gcspread.sheets.9.40.20161.7.min.js" type="text/javascript"></script>
        <script src="https://www.grapecity.co.kr/files/license/codepen_v14.js"></script>

        <link href="http://cdn.grapecity.com/spreadjs/hosted/css/gc.spread.sheets.excel2013white.10.0.0.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="http://cdn.grapecity.com/spreadjs/hosted/scripts/gc.spread.sheets.all.10.0.0.min.js"></script>
        <script type="text/javascript" src="http://cdn.grapecity.com/spreadjs/hosted/scripts/interop/gc.spread.excelio.10.0.0.min.js"></script>

        <script>
        </script>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
            ['name' => 'Users', 'route' => 'user/admin'],
        ]
    ])


    <div class="card">
      <div class="card-body">
        <blockquote class="blockquote">
          <p>Report Section</p>
{{--            @php echo asset('reports/POE1.xlsx') @endphp--}}
          <footer class="card-blockquote"><cite title="Source title">Under Construction</cite></footer>
        </blockquote>
          <div id="ss" style="height:700px ; width :100%; "></div>
{{--          <input type="text" id="importUrl" value="xxxx" style="width:300px" />--}}
{{--          <button id="addRevenue">Add Revenue</button>--}}
{{--          <button id="export">Export File</button>--}}
{{--          <input type="text" id="exportFileName" placeholder="Export file name" value="export.xlsx" />--}}

      </div>
    </div>

    @endsection

    @section('script')
            <script>
                $(document).ready(function () {
                    // var spread = new GcSpread.Sheets.Spread(document.getElementById("ss"), {
                    //     sheetCount: 2,
                    // });

                    // initSpread(spread);

                    ImportFile();

                });
                function ImportFile() {
                    workbook = new GC.Spread.Sheets.Workbook(document.getElementById("ss"));

                    excelIO = new GC.Spread.Excel.IO();
                    @if($type==='poe')
                        @if($id==='1')
                            var excelUrl = "@php echo asset('reports/POE1.xlsx') @endphp";
                        @elseif($id ==='2')
                            var excelUrl = "@php echo asset('reports/POE2.xlsx') @endphp";
                        @endif
                    @elseif($type==='ppmp')
                        @if($id==='1')
                            var excelUrl = "@php echo asset('reports/PPMP1.xlsx') @endphp";
                        @elseif($id ==='2')
                            var excelUrl = "@php echo asset('reports/PPMP1.xlsx') @endphp";
                        @endif
                    @elseif($type==='bgf')
                        @if($id==='1')
                        var excelUrl = "@php echo asset('reports/BGF1.xlsx') @endphp";
                        @elseif($id ==='2')
                        var excelUrl = "@php echo asset('reports/BGF2.xlsx') @endphp";
                        @endif
                    @elseif($type==='opc')
                        @if($id==='1')
                        var excelUrl = "@php echo asset('reports/OPC1.xlsx') @endphp";
                        @elseif($id ==='2')
                        var excelUrl = "@php echo asset('reports/OPC1.xlsx') @endphp";
                        @endif
                    @elseif($type==='f1')
                    var excelUrl = "@php echo asset('reports/F1A.xlsx') @endphp";
                    @endif
                    //var excelUrl = $("#importUrl").val();

                    var oReq = new XMLHttpRequest();
                    oReq.open('get', excelUrl, true);
                    oReq.responseType = 'blob';
                    oReq.onload = function () {
                        var blob = oReq.response;
                        // console.log(blob)
                        excelIO.open(blob, LoadSpread, function (message) {
                            console.log(message);
                        });
                    };
                    oReq.send(null);
                }
                function LoadSpread(json) {
                    jsonData = json;
                    workbook.fromJSON(json);
                    workbook.sheet.remove(workbook.sheet[1])

                    // workbook.setActiveSheet("Revenues (Sales)");

                }
                function initSpread(spread) {
                    var spreadNS = GcSpread.Sheets,
                        sheet = spread.getSheet(0);
                    window.sp = spread;
                    window.sheet = sheet;
                    let items = [];

                    $.ajax({
                        type: "GET",
                        url: "https://demodata.grapecity.com/northwind/api/v1/Customers",
                        success: function (data) {
                            data.forEach((d) => {
                                d.text = d.customerId;
                            });
                            combo.items(data);
                        },
                        error: function (error) {
                            console.log(error);
                        },
                    });
                    var $eventTrigger = $("#eventTrigger");
                    spread.bind(spreadNS.Events.CellChanged, function (e, args) {
                        if (
                            args.sheet.getCellType(args.row, args.col) instanceof
                            spreadNS.ComboBoxCellType
                        ) {
                            combo._items.forEach((item) => {
                                if (item.text === args.newValue) {
                                    sheet.setValue(args.row, args.col + 1, item.companyName);
                                    sheet.setValue(args.row, args.col + 2, item.country);
                                }
                            });
                        }
                    });
                    var combo = new spreadNS.ComboBoxCellType();
                    combo.editorValueType(spreadNS.EditorValueType.Text);

                    window.combo = combo;
                    sheet.getCell(1, 1, spreadNS.SheetArea.viewport).cellType(combo);
                    sheet.getCell(0, 2).value("companyName");
                    // sheet.getCell(0, 3).value("PROGRAM OF EXPENDITURES");
                    sheet.getCell(0, 3).value("country");

                    sheet.isPaintSuspended(true);

                    sheet.setValue(1, 0, "ComboBoxCellType");
                    sheet.isPaintSuspended(false);
                }
            </script>
    @endsection
</x-app-layout>
