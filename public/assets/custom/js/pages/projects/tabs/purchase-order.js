$(function () {

    $(document).on("click", "#create-po-btn", function () {
        sectionAnimation();
    });

    $(document).on("click", "#cancel-btn-from-checklist", function () {
       sectionAnimation("cancel-btn-from-checklist");
    });

    $(document).on("click", "#cancel-btn-from-tablelist", function () {
       sectionAnimation("cancel-btn-from-tablelist");
    });

    $(document).on("change", "#supplier_id", function () {
        let supplier_id = $(this).val();
        $("[name=supplier_id]").val(supplier_id);
        getCostPlanItems(supplier_id);
    })

    $(document).on("keyup", ".compute-total", function () {
        let table_row = $(this).closest("tr");
        let quantity = parseFloat(table_row.find(".qty-input").val() ?? 0);
        let rate = parseFloat(table_row.find(".price-input").val() ?? 0);
        let total = parseFloat(quantity * rate) ?? 0;
        table_row.find("[name=total]").val(total.toFixed(2));
        table_row.find(".total-cell").text(total.toFixed(2));
    });

    $(document).on("click", "#proceed-btn-from-checklist", function () {
        sectionAnimation("proceed-btn-from-checklist");
        getPurchaseOrderItems();
    });

    $(document).on("click",".edit-purchase-order", function(){
        let purchase_order_element = $(this);
        sectionAnimation("edit-purchase-order");
        getPurchaseOrderItems(purchase_order_element);
    })

    function getCostPlanItems(supplier_id = false) {
        let line_item_container = $("#line-items-list");
        $.ajax({
            headers: { 'X-CSRF-Token': CSRF_TOKEN },
            url: `${BASE_URL}/get_items_by_supplier`,
            type: 'POST',
            data: { supplier_id },
            dataType: 'json',
            beforeSend: function () {
                let html = `<span>Loading...</span>`;
                line_item_container.html(html);
            },
            success: function (response) {
                let html = "";
                response.map((item, index) => {
                    html += `<label class="d-flex align-items-center mb-2 selectable-label">
                                    <input type="checkbox"
                                        class="cost-plan-item"
                                        data-section-id="${item.cost_plan_section_id}" 
                                        data-item-code="${item.item_code}" 
                                        data-item-description="${item.description}" 
                                        data-quantity="${item.quantity}" 
                                        data-unit-price="${item.rate}" >
                                    <span class="mx-2">
                                        <strong>${item.item_code}</strong> — ${item.description}
                                    </span>
                                </label>`;
                });
                line_item_container.html(html);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

    }

    function getPurchaseOrderItems(purchase_order_element = false){
        let html = "";
        let line_item_tbody = $("#line-items-table-body");
        let loading_screen = `<tr><td class="text-center" colspan="5"><span>Loading...</span></td></tr>`;
        line_item_tbody.html(loading_screen);
        let item_total_amount = 0;

        if(purchase_order_element){
            let purchase_order_id = purchase_order_element.attr("data-purchase-order-id");
            let supplier_id = purchase_order_element.attr("data-supplier-id");
            $("[name=purchase_order_id]").val(purchase_order_id);
            $("[name=supplier_id]").val(supplier_id);
            $.ajax({
                headers: {'X-CSRF-Token': CSRF_TOKEN},
                url:`${BASE_URL}/get_po_item`,
                type: 'POST',
                data:{purchase_order_id},
                dataType:'json',
                success:function(response){
                    response.map((item, index)=>{
                        let data = {
                            index,
                            cost_plan_section_id:item.cost_plan_section_id,
                            item_code:item.item_code,
                            item_description:item.description,
                            item_quantity: item.quantity,
                            item_unit_price:item.unit_price,
                            total: item.total  
                        }
                        item_total_amount += parseFloat(item.total || 0)
                        html += itemTableRow(data);
                    });
                },
                error:function(xhr, status, error){
                    console.log(error);
                }
            })
        }else{
            $(".cost-plan-item:checked").each((index, item) => {
                let cost_plan_section_id = $(item).attr("data-section-id");
                let item_code = $(item).attr("data-item-code");
                let item_description = $(item).attr("data-item-description");
                let item_quantity = $(item).attr("data-quantity");
                let item_unit_price = parseFloat($(item).attr("data-unit-price") ?? 0);
                let total = parseFloat(item_quantity ?? 0) * parseFloat(item_unit_price ?? 0);
                item_total_amount += parseFloat(total);
                let data = {index, cost_plan_section_id, item_code,item_description,item_quantity,item_unit_price, total};
                html += itemTableRow(data);
            });
        }
        
        setTimeout(() => {
            html += `tr>
                        <td colspan="4">Total</td>
                        <td class="text-right">${currencyFormat(item_total_amount)}</td>
                    </tr>`;
            line_item_tbody.html(html);
        }, 2000);
    }

    function itemTableRow(data = {}){
        let {
            index, cost_plan_section_id, item_code, item_description, item_quantity, item_unit_price, total
        } = data;   

        let section_code = item_code.split(".");

        return `<tr>
                    <td>
                        <input type="hidden" name="section_code[${index}]" value="${section_code[0]}">
                        <input type="hidden" name="cost_plan_section_id[${index}]" value="${cost_plan_section_id}">
                        <input type="hidden" name="item_code[${index}]" value="${item_code}">
                        <input type="hidden" name="item_description[${index}]" value="${item_description}" >
                        <strong>${item_code}</strong>
                    </td>
                    <td>${item_description}</td>
                    <td>
                        <input type="number" name="quantity[${index}]" class="form-control compute-total qty-input" value="${item_quantity}" min="0">
                    </td>
                    <td>
                        <input type="number" name="unit_price[${index}]" class="form-control compute-total price-input" value="${item_unit_price.toFixed(2)}" min="0" step="0.01">
                        <input type="hidden" name="total[${index}]" value="${total.toFixed(2)}" >
                    </td>
                    <td class="total-cell text-right">${total.toFixed(2)}</td>
                </tr>`;
    };

    function sectionAnimation(from = "create-button-order"){
        $("#purchase-order-form").hide();
        $("[name=purchase_order_id]").val("");
        // $("[name=supplier_id]").val("");
        switch (from) {
            case "cancel-btn-from-checklist":
                    $("#purchase-order-form").hide();
                    $("#line-items-container").hide();
                    $("#line-items-table-container").hide();
                break;
            case "proceed-btn-from-checklist":
                    $("#purchase-order-form").show();
                    $("#line-items-container").hide();
                    $("#line-items-table-container").show();
                break;
            case "cancel-btn-from-tablelist":
                    $("#purchase-order-form").show();
                    $("#line-items-container").show();
                    $("#line-items-table-container").hide();
                break;        
            case "edit-purchase-order":
                    $("#purchase-order-form").show();
                    $("#line-items-container").hide();
                    $("#line-items-table-container").show();
                break;                    
            default:
                $("#purchase-order-form").show();
                $("#line-items-container").show();
                $("#line-items-table-container").hide();
                break;
        }
    }

})