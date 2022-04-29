const modalUser = new bootstrap.Modal(document.querySelector("#modalUser"));
const modalTitle = document.querySelector(".modal-title");
const idUserInput = document.querySelector("#idUser");
const usernameInput = document.querySelector("#username");
const usernameFeedback = document.querySelector("#usernameFeedback");
const passwordInput = document.querySelector("#password");
const passwordFeedback = document.querySelector("#passwordFeedback");
const btnSimpan = document.querySelector(".btn-submit");

const modalSettingUser = new bootstrap.Modal(
    document.querySelector("#modalSettingUser")
);
const idProfilUserInput = document.querySelector("#idProfilUser");
const profilNameUser = document.querySelector("#profilNameUser");
const nikUser = document.querySelector("#nikUser");
const btnSimpanProfil = document.querySelector(".btn-submit-profil");

let url, data;

const user = {
    loadData: async() => {
        url = `${baseUrl}/users/get-all-data?data=user`;

        await fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Terjadi kesalahan saat pengambilan data",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#EF5950",
                        }).showToast()
                    );
                }

                return response.json();
            })
            .then((response) => {
                user.setData(response);
            });
    },

    setData: (result) => {
        $("#tb-user").DataTable({
            processing: true,
            destroy: true,
            data: result,
        });
    },

    onInit: () => {
        user.loadData();
    },

    addNew: () => {
        modalUser.show();
        modalTitle.innerHTML = "Managemen User";
        usernameInput.value = "";
        passwordInput.value = "";
        usernameInput.classList.remove("is-invalid");
        passwordInput.classList.remove("is-invalid");
        btnSimpan.setAttribute("data-type", "add-new");
    },

    setUser: async(username) => {
        url = `${baseUrl}/master/users/${username}/edit`;

        await fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Terjadi kesalahan saat pengambilan data",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#EF5950",
                        }).showToast()
                    );
                }

                return response.json();
            })
            .then((response) => {
                modalUser.show();
                modalTitle.innerHTML = "Managemen User";
                idUserInput.value = response.id;
                usernameInput.value = response.username;
                passwordInput.value = "";
                usernameInput.classList.remove("is-invalid");
                passwordInput.classList.remove("is-invalid");
                btnSimpan.setAttribute("data-type", "edit-data");
                usernameInput.setAttribute("readonly", true);
            });
    },

    settingUser: async(username) => {
        url = `${baseUrl}/master/users/${username}/edit`;

        await fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Terjadi kesalahan saat pengambilan data",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#EF5950",
                        }).showToast()
                    );
                }

                return response.json();
            })
            .then((response) => {
                modalSettingUser.show();
                idProfilUserInput.value = response.username;
                profilNameUser.value = response.profil_nama;
                nikUser.value = response.nik;
            });
    },

    postData: async(url, data, method, csrf) => {
        return await fetch(url, {
                method: method,
                body: data,
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                },
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Terjadi kesalahan saat pengiriman data",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#EF5950",
                        }).showToast()
                    );
                }

                return response.json();
            })
            .then((response) => response);
    },
};

user.onInit();

btnSimpanProfil.addEventListener("click", async() => {
    let csrf = btnSimpanProfil.dataset.csrf;

    data = {
        profilName: profilNameUser.value,
        nik: nikUser.value,
        _token: csrf,
    };

    blockModal();

    const results = await user.postData(
        `${baseUrl}/master/users/update-profile/${idProfilUserInput.value}`,
        JSON.stringify(data),
        "put",
        csrf
    );

    unBlockModal();

    if (results.data.status) {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#769769",
        }).showToast();

        modalSettingUser.hide();
        user.loadData();
    } else {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#EF5950",
        }).showToast();
    }
});

btnSimpan.addEventListener("click", async() => {
    let dataButton = btnSimpan.dataset.type;
    let csrf = btnSimpan.dataset.csrf;

    if (dataButton === "add-new") {
        url = `${baseUrl}/master/users`;

        data = {
            username: usernameInput.value,
            password: passwordInput.value,
            _token: csrf,
        };

        blockModal();

        const results = await user.postData(
            url,
            JSON.stringify(data),
            "post",
            csrf
        );

        unBlockModal();

        if (results.data.status) {
            Toastify({
                text: results.data.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#769769",
            }).showToast();

            modalUser.hide();
            user.loadData();
        } else {
            if (results.data.message.username) {
                usernameInput.classList.add("is-invalid");
                usernameFeedback.innerHTML = results.data.message.username;
            } else {
                usernameInput.classList.remove("is-invalid");
            }

            if (results.data.message.password) {
                passwordInput.classList.add("is-invalid");
                passwordFeedback.innerHTML = results.data.message.password;
            } else {
                passwordInput.classList.remove("is-invalid");
            }

            if (typeof results.data.message === "string") {
                Toastify({
                    text: results.data.message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#EF5950",
                }).showToast();
            }
        }
    }

    if (dataButton === "edit-data") {
        url = `${baseUrl}/master/users/${usernameInput.value}`;

        data = {
            username: usernameInput.value,
            password: passwordInput.value,
            _token: csrf,
        };

        blockModal();

        const results = await user.postData(
            url,
            JSON.stringify(data),
            "put",
            csrf
        );

        unBlockModal();

        if (results.data.status) {
            Toastify({
                text: results.data.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#769769",
            }).showToast();

            modalUser.hide();
            user.loadData();
        } else {
            if (results.data.message.username) {
                usernameInput.classList.add("is-invalid");
                usernameFeedback.innerHTML = results.data.message.username;
            } else {
                usernameInput.classList.remove("is-invalid");
            }

            if (results.data.message.password) {
                passwordInput.classList.add("is-invalid");
                passwordFeedback.innerHTML = results.data.message.password;
            } else {
                passwordInput.classList.remove("is-invalid");
            }

            if (typeof results.data.message === "string") {
                Toastify({
                    text: results.data.message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#EF5950",
                }).showToast();
            }
        }
    }
});