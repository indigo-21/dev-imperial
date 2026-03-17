$(function(){
    $(document).on("click", "#create-po-btn", function () {
        sectionAnimation();
    });

    $(document).on("click", "#cancel-btn-from-checklist", function () {
       sectionAnimation("cancel-btn-from-checklist");
    });

    $(document).on("click", "#proceed-btn-from-checklist", function () {
        sectionAnimation("proceed-btn-from-checklist");
        displayLineItems();
    });

    $(document).on("click", "#cancel-btn-from-tablelist", function () {
       sectionAnimation("cancel-btn-from-tablelist");
    });

    $(document).on("change", "#supplier_id", function () {
        let supplier_id = $(this).val();
        $("[name=supplier_id]").val(supplier_id);
        displaySupplierItems(supplier_id);
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

        updateNameAttrLineItems();
    });

    $(document).on("click", ".remove-purchase-order-item-row", function(){
        let table_row = $(this).closest(".purchase-order-item");
        table_row.hide(()=>{
            table_row.remove();
            updateNameAttrLineItems();
        })
    });

    $(document).on("keyup", ".compute-total", function () {
        let table_row = $(this).closest(".purchase-order-item");
        let quantity_element = table_row.find(".qty-input").val() != "" ? table_row.find(".qty-input").val() : 0;
        let rate_element = table_row.find(".price-input").val() != "" ? table_row.find(".price-input").val() : 0;
        let quantity = parseFloat(quantity_element ?? 0);
        let rate = parseFloat(rate_element ?? 0);
        let total = parseFloat(quantity * rate) ?? 0;
        table_row.find("[name=total]").val(currencyFormat(total));
        table_row.find(".total-cell").text(currencyFormat(total));

        updateNameAttrLineItems();
    });

});

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

async function displaySupplierItems(supplier_id, existed_ids = []){
    let line_item_container = $("#line-items-list");
    let html = "<span>Loading...</span>";
    let cost_plan_items = await getSupplierItems(supplier_id);
    line_item_container.html(html);

    if(cost_plan_items){
        html = "";
        cost_plan_items.map((cost_plan_item, index)=>{
            let is_checked = existed_ids.includes(cost_plan_item.item_code); 
            html += `
                        <label class="d-flex align-items-center mb-2 selectable-label">
                            <input type="checkbox"
                                class="cost-plan-item"
                                data-section-id="${cost_plan_item.cost_plan_section_id}" 
                                data-item-code="${cost_plan_item.item_code}" 
                                data-item-description="${cost_plan_item.description}" 
                                data-quantity="${cost_plan_item.quantity}" 
                                data-unit-price="${cost_plan_item.rate}" ${is_checked ? 'checked disabled' : ''}
                                data-item-total="${cost_plan_item.total}"
                            >
                            <span class="mx-2">
                                <strong>${cost_plan_item.item_code}</strong> — ${cost_plan_item.description}
                            </span>
                        </label>
                    `;
        }); 

        setTimeout(() => {
            line_item_container.html(html);
        }, 2000);
    }
}

async function displayLineItems(){
    let html = "";
    let line_item_tbody = $("#line-items-table-body");
    let loading_screen = `<tr><td class="text-center" colspan="5"><span>Loading...</span></td></tr>`;
    line_item_tbody.html(loading_screen);
    let item_total_amount = 0;

    $(".cost-plan-item").each((index, item) => {
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

    setTimeout(() => {
        html += `tr>
                <td colspan="5">Total</td>
                <td class="text-right total-table">${currencyFormat(item_total_amount)}</td>
            </tr>`;
        line_item_tbody.html(html); 
    }, 1500);
    
} 

async function getSupplierItems(supplier_id = false) {
    let project_id = $("[name=project_id]").val();
    try {
        const response = await fetch(`${BASE_URL}/get_items_by_supplier`, {
            method: "POST",
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                 project_id, supplier_id
            })
        });

        let html = "";
        let result = await response.json();
        return result;
    } catch (error) {
        console.log(error);
    }

}

async function getPurchaseOrderItems(purchase_order_id = false){
    try {
        const response = await fetch(`${BASE_URL}/get_po_item`,{
            method: "POST",
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ purchase_order_id })
        }).json();
        return response;
    } catch (error) {
        console.log(error);
    }
}

function itemTableRow(data = {}){
    let {
            index = 0, 
            cost_plan_section_id = null, 
            item_code = "", 
            item_description = "", 
            item_quantity = 0, 
            item_unit_price = 0, 
            total = 0,
            is_sub_row = false
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
                    <textarea ${!is_sub_row ? 'disabled' : ''} name="item_description[${index}]" class="form-control item_description" rows="3">${item_description ?? '' }</textarea>
                </td>
                <td>
                    <input type="number" name="quantity[${index}]" class="form-control compute-total qty-input quantity" value="${item_quantity ?? '0' }" min="0">
                </td>
                <td>
                    <input type="number" name="unit_price[${index}]" class="form-control compute-total price-input unit_price" value="${item_unit_price ? item_unit_price.toFixed(2) : '0.00' }" min="0" step="0.01">
                    <input type="hidden" name="total[${index}]" value="${total ? total.toFixed(2) : '0.00' }" >
                </td>
                <td class="total-cell text-right">${total ? total.toFixed(2) : '0.00' }</td>
            </tr>`;
};

function updateNameAttrLineItems(){
    let grand_total = 0;

    $(".purchase-order-item").each((index, element) => {
        let total_row_cell = $(element).find(".total-cell").text();
        grand_total += parseFloat(total_row_cell ?? "0");
        $(element).find(".section_code").attr("name", `section_code[${index}]`);
        $(element).find(".cost_plan_section_id").attr("name", `cost_plan_section_id[${index}]`);
        $(element).find(".item_code").attr("name", `item_code[${index}]`);
        $(element).find(".item_description").attr("name", `item_description[${index}]`);
        $(element).find(".quantity").attr("name", `quantity[${index}]`);
        $(element).find(".unit_price").attr("name", `unit_price[${index}]`);
    });

    $(".total-table").text(currencyFormat(grand_total));
}

function getPurchaseOrderLineItems(){
    let data = {};
    let purchase_order_items = $(".purchase-order-item");

    purchase_order_items.each()

}
function upsertPurchaseOrderItem(){
    
}