@extends('pages.projects.form')
@section("purchase-orders-tab")
    <div class="card-header d-flex justify-content-between align-items-center">
        <button id="create-po-btn" type="button" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> &nbsp; Create Purchase Order
        </button>
    </div>

    <div class="card-body">

        <!-- TABLE: Existing Purchase Orders -->
        <div id="purchase-order-table">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Created By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PO-001</td>
                        <td>ABC Supplies Inc.</td>
                        <td>Christine Carillo</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div id="purchase-order-form" class="mt-3" style="display: none;">
        <div class="card border">
            <div class="card-header">
                <strong>Create Purchase Order</strong>
            </div>
    
            <div class="card-body">
                <form>

                    <div class="form-group">
                        <label for="po_number">PO Number</label>
                        <input
                            type="text"
                            id="po_number"
                            class="form-control"
                            value="PO-0001"
                            readonly
                        >
                    </div>
    
                    <div class="form-group">
                        <label for="supplier_id">Supplier</label>
                        <select id="supplier_id" class="form-control">
                            <option value="">-- Select Supplier --</option>
                            <option>ABC Supplies Inc.</option>
                            <option>Global Trading Co.</option>
                            <option>XYZ Construction Materials</option>
                        </select>
                    </div>

                    <!-- LINE ITEMS -->
                    <div id="line-items-container" style="display: none;">
                        <label class="font-weight-bold mb-2">Line Items</label>

                        <div id="line-items-list"></div>
                    </div>

                    <div id="line-items-table-container" style="display: none;" class="mt-4">

                        <label class="font-weight-bold mb-2">Purchase Order Line Items</label>
                    
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th width="120">Qty</th>
                                    <th width="150">Unit Price</th>
                                    <th width="150">Total</th>
                                </tr>
                            </thead>
                            <tbody id="line-items-table-body">
                            </tbody>
                        </table>
                    
                    </div>

                    <!-- ACTIONS -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" id="proceed-btn" class="btn btn-success btn-sm">
                            Proceed
                        </button>
                        <button type="button" id="cancel-po-btn" class="btn btn-secondary btn-sm ml-2">
                            Cancel
                        </button>
                    </div>
    

                </form>
            </div>
        </div>
    </div>

    <script>
        
        document.addEventListener('DOMContentLoaded', function () {

            const createBtn = document.getElementById('create-po-btn');
            const cancelBtn = document.getElementById('cancel-po-btn');
            const form = document.getElementById('purchase-order-form');
            const supplierSelect = document.getElementById('supplier_id');
            const lineItemsContainer = document.getElementById('line-items-container');
            const lineItemsList = document.getElementById('line-items-list');
        
            const lineItems = [
                { section_id: 2, item_code: '2.01', description: 'Full Time Site Manager' },
                { section_id: 2, item_code: '2.02', description: 'Working Site Supervisor' },
                { section_id: 2, item_code: '2.03', description: 'Saturday Out of hours working & deliveries (noise restrictions)' },
                { section_id: 2, item_code: '2.04', description: 'Sunday Out of hours working & deliveries (noise restrictions)' },
                { section_id: 2, item_code: '2.05', description: 'Attendant labour' },
            ];
        
            createBtn.addEventListener('click', function () {
                form.style.display = 'block';
            });
        
            cancelBtn.addEventListener('click', function () {
                form.style.display = 'none';
                supplierSelect.value = '';
                lineItemsContainer.style.display = 'none';
                lineItemsList.innerHTML = '';
            });
        
            supplierSelect.addEventListener('change', function () {
        
                lineItemsList.innerHTML = '';
        
                if (!this.value) {
                    lineItemsContainer.style.display = 'none';
                    return;
                }
        
                lineItemsContainer.style.display = 'block';
        
                lineItems.forEach(item => {
                    lineItemsList.innerHTML += `
                        <label class="d-flex align-items-center mb-2 selectable-label">
                            <div class="select-box mr-2" onclick="toggleBox(this)"></div>
                            <input type="hidden" name="line_items[]"
                                value="${item.section_id}|${item.item_code}|${item.description}"
                                disabled>
                            <span>
                                <strong>${item.item_code}</strong> — ${item.description}
                            </span>
                        </label>
                    `;
                });
            });
        
        });

        document.getElementById('proceed-btn').addEventListener('click', function () {

        const selectedInputs = document.querySelectorAll(
            '#line-items-list input[name="line_items[]"]:not([disabled])'
        );

        if (selectedInputs.length === 0) {
            alert('Please select at least one line item.');
            return;
        }

        const tableBody = document.getElementById('line-items-table-body');
        tableBody.innerHTML = '';

        selectedInputs.forEach(input => {
            const [sectionId, itemCode, description] = input.value.split('|');

            tableBody.innerHTML += `
                <tr>
                    <td><strong>${itemCode}</strong></td>
                    <td>${description}</td>
                    <td>
                        <input type="number" class="form-control qty-input" value="1" min="0">
                    </td>
                    <td>
                        <input type="number" class="form-control price-input" value="0" min="0" step="0.01">
                    </td>
                    <td class="total-cell">0.00</td>
                </tr>
            `;
        });

        // Hide selector, show table
        document.getElementById('line-items-container').style.display = 'none';
        document.getElementById('line-items-table-container').style.display = 'block';

        attachCalculationListeners();
        });

        function attachCalculationListeners() {
            document.querySelectorAll('.qty-input, .price-input').forEach(input => {
                input.addEventListener('input', function () {
                    const row = this.closest('tr');
                    const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                    const price = parseFloat(row.querySelector('.price-input').value) || 0;
                    const total = qty * price;

                    row.querySelector('.total-cell').textContent = total.toFixed(2);
                });
            });
        }
        
        function toggleBox(box) {
            box.classList.toggle('selected');
        
            const input = box.nextElementSibling;
            input.disabled = !box.classList.contains('selected');
        }
        </script>
@endsection
