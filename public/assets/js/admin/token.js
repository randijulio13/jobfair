$(function () {
    let selectedId;

    $("#btnTambah").click(function (e) {
        e.preventDefault();
        let quantity = $("#quantity").val();
        $.post("/admin/token/generate", { quantity })
            .then((res) => {
                mySwal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false,
                });
                table.ajax.reload();
            })
            .catch((err) => {
                mySwal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: err.reponseJSON.message,
                    timer: 1500,
                    showConfirmButton: false,
                });
            });
    });

    var table = $("#tableToken").DataTable({
        searchDelay: 500,
        processing: true,
        serverSide: true,
        language: {
            processing:
                '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><br>Loading... ',
        },
        ajax: {
            url: "/admin/token/datatable",
        },
        order: [[1, "desc"]],
        columns: [
            { data: "DT_RowIndex", orderable: false },
            { data: "token" },
            { data: "status", class: "text-center", orderable: false },
            { data: "aksi", class: "text-center", orderable: false },
        ],
    });

    $(document).on("click", ".btn-hapus", async function (e) {
        e.preventDefault();
        selectedId = $(this).parents("tr").attr("id");
        $.ajax({
            url: `/admin/token/${selectedId}`,
            dataType: "json",
            type: "delete",
        }).then((res) => {
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                timer: 1500,
                showConfirmButton: false,
                timerProgressBar: true,
                text: "Token berhasil dihapus",
            });
            table.ajax.reload();
        });
    });
});
