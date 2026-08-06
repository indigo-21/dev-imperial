$(function () {
    const supplierSelect = document.getElementById("supplier_to_invoice");
    const tableContainer = document.getElementById("line-items-table-container");
    const tableBody = document.getElementById("line-items-table-body");
    const submitInvoice = document.getElementById("proceed-btn-from-invoice");

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

    supplierSelect.addEventListener("change", async function () {
        const supplierId = this.value;

        if (supplierId) {

            const purchaseOrderItems = await getPoItems({ supplierId });

            tableBody.innerHTML = "";

            purchaseOrderItems.map((item, index) => {
                tableBody.innerHTML += `
                                        <tr class="invoice-row" purchase-order-id="${item.id}">
                                
                                            <td>${item.item_code}</td>
                                            <td>${item.description}</td>
                                            <td>${formatPO(item.purchase_order_id)}</td>
                                            <td>${currencyFormat(item.total)}</td>
                                            <td>
                                            <input type="text" 
                                            class="form-control" 
                                            name="invoice_number[${index}]"
                                            placeholder="Enter invoice Number"
                                            value="${item.invoice_number ?? ''}">
                                            </td>
                                            <td>
                                                <input type="text" 
                                            class="form-control" 
                                            name="invoice_amount[${index}]"
                                            placeholder="Enter Invoice Amount" 
                                            value="${item.invoice_amount ?? ''}">
                                            </td>
                                        </tr>
                                    `;
            });

            tableContainer.style.display = "block";
        } else {
            tableBody.innerHTML = "";
            tableContainer.style.display = "none";
        }
    });

    submitInvoice.addEventListener("click", async () => {
        
        const payload = $(".invoice-row").map((index, element) => {
            const $row = $(element);

            return {
                purchaseOrderId: $row.attr("purchase-order-id"),
                invoiceNumber: $row
                    .find(`[name="invoice_number[${index}]"]`)
                    .val(),
                invoiceAmount: $row
                    .find(`[name="invoice_amount[${index}]"]`)
                    .val()
            };
        }).get();

        try {
            const response = await fetch(`${BASE_URL}/invoiced_items`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                throw new Error(`Invoice submission failed: ${response.status}`);
            }

            const data = await response.json();

            Swal.fire({
                toast: true,
                position: "top-end",
                icon: response.ok && data.success ? "success" : "error",
                title: data.message ?? "Something went wrong.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            if (response.ok && data.success) {
                setTimeout(() => {
                    supplierSelect.dispatchEvent(new Event("change", { bubbles: true }));
                }, 2000);
            }

            
        } catch (error) {
            console.error("Unable to submit invoices:", error);
        }
    });




});