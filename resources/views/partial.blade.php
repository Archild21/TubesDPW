@extends('template')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <link rel="icon" href="{{url('images/logo_sml.png')}}">
</head>
<body>
    <style>
    .navbar {
        background-image: linear-gradient(to right, #5BC0F8, #0081C9);
  }
    </style>
    <nav class="navbar navbar-dark bg-dark" aria-label="First navbar example">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{url('/')}}">{{config('app.name')}}</a>
            @auth
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link" href="{{url('/dashboard')}}">Dashboard</a>
                    </li>
                </ul>
    
                <div class="d-flex align-items-center">
                    <ul class="navbar-nav ml-auto ">
                        
                            <div class="d-flex align-items-center">
                                <a href="{{url('user')}}" class="nav-link me-3">User</a>
                                <a href="{{url('logout')}}" class="nav-link me-3">Logout</a>
                            </div>
                        
                    </ul>
                </div>
            @endauth
        </div>
    </nav>
</body>
</html>



