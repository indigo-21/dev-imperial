$(function(){
    
    $(document).on("click",".view-items", function(){
        let table_body = $("#cost-plan-items-table-body");
        let project_id = $(this).attr("projectid");
        let section_id = $(this).attr("sectionid");

        $.ajax({
            url: `${BASE_URL}/get_items`,
            type: 'POST',
            data: { section_id },
            dataType: 'json',
            beforeSend: function () {
                let html = `<tr><td class="text-center" colspan="11">Loading...</td></tr>`;
                table_body.html(html);
            },
            success: function (response) {
                let html = ""; 
                let {cost_plan_items, purchase_order_items} = response;
                let po_list = {}

                purchase_order_items.forEach(purchase_order => {
                    po_list[purchase_order.item_code] = purchase_order;
                });

                cost_plan_items.map((items,index)=> {
                    let purchase_order = po_list[items.item_code] || {}
                    let purchase_order_id = purchase_order.purchase_order_id ?? false;
                    html += `
                            <tr>
                                <td>${items.item_code}</td>
                                <td>${items.description}</td>
                                <td>${items.quantity}</td>
                                <td>${items.unit}</td>
                                <td>${items.rate}</td>
                                <td>${items.cost}</td>
                                <td>${items.total}</td>
                                <td>${formatPO(purchase_order_id)}</td>
                                <td>${purchase_order_id ? purchase_order.total : 0.00}</td>
                                <td>INV-00001</td>
                                <td>0.00</td>s
                            </tr>
                            `;
                });
                table_body.html(html);
                $("#costPlanItems").modal("show");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }

        });
        
    });



    function formatPO(num) {
        return num ? "PO-" + String(num).padStart(5, '0') : "-";
    }
    


});