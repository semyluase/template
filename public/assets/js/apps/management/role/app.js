const modalUser = new bootstrap.Modal(document.querySelector(".modal"));
const modalTitle = document.querySelector(".modal-title");
const usernameInput = document.querySelector("#username");
const btnSimpan = document.querySelector("#simpan-jstree");
const btnSearch = document.querySelector("#btn-search");

let url, data;

const managementRole = {
    loadData: async() => {
        url = `${baseUrl}/users/get-all-data?data=role`;

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
                managementRole.setData(response);
            });

        unBlockUI();
    },

    setData: (result) => {
        $("#tb-user").DataTable({
            processing: true,
            destroy: true,
            data: result,
        });
    },

    onInit: () => {
        if (!btnSimpan.classList.contains("d-none")) {
            btnSimpan.classList.add("d-none");
        }

        usernameInput.value = "";

        // managementRole.loadData();
    },

    setUser: async(username) => {
        usernameInput.value = username;
        modalUser.hide();

        await managementRole.loadRole(username);
        btnSimpan.classList.remove("d-none");
    },

    loadRole: async(user) => {
        url = `${baseUrl}/master/roles/get-role-tree?username=${user}`;

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
                $("#jstree-role").jstree("destroy");
                $("#jstree-role").jstree({
                    plugins: ["wholerow", "checkbox", "types"],
                    core: {
                        themes: {
                            responsive: !1,
                        },
                        data: response,
                        multiple: false,
                    },
                    types: {
                        default: {
                            icon: "fas fa-tag icon-state-warning",
                        },
                    },
                });
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

managementRole.onInit();

btnSearch.addEventListener("click", () => {
    modalUser.show();
    modalTitle.innerHTML = "List User";
    managementRole.loadData();
});

btnSimpan.addEventListener("click", async() => {
    let arr = $("#jstree-role").jstree("get_checked");
    let csrf = btnSimpan.dataset.csrf;

    url = `${baseUrl}/user/role`;

    data = {
        role: arr,
        username: usernameInput.value,
        _token: csrf,
    };

    blockUI();

    const results = await managementRole.postData(
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
        managementRole.onInit();
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