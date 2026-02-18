<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>People List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        table { font-family: 'Poppins', sans-serif; }
        h2 { font-weight: 600; }
    </style>
</head>
<body class="bg-light py-4">
<div class="container">
    <h2 class="mb-4 text-center">People List</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Add Person Form --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('people.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-primary w-100">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- People Table --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="10%">ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($people as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->firstname }}</td>
                            <td>{{ $p->lastname }}</td>
                            <td>
                                {{-- Update Button triggers modal --}}
                                <button 
                                    class="btn btn-warning btn-sm me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $p->id }}"
                                    data-firstname="{{ $p->firstname }}"
                                    data-lastname="{{ $p->lastname }}"
                                >Update</button>

                                {{-- Delete --}}
                                <form action="{{ route('people.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this person?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No people found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Person</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" name="firstname" id="editFirstname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="lastname" id="editLastname" class="form-control" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Pass data to modal and set form action
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var firstname = button.getAttribute('data-firstname');
        var lastname = button.getAttribute('data-lastname');

        // Set input values
        document.getElementById('editFirstname').value = firstname;
        document.getElementById('editLastname').value = lastname;

        // Set form action dynamically using Laravel url helper
        document.getElementById('editForm').action = '{{ url("people") }}/' + id;
    });
</script>
</body>
</html>
