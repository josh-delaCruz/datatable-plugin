$(document).ready(function () {
    $('#tabella').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '../index.php',
            type: 'POST',
        },
        columns: [
            { data: 'id' },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'gender' },
            { data: 'birth_date' },
            { data: 'hire_date' },
        ],
    });
});
