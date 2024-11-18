<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Category Page</title>
</head>

<body>

    @if (session('success'))
        <script>
            Swal.fire({
                title: "Success",
                text: "{{ session('success') }}",
                icon: "success",
                showConfirmButton: true,
                timer: 3000
            });
        </script>
    @endif
    <div class="container my-4">
        <h1 class="mb-3">Categories</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Create Category</a>
            <a href="" class="btn btn-success">Product</a>
        </div>
        <div class="table-responsive">
            <div class="card">
                <div class="card-footer">
                    <table id="categories-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('categories.index') }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Handle delete confirmation
        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // // Toggle category status
        // $(document).on('click', '.toggle-status', function() {
        //     var categoryId = $(this).data('id');
        //     var newStatus = $(this).data('status');
        //     var button = $(this);

        //     $.ajax({
        //         url: '/categories/' + categoryId + '/update-status',
        //         type: 'PATCH',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             status: newStatus
        //         },
        //         success: function(response) {
        //             if (newStatus === 'active') {
        //                 button.removeClass('btn-secondary').addClass('btn-success').text(
        //                     'Active');
        //                 button.data('status', 'inactive');
        //             } else {
        //                 button.removeClass('btn-success').addClass('btn-secondary').text(
        //                     'Inactive');
        //                 button.data('status', 'active');
        //             }
        //         },
        //         error: function() {
        //             alert('Error updating status');
        //         }
        //     });
        // });
    });
</script>

</html>
