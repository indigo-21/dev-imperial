$(function () {
    const supplierSelect = document.getElementById("purchase_order_to_invoice");
    const tableContainer = document.getElementById("line-items-table-container");
    const tableBody = document.getElementById("line-items-table-body");
    // const submitInvoice = document.getElementById("proceed-btn-from-invoice");

    tableContainer.style.display = "none";

    // Updated sample static data
    const sampleItems = [
        {
            item: "2.08",
            description: "Provide small plant and access staging's",
            total: "310.00",
            po_number: "PO-00001",
            po_amount: "310.00"
        },
        {
            item: "2.08",
            description: "Provide small plant and access staging's",
            total: "310.00",
            po_number: "PO-00002",
            po_amount: "250.00"
        },
        {
            item: "2.09",
            description: "Provide temporary site offices and meeting facilities",
            total: "1,282.50",
            po_number: "PO-00003",
            po_amount: "950.00"
        },
        {
            item: "2.10",
            description: "Mobile communications",
            total: "500",
            po_number: "PO-00003",
            po_amount: "300.00"
        }
    ];

    // supplierSelect.addEventListener("change", async function () {
    //     const supplierId = this.value;

    //     if (supplierId) {

    //         const purchaseOrderItems = await getPoItems({ supplierId });

    //         tableBody.innerHTML = "";

    //         purchaseOrderItems.map((item, index) => {

    //             tableBody.innerHTML += `
    //                                     <tr class="invoice-row" purchase-order-id="${item.id}">
                                
    //                                         <td>${item.item_code}</td>
    //                                         <td>${item.description}</td>
    //                                         <td>${formatPO(item.purchase_order_id)}</td>
    //                                         <td>${currencyFormat(item.total)}</td>
                                            
    //                                         <td>${item.invoices_sum_invoice_amount ?? '0'}</td>
    //                                         <td> ${item.outstanding_amount} </td>
    //                                         <td>
    //                                             <a href="/projects/invoice-receipts/${item.id}" 
    //                                             class="btn btn-primary" target="_blank">
    //                                                 View Receipts
    //                                             </a>
    //                                         </td>
    //                                     </tr>
    //                                 `;
    //         });

    //         tableContainer.style.display = "block";
    //     } else {
    //         tableBody.innerHTML = "";
    //         tableContainer.style.display = "none";
    //     }
    // });

    // submitInvoice.addEventListener("click", async () => {   
        
    //     const payload = $(".invoice-row").map((index, element) => {
    //         const $row = $(element);

    //         return {
    //             purchaseOrderId: $row.attr("purchase-order-id"),
    //             invoiceNumber: $row
    //                 .find(`[name="invoice_number[${index}]"]`)
    //                 .val(),
    //             invoiceAmount: $row
    //                 .find(`[name="invoice_amount[${index}]"]`)
    //                 .val()
    //         };
    //     }).get();

    //     try {
    //         const response = await fetch(`${BASE_URL}/invoiced_items`, {
    //             method: "POST",
    //             headers: {
    //                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //                 "Content-Type": "application/json",
    //                 "Accept": "application/json"
    //             },
    //             body: JSON.stringify(payload)
    //         });

    //         if (!response.ok) {
    //             throw new Error(`Invoice submission failed: ${response.status}`);
    //         }

    //         const data = await response.json();

    //         Swal.fire({
    //             toast: true,
    //             position: "top-end",
    //             icon: response.ok && data.success ? "success" : "error",
    //             title: data.message ?? "Something went wrong.",
    //             showConfirmButton: false,
    //             timer: 3000,
    //             timerProgressBar: true
    //         });

    //         if (response.ok && data.success) {
    //             setTimeout(() => {
    //                 supplierSelect.dispatchEvent(new Event("change", { bubbles: true }));
    //             }, 2000);
    //         }

            
    //     } catch (error) {
    //         console.error("Unable to submit invoices:", error);
    //     }
    // });


    // Centralized Event Handlers
    const clickHandlers = {
        "#create-invoice-btn": () => sectionAnimation(),
        "#cancel-btn-from-invoice": () => sectionAnimation("cancel"),
    };

    Object.entries(clickHandlers).forEach(([selector, handler]) => {
        $(document).on("click", selector, handler);
    });


    // Purchase Order change
    $(document).on("change", "#purchase_order_to_invoice", async function () {

        const purchaseOrderId = $(this).val();

        if (!purchaseOrderId) {
        $("#line-items-table-body").html("");
        $("#line-items-table-container").hide();
            return;
        }

        await displayInvoiceLineItems(purchaseOrderId);

        $("#line-items-table-container").show();

    });

});


/* -----------------------------
    Section Animation
----------------------------- */

function sectionAnimation(from = "create-invoice-btn") {

    const form = $("#invoice-form");
    const table = $("#line-items-table-container");

    const purchaseOrderField = $("#purchase_order_to_invoice");

    // Reset
    form.hide();
    table.hide();

    const states = {

        "cancel": () => {
            // Nothing to show
        },

        "proceed": () => {
            form.show();
            table.show();
        }

    };


    if (states[from]) {

        states[from]();

    } else {

        // Create Invoice
        form.show();

        purchaseOrderField
            .attr("disabled", false)
            .val("");

        $("#line-items-table-body").html("");

    }
}


/* -----------------------------
    Proceed
----------------------------- */

async function proceedToTable() {

    const purchaseOrderId = $("#purchase_order_to_invoice").val();

    if (!purchaseOrderId) {

        Swal.fire({
            icon: "warning",
            title: "Purchase Order Required",
            text: "Please select a Purchase Order."
        });

        return;
    }

    await displayInvoiceLineItems(purchaseOrderId);

    $("#line-items-table-container").show();
}

/* -----------------------------
    Display PO Line Items
----------------------------- */

async function displayInvoiceLineItems(purchaseOrderId) {

    const tbody = $("#line-items-table-body");

    tbody.html(`
        <tr>
            <td colspan="7" class="text-center">
                Loading...
            </td>
        </tr>
    `);


    const items = await getPoItemsForInvoice({purchaseOrderId});


    if (!items || items.length === 0) {

        tbody.html(`
            <tr>
                <td colspan="7" class="text-center">
                    No Purchase Order items found.
                </td>
            </tr>
        `);

        return;
    }


    let html = "";


    items.forEach(function (item) {

        html += invoiceItemTableRow(item);

    });


    tbody.html(html);
}


/* -----------------------------
    Invoice Item Row
----------------------------- */

function invoiceItemTableRow(item) {

    return `
        <tr class="invoice-item" data-item-id="${item.id}">
            <td>
                ${item.item_code ?? ""}
            </td>

            <td>
                ${item.description ?? ""}
            </td>

            <td class="text-right">
                ${currencyFormat(item.po_amount ?? 0)}
            </td>

             <td class="text-right">
                ${currencyFormat(item.outstanding_amount ?? 0)}
            </td>

            <td class="text-right">
                   <input
                        type="number"
                        class="form-control form-control-sm invoice-amount"
                        data-item-id="${item.id}"
                        min="0"
                        max="${item.outstanding_amount ?? 0}"
                        step="0.01"
                        value="${item.invoice_amount ?? ''}"
                        placeholder="0.00"
                    >
            </td>

   

           

        </tr>
    `;
}


/* -----------------------------
    API Request
----------------------------- */

async function getPoItemsForInvoice({purchaseOrderId}) {

    console.log("getPoItemsForInvoice PO ID:", purchaseOrderId);


    try {

        const projectId = $("[name=project_id]").val();

        const res = await fetch(`${BASE_URL}/get_po_items_for_invoice`,{
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Content-Type": "application/json"
            },

            body: JSON.stringify({projectId, purchaseOrderId})

        });


        return await res.json();

    } catch (message) {

        console.error(message);

        return [];

    }

}

$(document).on("click", "#save-invoice-btn", async function () {

    const invoiceNumber = $("#invoice_number").val().trim();

    if (!invoiceNumber) {
        Swal.fire({
            icon: "warning",
            title: "Invoice Number Required",
            text: "Please enter an invoice number."
        });
        return;
    }

    const items = [];

    $(".invoice-item").each(function () {

        const row = $(this);
        const invoiceAmount = row.find(".invoice-amount").val();

        if (invoiceAmount !== "") {
            items.push({
                purchaseOrderItemId: row.data("item-id"),
                invoiceAmount: invoiceAmount
            });
        }
    });

    if (items.length === 0) {
        Swal.fire({
            icon: "warning",
            title: "Invoice Amount Required",
            text: "Please enter an invoice amount for at least one item."
        });
        return;
    }

    try {

        const response = await fetch(`${BASE_URL}/invoiced_items`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                invoiceNumber: invoiceNumber,
                items: items
            })
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.message ?? "Failed to save invoice.");
        }

        await Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: data.message,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        location.reload();

 

    } catch (error) {

        console.error("Unable to save invoice:", error);

        Swal.fire({
            icon: "error",
            title: "Unable to Save Invoice",
            text: error.message
        });
    }
});