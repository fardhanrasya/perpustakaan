@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="loginTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button" role="tab">Login Admin</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#siswa" type="button" role="tab">Login Siswa</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="loginTabContent">
                    <div class="tab-pane fade show active" id="admin" role="tabpanel">
                         <form action="{{ route('login.admin') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login Admin</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="siswa" role="tabpanel">
                        <form action="{{ route('login.siswa') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Login Siswa</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <p>Belum punya akun?</p>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary">Daftar Anggota</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
