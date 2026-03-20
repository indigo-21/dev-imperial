$(function () {

    // Centralized Event Handlers
    const clickHandlers = {
        "#create-po-btn": () => sectionAnimation(),
        "#cancel-btn-from-checklist": () => sectionAnimation("cancel-btn-from-checklist"),
        "#proceed-btn-from-checklist": proceedToTable,
        "#cancel-btn-from-tablelist": () => sectionAnimation("cancel-btn-from-tablelist"),
        ".add-purchase-order-item-row": handleAddRow,
        ".remove-purchase-order-item-row": handleRemoveRow,
        "#proceed-btn-from-tablelist": () => handleUpsertValiadtion(),
        ".edit-purchase-order": handleEdit,
    };

    Object.entries(clickHandlers).forEach(([selector, handler]) => {
        $(document).on("click", selector, handler);
    });

    // Supplier change
    $(document).on("change", "#supplier_id", function () {
        const supplierId = $(this).val();
        $("[name=supplier_id]").val(supplierId);
        displaySupplierItems(supplierId);
    });

    // Recompute totals
    $(document).on("keyup", ".compute-total", handleRecomputeTotal);
});

let LIMIT_COST = [];

/* -----------------------------
    Row Add / Remove
----------------------------- */

function handleAddRow() {
    const tableRow = $(this).closest(".purchase-order-item");
    const index = $(".purchase-order-item").length + 1;

    const data = {
        index,
        cost_plan_section_id: tableRow.find(".cost_plan_section_id").val(),
        item_code: tableRow.find(".item_code").val().toString(),
        is_sub_row: true
    };

    tableRow.after(itemTableRow(data));
    updateNameAttrLineItems();
}

function handleRemoveRow() {
    const row = $(this).closest(".purchase-order-item");
    row.fadeOut(150, () => {
        row.remove();
        updateNameAttrLineItems();
    });
}

/* -----------------------------
    Compute Totals
----------------------------- */

function handleRecomputeTotal() {
    const row = $(this).closest(".purchase-order-item");
    const qty = parseFloat(row.find(".qty-input").val()) || 0;
    const rate = parseFloat(row.find(".price-input").val()) || 0;
    const total = qty * rate;
    
    row.find("[name=total]").val(total.toFixed(2));
    row.find(".total-cell").text(total.toFixed(2));
    
    updateNameAttrLineItems();
    
    
}

/* -----------------------------
    Handling Proceed to Display in Table
----------------------------- */
async function proceedToTable(){
    const isFromEdit = $(this).attr("data-is-from-edit");
    const supplierId = $("#supplier_id").val();
    sectionAnimation("proceed-btn-from-checklist");
    displayLineItems();
    $("#proceed-btn-from-checklist").attr("data-is-from-edit", isFromEdit);
    $("[name=supplier_id]").val(supplierId);
}
/* -----------------------------
    Handling Edit Button from the table
----------------------------- */

async function handleEdit(){
    const purchaseOrderId = $(this).attr("data-purchase-order-id");
    const supplierId = $(this).attr("data-supplier-id");
    sectionAnimation("edit-purchase-order");
    await displaySupplierItems(supplierId, purchaseOrderId);

    $("#supplier_id").attr("disabled", true);
    $("#proceed-btn-from-checklist").attr("data-is-from-edit", true);

    $("#supplier_id").val(supplierId);
    $("[name=purchase_order_id]").val(purchaseOrderId);
}

/* -----------------------------
    Section Animation
----------------------------- */

function sectionAnimation(from = "create-button-order") {
    const form = $("#purchase-order-form");
    const list = $("#line-items-container");
    const table = $("#line-items-table-container");

    const supplierField = $("#supplier_id");
    const itemList = $("#line-items-list");

    // reset
    form.hide();
    list.hide();
    table.hide();
    // $("[name=purchase_order_id]").val("");
    
    const states = {
        "cancel-btn-from-checklist": () => {},
        "proceed-btn-from-checklist": () => { form.show() & table.show()},
        "cancel-btn-from-tablelist": () => form.show() & list.show(),
        "view-purchase-order": () => table.show(),
        "edit-purchase-order": () => { form.show() & list.show() }
    }; 
    
    (states[from] ?? ( () => {
                                    form.show();
                                    list.show();
                                    supplierField.attr("disabled", false);
                                    supplierField.val("");
                                    itemList.html("");
                                }) 
    ) ();

}

/* -----------------------------
    Fetch & Display Supplier Items
----------------------------- */

async function displaySupplierItems(supplierId, purchaseOrderId = false) {
    const poItems = await getPoItems({supplierId, purchaseOrderId});
    const existItemCode = poItems.map( item => { return item.item_code } );

    const container = $("#line-items-list");
    container.html("<span>Loading...</span>");

    const items = await getSupplierItems(supplierId);
    if (!items) return container.html("<span>No items found.</span>");

    const html = items
        .map(item => {
            const checked = existItemCode.includes(item.item_code) ? "checked disabled" : "";
            return `
                <label class="d-flex align-items-center mb-2 selectable-label">
                    <input type="checkbox"
                        class="cost-plan-item"
                        data-section-id="${item.cost_plan_section_id}" 
                        data-item-code="${item.item_code}" 
                        data-item-description="${item.description}" 
                        data-quantity="${item.quantity}" 
                        data-unit-price="${item.rate}"
                        data-item-total="${item.total}"
                        ${checked}
                    >
                    <span class="mx-2">
                        <strong>${item.item_code}</strong> — ${item.description}
                    </span>
                </label>`;
        })
        .join("");

    container.html(html);
}

/* -----------------------------
    Display Selected Line Items
----------------------------- */

async function displayLineItems() {
    const isFromEdit = $("#proceed-btn-from-checklist").attr("data-is-from-edit");
    const tbody = $("#line-items-table-body");
    
    let countRow = 0;

    tbody.html(`<tr><td colspan="5" class="text-center">Loading...</td></tr>`);

    let totalAmount = 0;
    const dataItem = [];
    let html = "";

    if(isFromEdit){
        const supplierId = $("#supplier_id").val();
        const purchaseOrderId = $("[name=purchase_order_id]").val();
        const poItems = await getPoItems({supplierId, purchaseOrderId});
        
        poItems.map( item => {
            const qty = item.quantity;
            const price = item.unit_price;
            const data = {
                index: countRow,
                cost_plan_section_id: item.cost_plan_section_id,
                item_code: item.item_code,
                item_description: item.description,
                item_quantity: qty,
                item_unit_price: price,
                total: qty * price
            };

            totalAmount += data.total;
            
            dataItem.push(data);

            countRow++;
        });
        
    }

    $(`.cost-plan-item:not(:disabled):checked`).each((i, item) => {
        const el = $(item);
        const qty = parseFloat(el.data("quantity")) || 0;
        const price = parseFloat(el.data("unit-price")) || 0;

        const data = {
            index: countRow,
            cost_plan_section_id: el.data("section-id"),
            item_code: el.data("item-code").toString(),
            item_description: el.data("item-description"),
            item_quantity: qty,
            item_unit_price: price,
            total: qty * price
        };

        totalAmount += data.total;
        // html += itemTableRow(data);

        dataItem.push(data);

        countRow++;
    });

    const sortedItems = dataItem.sort((a, b) => {
                            let [a1, a2] = a.item_code.split('.').map(Number);
                            let [b1, b2] = b.item_code.split('.').map(Number);

                            return a1 - b1 || a2 - b2;
                        });
                        
    sortedItems.map(item => {
        html += itemTableRow(item);
    })
    
    html += `
        <tr>
            <td colspan="5">Total</td>
            <td class="total-table text-right">${currencyFormat(totalAmount)}</td>
        </tr>`;

    tbody.html(html);
}

/* -----------------------------
    Row Template
----------------------------- */

function itemTableRow({
    index = 0,
    cost_plan_section_id = "",
    item_code = "",
    item_description = "",
    item_quantity = 0,
    item_unit_price = 0,
    total = 0,
    is_sub_row = false
}) {
    const sectionCode = item_code && item_code.split(".")[0];

    return `
        <tr class="purchase-order-item">
            <td style="width:5%">
                ${is_sub_row ? `<button type="button" class="btn btn-danger remove-purchase-order-item-row my-2 w-100">
                    <i class="fas fa-minus"></i>
                </button>` : ""}
            </td>

            <td>
                <input type="hidden" class="section_code" name="section_code[${index}]" value="${sectionCode}">
                <input type="hidden" class="cost_plan_section_id" name="cost_plan_section_id[${index}]" value="${cost_plan_section_id}">
                <input type="hidden" class="item_code" name="item_code[${index}]" value="${item_code}">
                <strong>${item_code}</strong>

                <button type="button" class="btn btn-primary add-purchase-order-item-row my-2 w-100">
                    <i class="fas fa-plus"></i>
                </button>
            </td>

            <td style="width:63%">
                <textarea name="item_description[${index}]" class="form-control item_description" rows="3">${item_description ?? ""}</textarea>
            </td>

            <td>
                <input type="number" name="quantity[${index}]" class="form-control compute-total qty-input quantity"
                    value="${item_quantity}" min="0">
            </td>

            <td>
                <input type="number" name="unit_price[${index}]" class="form-control compute-total price-input unit_price"
                    value="${item_unit_price.toFixed(2)}" min="0" step="0.01">
                <input type="hidden" name="total[${index}]" value="${total.toFixed(2)}">
            </td>

            <td class="total-cell text-right">${total.toFixed(2)}</td>
        </tr>`;
}

/* -----------------------------
    Update Attributes + Grand Total
----------------------------- */

function updateNameAttrLineItems() {
    let grandTotal = 0;

    $(".purchase-order-item").each((i, row) => {
        const el = $(row);

        grandTotal += parseFloat(el.find(".total-cell").text()) || 0;

        el.find(".section_code").attr("name", `section_code[${i}]`);
        el.find(".cost_plan_section_id").attr("name", `cost_plan_section_id[${i}]`);
        el.find(".item_code").attr("name", `item_code[${i}]`);
        el.find(".item_description").attr("name", `item_description[${i}]`);
        el.find(".quantity").attr("name", `quantity[${i}]`);
        el.find(".unit_price").attr("name", `unit_price[${i}]`);
    });

    $(".total-table").text(currencyFormat(grandTotal));
}

/* -----------------------------
   Getting Line Item in Table
----------------------------- */

function getUpsertPayload(){
    const projectId = $("[name=project_id]").val();
    const purchaseOrderId = $("[name=purchase_order_id]").val();
    const supplierId = $("[name=supplier_id]").val();


    let data = { projectId, purchaseOrderId, supplierId, items: [] };
    $(".purchase-order-item").each((i, row) =>{
        const el = $(row);

        const item = {
            section_code: el.find(".section_code").val(),
            cost_plan_section_id: el.find(".cost_plan_section_id").val(),
            item_code: el.find(".item_code").val(),
            item_description: el.find(".item_description").val(),
            quantity: el.find(".quantity").val(),
            unit_price: el.find(".unit_price").val(),
        }

        data.items.push(item);
    });

    return data;
}


/* -----------------------------
    API Requests
----------------------------- */

async function getSupplierItems(supplierId) {
    const projectId = $("[name=project_id]").val();
    LIMIT_COST = [];
    try {
        const res = await fetch(`${BASE_URL}/get_items_by_supplier`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ project_id: projectId, supplier_id: supplierId })
        });
        const result = await res.json();
        result.map((item, i)=>{
            const tmp = {
                                item_code: item.item_code,
                                cost_limit: parseFloat(item.rate ?? 0)
                            };
            LIMIT_COST.push(tmp)
        });
        return result;
    } catch (err) {
        console.error(err);
        return [];
    }
}

async function handleUpsertValiadtion(){
    const row  = $(".purchase-order-item");

    let hasWarning = false;
    
    LIMIT_COST.map((item, i) => {
        const itemCode = item.item_code;
        const costLimit = parseFloat(item.cost_limit ?? 0);

        let rowTotal = 0;

        row.find(`[value='${itemCode}']`).each((rowIndex, rowItem) =>{
            const tableRow = $(rowItem).closest(".purchase-order-item");
            const total = tableRow.find(".total-cell").html() == NaN ? "0" : tableRow.find(".total-cell").html().trim();

            rowTotal += parseFloat(total);
        });

        if(rowTotal > costLimit){
            row.find(`[value='${itemCode}']`).each((rowIndex, rowItem) =>{
                const tableRow = $(rowItem).closest(".purchase-order-item");
                const unitPrice = tableRow.find(".unit_price");

                unitPrice.addClass("is-invalid");

            });
            
            hasWarning = true;
        }

    });

    if(hasWarning){
        swal({
                title: "Warning!",
                text: "Item total exceed Item Cost in Cost Plan.",
                icon: "warning",
                buttons: {
                    proceed: "Proceed",
                    cancel: "See Items",
                },
                dangerMode: true,
                })
                .then((value) => {
                if (value == "proceed") {
                    upsert();
                    // swal("Poof! Your imaginary file has been deleted!", {
                    //     icon: "success",
                    // });
                } else {
                    swal("Please see red fields.");
                }
        });
    }
    
    

    // $(".purchase-order-item").find(`[value='${itemCode}']`).each((i, item) =>{

    // });
}

async function upsert() {

    const payload = getUpsertPayload();

    try {
        const res = await fetch(`${BASE_URL}/projects/purchase_order_upsert`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        });

        const message =  await res.json();

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: message,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        setTimeout(() => {
            window.location.reload();
        }, 2000);

    } catch (err) {
        console.error(err);
        return [];
    }
}

async function getPoItems({supplierId, purchaseOrderId = false}){
    try {
        const projectId = $("[name=project_id]").val();

        const res = await fetch(`${BASE_URL}/get_po_item`,{
            method:"POST",
            headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        "Content-Type": "application/json"
                    },
            body:JSON.stringify({projectId, supplierId, purchaseOrderId})
        });
        return res.json();

    } catch (message) {
        console.error(message);
        return [];
    }
}