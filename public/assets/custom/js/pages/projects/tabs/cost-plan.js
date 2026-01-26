$(function () {
    setTimeout(() => {
        $(".markup-input").trigger("change");
    }, 2000);

    $(document).on("keyup", ".section-markup-input", function () {
        let this_val = parseFloat($(this).val() || 0);
        let parent = $(this).closest(".item-container").find(".section-card");
        parent.find(".markup-input").val(this_val);
        $(".markup-input").trigger("change");
    });

    $(document).on("keyup", ".item-input", function () {
        compute_section_item($(this));
    });

    $(document).on("change", ".markup-input", function () {
        compute_section_item($(this));
    });

    $(document).on("click", ".add-section-item", function () {
        let parent = $(this).closest(".section-card");
        let this_section_length = parent.attr("data-section");
        let section_items = parent.find(".section-items");
        let last_section_item = 0;
        let supplier_options = "";

        section_items.each((index, section_item) => {
            supplier_options = "";
            $(this).attr("name", `[${this_section_length}][${index}]`);
            supplier_options = $(section_item).find(`[name="supplier_id[${this_section_length}][${index}]"] option`);
            supplier_options.each((option_index, option) => {
                supplier_options += `<option value="${option.value}">${option.label}</option>`;
            });
            last_section_item = index + 1;
        });

        let item_code_last = parseFloat(last_section_item) + 1;
        let item_code = `${parseFloat(this_section_length) + 1}.${item_code_last.toString().padStart(2, '0')}`;
        let html = `<div class="section-items">
                        <div class="form-group row mb-3 section-item-row">

                            <div class="col-md-6 d-flex">
                                <div class="short-input">
                                    <label>Code</label>
                                    <input type="text" name="item_code[${this_section_length}][${last_section_item}]" class="form-control code-input"
                                        readonly value="${item_code}">
                                </div>

                                <div class="col">
                                    <label>Item Description</label>
                                    <textarea required name="description[${this_section_length}][${last_section_item}]" class="form-control item-description"
                                        rows="10"></textarea>
                                    <input type="hidden" id="description[${this_section_length}][${last_section_item}]" name="description[${this_section_length}][${last_section_item}]" >
                                    <span class="text-danger error"></span>
                                </div>

                            </div>

                            <div class="col-md-6 row">
                                <div class="col-12 row">
                                    <div class="col-md-2">
                                        <label>Qty</label>
                                        <input type="number" name="quantity[${this_section_length}][${last_section_item}]"
                                            class="form-control calc-field item-input quantity-input" min="1"
                                            value="1">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Unit</label>
                                        <input type="text" name="unit[${this_section_length}][${last_section_item}]" class="form-control unit-input"
                                            value="item">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Rate</label>
                                        <input type="number" step="0.01" name="rate[${this_section_length}][${last_section_item}]"
                                            class="form-control calc-field item-input rate-input" value="0.00">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Cost</label>
                                        <input type="text" name="cost[${this_section_length}][${last_section_item}]" value="0.00"
                                            class="form-control cost-output" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Total</label>
                                        <input type="text" name="total[${this_section_length}][${last_section_item}]"
                                            class="form-control total-output" readonly value="0.00">
                                    </div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-md-4 mt-3">
                                        <label>Mark Up %</label>
                                        <input type="number" step="0.1" min="0" name="mark_up[${this_section_length}][${last_section_item}]"
                                            class="form-control calc-field item-input markup-input" value="20">
                                    </div>
                                    <div class="col-md-8 mt-3">
                                        <label>Supplier</label>
                                        <select name="supplier_id[${this_section_length}][${last_section_item}]" class="form-control select2bs4">
                                            ${supplier_options}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 row">
                                    <!-- Remove row button -->
                                    <div class="col-12 d-flex align-item-center justify-content-center py-3">
                                        <button type="button" class="btn btn-danger w-50 remove-row">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

        if(section_items){
            section_items.last().after(html);
        }else{
            section_items.append(html);
        }
        // ISSUE IN TEXTAREA
        // $("#cost_plan_form").append(`<input type="hidden" id="description[${this_section_length}][${last_section_item}]" name="description[${this_section_length}][${last_section_item}]" >`);

    });

    $(document).on("keyup",".item-description", function(){
        let this_val = $(this).val();
        let this_name = $(this).attr("name")
        $(this).html(this_val);
        $(`[name="${this_name}"]`).val(this_val);
    });



    function compute_section_item(element) {
        let parent_card = element.closest(".section-card");
        let section_items = parent_card.find(".section-item-row");
        let cost_output = parent_card.find(".cost-output");
        let total_output = parent_card.find(".total-output");
        let subtotal_cost = 0;
        let subtotal_total = 0;

        section_items.each((index, item_row) => {
            console.log(item_row);
            let this_element = $(item_row);
            let item_quantity = parseFloat(this_element.find(".quantity-input").val() || 0);
            let item_rate = parseFloat(this_element.find(".rate-input").val() || 0)
            let item_cost = item_quantity * item_rate;
            let item_markup = parseFloat(this_element.find(".markup-input").val() || 0);
            let markup_percentage = item_markup / 100;
            let item_total = (item_cost * markup_percentage) + item_cost
            this_element.find(".cost-output").val(item_cost.toFixed(2))
            this_element.find(".total-output").val(item_total.toFixed(2));
        });

        cost_output.each((index, cost_element) => {
            subtotal_cost += parseFloat($(cost_element).val() || 0);
        });

        total_output.each((index, total_element) => {
            subtotal_total += parseFloat($(total_element).val() || 0);
        });

        parent_card.find(".subtotal-cost").val(subtotal_cost.toFixed(2));
        parent_card.find(".subtotal-total").val(subtotal_total.toFixed(2));




    }



    function has_value(element) {

    }


});