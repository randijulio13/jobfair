$(function () {
    $("#tableApplicant").DataTable({
        searchDelay: 500,
        processing: true,
        serverSide: true,
        language: {
            processing:
                '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><br>Loading... ',
        },
        ajax: {
            url: "/admin/applicant/datatables",
        },
        order: [[0, "desc"]],
        columns: [
            { data: "DT_RowIndex" },
            { data: "name" },
            { data: "last_edu" },
            { data: "fields" },
            { data: "aksi" },
        ],
    });

    $(".js-example-basic-multiple").select2({
        maximumSelectionLength: 2
    });

    $("#formField").on("submit", async function (e) {
        e.preventDefault();
        let data = $(this).serialize();
        let res = await $.post("/admin/applicant/sponsor", data);
        await Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: "Data berhasil disimpan",
            timer: 3000,
            showConfirmButton: false,
            timerProgressBar: true,
        });
        window.location.reload();
    });
});
