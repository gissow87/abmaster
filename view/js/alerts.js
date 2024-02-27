const ajaxForms = document.querySelectorAll(".ajaxForm");

function sendAjaxForm(e) {
    e.prevenDefault();

    let data = new FormData(this);
    let method = this.getAttribute("method");
    let action = this.getAttribute("action");
    let type = this.getAttribute("data-form");

    let headers = new Headers();
    let configs = {
        method: method,
        headers: headers,
        mode: 'cors',
        cache: 'no-cache',
        body: data,
    };

    let alertText = "";
    switch (type) {
        case "save":
            alertText = "Los datos quedarán guardados en el sistema.";
            break;
        case "delete":
            alertText = "Los datos serán eliminados del sistema."
            break;
        case "update":
            alertText = "Los datos serán actualizados en el sistema.";
            break;
        case "search":
            alertText = "Se eliminara el termino de busqueda.";
            break;
        case "loans":
            alertText = "¿Desea remover los datos seleccionados?"
            break;
    }
    if (alertText == "")
        alertText = "¿Quieres realizar la operación solicitada?";

    Swal.fire({
        tittle: "¿Estás seguro?",
        text: alertText,
        type: 'question',
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#3085d6",
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#d33"
    }).then((result) => {
        if (result.value)
            fetch(action, configs)
                .then((response) =>
                    response.json()
                ).then(response => {
                    return ajaxAlerts(response);
                });
    });
}

ajaxForms.forEach((ajaxForm) => {
    ajaxForm.addEventListener("submit", sendAjaxForm);
});

function ajaxAlerts(aAlert) {
    if (aAlert.alert == "simple") {
        Swal.fire({
            tittle: aAlert.tittle,
            text: aAlert.text,
            type: aAlert.type,
            confirmButtonText: "Aceptar",
        });
    }
    else if (aAlert.alert == "reload") {
        Swal.fire({
            tittle: aAlert.tittle,
            text: aAlert.text,
            type: aAlert.type,
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#d33"
        }).then((result) => {
            if (result.value)
                location.reload();
        });
    }
    else if (alert.alert == "clear") {
        Swal.fire({
            tittle: aAlert.tittle,
            text: aAlert.text,
            type: aAlert.type,
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#d33"
        }).then((result) => {
            if (result.value)
                document.querySelector(".ajaxForm").reset();
        });
    }
    else if (aAlert.alert == "redirect") {
        windows.location.href = aAlert.url;
    }
}