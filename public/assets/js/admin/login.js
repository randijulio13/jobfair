$(function () {
    $("#formLogin").submit(function (e) {
        e.preventDefault();
        let data = $(this).serialize();
        $(".is-invalid").removeClass("is-invalid");
        $.post("/admin/login", data)
            .then((res) => {
                mySwal.fire({
                    title: "Berhasil",
                    icon: "success",
                    text: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(()=>{
                    window.location.href = '/admin'
                })
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
});
