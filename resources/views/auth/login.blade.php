<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }
    
    body {
      background-color: #f5f7fa;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #333;
      position: relative;
      overflow: hidden;
    }
    
    .background-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: 0;
      opacity: 0.5; /* Adjust opacity as needed */
    }
    
    .login-container {
      display: flex;
      width: 900px;
      height: 600px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
      z-index: 1;
    }
    
    .illustration-side {
      flex: 1;
      background: linear-gradient(135deg,rgb(0, 104, 131) 0%,rgb(0, 251, 255) 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      position: relative;
    }
    
    .illustration-side img {
      width: 100%;
      max-width: 300px;
      margin-bottom: 30px;
    }
    
    .illustration-side h2 {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }
    
    .illustration-side p {
      font-size: 14px;
      text-align: center;
      opacity: 0.9;
      line-height: 1.6;
    }
    
    .login-side {
      flex: 1;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    .login-header {
      margin-bottom: 40px;
      text-align: center;
    }
    
    .login-header h1 {
      font-size: 28px;
      font-weight: 600;
      color: #009951;
      margin-bottom: 10px;
    }
    
    .login-header p {
      font-size: 14px;
      color: #666;
    }
    
    .form-group {
      margin-bottom: 25px;
      position: relative;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      font-size: 14px;
      color: #555;
    }
    
    .input-field {
      width: 100%;
      padding: 12px 15px 12px 40px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s;
      background-color: #f9f9f9;
    }
    
    .input-field:focus {
      outline: none;
      border-color: #009951;
      box-shadow: 0 0 0 3px rgba(0, 153, 81, 0.1);
      background-color: white;
    }
    
    .input-icon {
      position: absolute;
      left: 15px;
      top: 40px;
      color: #777;
      font-size: 16px;
    }
    
    .btn-login {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #009951 0%, #14ae5c 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 10px;
    }
    
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 153, 81, 0.3);
    }
    
    .forgot-password {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #666;
    }
    
    .forgot-password a {
      color: #009951;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.2s;
    }
    
    .forgot-password a:hover {
      text-decoration: underline;
    }
    
    .invalid-feedback {
      color: #e74c3c;
      font-size: 12px;
      margin-top: 5px;
      display: block;
    }
    
    .is-invalid {
      border-color: #e74c3c !important;
    }
    
    .is-invalid:focus {
      box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .login-container {
        flex-direction: column;
        width: 90%;
        height: auto;
      }
      
      .illustration-side {
        padding: 30px 20px;
      }
      
      .illustration-side img {
        max-width: 200px;
      }
      
      .login-side {
        padding: 40px 30px;
      }
      
      .background-image {
        opacity: 0.1; /* More subtle on mobile */
      }
    }
    
    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .login-side {
      animation: fadeIn 0.6s ease-out;
    }
  </style>
</head>
<body>
  <!-- Full-page background image -->
 <img src="{{ url('frontend/images/back.png') }}" alt="Background" class="background-image">

  <div class="login-container">
    <div class="illustration-side">
      <img src="{{ url('frontend/images/screenshot-2025-04-22-233713-removebg-preview-10.png') }}" alt="Login Illustration">
      <h2>Welcome Back! Admin</h2>
    </div>
    
    <div class="login-side">
      <div class="login-header">
        <h1>Login In</h1>
      </div>
      
      <form action="{{ route('login') }}" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="email">Email Address</label>
          <i class="fas fa-envelope input-icon"></i>
          <input type="email" id="email" name="email" 
                 class="input-field @error('email') is-invalid @enderror" 
                 placeholder="your@email.com" 
                 value="{{ old('email') }}" 
                 required>
          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <i class="fas fa-lock input-icon"></i>
          <input type="password" id="password" name="password" 
                 class="input-field @error('password') is-invalid @enderror" 
                 placeholder="••••••••" 
                 required>
          @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        
        <button type="submit" class="btn-login">
          Login <i class="fas fa-arrow-right"></i>
        </button>
        
        <div class="forgot-password">
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot your password?</a>
          @endif
        </div>
      </form>
    </div>
  </div>
  
  <!-- Scripts -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script>
    // Simple animation on input focus
    document.querySelectorAll('.input-field').forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.querySelector('.input-icon').style.color = '#009951';
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.querySelector('.input-icon').style.color = '#777';
      });
    });
  </script>
</body>
</html>