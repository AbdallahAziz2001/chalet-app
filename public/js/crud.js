function confirmDestroy(url, id, reference) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteItem(url, id, reference);
        }
    })
}

function deleteItem(url, id, reference) {
    axios.delete(url + '/' + id)
        .then(function (response) {
            // handle success 2xx
            console.log(response);
            showMessage(response.data);
            reference.closest('tr').remove();
        })
        .catch(function (error) {
            // handle error 4xx - 5xx
            console.log(error);
            showMessage(error.response.data);
        });
}

function showMessage(data) {
    Swal.fire({
        // position: 'top-end',
        icon: data.icon,
        title: data.title,
        showConfirmButton: false,
        timer: 1500
    })
}

function store(url, data) {
    axios.post(url, data).then(function (response) {
            console.log(response);
            toastr.success(response.data.message)
            document.getElementById('create-form').reset();
        })
        .catch(function (error) {
            console.log(error);
            toastr.error(error.response.data.message)
        });
}

function update(url, data, redirectRoute) {
    axios.put(url, data).then(function (response) {
        // handle success 2xx
        console.log(response);
        if (redirectRoute != undefined) {
            window.location.href = redirectRoute;
        } else {
            toastr.success(response.data.message);
        }
    }).catch(function (error) {
        // handle error 4xx - 5xx
        console.log(error);
        toastr.error(error.response.data.message)
    });
}

function updateWithFormData(url, data, redirectRoute) {
    axios.post(url, data).then(function (response) {
        // handle success 2xx
        console.log(response);
        if (redirectRoute != undefined) {
            window.location.href = redirectRoute;
        } else {
            toastr.success(response.data.message);
        }
    }).catch(function (error) {
        // handle error 4xx - 5xx
        console.log(error);
        toastr.error(error.response.data.message)
    });
}
