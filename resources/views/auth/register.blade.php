<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="width: 50%; height: 100px;">
        <h2 class="mt-5 text-center">Registrasi</h2>

        <!-- Alert for error messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mt-4">
            <div class="card-body">
                <form action="{{ route('daftar') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="company_name">Company Name:</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat">
                    </div>
                    <div class="form-group">
                        <label for="no_telepon">Nomor Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" id="no_telepon" placeholder="Nomor Telepon">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi"></textarea>
                    </div>                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="" disabled selected hidden>Pilih Role</option> 
                            <option value="merchant">Merchant</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>                    
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </form>
                <div class="mt-3">
                    <p>Sudah punya akun? <a href="{{ route('login') }}" class="btn btn-link">Login Sekarang</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-ZVP8gziD15h9NUX7YgPfH+6m3uZQ4LkD3mDP5PBjGMq0PzBr64Vf8uY44S0N1Q0t" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-5c5ss5x56t/6UbR5I76sKDf8G9bNnE8+RW2nbQ+fxZBgBv1Ke5sZ9M2qeHeD4F8g" crossorigin="anonymous"></script>
</body>
</html>
