const d = document;
let idModal;
let $modal;
let $form;
let instanceDataTable;
const allIdModal = [
  "createNewClientModal",
  "createNewUserModal",
  "createNewBoxModal",
  "createNewCategoryModal",
  "createNewMeasureModal",
  "createNewProductModal",
];

const $titleModal = d.getElementById("modal-header__title");

const assignValueToModalVariables = () => {
  const urlRoute = location.pathname;
  let lastPartUrl = urlRoute.split("/")[2];

  if (!lastPartUrl) return;

  for (let i = 0; i < allIdModal.length; i++) {
    idModal = new RegExp(`${lastPartUrl}`, "g").exec(allIdModal[i])
      ? allIdModal[i]
      : "";
    if (idModal) break;
  }
  if (!idModal) return;

  $modal = d.getElementById(idModal);
  $form = $modal.querySelector("form");
};

const validateEmptyFormInputs = (form) => {
  let count = 0;
  let inputsWithinForm = form.querySelectorAll("input[name]");
  inputsWithinForm.forEach((input) => {
    if (!input.value) {
      input.classList.add("is-invalid");
      input.focus();
      count += 1;
    } else {
      input.classList.remove("is-invalid");
    }
    return count;
  });
};

const validateEqualPasswords = (form) => {
  const $passwordInputs = form.querySelectorAll("input[type=password]");
  return $passwordInputs[0].value == $passwordInputs[1].value
    ? true
    : "Las contraseñas no son iguales intente nuevamente";
};

const sweetAlert = (options) => {
  let { title, text, icon, timer } = options;
  Swal.fire({
    title,
    text,
    icon,
    timer,
  });
};

const submitForm = async (form, success, error, checkPasswordAgain = null) => {
  const emptyInputValidation = validateEmptyFormInputs(form);
  if (emptyInputValidation > 0) return;

  const fetchOptions = {
    method: "POST",
    body: new FormData(form),
  };
  try {
    if (typeof checkPasswordAgain == "string") {
      const messageCheckPasswordAgain = checkPasswordAgain;
      throw { status: "", statusText: messageCheckPasswordAgain };
    }

    const response = await fetch(form.action, fetchOptions),
      json = await response.json();
    console.log(json);
    if (!response.ok)
      throw { status: response.status, statusText: response.statusText };

    const serverErrorMessage = json["errorMsg"];

    const messageServe = json["msg"];

    if (typeof json !== "object" && !json["ok"])
      throw {
        status: 500,
        statusText: messageServe,
        errorMsg: serverErrorMessage,
      };

    success(messageServe, json);
  } catch (err) {
    console.log(err);
    error(err);
  }
};

const makeRequestToServe = async (url, options = {}) => {
  try {
    const response = await fetch(url, options),
      json = await response.json();
    console.log(json);
    if (!response.ok)
      throw { status: response.status, statusText: response.statusText };

    const serverErrorMessage = json["errorMsg"];

    const messageServe = json["msg"];

    if (!json["ok"]) {
      throw {
        status: 500,
        statusText: messageServe,
        errorMsg: serverErrorMessage,
      };
    }
    return json;
  } catch (err) {
    console.log(err);
    return err;
  }
};

const showOrHidePasswordInput = (form, show = false) => {
  const $inputsToHide = form.querySelectorAll("input[type=password]");
  $inputsToHide.forEach((input) =>
    show
      ? input.parentElement.classList.remove("d-none")
      : input.parentElement.classList.add("d-none")
  );
};

const fillFormInputs = async (routeFetch, form, additionalTargets = []) => {
  const response = await makeRequestToServe(routeFetch);
  const data = response["data"];
  console.log(data);
  let $inputs = Array.from(form.querySelectorAll("*[name]"));
  console.log(form);

  $inputs = $inputs.filter(
    (input) => input.type != "password" && input.type != "file"
  );
  $inputs.forEach((input) => {
    if (data[input.name]) {
      input.value = data[input.name];
    } else {
      input.value = data[input.getAttribute("data-name")];
    }
  });

  if (additionalTargets.length > 0) {
    additionalTargets.forEach((target) => {
      console.log(target);
      let $target = target["target"];
      $target.setAttribute(target["attr"], "Assets/img/" + data["image"]);
    });
  }

  showOrHidePasswordInput(form);
};

const confirmDialogSweetAlert = async (options, callBack) => {
  let { title, text, confirmButtonText, cancelButtonText } = options;
  Swal.fire({
    title,
    text,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText,
    confirmButtonText,
  }).then(async (result) => {
    if (result.isConfirmed) {
      const response = await callBack();
      if (response["ok"]) {
        sweetAlert({
          title: "Exito",
          text: response["msg"],
          icon: "success",
          timer: 4000,
        });
      } else {
        sweetAlert({
          title: "Error",
          text: response["msg"],
          icon: "error",
          timer: 4000,
        });
      }
    }
  });
};

const createDataTable = (idTable, options) => {
  let { columns, ajaxUrl } = options;
  const table = new DataTable(`#${idTable}`, {
    ajax: {
      url: ajaxUrl,
      dataSrc: "",
    },
    columns,
    autoWidth: true,
  });
  return table;
};

const urlRouter = () => {
  const pathNameRoute = location.pathname;
  if (pathNameRoute == baseRoute + "/User") {
    instanceDataTable = createDataTable("table-users", {
      columns: [
        { data: "id" },
        { data: "user" },
        { data: "name" },
        { data: "box" },
        { data: "nameState" },
        { data: "acciones" },
      ],
      ajaxUrl: `${baseRoute}/User/dataList`,
    });
  } else if (pathNameRoute == baseRoute + "/Client") {
    instanceDataTable = createDataTable("table-clients", {
      columns: [
        { data: "id" },
        { data: "name" },
        { data: "type_document" },
        { data: "number_document" },
        { data: "phone" },
        { data: "address" },
        { data: "nameState" },
        { data: "acciones" },
      ],
      ajaxUrl: `${baseRoute}/Client/dataList`,
    });
  } else if (pathNameRoute == baseRoute + "/Box") {
    instanceDataTable = createDataTable("table-boxs", {
      columns: [
        { data: "id" },
        { data: "box" },
        { data: "nameState" },
        { data: "acciones" },
      ],
      ajaxUrl: `${baseRoute}/Box/dataList`,
    });
  } else if (pathNameRoute == baseRoute + "/Category") {
    instanceDataTable = createDataTable("table-categories", {
      columns: [
        { data: "id" },
        { data: "name" },
        { data: "nameState" },
        { data: "acciones" },
      ],
      ajaxUrl: `${baseRoute}/Category/dataList`,
    });
  } else if (pathNameRoute == baseRoute + "/Measure") {
    instanceDataTable = createDataTable("table-measures", {
      columns: [
        { data: "id" },
        { data: "full_name" },
        { data: "short_name" },
        { data: "nameState" },
        { data: "acciones" },
      ],
      ajaxUrl: `${baseRoute}/Measure/dataList`,
    });
  } else if (pathNameRoute == baseRoute + "/Product") {
    instanceDataTable = createDataTable("table-products", {
      columns: [
        { data: "id" },
        { data: "renderImage" },
        { data: "code" },
        { data: "description" },
        { data: "purchase_price" },
        { data: "sale_price" },
        { data: "quantity" },
        { data: "measure" },
        { data: "category" },
        { data: "quantity" },
        { data: "nameState" },
        { data: "acciones" },
      ],
      ajaxUrl: `${baseRoute}/Product/dataList`,
    });
  } else if (pathNameRoute == baseRoute + "/Buy") {
    instanceDataTable = createDataTable("table-buys", {
      columns: [
        { data: "id" },
        { data: "description" },
        { data: "quantity" },
        { data: "price" },
        { data: "subtotal" },
      ],
      ajaxUrl: `${baseRoute}/Buy/dataList`,
    });
  }
};

const deleteBuyDetail = async () => {
  const route = baseRoute + "/Buy/destroy";
  const response = await makeRequestToServe(route);

  return response["ok"] ? true : false;
};

const showOrHidePreviousImg = (imageUrl) => {
  const $previousImg = d.getElementById("file-input__imagePrevious");
  $previousImg.src = !imageUrl ? "" : imageUrl;
};

d.addEventListener("DOMContentLoaded", () => {
  urlRouter();
  assignValueToModalVariables();
});

d.addEventListener("submit", async (e) => {
  e.preventDefault();
  if (e.target.matches("#form__authenticateUser")) {
    await submitForm(
      e.target,
      (response) => {
        window.location.reload();
      },
      (error) => {
        const $divAlert = d.getElementById("form-login-alert__message");
        $divAlert.textContent = error.statusText;
        $divAlert.classList.remove("d-none");
      }
    );
  } else if (e.target.matches("#modal-form__createUser")) {
    await submitForm(
      e.target,
      (msg) => {
        const optionsSweetAlert = {
          title: "Exito",
          text: msg,
          icon: "success",
          timer: 4000,
        };
        e.target.reset();
        $(`#${idModal}`).modal("hide");
        $(".modal-backdrop").remove();
        sweetAlert(optionsSweetAlert);
      },
      (error) => {
        const optionsSweetAlert = {
          title: "Error",
          text: error.statusText,
          icon: "error",
          timer: 4000,
        };
        sweetAlert(optionsSweetAlert);
      },
      validateEqualPasswords(e.target)
    );
  } else if (e.target.matches("#modal-form__createClient")) {
    await submitForm(
      e.target,
      (success) => {
        const optionsSweetAlert = {
          title: "Exito",
          text: success,
          icon: "success",
          timer: 4000,
        };
        const idModal = "createNewClientModal";
        $(`#${idModal}`).modal("hide");
        $(".modal-backdrop").remove();

        sweetAlert(optionsSweetAlert);
      },
      (error) => {
        const optionsSweetAlert = {
          title: "Error",
          text: error.statusText,
          icon: "error",
          timer: 4000,
        };
        sweetAlert(optionsSweetAlert);
      }
    );
  } else if (e.target.matches("#modal-form__createBox")) {
    await submitForm(
      e.target,
      (success) => {
        const optionsSweetAlert = {
          title: "Exito",
          text: success,
          icon: "success",
          timer: 4000,
        };
        $(`#${idModal}`).modal("hide");
        $(".modal-backdrop").remove();

        sweetAlert(optionsSweetAlert);
      },
      (error) => {
        const optionsSweetAlert = {
          title: "Error",
          text: error.statusText,
          icon: "error",
          timer: 4000,
        };
        sweetAlert(optionsSweetAlert);
      }
    );
  } else if (e.target.matches("#modal-form__createCategory")) {
    await submitForm(
      e.target,
      (success) => {
        const optionsSweetAlert = {
          title: "Exito",
          text: success,
          icon: "success",
          timer: 4000,
        };
        $(`#${idModal}`).modal("hide");
        $(".modal-backdrop").remove();

        sweetAlert(optionsSweetAlert);
      },
      (error) => {
        const optionsSweetAlert = {
          title: "Error",
          text: error.statusText,
          icon: "error",
          timer: 4000,
        };
        sweetAlert(optionsSweetAlert);
      }
    );
  } else if (e.target.matches("#modal-form__createMeasure")) {
    await submitForm(
      e.target,
      (success) => {
        const optionsSweetAlert = {
          title: "Exito",
          text: success,
          icon: "success",
          timer: 4000,
        };
        $(`#${idModal}`).modal("hide");
        $(".modal-backdrop").remove();

        sweetAlert(optionsSweetAlert);
      },
      (error) => {
        const optionsSweetAlert = {
          title: "Error",
          text: error.statusText,
          icon: "error",
          timer: 4000,
        };
        sweetAlert(optionsSweetAlert);
      }
    );
  } else if (e.target.matches("#modal-form__createProduct")) {
    await submitForm(
      e.target,
      (success) => {
        const optionsSweetAlert = {
          title: "Exito",
          text: success,
          icon: "success",
          timer: 4000,
        };
        $(`#${idModal}`).modal("hide");
        $(".modal-backdrop").remove();

        sweetAlert(optionsSweetAlert);
      },
      (error) => {
        const optionsSweetAlert = {
          title: "Error",
          text: error.statusText,
          icon: "error",
          timer: 4000,
        };
        sweetAlert(optionsSweetAlert);
      }
    );
  }

  instanceDataTable.ajax.reload();
});

d.addEventListener("click", async (e) => {
  if (e.target.matches("#btn-open-modal__create")) {
    const createUserRoute = `${baseRoute}/User/store`;
    $titleModal.textContent = "Crear un nuevo usuario";
    $form.reset();
    $form.action = createUserRoute;
    showOrHidePasswordInput($form, true);
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-open-modal__editar")) {
    $titleModal.textContent = "Editar usuario";
    const idParameter = e.target.getAttribute("data-id");
    const editUserRoute = `${baseRoute}/User/edit/${idParameter}`;
    const updateUserRoute = `${baseRoute}/User/update/${idParameter}`;
    $form.action = updateUserRoute;
    fillFormInputs(editUserRoute, $form);

    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-user__delete")) {
    const idParameter = e.target.getAttribute("data-id");
    const deleteRoute = `${baseRoute}/User/destroy/${idParameter}`;
    confirmDialogSweetAlert(
      {
        title: "Estas seguro de querer eliminar este usuario?",
        text: "Recuerda el usuario no se eliminara si no que su estado cambiara a inactivo",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
      },
      () =>
        makeRequestToServe(deleteRoute, {
          method: "POST",
        })
    );
  } else if (e.target.matches("#btn-open-modal__createClient")) {
    const createClientRoute = baseRoute + "/Client/store";
    $titleModal.textContent = "Crear un nuevo cliente";
    $form.action = createClientRoute;
    $form.reset();
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-open-modal__editClient")) {
    const idParameter = e.target.getAttribute("data-id");
    const editRoute = baseRoute + "/Client/edit/" + idParameter;
    const updateRoute = baseRoute + "/Client/update/" + idParameter;
    $titleModal.textContent = "Editar cliente";
    $form.action = updateRoute;
    fillFormInputs(editRoute, $form);
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-client__delete")) {
    const idParameter = e.target.getAttribute("data-id");
    const deleteRoute = `${baseRoute}/Client/destroy/${idParameter}`;
    confirmDialogSweetAlert(
      {
        title: "Estas seguro de querer eliminar este cliente?",
        text: "Recuerda el cliente no se eliminara si no que su estado cambiara a inactivo",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
      },
      () =>
        makeRequestToServe(deleteRoute, {
          method: "POST",
        })
    );
  } else if (e.target.matches("#btn-open-modal__createBox")) {
    const createBoxRoute = `${baseRoute}/Box/store`;
    $titleModal.textContent = "Crear una nueva caja";
    $form.reset();
    $form.action = createBoxRoute;
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-open-modal__editBox")) {
    const idParameter = e.target.getAttribute("data-id");
    const editRoute = baseRoute + "/Box/edit/" + idParameter;
    const updateRoute = baseRoute + "/Box/update/" + idParameter;
    $titleModal.textContent = "Editar la caja";
    $form.action = updateRoute;
    fillFormInputs(editRoute, $form);
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-box__delete")) {
    const idParameter = e.target.getAttribute("data-id");
    const deleteRoute = `${baseRoute}/Box/destroy/${idParameter}`;
    confirmDialogSweetAlert(
      {
        title: "Estas seguro de querer eliminar esta caja?",
        text: "Recuerda la caja no se eliminara si no que su estado cambiara a inactivo",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
      },
      () =>
        makeRequestToServe(deleteRoute, {
          method: "POST",
        })
    );
  } else if (e.target.matches("#btn-open-modal__createCategory")) {
    const createCategoryRoute = `${baseRoute}/Category/store`;
    $titleModal.textContent = "Crear una nueva categoria";
    $form.reset();
    $form.action = createCategoryRoute;
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-open-modal__editCategory")) {
    const idParameter = e.target.getAttribute("data-id");
    const editRoute = baseRoute + "/Category/edit/" + idParameter;
    const updateRoute = baseRoute + "/Category/update/" + idParameter;
    $titleModal.textContent = "Editar una categoria";
    $form.action = updateRoute;
    fillFormInputs(editRoute, $form);
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-category__delete")) {
    const idParameter = e.target.getAttribute("data-id");
    const deleteRoute = `${baseRoute}/Category/destroy/${idParameter}`;
    confirmDialogSweetAlert(
      {
        title: "Estas seguro de querer eliminar esta categoria?",
        text: "Recuerda la categoria no se eliminara si no que su estado cambiara a inactivo",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
      },
      () =>
        makeRequestToServe(deleteRoute, {
          method: "POST",
        })
    );
  } else if (e.target.matches("#btn-open-modal__createMeasure")) {
    const createMeasureRoute = `${baseRoute}/Measure/store`;
    $titleModal.textContent = "Crear una  medida";
    $form.reset();
    $form.action = createMeasureRoute;
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-open-modal__editMeasure")) {
    const idParameter = e.target.getAttribute("data-id");
    const editRoute = baseRoute + "/Measure/edit/" + idParameter;
    const updateRoute = baseRoute + "/Measure/update/" + idParameter;
    $titleModal.textContent = "Editar una medida";
    $form.action = updateRoute;
    fillFormInputs(editRoute, $form);
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-measure__delete")) {
    const idParameter = e.target.getAttribute("data-id");
    const deleteRoute = `${baseRoute}/Measure/destroy/${idParameter}`;
    confirmDialogSweetAlert(
      {
        title: "Estas seguro de querer eliminar esta medida?",
        text: "Recuerda la medida no se eliminara si no que su estado cambiara a inactivo",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
      },
      () =>
        makeRequestToServe(deleteRoute, {
          method: "POST",
        })
    );
  } else if (e.target.matches("#btn-open-modal__createProduct")) {
    const createProductRoute = `${baseRoute}/Product/store`;
    $titleModal.textContent = "Crear un producto";
    $form.reset();
    $form.action = createProductRoute;
    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-open-modal__editProduct")) {
    const idParameter = e.target.getAttribute("data-id");
    const editRoute = baseRoute + "/Product/edit/" + idParameter;
    const updateRoute = baseRoute + "/Product/update/" + idParameter;
    const btnClearPreviewImg = d.getElementById("btn__clearPreviousImage");
    const $previosImg = d.getElementById("file-input__imagePrevious");
    const $hideInput = $form.querySelector("input[type=hidden]");
    const $labelOfFileInput = d.getElementById("label-file-input");

    $titleModal.textContent = "Editar una producto";
    $form.action = updateRoute;
    await fillFormInputs(editRoute, $form, [
      {
        target: $previosImg,
        attr: "src",
        name: "image",
      },
    ]);
    $hideInput.value = $previosImg.src;
    btnClearPreviewImg.classList.remove("d-none");
    $labelOfFileInput.classList.add("d-none");

    $(`#${idModal}`).modal("show");
  } else if (e.target.matches("#btn-product__delete")) {
    const idParameter = e.target.getAttribute("data-id");
    const deleteRoute = `${baseRoute}/Product/destroy/${idParameter}`;
    confirmDialogSweetAlert(
      {
        title: "Estas seguro de querer eliminar este producto?",
        text: "Recuerda el producto no se eliminara si no que su estado cambiara a inactivo",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
      },
      () =>
        makeRequestToServe(deleteRoute, {
          method: "POST",
        })
    );
  } else if (e.target.matches("#btn__clearPreviousImage")) {
    const $btnClearPreviousImg = e.target;
    const $inputFileLabel = $btnClearPreviousImg.previousElementSibling;
    const $previousImg = d.getElementById("file-input__imagePrevious");
    const $fileInput = $inputFileLabel.lastElementChild;

    $inputFileLabel.classList.remove("d-none");
    $btnClearPreviousImg.classList.add("d-none");
    $previousImg.src = "";
    $fileInput.value = "";
  } else if (e.target.matches("#btn__makeToBuy")) {
    const $inputTotal = d.getElementById("input__totalProduct");
    const route = baseRoute + "/Buy/makeToBuy";
    console.log($inputTotal.value);
    try {
      if (!$inputTotal.value)
        throw {
          status: "",
          statusText: "No se pudo encontrar el total asociado",
        };
      const formData = new FormData();
      formData.append("total", $inputTotal.value);

      const response = await makeRequestToServe(route, {
        method: "POST",
        body: formData,
      });
      if (!response.ok) throw { status: 500, statusText: response["msg"] };

      let eliminar = await deleteBuyDetail();
      console.log(eliminar);

      location.href = baseRoute + "/Buy/pdf";
    } catch (err) {
      console.log(err);
      sweetAlert({
        title: "Error",
        text: err.statusText,
        icon: "error",
        timer: 4000,
      });
    }
  }

  if (instanceDataTable) instanceDataTable.ajax.reload();
});

d.addEventListener("change", (e) => {
  if (e.target.matches("#input-file")) {
    const btnClearPreviewImg = d.getElementById("btn__clearPreviousImage");
    const files = e.target.files;
    const $labelOfFileInput = d.getElementById("label-file-input");

    btnClearPreviewImg.classList.remove("d-none");
    $labelOfFileInput.classList.add("d-none");
    const imageUrl = files.length > 0 ? URL.createObjectURL(files[0]) : "";
    showOrHidePreviousImg(imageUrl);
  }
});

d.addEventListener("keyup", async (e) => {
  if (e.target.matches("#code_product") && e.key == "Enter") {
    const code = e.target.value;
    console.log(code);
    const route = baseRoute + "/Buy/getProduct/" + code;
    const response = await makeRequestToServe(route);
    const $codeInput = e.target;
    const $descriptionInput = d.getElementById("description_pruduct");
    const $purchasePriceInput = d.getElementById("purchase_price_product");
    if (!response.data || !code) {
      sweetAlert({
        title: "Error",
        text: "El producto no existe",
        icon: "error",
        timer: 4000,
      });
      return;
    }
    $descriptionInput.value = response["data"]["description"];
    $purchasePriceInput.value = response["data"]["purchase_price"];
  } else if (e.target.matches("#quantity_product")) {
    const $subtotalInput = d.getElementById("subtotal");
    const $purchasePriceInput = d.getElementById("purchase_price_product");
    const $quantityInput = e.target;

    $subtotalInput.value = $quantityInput.value * $purchasePriceInput.value;

    if (e.key == "Enter" && $quantityInput.value) {
      const $form = d.getElementById("form-productCode");
      await submitForm(
        $form,
        (success, data) => {
          const $totalInput = d.getElementById("input__totalProduct");
          const optionsSweetAlert = {
            title: "Exito",
            text: success,
            icon: "success",
            timer: 4000,
          };
          $totalInput.value = data["data"]["total"];
          sweetAlert(optionsSweetAlert);
        },
        (error) => {
          const optionsSweetAlert = {
            title: "Error",
            text: error.statusText,
            icon: "error",
            timer: 4000,
          };
          sweetAlert(optionsSweetAlert);
        }
      );
    }
  }
});
