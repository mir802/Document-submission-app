@extends('layouts.app') {{-- or whatever your layout file is named --}}

@section('content')
    <h3>All Users</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Admin Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }} {{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge 
                            {{ $user->is_admin ? 'bg-success' : ($user->is_reviewer ? 'bg-warning' : 'bg-secondary') }}">
                            {{ $user->is_admin ? 'Admin' : ($user->is_reviewer ? 'Reviewer' : 'User') }}
                        </span>
                    </td>
                    <td>
                        @if(auth()->user()->is_admin && $user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.toggleAdmin', $user) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $user->is_reviewer ? 'btn-danger' : 'btn-success' }}">
                                    {{ $user->is_reviewer ? 'Remove Reviewer' : 'Make Reviewer' }}
                                </button>
                            </form>
                        @elseif($user->id === auth()->id())
                            <em>You</em>
                        @else
                            <em>Restricted</em>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
