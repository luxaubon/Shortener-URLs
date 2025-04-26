@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <h2>{{ $stats['total_users'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total URLs</h5>
                    <h2>{{ $stats['total_urls'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Recent URLs</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Original URL</th>
                        <th>Short URL</th>
                        <th>Created By</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats['recent_urls'] as $url)
                    <tr>
                        <td>{{ $url->title }}</td>
                        <td>{{ Str::limit($url->original_url, 30) }}</td>
                        <td>{{ route('shortener.redirect', $url->shortener_url) }}</td>
                        <td>{{ $url->user->name }}</td>
                        <td>{{ $url->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



