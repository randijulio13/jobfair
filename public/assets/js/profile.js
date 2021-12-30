$(function () {
    $(".js-example-basic-multiple").select2({});

    $("#formProfile").on("submit", function (e) {
        e.preventDefault();
        $(".is-invalid").removeClass("is-invalid");
        let data = new FormData(this);
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
        $.ajax({
            type: "post",
            url: "/profile/payment",
            data: data,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
        }).then(async (res)=>{
            await Swal.fire({
                icon:'success',
                title:'Berhasil',
                text:'Bukti pembayaran anda berhasil disubmit',
                timer:1500,
                showConfirmButton:false,
                timerProgressBar:true,
            })
            window.location.reload()
        });
    });
});
