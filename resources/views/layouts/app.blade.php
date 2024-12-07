<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Pegawai')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" />

    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
</head>
<style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.sidebar {
    width: 250px;
    background-color: #343a40;
    color: white;
    position: fixed;
    height: 100%;
    padding: 20px 10px;
    transition: transform 0.3s ease;
}

.sidebar h4 {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 20px;
}

.sidebar a {
    text-decoration: none;
    color: #adb5bd;
    display: block;
    margin: 15px 0;
    padding: 10px;
    border-radius: 5px;
}

.sidebar a:hover {
    background-color: #495057;
    color: white;
}

.content {
    margin-left: 260px;
    padding: 20px;
    transition: margin-left 0.3s ease;
}

.navbar {
    margin-left: 260px;
    background-color: #e9ecef;
}

.navbar .nav-link {
    color: #495057;
}

.navbar .nav-link:hover {
    color: #000;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead.table-dark th {
    background-color: #343a40;
    color: white;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

tbody tr:hover {
    background-color: #ddd;
}

.footer {
    text-align: center;
    padding: 10px 0;
    background: #343a40;
    color: white;
    margin-top: 20px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
    margin-top: 20px;
}

@media (max-width: 768px) {
    .content {
        margin-left: 50px;
        padding-left: 15px;
        padding-right: 15px;
    }

    .sidebar.active + .content {
        margin-left: 200px;
    }

    .sidebar {
        transform: translateX(-250px);
        width: 200px;
    }

    .sidebar.active {
        transform: translateX(0);
    }

    .sidebar a {
        font-size: 14px;
    }
}

.burger-menu {
    display: none;
    font-size: 24px;
    cursor: pointer;
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 9999;
}

/* .burger-menu div {
    width: 30px;
    height: 4px;
    background-color: #333;
    margin: 6px 0;
    transition: 0.4s;
} */

@media (max-width: 768px) {
    .burger-menu {
        display: flex;
    }
}

</style>
<body>
    <div class="burger-menu">
        &#9776;
    </div>
    <div class="sidebar">
        <h4>Dashboard</h4>
        <a href="{{ route('pegawai.index') }}">Pegawai</a>
        <a href="{{ route('pegawai.create') }}">Tambah Pegawai</a>
    </div>

    

    <div class="content">
        <h1>@yield('title', 'Dashboard')</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>

    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

<!-- FILEINPUT JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/js/fileinput.min.js"></script>

<!-- SELECT2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>
    $(document).ready(function() {
        $('.burger-menu').click(function() {
            $('.sidebar').toggleClass('active');
            $('.content').toggleClass('active');
        });

        $("#file_ktp").fileinput({
                showPreview: true,
                allowedFileExtensions: ['jpg', 'jpeg', 'png', 'pdf'],
                showUpload: false,
                browseClass: "btn btn-primary",
                previewFileType: 'any',
                theme: 'fas',
        });
        
        $("#file_ktp_edit").fileinput({
            showPreview: true,
            allowedFileExtensions: ['jpg', 'jpeg', 'png', 'pdf'],
            showUpload: false,
            browseClass: "btn btn-primary",
            previewFileType: 'any',
            theme: 'fas',
        });

        $('#pegawai-table').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            paging: true,
            buttons: ['excel', 'pdf', 'print'],
        });
        
        $('#tanggal_lahir').datepicker({
                dateFormat: 'yy-mm-dd',  
                changeMonth: true,       
                changeYear: true,         
                yearRange: '1900:2023',   
                maxDate: new Date(),      
            });
        
        $('#daterange').daterangepicker({
            opens: 'left',  
            locale: {
                format: 'YYYY-MM-DD',  
            }
        });
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $('input[name="date_range"]').val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    });
</script>

</body>
</html>
