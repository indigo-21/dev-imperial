$(function(){
    $(document).on("click",".form-btn-cancel", function(){
        $(`[name=project_file_id]`).val('');
        $("#upload_btn").text("Submit");
    });

    $(document).on("click",".edit-document", function(){
        let project_file_id = $(this).attr("data-project-id");
        let description = $(this).closest(".project-file-row").find(".project-file-description").text();
        $(`[name=project_file_id]`).val(project_file_id);
        $("[name=description]").val(description);
        $("#upload_btn").text("Update");
    }); 

});