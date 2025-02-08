@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengguna</h3>
        <div class="card-tools">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Hak Akses</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="role" class="form-control" onchange="this.form.submit()">
                                <option value="pengunjung" {{ $user->hasRole('pengunjung') ? 'selected' : '' }}>Pengunjung</option>
                                <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    </td>                    
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @if(auth()->user()->id !== $user->id)
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-ban"></i> Tidak Bisa Hapus
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
