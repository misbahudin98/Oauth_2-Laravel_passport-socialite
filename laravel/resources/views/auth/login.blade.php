<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Login - pcke.org</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    integrity="sha512-Fo3rlrZj/kMVqzD9r5eIu8z/6x8DfxeXpF7+un00ay8x/99/z5+LzQABl/7Em3P75jRj2uZj3YsEdt/3Y/RiOA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      background: #f5f5f5;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-wrapper {
      display: flex;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      max-width: 900px;
      width: 100%;
    }

    /* Kolom slider */
    .login-image {
      flex: 1;
      display: none;
      /* Hidden on small screens */
    }

    @media (min-width: 768px) {
      .login-image {
        display: block;
      }
    }

    /* Kolom form login */
    .login-form {
      flex: 1;
      padding: 30px;
    }

    h2 {
      font-weight: 600;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      padding: 10px 20px;
      font-size: 16px;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.3s;
      border: none;
      cursor: pointer;
      width: 100%;
      justify-content: center;
      margin-bottom: 10px;
    }

    .btn-icon {
      display: inline-block;
      width: 24px;
      height: 24px;
      background-size: contain;
      background-position: center;
      background-repeat: no-repeat;
      margin-right: 10px;
    }

    /* Tombol Google */
    .btn-google {
      background-color: #540d6e;
    }

    .btn-google:hover {
      background-color: rgb(210, 210, 210);
      color: #000;
    }

    .btn-google .btn-icon {
      background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/24px-Google_%22G%22_logo.svg.png');
    }

    /* Tombol Facebook */
    .btn-facebook {
      background-color: #ee4266;
    }

    .btn-facebook:hover {
      background-color: rgb(210, 210, 210);
      color: #000;
    }

    .btn-facebook .btn-icon {
      background-image: url('https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_(2019).png');
    }

    /* Tombol Facebook */
    .btn-github {
      background-color:#ffd23f;
    }

    .btn-github:hover {
      background-color: rgb(210, 210, 210);
      color: #000;
    }

    .btn-github .btn-icon {
      background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/c/c2/GitHub_Invertocat_Logo.svg/240px-GitHub_Invertocat_Logo.svg.png');
    }
  </style>
</head>

<body>
  <div class="login-wrapper">
    <!-- Kolom Slider di Background Kiri -->
    <div class="login-image">
      <div id="carouselBackground" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner h-100">
          <div class="carousel-item active h-100">
            <img src="https://st.depositphotos.com/17620692/58435/v/450/depositphotos_584355608-stock-illustration-abstract-colorful-blue-red-yellow.jpghttps://i.pinimg.com/736x/5b/64/99/5b6499cc2b325a7cc556c4d61f811357.jpghttps://i.pinimg.com/736x/5b/64/99/5b6499cc2b325a7cc556c4d61f811357.jpg" class="d-block w-100 h-100" alt="Slide 1" style="object-fit: cover;">
          </div>
          <div class="carousel-item h-100">
            <img src="https://www.pixelstalk.net/wp-content/uploads/images6/Abstract-Wallpaper-4K-Wallpaper-HD.png" class="d-block w-100 h-100" alt="Slide 2" style="object-fit: cover;">
          </div>
          <div class="carousel-item h-100">
            <img src="https://cdn.pixabay.com/photo/2016/05/22/19/15/background-1409028_640.png" class="d-block w-100 h-100" alt="Slide 3" style="object-fit: cover;">
          </div>
        </div>
      </div>
    </div>

    <!-- Kolom Form Login -->
    <div class="login-form">
      <h2 class="mb-4 text-center">Login ke pcke.org</h2>
      <!-- Form Login Lokal -->
      <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-secondary">Login</button>
      </form>

      <hr>
      <p class="text-center">Atau login dengan:</p>

      <!-- Tombol Login Sosial -->
      <div>
        <a href="{{ route('platform.redirect') }}?platform=google" class="btn btn-google">
          <span class="btn-icon"></span>
          Login with Google
        </a>
        <a href="{{ route('platform.redirect') }}?platform=facebook" class="btn btn-facebook">
          <span class="btn-icon"></span>
          Login with Facebook
        </a>
        <a href="{{ route('platform.redirect') }}?platform=github" class="btn btn-github">
          <span class="btn-icon"></span>
          Login with Github
        </a>
      </div>

      <!-- Tampilkan Error jika ada -->
      @if ($errors->any())
      <div class="alert alert-danger mt-3">
        @foreach ($errors->all() as $error)
        <p class="mb-1">{{ $error }}</p>
        @endforeach
      </div>
      @endif
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>