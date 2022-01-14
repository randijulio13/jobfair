$(function () {
    let id = $("#id").val();
    let selectedId;
    let table = $("#tableApplicant").DataTable({
        searchDelay: 500,
        processing: true,
        serverSide: true,
        language: {
            processing:
                '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><br>Loading... ',
        },
        ajax: {
            url: "/admin/vacancy/datatables/" + id,
        },
        order: [[4, "desc"]],
        columns: [
            { data: "DT_RowIndex", orderable: false },
            { data: "name" },
            { data: "last_edu" },
            { data: "fields" },
            { data: "sent_at", class: "text-center" },
            { data: "aksi", class: "text-center", orderable: false },
        ],
    });

    $(document).on("click", ".btn-download", function (e) {
        e.preventDefault();
        selectedId = $(this).parents("tr").attr("id");
        let url = $(this).attr("href");
        $.post("/admin/vacancy/set_seen", {
            applicant_id: selectedId,
            vacancy_id: id,
        }).then(() => {
            window.location.href = url;
        });
    });

    $("#description").summernote({
        height: "100",
    });

    $("#formVacancy").on("submit", function (e) {
        e.preventDefault();
        let data = new FormData(this);
        mySwalLoading();
        $.ajax({
            type: "post",
            url: "/admin/vacancy/" + id,
            data: data,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
        })
            .then(async (res) => {
                await Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false,
                });
                window.location.reload();
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
});
