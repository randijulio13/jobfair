$(function () {
    $('#modalRegister').on('shown.bs.modal',function(){
        $('#name').focus()
    })

    $("#formDaftarUser").on("submit", function (e) {
        e.preventDefault();
        $('.is-invalid').removeClass('is-invalid')
        let data = $(this).serialize();
        let token = $("#token").val();
        if (!token) {
            return mySwal
                .fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Token tidak ditemukan",
                    timer: 1500,
                    showConfirmButton: false,
                })
                .then(() => {
                    $("#modalRegister").modal("hide");
                    $("#formDaftarUser").trigger("reset");
                });
        }
        $.post(`/user/${token}`, data)
            .then((res) => {
                mySwal
                    .fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    .then(() => {
                        window.location.href = "/login";
                    });
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
    });

    $("#formToken").on("submit", function (e) {
        e.preventDefault();
        let token = $("#token").val();
        if (!token) {
            return mySwal
                .fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Token tidak ditemukan",
                    timer: 1500,
                    showConfirmButton: false,
                })
                .then(() => {
                    $("#modalRegister").modal("hide");
                    $("#formDaftarUser").trigger("reset");
                });
        }
        $.get(`/token/${token}`)
            .then((res) => {
                console.log(res);
                $("#modalRegister").modal("show");
            })
            .catch((err) => {
                mySwal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: err.responseJSON.message,
                    timer: 1500,
                    showConfirmButton: false,
                });
            });
    });
});
