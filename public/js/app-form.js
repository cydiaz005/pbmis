function AppForm(opts){
    let table = document.querySelector(opts.table);
    let source_id = 1;
    let rows = {};
    let eventListeners={};
    let createElement = function (el, className, innerHTML) {
        let element = document.createElement(el);
        if(className)
        element.className = className;
        if (innerHTML)
        element.innerHTML = innerHTML;
        return element;
    }
    let RowApi = (function () {
        function RowApi(source_id, item_req_id, inputs) {
            this._source_id = source_id;
            this._item_req_id = item_req_id;
            this._inputs = inputs;
        }
        RowApi.prototype.getData = function () {
            let data = {};
            for (const key in this._inputs) {
                data[key] = this._inputs[key].value;
            }
            data['item_req_id'] = this._item_req_id;
            return data;
        }
        return RowApi;
    }());
    this.getRowsData=function(){
        let app_rows = [];
        for (const key in rows) {
            const element = rows[key];
            app_rows.push(element.getData());
        }
        return app_rows;
    }
    this.generateReport=function(type){
        fetch("/form/app-form/fetch", {       
            method: "POST",
            headers: {
                Accept: "application/json, text/plain, */*",
                "Content-Type": "application/json",
                "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
            },
            body: JSON.stringify(opts.params),
        }).then(function (response) {
            if (!response.ok) {
                throw new Error("HTTP status " + response.status);
            }
            return response.json();
        }).then(function(res){
            console.log("res",res);

            // getPDF(report_table);
            // download(report_table)
            // demoFromHTML(report_table);
            if(type=="pdf"){
                exportPDF(res);
            }
            else{
                exportExcel(res);
            }
        });
    }
    this.getItems=function(){
        getItemPpmps();
    }
    this.on=function(e,f){
        eventListeners[e]=f;
    }
    function exportPDF(data){
        var doc = new jsPDF('l', 'pt', [1920, 1080]);
        doc.text(`Office of Civil Defense Indicative Annual Procurement Plan for FY ${opts.params.year}`, (doc.internal.pageSize.getWidth() / 2), 50, null, null, 'center');
        let body = []
        let head = [
            [
                {
                    content: 'Code (PAP)',
                    rowSpan: 2,
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'Account Code',
                    rowSpan: 2,
                    styles: { valign: 'middle', lineWidth: 1},
                },
                // {
                //     content: 'Item Requirement',
                //     rowSpan: 2,
                //     styles: { valign: 'middle', lineWidth: 1},
                // },
                {
                    content: 'Procurement Program/Project',
                    rowSpan: 2,
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'PMO/End-User',
                    rowSpan: 2,
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'Mode of Procurement',
                    rowSpan: 2,
                    styles: { valign: 'middle', lineWidth: 1},
                },



                {
                    content: 'Schedule for Each Procurement Activity',
                    colSpan: 4,
                    styles: { valign: 'middle', halign: 'center', lineWidth: 1},
                },
                {
                    content: 'Source of Funds',
                    rowSpan: 2,
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'Estimated Budget (PhP)',
                    colSpan: 3,
                    styles: { valign: 'middle', halign: 'center', lineWidth: 1},
                },
                {
                    content: 'Remarks (brief description of Program/Activity/Project)',
                    rowSpan: 2,
                    styles: { valign: 'middle', lineWidth: 1},
                },
            ],
            [
                {
                    content: 'Advertisement/Posting of IB/REI',
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'Submission/Opening of Bids',
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'Notice of Award',
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'Contract Signing',
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'Total',
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'MOOE',
                    styles: { valign: 'middle', lineWidth: 1},
                },
                {
                    content: 'CO',
                    styles: { valign: 'middle', lineWidth: 1},
                },
            ]
        ];

        if(data.length){
            for (let i = 0; i < data.length; i++) {
                const ppmp = data[i];
                const ppmp_code = ppmp.ppmp_code;
                const division_section = ppmp.poe.creator.division_section ? ppmp.poe.creator.division_section.accronym : 'N/A';
                const account_code_id = ppmp.poe.category_class.ac_id;
                const fund_chargeability = ppmp.poe.category_class.fund_chargeability.accronym;

                for (let x = 0; x < ppmp.poe.subpap.length; x++) {
                    const subpap = ppmp.poe.subpap[x];
                    for (let z = 0; z < subpap.item_requirements.length; z++) {
                        const item_requirements = subpap.item_requirements[z];
                        body.push([
                            ppmp_code,
                            item_requirements.chart_of_account.code,
                            // item_requirements.itemreq_txt || item_requirements.suggested_item_requirement.ireq,
                            item_requirements.app_form.app_procurement_program,
                            `${division_section}-${ppmp.poe.service_region.accronym}`,
                            item_requirements.procurement_mode.title,
                            item_requirements.app_form.formatted_dates.app_advertisement,
                            item_requirements.app_form.formatted_dates.app_submission,
                            item_requirements.app_form.formatted_dates.app_notice_of_award,
                            item_requirements.app_form.formatted_dates.app_contract_signing,
                            fund_chargeability,
                            item_requirements.total,
                            (account_code_id == 1 ? item_requirements.total:""),
                            (account_code_id == 3 ? item_requirements.total:""),
                            item_requirements.app_form.app_remarks,
                        ]);
                    }
                }
            }
        }
        else{
            body.push([
                {
                    content: 'Empty',
                    colSpan: 15,
                    styles: { cellPadding: 2, valign: 'middle', halign: 'center', lineWidth: 1},
                },
            ])
        }
        doc.autoTable({
            startY: 60,
            head: head,
            body: body,
            theme: 'striped',
            headStyles: {
                fillColor: [255, 188, 0],
                // fontSize: 15,
            },
        })
        doc.save(`Annual Procurement Plan ${opts.params.year}.pdf`);
        renderEvent('report-generated');
    }
    function exportExcel(data){
        let report_table = createElement('table');

        // <th rowspan="2">Item Requirement</th>
        report_table.innerHTML=`
            <thead>
                <tr>
                    <th rowspan="2" colspan="15" style="height: 300px; text-aligin: center">
                        Office of Civil Defense Indicative Annual Procurement Plan for FY ${opts.params.year}
                    </th>
                </tr>
                <tr>
                </tr>
                <tr>
                    <th rowspan="2">Code (PAP)</th>
                    <th rowspan="2">Account Code</th>
                
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
            </thead>`;

        if(data.length){
            for (let i = 0; i < data.length; i++) {
                let tbody = createElement('tbody');
                const ppmp = data[i];
                const ppmp_code = ppmp.ppmp_code;
                const division_section = ppmp.poe.creator.division_section ? ppmp.poe.creator.division_section.accronym : 'N/A';
                const account_code_id = ppmp.poe.category_class.ac_id;
                const fund_chargeability = ppmp.poe.category_class.fund_chargeability.accronym;

                for (let x = 0; x < ppmp.poe.subpap.length; x++) {
                    const subpap = ppmp.poe.subpap[x];
                    for (let z = 0; z < subpap.item_requirements.length; z++) {
                        const item_requirements = subpap.item_requirements[z];
                        let tr3 = createElement('tr');
                        tbody.appendChild(tr3);
                        // <td class="read-only">${item_requirements.itemreq_txt || item_requirements.suggested_item_requirement.ireq}</td>
                        tr3.innerHTML=`
                            <td class="disabled read-only">${ppmp_code}</td>
                            <td class="read-only">${item_requirements.chart_of_account.code}</td>
                            
                            <td class="text-area-td app-procurement-program"></td>
                            <td class="read-only">${division_section}-${ppmp.poe.service_region.accronym}</td>
                            <td class="read-only">${item_requirements.procurement_mode.title}</td>
                            <td class="text-area-td app-advertisement"></td>
                            <td class="text-area-td app-submission"></td>
                            <td class="text-area-td app-notice-of-award"></td>
                            <td class="text-area-td app-contract-signing"></td>
                            <td class="read-only">${fund_chargeability}</td>
                            <td class="read-only app-total">${item_requirements.total}</td>
                            <td class="read-only app-mooe">${(account_code_id == 1 ? item_requirements.total:"")}</td>
                            <td class="read-only app-co">${(account_code_id == 3 ? item_requirements.total:"")}</td>
                            <td class="text-area-td app-remarks"></td>
                        `;
                        if(item_requirements.app_form){
                            tr3.querySelector('.app-procurement-program').innerHTML=item_requirements.app_form.app_procurement_program;
                            tr3.querySelector('.app-advertisement').innerHTML=item_requirements.app_form.formatted_dates.app_advertisement;
                            tr3.querySelector('.app-submission').innerHTML=item_requirements.app_form.formatted_dates.app_submission;
                            tr3.querySelector('.app-notice-of-award').innerHTML=item_requirements.app_form.formatted_dates.app_notice_of_award;
                            tr3.querySelector('.app-contract-signing').innerHTML=item_requirements.app_form.formatted_dates.app_contract_signing;
                            tr3.querySelector('.app-remarks').innerHTML=item_requirements.app_form.app_remarks;
                        }
                        const rowApi = new RowApi(source_id, item_requirements.id, {
                            app_advertisement: tr3.querySelector('.app-advertisement'),
                            app_submission: tr3.querySelector('.app-submission'),
                            app_notice_of_award: tr3.querySelector('.app-notice-of-award'),
                            app_contract_signing: tr3.querySelector('.app-contract-signing'),
                            app_remarks: tr3.querySelector('.app-remarks'),
                        });
                        rows[source_id] = rowApi;
                        source_id++;
                    }
                }
                report_table.appendChild(tbody);
            }
        }
        else{
            let tbody = createElement('tbody');
            tbody.innerHTML = '<tr><td colspan="15" class="text-center">Empty</td></tr>';
            report_table.appendChild(tbody);
        }

        // Extract Data (create a workbook object from the table)
        var workbook = XLSX.utils.table_to_book(report_table, {raw:true});
        console.log("XLSX.utils.table_to_book",XLSX.utils.table_to_book);
        console.log("workbook",workbook);
        
        // Process Data (add a new row)
        var ws = workbook.Sheets["Sheet1"];

        for (const key in ws) {
            if(!key.includes("!")){
                ws[key].s = {
                    alignment: {
                        wrapText: true,
                        vertical: 'center',
                    }
                }
            }
        }
        ws["A1"].s = {
            alignment: {
                wrapText: true,
                vertical: 'center',
                horizontal: 'center',
            },
            font: {
                name: "Calibri",
                sz: 12,
                bold: true,
                // color: { rgb: "FFFFAA00" },
            },
        }

        const header_cell = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O"];
        //add style to headers
        for (let j = 0; j < header_cell.length; j++) {
            for (let i = 3; i <= 4; i++) {
                let key = header_cell[j] + i;
                if(!ws[key]){
                    ws[key]={
                        s: "",
                        t: "s",
                        v: ""
                    }
                }
                ws[key].t = "s";
                ws[key].s = {
                    alignment: {
                        wrapText: true,
                        vertical: 'center',
                    },
                    font: {
                        name: "Calibri",
                        sz: 12,
                        bold: true,
                        // color: { rgb: "FFFFAA00" },
                    },
                    border: {
                        top: {
                            style: 'medium',
                            color: 'FFFFAA00',
                        },
                        right: {
                            style: 'medium',
                            color: 'FFFFAA00',
                        },
                        left: {
                            style: 'medium',
                            color: 'FFFFAA00',
                        },
                        bottom: {
                            style: 'medium',
                            color: 'FFFFAA00',
                        },
                    },
                }
            }
            
            console.log("ws", ws);
        }
    
        let wscols = [
            {wch:20},
            {wch:35},
            {wch:30},
            {wch:40},
            {wch:15},
            {wch:40},
            {wch:40},
            {wch:40},
            {wch:40},
            {wch:40},
            {wch:15},
            {wch:15},
            {wch:15},
            {wch:15},
            {wch:40},
        ];
        ws['!cols'] = wscols;
        
        XLSX.writeFile(workbook, "APP Form "+opts.params.year+".xlsx");
        renderEvent('report-generated');
    }
    function getItemPpmps(){
        fetch("/form/app-form/fetch", {       
            method: "POST",
            headers: {
                Accept: "application/json, text/plain, */*",
                "Content-Type": "application/json",
                "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
            },
            body: JSON.stringify(opts.params),
        }).then(function (response) {
            if (!response.ok) {
                throw new Error("HTTP status " + response.status);
            }
            return response.json();
        })
        .then(function(res){
            console.log("res",res);
            if(res.length){
                table.querySelector('tbody').remove();
                for (let i = 0; i < res.length; i++) {
                    let tbody = createElement('tbody');
                    const ppmp = res[i];
                    const ppmp_code = ppmp.ppmp_code;
                    const division_section = ppmp.poe.creator.division_section ? ppmp.poe.creator.division_section.accronym : 'N/A';
                    const account_code_id = ppmp.poe.category_class.ac_id;
                    const fund_chargeability = ppmp.poe.category_class.fund_chargeability.accronym;

                    let tr1 = createElement('tr');
                    tr1.style="background:orange";
                    tr1.innerHTML=`<td colspan="15">${ppmp.poe.pap_txt || ppmp.poe.suggested_pap.paps}</td>`;
                    tbody.appendChild(tr1);

                    for (let x = 0; x < ppmp.poe.subpap.length; x++) {
                        const subpap = ppmp.poe.subpap[x];
                        
                        let tr2 = createElement('tr');
                        tr2.style="background:yellow";
                        tr2.innerHTML=`<td colspan="15">${subpap.subpap_txt || subpap.suggested_sub_pap.subpaps}</td>`;
                        tbody.appendChild(tr2);

                        for (let z = 0; z < subpap.item_requirements.length; z++) {
                            const item_requirements = subpap.item_requirements[z];
                            console.log("item_requirements",item_requirements);
                            let tr3 = createElement('tr');
                            tbody.appendChild(tr3);
                            tr3.innerHTML=`
                                <td class="disabled read-only">${ppmp_code}</td>
                                <td class="read-only">${item_requirements.chart_of_account.code}</td>
                                <td class="read-only">${item_requirements.itemreq_txt || item_requirements.suggested_item_requirement.ireq}</td>
                                <td class="read-only"><textarea class="text-area-td app-procurement-program"></textarea></td>
                                <td class="read-only">${division_section}-${ppmp.poe.service_region.accronym}</td>
                                <td class="read-only">${item_requirements.procurement_mode.title}</td>
                                <td><input type="month" class="date-td app-advertisement"></td>
                                <td><input type="month" class="date-td app-submission"></td>
                                <td><input type="month" class="date-td app-notice-of-award"></td>
                                <td><input type="month" class="date-td app-contract-signing"></td>
                                <td class="read-only">${fund_chargeability}</td>
                                <td class="read-only app-total">${item_requirements.total}</td>
                                <td class="read-only app-mooe">${(account_code_id == 1 ? item_requirements.total:"")}</td>
                                <td class="read-only app-co">${(account_code_id == 3 ? item_requirements.total:"")}</td>
                                <td><textarea class="text-area-td app-remarks"></textarea></td>
                            `;
                            if(item_requirements.app_form){
                                tr3.querySelector('.app-procurement-program').value=item_requirements.app_form.app_procurement_program;
                                tr3.querySelector('.app-advertisement').value=item_requirements.app_form.app_advertisement;
                                tr3.querySelector('.app-submission').value=item_requirements.app_form.app_submission;
                                tr3.querySelector('.app-notice-of-award').value=item_requirements.app_form.app_notice_of_award;
                                tr3.querySelector('.app-contract-signing').value=item_requirements.app_form.app_contract_signing;
                                tr3.querySelector('.app-remarks').value=item_requirements.app_form.app_remarks;
                            }
                            if(opts.readOnly){
                                tr3.querySelector('.app-procurement-program').disabled=true;
                                tr3.querySelector('.app-advertisement').disabled=true;
                                tr3.querySelector('.app-submission').disabled=true;
                                tr3.querySelector('.app-notice-of-award').disabled=true;
                                tr3.querySelector('.app-contract-signing').disabled=true;
                                tr3.querySelector('.app-remarks').disabled=true;
                            }
                            const rowApi = new RowApi(source_id, item_requirements.id, {
                                app_procurement_program: tr3.querySelector('.app-procurement-program'),
                                app_advertisement: tr3.querySelector('.app-advertisement'),
                                app_submission: tr3.querySelector('.app-submission'),
                                app_notice_of_award: tr3.querySelector('.app-notice-of-award'),
                                app_contract_signing: tr3.querySelector('.app-contract-signing'),
                                app_remarks: tr3.querySelector('.app-remarks'),
                            });
                            rows[source_id] = rowApi;
                            source_id++;

                            let date = new Date();
                                
                            let addPadd = function(num){
                                if(num < 10){
                                    return "0" + num;
                                }
                                return num;
                            }

                            let month_date = "-" + addPadd(date.getMonth());

                            let setMaxMin=function(input_class){
                                setMinDateInput(tr3.querySelector(input_class), date.getFullYear() + month_date);
                                setMaxDateInput(tr3.querySelector(input_class), (date.getFullYear() + 2) + month_date);
                            }

                            setMaxMin('.app-advertisement');
                            setMaxMin('.app-submission');
                            setMaxMin('.app-notice-of-award');
                            setMaxMin('.app-contract-signing');

                        }
                    }
                    table.appendChild(tbody);
                }
            }
            else{
                table.querySelector('tbody').innerHTML='<tr><td colspan="15" class="text-center">Empty</td></tr>';
            }
        });
    }
    function renderEvent(e, params){
        if(eventListeners[e]){
            eventListeners[e](params);
        }
    }
}