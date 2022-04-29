const usernameInput = document.querySelector("#username");
const profilNameInput = document.querySelector("#profilName");
const nikInput = document.querySelector("#nik");
const btnSimpan = document.querySelector("#simpan-profile");
const oldPasswordInput = document.querySelector("#oldPassword");
const oldPasswordFeedback = document.querySelector(".oldPasswordFeedback");
const newPasswordInput = document.querySelector("#newPassword");
const newPasswordFeedback = document.querySelector(".newPasswordFeedback");
const confirmPasswordInput = document.querySelector("#confirmPassword");
const confirmPasswordFeedback = document.querySelector(
    ".confirmPasswordFeedback"
);
const btnGantiPassword = document.querySelector("#ganti-password");

let url, data;

const myProfile = {
    loadData: async() => {
        url = `${baseUrl}/master/users/${usernameInput.value}/edit`;

        blockUI();

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
                profilNameInput.value = response.profil_nama;
                nikInput.value = response.nik;
            });

        unBlockUI();
    },

    onInit: () => {
        myProfile.loadData();

        oldPasswordInput.value = "";
        newPasswordInput.value = "";
        confirmPasswordInput.value = "";
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

myProfile.onInit();

btnSimpan.addEventListener("click", async() => {
    url = `${baseUrl}/user/profile`;

    let csrf = btnSimpan.dataset.csrf;

    data = {
        username: usernameInput.value,
        profileName: profilNameInput.value,
        nik: nikInput.value,
        _token: csrf,
    };

    blockUI();

    const results = await myProfile.postData(
        url,
        JSON.stringify(data),
        "post",
        csrf
    );

    unBlockUI();

    if (results.data.status) {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#769769",
        }).showToast();

        $("#jstree-role").jstree("destroy");
        myProfile.onInit();
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

btnGantiPassword.addEventListener("click", async() => {
    url = `${baseUrl}/user/profile/change-password`;

    let csrf = btnGantiPassword.dataset.csrf;

    data = {
        username: usernameInput.value,
        oldPassword: oldPasswordInput.value,
        newPassword: newPasswordInput.value,
        confirmPassword: confirmPasswordInput.value,
        _token: csrf,
    };

    blockUI();

    const results = await myProfile.postData(
        url,
        JSON.stringify(data),
        "post",
        csrf
    );

    unBlockUI();

    if (results.data.status) {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#769769",
        }).showToast();

        $("#jstree-role").jstree("destroy");
        myProfile.onInit();
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