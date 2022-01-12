$(function () {
    let selectedId;
    let formType;

    let table = $("#tablePayment").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/admin/payment/datatables",
        },
        order: [[2, "asc"]],
        columns: [
            { data: "DT_RowIndex", class: "text-center", orderable: false },
            { data: "logo", orderable: false, class: "text-center" },
            { data: "name" },
            { data: "description" },
            { data: "status", class: "text-center", orderable: false },
            { data: "aksi", class: "text-center", orderable: false },
        ],
    });

    $(document).on("change", ".status-payment", function (e) {
        selectedId = $(this).parents("tr").attr("id");
        let status = $(this)[0].checked;
        $.ajax({
            type: "patch",
            dataType: "json",
            url: "/admin/payment/" + selectedId,
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

    $(document).on("click", ".btn-delete", async function (e) {
        e.preventDefault();
        selectedId = $(this).parents("tr").attr("id");
        let confirm = await mySwal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
        });
        if (confirm.isConfirmed) {
            try {
                let res = await $.ajax({
                    url: `/admin/payment/${selectedId}`,
                    type: "delete",
                    dataType: "json",
                });
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
                table.ajax.reload();
            } catch (err) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: err.responseJSON.message,
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });
            }
        }
    });

    $(document).on("click", ".btn-edit", async function (e) {
        e.preventDefault();
        selectedId = $(this).parents("tr").attr("id");
        formType = "update";
        try {
            let res = await $.get(`/admin/payment/${selectedId}`);
            let payment = res.data;
            setForm(payment);
            $("#modalPayment").modal("show");
        } catch (err) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: err.responseJSON.message,
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
        }
    });

    function setForm(data = null) {
        $("#modalPayment").trigger("reset");
        if (data == null) {
            $("#name").val("");
            $("#description").summernote("code", "");
        } else {
            $("#name").val(data.name);
            $("#description").summernote("code", data.description);
        }
    }

    $("#modalPayment").on("shown.bs.modal", function () {
        $("#name").focus();
    });

    $("#modalPayment").on("hidden.bs.modal", function () {
        setForm();
    });

    $("#formPayment").on("submit", async function (e) {
        e.preventDefault();
        let data = new FormData(this);
        let url =
            formType == "submit"
                ? "/admin/payment"
                : `/admin/payment/${selectedId}`;
        try {
            let res = await $.ajax({
                type: "post",
                url: url,
                data: data,
                enctype: "multipart/form-data",
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
            });
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: res.message,
                timer: 1500,
                showConfirmButton: false,
                timerProgressBar: true,
            });
            table.ajax.reload();
            $("#modalPayment").modal("hide");
        } catch (err) {
            if (err.status == 422) errorValidasi(err);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: err.responseJSON.message,
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
        }
    });

    $("#description").summernote("code", "");

    $("#btnAdd").on("click", function (e) {
        e.preventDefault();
        formType = "submit";
        $("#modalPayment").modal("show");
    });
});
