@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manajemen Hak Akses</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('role-permission.update') }}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $i => $role)
                        <tr>
                            <td><strong>{{ $role->name }}</strong></td>
                            <td>
                                <input type="hidden" name="role_id[{{ $i }}]" value="{{ $role->id }}">
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" 
                                                       name="permissions[{{ $i }}][]" value="{{ $permission->name }}" 
                                                       {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary btn-sm mt-3" style="font-size: 12px">
                <i class="fas fa-save mr-1"></i>
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
