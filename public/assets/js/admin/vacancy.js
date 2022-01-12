$(function () {
    let selectedId;

    let table = $("#tableLoker").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/admin/vacancy/datatables",
        },
        order: [[2, "asc"]],
        columns: [
            {
                data: "DT_RowIndex",
                class: "text-center",
                orderable: false,
                width: "1%",
            },
            {
                data: "sponsor_image",
                class: "text-center",
                orderable: false,
                width: "1%",
            },
            { data: "title" },
            { data: "career_field" },
            { data: "applicant",class:'text-center' },
            { data: "status", class: "text-center", orderable: false },
            { data: "aksi", orderable: false, class: "text-center" },
        ],
    });

    $("#modalVacancy").on("shown.bs.modal", function () {
        $("#title").focus();
    });

    $("#modalVacancy").on("hidden.bs.modal", function () {
        $("#formVacancy").trigger("reset");
        $(".is-invalid").removeClass("is-invalid");
    });

    $('#description').summernote({
        height:'100'
    })

    $("#formVacancy").on("submit", function (e) {
        e.preventDefault();
        let data = $(this).serialize();
        $.post("/admin/vacancy", data)
            .then((res) => {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false,
                });
                table.ajax.reload();
                $("#modalVacancy").modal("hide");
            })
            .catch((err) => {
                console.log(err);
                if (err.status == 422) {
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
    });

    $("#btnAdd").on("click", function (e) {
        e.preventDefault();
        $("#modalVacancy").modal("show");
    });

    $(document).on("change", ".status-vacancy", function (e) {
        selectedId = $(this).parents("tr").attr("id");
        let status = $(this)[0].checked;
        $.ajax({
            type: "patch",
            dataType: "json",
            url: "/admin/vacancy/status/" + selectedId,
            data: {
                status,
            },
        }).catch((err) => {
            table.ajax.reload();
            Swal.fire({
                icon: "error",
                title: "Error",
                message: err.responseJSON.message,
                timer: 1500,
                showConfirmButton: false,
            });
        });
    });
});
