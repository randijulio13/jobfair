$(function () {
    let formType;
    let selectedId;
    $("#btnTambah").on("click", function (e) {
        e.preventDefault();
        $("#formBidang").trigger("reset");
        $("#modalAdd").modal("show");
        formType = "post";
    });

    $("#modalAdd").on("shown.bs.modal", function () {
        $("#name").focus();
    });

    $("#formBidang").on("submit", function (e) {
        e.preventDefault();
        let data = $(this).serialize();
        $(".is-invalid").removeClass("is-invalid");
        if (formType == "post") {
            store(data);
        } else {
            patch(data, selectedId);
        }
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
                        url: `/admin/field/${selectedId}`,
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

    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();
        selectedId = $(this).parents("tr").attr("id");
        $.get(`/admin/field/${selectedId}`).then((res) => {
            $("#name").val(res.name);
            $("#modalAdd").modal("show");
            console.log(res);
        });
        formType = "patch";
    });

    function patch(data, id) {
        $.ajax({
            url: `/admin/field/${id}`,
            type: "patch",
            dataType: "json",
            data: data,
        })
            .then((res) => {
                mySwal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false,
                });
                $("#modalAdd").modal("hide");
                $("#formBidang").trigger("reset");
                table.ajax.reload();
            })
            .catch((err) => {
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
    }

    function store(data) {
        $.post("/admin/field", data)
            .then((res) => {
                mySwal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false,
                });
                $("#modalAdd").modal("hide");
                $("#formBidang").trigger("reset");
                table.ajax.reload();
            })
            .catch((err) => {
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
    }

    var table = $("#tableBidang").DataTable({
        processing: true,
        searchDelay: 500,
        serverSide: true,
        language: {
            processing:
                '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><br>Loading... ',
        },
        ajax: {
            url: "/admin/field/datatable",
        },
        order: [[0, "desc"]],
        columns: [{ data: "DT_RowIndex",orderable:false,class:'text-center' }, { data: "name" }, { data: "aksi",orderable:false,class:'text-center' }],
    });
});
