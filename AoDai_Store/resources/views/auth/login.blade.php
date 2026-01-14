<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; 
        }

        body {
            background: linear-gradient(135deg, #fdfbf9 0%, #f3ece4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Blobs trang trí */
        .blob {
            position: absolute;
            width: 40vw; 
            height: 40vw;
            background: #f1e4d5;
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.6;
        }
        .blob-1 { top: -10%; left: -10%; }
        .blob-2 { bottom: -10%; right: -10%; background: #e8ded2; }

        /* Card tinh chỉnh */
        .soft-card {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(10px);
            border-radius: 2rem !important;
            border: none;
        }

        .form-control {
            background-color: #fcfaf8 !important;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(128, 0, 0, 0.1);
            background-color: #ffffff !important;
        }
    </style>
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container">
        <div class="row justify-content-center g-0">
            <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-5">
                
                <div class="card shadow-lg soft-card">
                    <div class="card-body p-4 p-md-5">
                        @if (session('success'))
                            <div id="success-alert" class="alert border-0 shadow-sm mb-4 d-flex align-items-center" 
                                style="background-color: rgba(40, 167, 69, 0.1); color: #28a745; border-radius: 15px; padding: 15px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                <div class="fw-bold small">
                                    {{ session('success') }}
                                </div>
                            </div>

                            <script>
                                setTimeout(function() {
                                    let alert = document.getElementById('success-alert');
                                    if (alert) {
                                        alert.style.transition = "all 0.5s ease";
                                        alert.style.opacity = "0";
                                        alert.style.transform = "translateY(-10px)";
                                        setTimeout(() => alert.remove(), 500);
                                    }
                                }, 4000);
                            </script>
                        @endif
                        <div class="text-center mb-4">
                            <div class="d-inline-block p-3 rounded-circle mb-3" style="background-color: rgba(128, 0, 0, 0.08);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" style="color: #800000;">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                            </div>
                            <h2 class="fw-bold h4 mb-1" style="color: #5d534a;">ĐĂNG NHẬP</h2>
                            <p class="text-muted small">Chào mừng bạn đã quay trở lại</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control border-0 shadow-none" id="TenDangNhap" name="TenDangNhap" placeholder="admin" required value="{{ old('TenDangNhap') }}">
                                <label for="TenDangNhap" class="text-muted small">Tên đăng nhập</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control border-0 shadow-none" id="MatKhau" name="MatKhau" placeholder="Password" required>
                                <label for="MatKhau" class="text-muted small">Mật khẩu</label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label small text-muted" for="remember">Ghi nhớ</label>
                                </div>
                                <a href="#" class="text-decoration-none small fw-bold" style="color: #800000;">Quên mật khẩu?</a>
                            </div>

                            <button type="submit" class="btn w-100 py-3 rounded-4 fw-bold shadow-sm text-white border-0" style="background-color: #800000;">
                                ĐĂNG NHẬP
                            </button>
                        </form>

                        <div class="text-center mt-4 text-muted small">
                            Chưa có tài khoản? <a href="/register" class="fw-bold text-decoration-none" style="color: #800000;">Đăng ký</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>