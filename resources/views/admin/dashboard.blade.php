@extends('layouts.admin')
@section('title','Dashboard Admin')

@section('content')
  <h1>Dashboard</h1>

  <div class="cards-container">
    <div class="card">
      <div class="card-icon"><i class="fas fa-user"></i></div>
      <div class="card-info"><h3>Data User</h3><p>{{ $userCount }}</p></div>
    </div>
    <div class="card">
      <div class="card-icon"><i class="fas fa-users"></i></div>
      <div class="card-info"><h3>Data Anggota</h3><p>{{ $anggotaCount }}</p></div>
    </div>
    <div class="card">
      <div class="card-icon"><i class="fas fa-newspaper"></i></div>
      <div class="card-info"><h3>Data Berita</h3><p>{{ $beritaCount }}</p></div>
    </div>
    <div class="card">
      <div class="card-icon"><i class="fas fa-envelope"></i></div>
      <div class="card-info"><h3>Data Aspirasi</h3><p>{{ $aspirasiCount }}</p></div>
    </div>
  </div>

 <section class="data-table-container">
  <h2>Data User</h2>
  <table class="data-table">
    <thead>
      <tr>
        <th>Photo User</th>
        <th>Name</th>
        <th>Email</th>
        <th>No. HP</th>
        <th>Role</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($users as $user)
        <tr>
          <td class="user-photo">
            <img src="{{ $user->photo_url ?? 'https://i.pravatar.cc/40' }}" alt="User">
          </td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->no_wa }}</td>
          <td>{{ strtoupper($user->role) }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="5" style="text-align:center; color:#888; padding:20px;">
            Belum ada data user
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</section>

@endsection
