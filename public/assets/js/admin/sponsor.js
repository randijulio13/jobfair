$(function () {
    let selectedId;
    let formType;

    let table = $("#tableSponsor").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/admin/sponsor/datatables",
        },
        order: [[2, "asc"]],
        columns: [
            { data: "DT_RowIndex", orderable: false, class: "text-center" },
            { data: "logo", class: "text-center", orderable: false },
            { data: "name" },
            { data: "type", class: "text-center" },
            { data: "description" },
            { data: "status", class: "text-center" },
            { data: "aksi", orderable: false, class: "text-center" },
        ],
    });

    $(document).on("change", ".status-sponsor", function (e) {
        selectedId = $(this).parents("tr").attr("id");
        let status = $(this)[0].checked;
        $.ajax({
            type: "patch",
            dataType: "json",
            url: "/admin/sponsor/" + selectedId,
            data: {
                status,
            },
        }).catch((err)=>{
            table.ajax.reload()
            Swal.fire({
                icon:'error',
                title:'Error',
                message:err.responseJSON.message,
                timer:1500,
                showConfirmButton:false
            })
        });
    });

    $("#btnAdd").on("click", function (e) {
        e.preventDefault();
        $("#modalSponsor").modal("show");
        $("#username").parents("div.form-group").show();
        $("#btnSubmit").html("Submit");
        formType = "submit";
    });

    $("#modalSponsor").on("shown.bs.modal", function (e) {
        $("#name").focus();
    });

    $("#modalSponsor").on("hidden.bs.modal", function (e) {
        $("#formSponsor").trigger("reset");
        $(".is-invalid").removeClass("is-invalid");
    });

    $("#formSponsor").on("submit", function (e) {
        e.preventDefault();
        let data = new FormData(this);
        $(".is-invalid").removeClass("is-invalid");
        if (formType == "submit") {
            mySwalLoading()
            $.ajax({
                type: "post",
                url: "/admin/sponsor",
                data: data,
                enctype: "multipart/form-data",
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
            })
                .then((res) => {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    table.ajax.reload();
                    $("#modalSponsor").modal("hide");
                })
                .catch((err) => {
                    if (err.status == 422) {
                        Swal.close()
                        errorValidasi(err);
                    } else {
                        mySwal.fire({
                            title: "Error",
                            icon: "error",
                            text: err.responseJSON.message,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                });
        } else {
            mySwalLoading()
            $.ajax({
                type: "post",
                url: "/admin/sponsor/" + selectedId,
                data: data,
                enctype: "multipart/form-data",
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
            })
                .then((res) => {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    table.ajax.reload();
                    $("#modalSponsor").modal("hide");
                })
                .catch((err) => {
                    if (err.status == 422) {
                        errorValidasi(err);
                        Swal.close()
                    } else {
                        mySwal.fire({
                            title: "Error",
                            icon: "error",
                            text: err.responseJSON.message,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                });
        }
    });

    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();
        $("#btnSubmit").html("Update");
        selectedId = $(this).parents("tr").attr("id");
        formType = "update";
        $.get("/admin/sponsor/" + selectedId)
            .then((res) => {
                $("#name").val(res.data.name);
                $("#username").parents("div.form-group").hide();
                $("#type").val(res.data.type);
                $("#description").val(res.data.description);

                $("#modalSponsor").modal("show");
            })
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: err.responseJSON.message,
                    timer: 1500,
                    showConfirmButton: false,
                });
            });
    });
});
