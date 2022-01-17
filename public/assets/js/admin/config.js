$(function () {
    let selectedId

    $("#formConfig").on("submit", async function (e) {
        e.preventDefault();
        let data = $(this).serialize();
        try {
            let update = await $.ajax({
                url: "/admin/config",
                type: "patch",
                dataType: "json",
                data,
            });

            Swal.fire({
                icon: "success",
                timer: 2000,
                title: "Berhasil",
                text: "Konfigurasi berhasil diperbarui",
                showConfirmButton: false,
                timerProgressBar: true,
            });
        } catch (err) {
            Swal.fire({
                icon: "error",
                timer: 3000,
                title: "Error",
                text: err.responseJSON.message,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        }
    });

    $(document).on("change", ".status-banner", function (e) {
        selectedId = $(this).parents("tr").attr("id");
        let status = $(this)[0].checked;
        $.ajax({
            type: "patch",
            dataType: "json",
            url: "/admin/config/banner/" + selectedId,
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

    $("#formBanner").on("submit", async function (e) {
        e.preventDefault();
        let data = new FormData(this);
        try {
            mySwalLoading();
            let res = await $.ajax({
                type: "post",
                url: "/admin/config",
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
            $('#formBanner').trigger('reset')
            $('.is-invalid').removeClass('is-invalid')
            $('#modalBanner').modal('hide')
        } catch (err) {
            if (err.status == 422) {
                errorValidasi(err);
                Swal.close();
            } else {
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

    $("#addBanner").on("click", function (e) {
        e.preventDefault();
        $("#modalBanner").modal("show");
    });

    $(document).on("click", ".btn-hapus", function (e) {
        selectedId = $(this).parents("tr").attr("id");
        mySwal
            .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: `/admin/config/banner/${selectedId}`,
                        dataType: "json",
                    }).then((res) => {
                        mySwal.fire({
                            title: "Berhasil",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false,
                            text: res.message,
                        });
                        table.ajax.reload()
                    }).catch((err)=>{
                        mySwal.fire({
                            title: "Gagal",
                            icon: "error",
                            timer: 1500,
                            showConfirmButton: false,
                            text: err.responseJSON.message,
                        });
                    });
                }
            });
    });

    let table = $("#tableBanner").DataTable({
        searchDelay: 500,
        processing: true,
        serverSide: true,
        language: {
            processing:
                '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><br>Loading... ',
        },
        ajax: {
            url: "/admin/config/datatables_banner",
        },
        order: [[2, "asc"]],
        columns: [
            { data: "DT_RowIndex", class: "text-center" },
            { data: "file", class: "text-center" },
            { data: "status", class: "text-center" },
            { data: "aksi", class: "text-center" },
        ],
    });
});
