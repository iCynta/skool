<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Admission No</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .suggestions {
            border: 1px solid #ddd;
            border-radius: 5px;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            z-index: 1000;
            background: white;
        }
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Search Admission No</h2>
        <div class="form-group">
            <label for="admissionSearch">Admission No:</label>
            <input type="text" class="form-control" id="admissionSearch" placeholder="Enter Admission No">
            <div class="suggestions" id="suggestions" style="display: none;"></div>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Admission No</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Batch</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody id="resultsTable">
                <!-- Rows will be populated here -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const suggestions = [
            { id: 1, admission_no: '12345', name: 'John Doe', course: 'Computer Science', batch: '2022', department: 'Engineering' },
            { id: 2, admission_no: '12346', name: 'Jane Smith', course: 'Business', batch: '2022', department: 'Commerce' },
            { id: 3, admission_no: '12347', name: 'Emily Johnson', course: 'Arts', batch: '2022', department: 'Humanities' },
        ];

        $('#admissionSearch').on('input', function() {
            const query = $(this).val().toLowerCase();
            $('#suggestions').empty().hide();

            if (query) {
                const filteredSuggestions = suggestions.filter(s => s.admission_no.includes(query));
                filteredSuggestions.forEach(s => {
                    $('#suggestions').append(`<div class="suggestion-item" data-id="${s.id}">${s.admission_no} - ${s.name}</div>`);
                });
                $('#suggestions').show();
            }
        });

        $(document).on('click', '.suggestion-item', function() {
            const id = $(this).data('id');
            const selectedStudent = suggestions.find(s => s.id === id);
            populateTable(selectedStudent);
            $('#admissionSearch').val(selectedStudent.admission_no);
            $('#suggestions').hide();
        });

        function populateTable(student) {
            $('#resultsTable').append(`
                <tr>
                    <td>${student.id}</td>
                    <td>${student.admission_no}</td>
                    <td>${student.name}</td>
                    <td>${student.course}</td>
                    <td>${student.batch}</td>
                    <td>${student.department}</td>
                </tr>
            `);
        }
    </script>
</body>
</html>
