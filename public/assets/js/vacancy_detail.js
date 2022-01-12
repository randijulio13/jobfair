$(function () {
    let vacancy_id = $("#vacancy_id").val();
    $("#btnDaftar").on("click", async function (e) {
        e.preventDefault();
        let isLoggedIn = await $.get("/check_login");
        if (isLoggedIn) {
            const { value: password } = await Swal.fire({
                title: "Password",
                input: "password",
                inputLabel: "Masukkan password anda",
                inputPlaceholder: "Masukkan password anda",
                confirmButtonText: "Kirim",
                confirmButtonColor: "#3085d6",
                inputAttributes: {
                    maxlength: 10,
                    autocapitalize: "off",
                    autocorrect: "off",
                },
            });

            if (password) {
                $.post("/loker", { password, vacancy_id })
                    .then((res) => {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: res.message,
                            timer: 3000,
                            showConfirmButton: false,
                            timerProgressBar: true,
                        });
                    })
                    .catch((err) => {
                        Swal.fire({
                            icon: "warning",
                            title: "Error",
                            html: err.responseJSON.message,
                            timer: 3000,
                            showConfirmButton: false,
                            timerProgressBar: true,
                        });
                    });
            }
        } else {
            await Swal.fire({
                title: "Anda belum login",
                icon: "warning",
                text: "Anda akan diarahkan ke halaman login",
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true,
            });
            window.location.href = "/login";
        }
    });
});
