$(function () {
    $(".js-example-basic-multiple").select2({});

    $("#formProfile").on("submit", function (e) {
        e.preventDefault();
        $(".is-invalid").removeClass("is-invalid");
        let data = new FormData(this);
        mySwalLoading()
        $.ajax({
            type: "post",
            url: "/profile",
            data: data,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
        })
            .then((res) => {
                mySwal
                    .fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    .then(() => window.location.reload());
            })
            .catch((err) => {
                if (err.status == 422) {
                    Swal.close()
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

    $(".btnPayment").on("click", function (e) {
        e.preventDefault();
        $("#modalPayment").modal("show");
    });

    $("#formPembayaran").on("submit", function (e) {
        e.preventDefault();
        let data = new FormData(this);
        mySwalLoading();
        $.ajax({
            type: "post",
            url: "/profile/payment",
            data: data,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
        }).then(async (res) => {
            await Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: "Bukti pembayaran anda berhasil disubmit",
                timer: 1500,
                showConfirmButton: false,
                timerProgressBar: true,
            });
            window.location.reload();
        }).catch((err)=>{
            mySwal.fire({
                title: "Error",
                icon: "error",
                text: err.responseJSON.message,
                showConfirmButton: false,
                timer: 1500,
            });
        });
    });

    $("#gantiPassword").on("click", function (e) {
        e.preventDefault();
        $("#modalPassword").modal("show");
    });

    $("#modalPassword").on("hidden.bs.modal", function () {
        $("#formPassword").trigger("reset");
    });

    $("#modalPassword").on("shown.bs.modal", function () {
        $("#old_password").focus();
    });

    $("#formAccount").on("submit", async function (e) {
        e.preventDefault();
        $(this).find('.is-invalid').removeClass('is-invalid')
        let data = $(this).serialize();
        try {
            let res = await $.ajax({
                type: "patch",
                url: "/profile",
                data,
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
            $("#modalPassword").modal("hide");
        } catch (err) {
            if (err.status == 422) return errorValidasi(err);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: err.responseJSON.message,
                timer: 5000,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        }
    });

    $("#formPassword").on("submit", async function (e) {
        e.preventDefault();
        $(this).find(".is-invalid").removeClass("is-invalid");
        let data = $(this).serialize();
        try {
            let res = await $.ajax({
                type: "patch",
                url: "/profile/password",
                data,
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
            $("#modalPassword").modal("hide");
        } catch (err) {
            if (err.status == 422) return errorValidasi(err);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: err.responseJSON.message,
                timer: 5000,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        }
    });
});
