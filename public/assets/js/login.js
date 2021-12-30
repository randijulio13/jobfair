$(function () {
    $("#formLogin").on("submit", function (e) {
        e.preventDefault();
        $(".is-invalid").removeClass("is-invalid");
        let data = $(this).serialize();
        $.post("/login", data)
            .then((res) => {
                mySwal
                    .fire({
                        title: "Berhasil",
                        icon: "success",
                        text: res.message,
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    .then(() => (window.location.href = "/profile"));
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

    $("#btnSignUp").on("click", function (e) {
        e.preventDefault();
        $("#modalRegister").modal("show");
    });

    $("#modalRegister").on("shown.bs.modal", function () {
        $("#name").focus();
    });
    $("#modalRegister").on("hidden.bs.modal", function () {
        $('#formDaftarUser').trigger('reset')
    });

    $("#formDaftarUser").on("submit", function (e) {
        e.preventDefault();
        $(".is-invalid").removeClass("is-invalid");
        let data = $(this).serialize();
        $.post(`/user`, data)
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
                        $("#modalRegister").modal("hide");
                    });
            })
            .catch((err) => {
                if (err.status == 422) {
                    errorValidasiName(err);
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
