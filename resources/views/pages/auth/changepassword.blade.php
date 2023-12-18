@extends('layout.default')


@section('title')
    Change password
@endsection


@section('content')
    <form action="{{ url('changepassword') }}" method="POST">
        @csrf
        <h1>Change password</h1>
        <div class="mb-3">
            <label class="form-label">Old password</label>
            <input class="form-control" type="password" name="oldPassword" placeholder="Enter old password" required />
        </div>
        <div class="mb-3">
            <label class="form-label">New password</label>
            <input class="form-control" type="password" name="password" placeholder="Enter new password" required />
        </div>
        <div class="mb-3">
            <label class="form-label">New password</label>
            <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm new password"
                required />
        </div>
        <button type="submit" class="btn btn-primary">Change password</button>
    </form>
@endsection
