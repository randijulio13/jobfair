$(function () {
    $(".js-example-basic-multiple").select2({});

    $("#formProfile").on("submit", function (e) {
        e.preventDefault();
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
