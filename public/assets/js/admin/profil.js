$(function(){
    $("#formProfil").on("submit", function (e) {
        e.preventDefault();

        let data = new FormData(this);
        mySwalLoading();
        $.ajax({
            type: "post",
            url: "/admin/profile",
            data: data,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
        })
            .then(async (res) => {
                await mySwal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false,
                });
                window.location.reload()
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
})