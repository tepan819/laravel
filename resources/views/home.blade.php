@extends('layouts.app')

@section('title', 'Home | Personal Portfolio')

@section('content')
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#home">MyPortfolio</a>
        </div>
    </nav>
    <section class="container py-5">
        <p>HELLO, I'M</p>
        <h1>{{ $profile->name ?? 'Tepan' }}</h1>
        <h2>{{ $profile->headline ?? 'Web Developer' }}</h2>
        <p>{{ $profile->bio ?? 'Selamat datang di website portfolio saya.' }}</p>
    </section>
@endsection