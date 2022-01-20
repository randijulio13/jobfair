$(function () {
    let selectedId;

    let table = $("#tableMessage").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/admin/message/datatables",
        },
        order: [[3, "desc"]],
        columns: [
            // { data: "DT_RowIndex", orderable: false, class: "text-center" },
            { data: "seen", class: "text-center" },
            { data: "from" },
            { data: "subject" },
            { data: "created_at" },
            { data: "aksi", orderable: false, class: "text-center" },
        ],
    });

    $(".btnReject").on("click", function (e) {
        e.preventDefault();
        let id = $(this).siblings(".btnActive").data("id");
        $("#modalReject").modal("show");
    });

    $("#formReply").on("submit", async function (e) {
        e.preventDefault();
        let data = $(this).serialize();
        let id = $("#user_id").val();
        await $.post("/admin/message", data);
        await $.ajax({
            url: `/admin/user/${id}`,
            dataType: "json",
            type: "patch",
            data: {
                status: 3,
            },
        });
        Swal.fire({
            title: "Berhasil",
            icon: "success",
            html: "Status user diubah menjadi menunggu pembayaran<br>Notifikasi penolakan berhasil dikirim",
            timer: 1500,
            showConfirmButton: false,
            timerProgressBar: true,
        });
        $("#message").html("");
        $("#modalReject").modal("hide");
    });
    $("#formReject").on("submit", async function (e) {
        e.preventDefault();
        let data = $(this).serialize();
        let id = $("#user_id").val();
        await $.post("/admin/message", data);
        await $.ajax({
            url: `/admin/user/${id}`,
            dataType: "json",
            type: "patch",
            data: {
                status: 3,
            },
        });
        Swal.fire({
            title: "Berhasil",
            icon: "success",
            html: "Status user diubah menjadi menunggu pembayaran<br>Notifikasi penolakan berhasil dikirim",
            timer: 1500,
            showConfirmButton: false,
            timerProgressBar: true,
        });
        $("#message").html("");
        $("#modalReject").modal("hide");
    });

    $(".btnActive").on("click", async function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        let res = await mySwal.fire({
            title: "Are you sure?",
            text: "Akun user akan diaktifkan",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, aktifkan!",
        });
        if (res.isConfirmed) {
            $.ajax({
                type: "patch",
                dataType: "json",
                url: "/admin/user/" + id,
                data: {
                    status: 1,
                },
            }).then(async (res) => {
                let notif = {
                    sender_id: 1,
                    sender_name: "Admin",
                    receiver_id: id,
                    subject: "Akun anda telah aktif",
                    message:
                        "Selamat! akun anda telah aktif, silahkan lengkapi data diri anda.",
                };
                await $.post("/admin/user/notif", notif);
                await Swal.fire({
                    title: "Berhasil",
                    icon: "success",
                    text: "Akun user berhasil diaktifkan",
                    timer: 1500,
                    showConfirmButton: false,
                });
                window.location.href = "/admin/message";
            });
        }
    });

    $(document).on("click", ".btn-hapus", function (e) {
        e.preventDefault();
        selectedId = $(this).parents("tr").attr("id");
        Swal.fire({
            title: "Hapus Pesan",
            text: "Pesan akan dihapus! anda yakin?",
            icon: "warning",
            confirmButtonColor: "#3085d6",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "delete",
                    url: "/admin/message/" + selectedId,
                    dataType: "json",
                })
                    .then((res) => {
                        Swal.fire({
                            title: "Berhasil",
                            icon: "success",
                            text: "Pesan berhasil dihapus",
                            timer: 1500,
                            showConfirmButton: false,
                        });
                        table.ajax.reload()
                    })
                    .catch((err) => {
                        Swal.fire({
                            title: "Error",
                            icon: "error",
                            text: "Gagal menghapus pesan",
                            timer: 1500,
                            showConfirmButton: false,
                        });
                    });
            }
        });
    });

    $('.btnReply').on('click',function(e){
        e.preventDefault()
        $('#modalReply').modal('show')
    })
});
