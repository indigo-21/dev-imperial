$(function () {
    setTimeout(() => {
        $(".markup-input").trigger("change");
    }, 2000);

    $(document).on("click","#cost-plan-submit-button", function(e){
        $(".item-description").removeClass("is-invalid");
        e.preventDefault();
        let error_found = false;
        let form = $("#cost_plan_form");
        let submit_button = $(this);
        submit_button.attr("disabled", true);
        form.find("textarea.item-description").each((index, element)=>{
            let is_empty = $(element).val().trim() === "";
            let error_span = $(element).closest(".form-group").find(".item-description-error");
            if(is_empty){
                $(element).addClass("is-invalid");
                error_span.text("The item description field is required.");
                error_found = true;
            }else{
                error_span.text("");
            }
        });
        
        if(!error_found){
            let project_id = $("[name=project_id]").val();
            let data = { project_id, sections: [] };
            $(".section-container").each((index, section)=>{
                let section_id = $(section).attr("data-section");
                let section_code = $(section).find("[name=section_code]").val();
                let section_name = $(section).find("[name=section_name]").val();
                let section_markup = $(section).find("[name=section_markup]").val();
                let sections = {project_id, section_code, section_name, section_markup, items:[]};
                let section_items_container = $(section).find(".section-items");
                section_items_container.each((index, item_row)=>{
                    let item_code = $(item_row).find("[name=item_code]").val(); 
                    let description = $(item_row).find("[name=description]").val();
                    let quantity = $(item_row).find("[name=quantity]").val(); 
                    let unit = $(item_row).find("[name=unit]").val(); 
                    let rate = $(item_row).find("[name=rate]").val(); 
                    let cost = $(item_row).find("[name=cost]").val(); 
                    let total = $(item_row).find("[name=total]").val(); 
                    let mark_up = $(item_row).find("[name=mark_up]").val(); 
                    let supplier_id = $(item_row).find("[name=supplier_id]").val();
                    sections.items.push({item_code, description, quantity, unit, rate, cost, total, mark_up, supplier_id});
                });
                data.sections.push(sections);
            });
           $.ajax({
                url: form.attr("action"),
                method: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                dataType: 'json', 
                beforeSend: function(){
                    $(".preloader").show();
                },
                success: function(response){
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response["message"],
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            });
        }else{
            form.find(".is-invalid").first().focus();
            submit_button.attr("disabled", false);
        }
    });

    $(document).on("keyup, change", ".section-markup-input", function () {
        let this_val = parseFloat($(this).val() || 0);
        let parent = $(this).closest(".item-container").find(".section-card");
        parent.find(".markup-input").val(this_val);
        $(".markup-input").trigger("change");
    });

    $(document).on("keyup, change", ".item-input", function () {
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
        let unit_options = "";

        supplier_options = $(`[name="supplier_id"]`).first().find("option");
        supplier_options.each((option_index, option) => {
            supplier_options += `<option value="${option.value}">${option.label}</option>`;
        });

        unit_options = $(`[name="unit"]`).first().find("option");
        unit_options.each((option_index, option) => {
            unit_options += `<option value="${option.value}">${option.label}</option>`;
        });


        if(section_items.length > 0 ){
            section_items.each((index, section_item) => {
                $(this).attr("name", `[${this_section_length}][${index}]`);
                last_section_item = index + 1;
            }); 
        }

        let item_code_last = parseFloat(last_section_item) + 1;
        let item_code = `${parseFloat(this_section_length) + 1}.${item_code_last.toString().padStart(2, '0')}`;
        let html = `<div class="section-items">
                        <div class="form-group row mb-3 section-item-row">

                            <div class="col-md-6 d-flex">
                                <div class="short-input">
                                    <label>Code</label>
                                    <input type="text" name="item_code" class="form-control code-input"
                                        readonly value="${item_code}">
                                </div>

                                <div class="col">
                                    <label>Item Description</label>
                                    <textarea required name="description" class="form-control item-description"
                                        rows="10"></textarea>
                                    <input type="hidden" id="description" name="description" >
                                    <span class="text-danger item-description-error error"></span>
                                </div>

                            </div>

                            <div class="col-md-6 row">
                                <div class="col-12 row">
                                    <div class="col-md-2">
                                        <label>Qty</label>
                                        <input type="number" name="quantity"
                                            class="form-control calc-field item-input quantity-input" min="1"
                                            value="1">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Unit</label>
                                        <select name="unit" class="form-control">
                                            ${unit_options}
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Rate</label>
                                        <input type="number" step="0.01" name="rate"
                                            class="form-control calc-field item-input rate-input" value="0.00">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Cost</label>
                                        <input type="text" name="cost" value="0.00"
                                            class="form-control cost-output" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Total</label>
                                        <input type="text" name="total"
                                            class="form-control total-output" readonly value="0.00">
                                    </div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-md-4 mt-3">
                                        <label>Mark Up %</label>
                                        <input type="number" step="0.1" min="0" name="mark_up"
                                            class="form-control calc-field item-input markup-input" value="20">
                                    </div>
                                    <div class="col-md-8 mt-3">
                                        <label>Supplier</label>
                                        <select name="supplier_id" class="form-control select2bs4">
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

        if(section_items.length > 0){
            section_items.last().after(html);
        }else{
            parent.prepend(html);
        }

        let $newRow = parent.find('.section-items').last();
        $newRow.find('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: "Select Supplier",
            allowClear: true,
            width: '100%'
        });
        // ISSUE IN TEXTAREA
        // $("#cost_plan_form").append(`<input type="hidden" id="description[${this_section_length}][${last_section_item}]" name="description[${this_section_length}][${last_section_item}]" >`);

    });

    $(document).on("keyup",".item-description", function(){
        let this_val = $(this).val();
        let this_name = $(this).attr("name");
        $(this).html(this_val);
        // $(`[name="${this_name}"]`).val(this_val);
        $(this).val(this_val);
    });

    $(document).on("click", ".remove-row",  function(){
        let section_item = $(this).closest(".section-items");
        let parent_section = section_item.closest(".section-card");
        let section_id = parseFloat(parent_section.attr("data-section")) + 1;
        
        section_item.remove();

        parent_section.find(".code-input").each((index, element)=>{
            let item_index = parseFloat(index) + 1;
            let item_code = `${section_id}.${item_index.toString().padStart(2, '0')}`;
            let item_attr = `[${section_id}][${index}]`;
            $(element).val(item_code);
            $(element).attr("name", `item_code`);
        });

        parent_section.find(".markup-input").trigger("change");

    });

    $(document).on("click", ".remove-all-items", function(){
        $(this).closest(".card-footer").find("input").val("0.00");
        $(this).closest(".card-footer").find("input").val("0.00");
        let $button = $(this);
        let section_containter = $button.closest(".section-container");
        let sectionId = section_containter.find(".card-header").data("target");
        let $itemsSection = $(sectionId).find(".section-items");
        $itemsSection.hide(500, function () {
            $(this).remove();
        });
    });


    function compute_section_item(element) {
        let parent_card = element.closest(".section-container");
        let section_items = parent_card.find(".section-item-row");
        let cost_output = parent_card.find(".cost-output");
        let total_output = parent_card.find(".total-output");
        let subtotal_cost = 0;
        let subtotal_total = 0;

        section_items.each((index, item_row) => {
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


});