@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>URL Details</h3>
            <a href="{{ route('admin.urls.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.urls.update', $url) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label>Short URL</label>
                    <input type="text" class="form-control" value="{{ url("/u/{$url->shortener_url}") }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label>Original URL</label>
                    <input type="url" name="original_url" class="form-control" value="{{ $url->original_url }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $url->title }}">
                </div>

                <div class="form-group mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $url->description }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>User</label>
                    <select name="user_id" class="form-control" required>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ $url->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update URL</button>
                    
                    <form action="{{ route('admin.urls.destroy', $url) }}" method="POST" class="d-inline float-end">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this URL?')">
                            Delete URL
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection