$(function () {
    let table = $("#tableUser").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `/admin/user/datatables/${type}`,
        },
        columns: [
            { data: "DT_RowIndex", class: "text-center", orderable: false },
            { data: "name" },
            { data: "username" },
            { data: "created_at", class: "text-center" },
            { data: "status", class: "text-center", orderable: false },
            // { data: "aksi", orderable: false, class: "text-center" },
        ],
    });

    $(document).on("change", ".status-user", function (e) {
        selectedId = $(this).parents("tr").attr("id");
        let status = $(this).val();
        $.ajax({
            type: "patch",
            dataType: "json",
            url: "/admin/user/" + selectedId,
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
});
