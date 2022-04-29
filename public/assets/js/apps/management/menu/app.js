const modalUser = new bootstrap.Modal(document.querySelector(".modal"));
const modalTitle = document.querySelector(".modal-title");
// const usernameInput = document.querySelector("#username");
const roleInput = document.querySelector("#userRoleMenu");
const btnSimpan = document.querySelector("#simpan-jstree");
// const btnSearch = document.querySelector("#btn-search");

const roleChoices = new Choices(roleInput);

let url, data;

const managementMenu = {
    createDropdown: async(url, element, placeholder, selected) => {
        element.clearStore();
        element.clearChoices();
        element.placeholder = true;
        element.placeholderValue = placeholder;

        const results = await fetch(url)
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
            .then((response) => element.setChoices(response));
        await element.setChoiceByValue(selected);
    },

    loadData: async() => {
        url = `${baseUrl}/users/get-all-data?data=menu`;

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
                managementMenu.setData(response);
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

    onInit: async() => {
        if (!btnSimpan.classList.contains("d-none")) {
            btnSimpan.classList.add("d-none");
        }

        await managementMenu.createDropdown(
            `${baseUrl}/utils/dropdown/get-role`,
            roleChoices,
            "Pilih Role",
            ""
        );

        // usernameInput.value = "";

        // managementRole.loadData();
    },

    setUser: async(username) => {
        usernameInput.value = username;
        modalUser.hide();

        await managementMenu.loadMenu(username);
        btnSimpan.classList.remove("d-none");
    },

    loadMenu: async(role) => {
        url = `${baseUrl}/master/menus/get-menu-tree?role=${role}`;

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
                $("#jstree-menu").jstree("destroy");
                $("#jstree-menu").jstree({
                    plugins: ["wholerow", "checkbox", "types"],
                    core: {
                        themes: {
                            responsive: !1,
                        },
                        data: response,
                    },
                    types: {
                        default: {
                            icon: "fas fa-tag icon-state-warning",
                        },
                    },
                });

                btnSimpan.classList.remove("d-none");
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

managementMenu.onInit();

roleInput.addEventListener("change", async() => {
    await managementMenu.loadMenu(roleChoices.getValue(true));
});
// btnSearch.addEventListener("click", () => {
//     modalUser.show();
//     modalTitle.innerHTML = "List User";
//     managementMenu.loadData();
// });

btnSimpan.addEventListener("click", async() => {
    let arr = $("#jstree-menu").jstree("get_checked");
    $("#jstree-menu")
        .find(".jstree-undetermined")
        .each(function(i, element) {
            arr.push($(element).closest(".jstree-node").attr("id"));
        });
    let csrf = btnSimpan.dataset.csrf;

    url = `${baseUrl}/user/menus`;

    data = {
        menu: arr,
        role: roleChoices.getValue(true),
        _token: csrf,
    };

    blockUI();

    const results = await managementMenu.postData(
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

        $("#jstree-menu").jstree("destroy");
        managementMenu.onInit();
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