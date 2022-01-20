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
            {
                data: "image",
                class: "text-center",
                orderable: false,
                width: "1%",
            },
            { data: "title" },
            { data: "fields" },
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

    $("#description").summernote({
        height: "100",
    });

    $("#sponsor_id").select2({
        dropdownParent: $("#modalVacancy"),
        width: "100%",
        theme: "bootstrap4",
        minimumInputLength: 1,
        allowClear: true,
        placeholder: "Pilih Sponsor",
        ajax: {
            url: "/admin/sponsor/select2",
            dataType: "json",
            delay: 250,
            cache: true,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                        };
                    }),
                };
            },
        },
    });

    $("#formVacancy").on("submit", function (e) {
        e.preventDefault();

        let data = new FormData(this);
        mySwalLoading();
        $.ajax({
            type: "post",
            url: "/admin/vacancy",
            data: data,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
        })
            .then((res) => {
                mySwal.fire({
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
                if (err.status == 422) {
                    Swal.close();
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
