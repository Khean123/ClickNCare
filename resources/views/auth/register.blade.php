<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  
  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/styleregister.css') }}">
  <link rel="stylesheet" href="{{ asset('css/vars.css') }}">
  
  <style>
    a,
    button,
    input,
    select,
    h1,
    h2,
    h3,
    h4,
    h5,
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        border: none;
        text-decoration: none;
        background: none;
        -webkit-font-smoothing: antialiased;
    }
    
    menu, ol, ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    
    body {
      font-family: Arial, sans-serif;
      overflow: hidden;
    }
    
    .frame-1 {
      background: #ffffff;
      opacity: 0.95;
      height: 100vh;
      width: 100vw;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
    }
    
    .image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }
    
    /* Register container */
    .register-container {
      position: absolute;
      left: 700px;
      width: 400px;
      padding: 30px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    
    .register-header {
      font-size: 36px;
      color: #030bf1;
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
    }
    
    /* Input groups */
    .input-group {
      margin-bottom: 20px;
    }
    
    .input-label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      font-style: italic;
      color: #000;
    }
    
    .input-field {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background: #fff;
    }
    
    /* Register button */
    .register-button {
      width: 100%;
      padding: 12px;
      background: #009951;
      color: white;
      border-radius: 8px;
      border: 1px solid #14ae5c;
      cursor: pointer;
      font-weight: bold;
      margin-top: 10px;
      transition: background 0.3s;
    }
    
    .register-button:hover {
      background: #007a40;
    }
    
    /* Login link */
    .login-link {
      text-align: center;
      margin-top: 20px;
      font-style: italic;
    }
    
    .login-link a {
      color: #030bf1;
    }
    
    /* Side image */
    .screenshot-2025-04-22-233713-removebg-preview-1 {
      width: 381px;
      height: 336px;
      position: absolute;
      left: 200px;
      top: 50%;
      transform: translateY(-50%);
      object-fit: cover;
    }
    
    /* Error messages */
    .invalid-feedback {
      color: red;
      font-size: 12px;
      margin-top: 5px;
    }
    
    .input-field.is-invalid {
      border-color: red;
    }
  </style>
</head>
<body>
  <div class="frame-1">
    <!-- Background image -->
    <img class="image" src="{{ asset('images/image0.png') }}" alt="Background" />
    
    <!-- Register form -->
    <div class="register-container">
      <div class="register-header">Register</div>
      
      <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="input-group">
          <label for="name" class="input-label">Name</label>
          <input id="name" type="text" class="input-field @error('name') is-invalid @enderror" 
                 name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                 placeholder="Enter your name">
          @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        
        <div class="input-group">
          <label for="email" class="input-label">Email</label>
          <input id="email" type="email" class="input-field @error('email') is-invalid @enderror" 
                 name="email" value="{{ old('email') }}" required autocomplete="email"
                 placeholder="Enter your email">
          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        
        <div class="input-group">
          <label for="password" class="input-label">Password</label>
          <input id="password" type="password" class="input-field @error('password') is-invalid @enderror" 
                 name="password" required autocomplete="new-password"
                 placeholder="Enter your password">
          @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        
        <div class="input-group">
          <label for="password-confirm" class="input-label">Confirm Password</label>
          <input id="password-confirm" type="password" class="input-field" 
                 name="password_confirmation" required autocomplete="new-password"
                 placeholder="Confirm your password">
        </div>
        
        <button type="submit" class="register-button">
          Register
        </button>
        
        <div class="login-link">
          Already have an account? 
          <a href="{{ route('login') }}">Login</a>
        </div>
      </form>
    </div>
    
    <!-- Side image -->
    <img class="screenshot-2025-04-22-233713-removebg-preview-1" 
         src="{{ asset('images/screenshot-2025-04-22-233713-removebg-preview-10.png') }}" 
         alt="Register Illustration" />
  </div>
</body>
</html>