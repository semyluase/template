const modalRole = new bootstrap.Modal(document.querySelector(".modal"));
const modalTitle = document.querySelector(".modal-title");
const idRoleInput = document.querySelector("#idRole");
const nameInput = document.querySelector("#name");
const nameFeedback = document.querySelector("#nameFeedback");
const descriptionInput = document.querySelector("#description");
const descriptionFeedback = document.querySelector("#descriptionFeedback");
const btnSubmit = document.querySelector(".btn-submit");

let url, data;

const role = {
    loadData: async() => {
        url = `${baseUrl}/master/roles/get-all-data`;

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
                role.setData(response);
            });

        unBlockUI();
    },

    setData: (result) => {
        $("#tb-role").DataTable({
            processing: true,
            destroy: true,
            data: result,
        });
    },

    onInit: () => {
        role.loadData();
    },

    addNew: () => {
        modalRole.show();
        modalTitle.innerHTML = "Managemen Role";
        idRoleInput.value = "";
        nameInput.value = "";
        descriptionInput.value = "";
        nameInput.classList.remove("is-invalid");
        descriptionInput.classList.remove("is-invalid");
        btnSubmit.setAttribute("data-type", "add-new");
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

    editData: async(id) => {
        url = `${baseUrl}/master/roles/${id}/edit`;

        blockModal();

        await fetch(url)
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
            .then((response) => {
                modalRole.show();
                modalTitle.innerHTML = "Managemen Role";
                idRoleInput.value = response.id;
                nameInput.value = response.name;
                descriptionInput.value = response.description;
                btnSubmit.setAttribute("data-type", "edit-data");
                nameInput.classList.remove("is-invalid");
                descriptionInput.classList.remove("is-invalid");
            });

        unBlockModal();
    },

    deleteData: async(id, csrf) => {
        url = `${baseUrl}/master/roles/${id}`;

        await Swal.fire({
            title: "Hapus Data",
            text: "Anda yakin akan mengubah data ini?",
            showCancelButton: true,
            confirmButtonText: "Ya, Yakin",
            cancelButtonText: "Tidak, Batal",
        }).then(async(result) => {
            if (result.value) {
                blockUI();

                data = {
                    id: id,
                    _token: csrf,
                };

                const results = await role.postData(
                    url,
                    JSON.stringify(data),
                    "delete",
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

                    role.loadData();
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
            }
        });
    },
};

role.onInit();

btnSubmit.addEventListener("click", async() => {
    let dataButton = btnSubmit.dataset.type;
    let csrf = btnSubmit.dataset.csrf;

    if (dataButton === "add-new") {
        url = `${baseUrl}/master/roles`;

        data = {
            name: nameInput.value,
            description: descriptionInput.value,
            _token: csrf,
        };

        blockModal();

        const results = await role.postData(
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

            modalRole.hide();
            role.loadData();
        } else {
            if (results.data.message.name) {
                nameInput.classList.add("is-invalid");
                nameFeedback.innerHTML = results.data.message.name;
            } else {
                nameInput.classList.remove("is-invalid");
            }

            if (results.data.message.description) {
                descriptionInput.classList.add("is-invalid");
                descriptionFeedback.innerHTML =
                    results.data.message.description;
            } else {
                descriptionInput.classList.remove("is-invalid");
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
        url = `${baseUrl}/master/roles/${idRoleInput.value}`;

        data = {
            id: idRoleInput.value,
            name: nameInput.value,
            description: descriptionInput.value,
            _token: csrf,
        };

        blockModal();

        const results = await role.postData(
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

            modalRole.hide();
            role.loadData();
        } else {
            if (results.data.message.name) {
                nameInput.classList.add("is-invalid");
                nameFeedback.innerHTML = results.data.message.name;
            } else {
                nameInput.classList.remove("is-invalid");
            }

            if (results.data.message.description) {
                descriptionInput.classList.add("is-invalid");
                descriptionFeedback.innerHTML =
                    results.data.message.description;
            } else {
                descriptionInput.classList.remove("is-invalid");
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