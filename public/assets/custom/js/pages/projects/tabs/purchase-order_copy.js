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

    $(document).on("click", "#proceed-btn-from-checklist", async function () {
        let purchase_order_id = $(this).attr("purchaseorderid") ?? false;
        
        await sectionAnimation("proceed-btn-from-checklist");
        await getPurchaseOrderItems($(this));
        if(purchase_order_id){
            let line_item_tbody = $("#line-items-table-body");
             $(".cost-plan-item:checked").each((index, item) => {
                if( $(item).prop("disabled") != true  ){
                    let cost_plan_section_id = $(item).attr("data-section-id");
                    let item_code = $(item).attr("data-item-code");
                    let item_description = $(item).attr("data-item-description");
                    let item_quantity = $(item).attr("data-quantity");
                    let item_unit_price = parseFloat($(item).attr("data-unit-price") ?? 0);
                    let total = parseFloat(item_quantity ?? 0) * parseFloat(item_unit_price ?? 0);
                    // item_total_amount += parseFloat(total);
                    let data = {index, cost_plan_section_id, item_code,item_description,item_quantity,item_unit_price, total};
                    line_item_tbody.append(itemTableRow(data));
                }
            });
            
            $("[name=purchase_order_id]").val(purchase_order_id);
        }
        
    });

    $(document).on("click",".add-purchase-order-item-row", function(){
        let table_row = $(this).closest(".purchase-order-item");
        let data = {
            index: $(".purchase-order-item").length > 0 ? (parseFloat($(".purchase-order-item").length) + 1) : 1,
            cost_plan_section_id: table_row.find(".cost_plan_section_id").val(),
            item_code: table_row.find(".item_code").val(),
            is_sub_row: true
        };
        table_row.after(itemTableRow(data));
    });

    $(document).on("click", "#proceed-btn-from-tablelist", function(){
        
    });

    $(document).on("click",".view-purchase-order", function(){
        let purchase_order_element = $(this);
        sectionAnimation("view-purchase-order");
        getPurchaseOrderItems(purchase_order_element);
    });

    $(document).on("click",".edit-purchase-order", function(){
        let purchase_order_element = $(this);
        let is_edit = true;
        sectionAnimation("edit-purchase-order");
        getPurchaseOrderItems(purchase_order_element, is_edit);
    });

    function getCostPlanItems(supplier_id = false, existed_ids = []) {
        let line_item_container = $("#line-items-list");
        let project_id = $("[name=project_id]").val();
        $.ajax({
            headers: { 'X-CSRF-Token': CSRF_TOKEN },
            url: `${BASE_URL}/get_items_by_supplier`,
            type: 'POST',
            data: { project_id, supplier_id },
            dataType: 'json',
            beforeSend: function () {
                let html = `<span>Loading...</span>`;
                line_item_container.html(html);
            },
            success: function (response) {
                let html = "";
                response.map((item, index) => {
                    let is_checked = existed_ids.includes(item.item_code); 
                    html += `<label class="d-flex align-items-center mb-2 selectable-label">
                                    <input type="checkbox"
                                        class="cost-plan-item"
                                        data-section-id="${item.cost_plan_section_id}" 
                                        data-item-code="${item.item_code}" 
                                        data-item-description="${item.description}" 
                                        data-quantity="${item.quantity}" 
                                        data-unit-price="${item.rate}" ${is_checked ? 'checked disabled' : ''}
                                        data-item-total="${item.total}"
                                    >
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

    async function getPurchaseOrderItems(purchase_order_element = false, is_edit = false){
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
            await $.ajax({
                headers: {'X-CSRF-Token': CSRF_TOKEN},
                url:`${BASE_URL}/get_po_item`,
                type: 'POST',
                data:{purchase_order_id},
                dataType:'json',
                success:function(response){
                    let {purchase_order, purchase_order_items } = response;
                    let purchase_order_items_ids = [];
                    purchase_order_items.map((item, index)=>{
                        let data = {
                            index,
                            cost_plan_section_id:item.cost_plan_section_id,
                            item_code:item.item_code,
                            item_description:item.description,
                            item_quantity: item.quantity,
                            item_unit_price:item.unit_price,
                            total: item.total  
                        }
                        purchase_order_items_ids.push(item.item_code);
                        item_total_amount += parseFloat(item.total || 0)
                        html += itemTableRow(data);
                    });

                    if(is_edit){
                        let {id, supplier_id} = purchase_order;
                        $("#supplier_id").val(supplier_id).attr("disabled", true);
                        getCostPlanItems(supplier_id, purchase_order_items_ids);
                        $("#proceed-btn-from-checklist").attr("purchaseorderid", id);
                        // getCostPlanItems(supplier_id);
                        
                    }

                },
                error:function(xhr, status, error){
                    console.log(error);
                }
            })
        }else{
             $(".cost-plan-item:checked").each((index, item) => {
                if($(item).prop("disabled") != true){
                    let cost_plan_section_id = $(item).attr("data-section-id");
                    let item_code = $(item).attr("data-item-code");
                    let item_description = $(item).attr("data-item-description");
                    let item_quantity = $(item).attr("data-quantity");
                    let item_unit_price = parseFloat($(item).attr("data-unit-price") ?? 0);
                    let total = parseFloat(item_quantity ?? 0) * parseFloat(item_unit_price ?? 0);
                    item_total_amount += parseFloat(total);
                    let data = {index, cost_plan_section_id, item_code,item_description,item_quantity,item_unit_price, total};
                    html += itemTableRow(data);
                }
            });
        }
        
        // setTimeout(() => {
            // html += `tr>
            //             <td colspan="5">Total</td>
            //             <td class="text-right">${currencyFormat(item_total_amount)}</td>
            //         </tr>`;
            // line_item_tbody.html(html);
        // }, 2000);

        html += `tr>
                    <td colspan="5">Total</td>
                    <td class="text-right">${currencyFormat(item_total_amount)}</td>
                </tr>`;
        line_item_tbody.html(html);
    }

    function itemTableRow(data = {}){
        let {
            index, 
            cost_plan_section_id, 
            item_code, 
            item_description, 
            item_quantity, 
            item_unit_price, 
            total,
            is_sub_row
        } = data;   

        let section_code = item_code.split(".");
        let remove_row = `<button type="button" 
                                class="btn btn-danger remove-purchase-order-item-row my-2 w-100">
                                <i class="fas fa-minus"></i>
                            </button>`;
        let add_row = `<button type="button" 
                            class="btn btn-primary add-purchase-order-item-row my-2 w-100">
                            <i class="fas fa-plus"></i>
                        </button>`;

        return `<tr class="purchase-order-item">
                    <td style="width:5% !important;">
                        ${is_sub_row ? remove_row : ''}
                    </td>
                    <td>
                        <input type="hidden" class="section_code" name="section_code[${index}]" value="${section_code[0]}">
                        <input type="hidden" class="cost_plan_section_id" name="cost_plan_section_id[${index}]" value="${cost_plan_section_id}">
                        <input type="hidden" class="item_code" name="item_code[${index}]" value="${item_code}">
                        <strong>${item_code}</strong>
                        ${add_row}
                    </td>
                    <td style="width:63% !important;">
                        <textarea ${!is_sub_row ? 'disabled' : ''} name="item_description[${index}]" class="form-control item-description" rows="3">${item_description ?? '' }</textarea>
                    </td>
                    <td>
                        <input type="number" name="quantity[${index}]" class="form-control compute-total qty-input" value="${item_quantity ?? '0' }" min="0">
                    </td>
                    <td>
                        <input type="number" name="unit_price[${index}]" class="form-control compute-total price-input" value="${item_unit_price ? item_unit_price.toFixed(2) : '0.00' }" min="0" step="0.01">
                        <input type="hidden" name="total[${index}]" value="${total ? total.toFixed(2) : '0.00' }" >
                    </td>
                    <td class="total-cell text-right">${total ? total.toFixed(2) : '0.00' }</td>
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
            case "view-purchase-order":
                    $("#purchase-order-form").show();
                    $("#line-items-container").hide();
                    $("#line-items-table-container").show();
                break;
            case "edit-purchase-order":
                    $("#purchase-order-form").show();
                    $("#line-items-container").show();
                    $("#line-items-table-container").hide();
                break;                    
            default:
                $("#purchase-order-form").show();
                $("#line-items-container").show();
                $("#line-items-table-container").hide();
                break;
        }
    }

})