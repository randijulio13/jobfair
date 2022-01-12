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

    $("#formReject").on("submit", async function (e) {
        e.preventDefault();
        let data = $(this).serialize();
        let id = $('#user_id').val()
        await $.post("/admin/message", data);
        await $.ajax({
            url:`/admin/user/${id}`,
            dataType:'json',
            type:'patch',
            data:{
                status:3
            },
        })
        Swal.fire({
            title: "Berhasil",
            icon: "success",
            html: "Status user diubah menjadi menunggu pembayaran<br>Notifikasi penolakan berhasil dikirim",
            timer: 1500,
            showConfirmButton: false,
            timerProgressBar: true,
        });
        $('#message').html('')
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
});
