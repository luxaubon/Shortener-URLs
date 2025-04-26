@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>URLs Management</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Original URL</th>
                        <th>Short URL</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($urls as $url)
                    <tr>
                        <td>{{ $url->title }}</td>
                        <td>
                            <a href="{{ $url->original_url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;">
                                {{ $url->original_url }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('shortener.redirect', $url->shortener_url) }}" target="_blank">
                                {{ $url->shortener_url }}
                            </a>
                        </td>
                        <td>{{ $url->user->name }}</td>
                        <td>{{ $url->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.urls.destroy', $url) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this URL?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $urls->links() }}
        </div>
    </div>
</div>
@endsection