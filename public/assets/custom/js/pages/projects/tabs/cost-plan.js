$(function(){
   setTimeout(() => {
        $(".markup-input").trigger("change");
   }, 2000);

    $(document).on("keyup", ".section-markup-input", function(){
        let this_val = parseFloat($(this).val() || 0);
        let parent = $(this).closest(".item-container").find(".section-card");
        parent.find(".markup-input").val(this_val);
        $(".markup-input").trigger("change");
    });

    $(document).on("keyup", ".item-input", function(){
        compute_section_item($(this));
    });

    $(document).on("change",".markup-input", function(){
        compute_section_item($(this));
    });



    function compute_section_item(element){
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
            let item_rate =  parseFloat(this_element.find(".rate-input").val() || 0)
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