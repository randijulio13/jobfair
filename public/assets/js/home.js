$(function () {
    $("#formToken").on("submit", function (e) {
        e.preventDefault();
        mySwal.fire({
            icon: "success",
            title: "Berhasil",
            html: "Token ditemukan!",
            timer: 1500,
            showConfirmButton: false,
        }).then(()=>{
            $('#modalRegister').modal('show')
        })
    });
});
