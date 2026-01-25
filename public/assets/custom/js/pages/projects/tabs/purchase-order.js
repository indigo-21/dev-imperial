$(function () {

    $(document).on("click", "#create-po-btn", function () {
        $("#purchase-order-form").show();
        $("#line-items-container").hide();
        $("#line-items-table-container").hide();
    });

    $(document).on("click", "#cancel-btn-from-checklist", function () {
        $("#line-items-container").hide();
        $("#purchase-order-form").hide();

    });

    $(document).on("click", "#cancel-btn-from-tablelist", function () {
        $("#line-items-table-container").hide();
        $("#line-items-container").show();
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
        let total = parseFloat(quantity * rate);
        table_row.find("[name=total]").val(total.toFixed(2));
        table_row.find(".total-cell").text(total.toFixed(2));
    });

    $(document).on("click", "#proceed-btn-from-checklist", function () {
        getPurchaseOrderItems();
    });

    $(document).on("click",".edit-purchase-order", function(){
        let purchase_order_id = $(this).attr("data-purchase-order-id");
        getPurchaseOrderItems(purchase_order_id);
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
                $("#line-items-container").show();
                $("#line-items-table-container").hide();
                let html = `<span>Loading...</span>`;
                line_item_container.html(html);
            },
            success: function (response) {
                let html = "";
                response.map((item, index) => {
                    html += `<label class="d-flex align-items-center mb-2 selectable-label">
                                    <input type="checkbox"
                                        class="cost-plan-item" 
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

    function getPurchaseOrderItems(purchase_order_id = false){
        $("#line-items-container").hide();
        $("#line-items-table-container").show();
        let html = "";
        let line_item_tbody = $("#line-items-table-body");
        let loading_screen = `<tr><td class="text-center" colspan="5"><span>Loading...</span></td></tr>`;
        line_item_tbody.html(loading_screen);

        if(purchase_order_id){
            $("[name=purchase_order_id]").val(purchase_order_id);
            $.ajax({
                headers: {'X-CSRF-Token': CSRF_TOKEN},
                url:`${BASE_URL}/get_po_item`,
                type: 'POST',
                data:{purchase_order_id},
                dataType:'json',
                success:function(response){
                    console.log(response);
                    response.map((item, index)=>{
                        let data = {
                            index,
                            item_code:response.item_code,
                            item_description:response.description,
                            item_quantity: response.quantity,
                            item_unit_price:response.unit_price,
                            total: response.total  
                        }
                        html += itemTableRow(data);
                    })
                    
                },
                error:function(xhr, status, error){
                    console.log(error);
                }
            })
        }else{
            $(".cost-plan-item:checked").each((index, item) => {
                let item_code = $(item).attr("data-item-code");
                let item_description = $(item).attr("data-item-description");
                let item_quantity = $(item).attr("data-quantity");
                let item_unit_price = parseFloat($(item).attr("data-unit-price") ?? 0);
                let total = parseFloat(item_quantity ?? 0) * parseFloat(item_unit_price ?? 0);
                let data = {index,item_code,item_description,item_quantity,item_unit_price, total};
                html += itemTableRow(data);
            });
        }

         setTimeout(() => {
            line_item_tbody.html(html);
        }, 2000);
    }

    function itemTableRow(data = {}){
        let {
            index, item_code, item_description, item_quantity, item_unit_price, total
        } = data;

        return `<tr>
                    <td>
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
                    <td class="total-cell">${total.toFixed(2)}</td>
                </tr>`;
    };

})