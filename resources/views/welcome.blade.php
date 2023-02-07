@extends('partial')
@section('content')
<style>
  .p-5 {
      background-image: linear-gradient(to right, #86E5FF, #7399bd);
  }
  .btn{
      background-image: #5BC0F8;
  }
  h1{
     color: #FFC93C;
  }
</style>
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold">Moiise Market</h1>
      <p class="col-md-10 fs-4" font>  
        Welcome to Moiise Market, your one-stop shop for all things shopping. Choose from a diverse range of categories including fashion, electronics, home & garden, and more. Enjoy a smooth shopping experience with our user-friendly platform and simple checkout process. Only top-quality products hand-selected for their value are offered. Join our satisfied customers and start shopping now!
      </p>   
      <a class="btn btn-light btn-lg" href="{{ url('/auth/redirect') }}" role="button"> <img src="{{url('images/icons8-google-48.png')}}" alt=""> Login with Google</a>
    </div>
  </div>
@endsection