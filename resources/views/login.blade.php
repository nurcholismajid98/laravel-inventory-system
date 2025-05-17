<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="icon" href="{{ asset('image/new_logo.png') }}" type="image/png">
    <title>Login</title>
    <style>
        body,
        html {
            height: 100%;
            background-color: #82e2a1;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #dc3545;
            /* Warna merah */
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px auto;
        }

        .icon-circle .bi {
            font-size: 30px;
            color: #fff;
        }

        .input-group-text {
            cursor: pointer;
        }

        img {
            max-height: 150px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Login</h3>
                    <img src="{{ asset('image/new_logo.png') }}" alt="Logo" class="img-fluid mx-auto d-block">
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Email wajib diisi" autocomplete="new-email" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Username wajib diisi" autocomplete="new-username" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password wajib diisi" autocomplete="new-password" required>
                                <span class="input-group-text" id="togglePassword">
                                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" autocomplete="off" required>
                                <option value="" disabled selected>Pilih Role (wajib diisi)</option>
                                <option value="IT Support">IT Support</option>
                                <option value="Admin GA">Admin GA</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="icon-circle">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <h5 class="modal-title mb-3" id="errorModalLabel">Login Gagal</h5>
                    <p>Akun tidak sesuai. Silakan periksa kembali email, username, password, dan role Anda.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle visibility password
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        });
    </script>

    @if ($errors->has('loginError'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    @endif
</body>

</html>