<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
          <a class="navbar-brand" href="#">Dasboard </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search">
                @csrf
                <button class="btn btn-danger" type="submit">Logout</button>
            </form>
          </div>
        </div>
    </nav>
 
    <div class="container">
       <h1> Welcome, {{ Auth::user()->name }}</h1>
    </div>

    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('urls.store') }}" method="POST">
                    @csrf
                        <div class="mb-3">
                            <label for="search" class="form-label">TITLE : </label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="TITLE" required value="{{ old('title') }}">
                        </div>
                        <div class="mb-3">
                            <label for="search" class="form-label">URL : </label>
                            <input type="text" name="original_url" class="form-control" id="original_url" placeholder="URL" required value="{{ old('original_url') }}">
                        </div>
                        <div class="mb-3">
                            <div class="d-grid">
                                <button class="btn btn-primary">Short URL</button>
                            </div>
                        </div>
                    </form>

                    <div class="md-6">
                        @foreach ($urls as $item)
                          <p >
                          {{ $item->user->name }} {{ $item->created_at->format('j M Y, g:i a') }}
                          </p>
                            <div class="p-6 flex space-x-2">
                               
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-800"></span>
                                            <small class="ml-2 text-sm text-gray-600"></small>
                                            @unless ($item->created_at->eq($item->updated_at))
                                                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                            @endunless
                                        </div>
                                        <div>
                                        @if ($item->user->is(auth()->user()))
                                            <form action="{{ route('urls.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" 
                                                    onclick="return confirm('Are you sure you want to delete this URL?')">
                                                    DELETE
                                                </button>
                                            </form>
                                          @endif
                                        </div>
                                      </div>
                                      <p class="mt-4 text-lg text-gray-900">TITLE {{ $item->title }}</p>
                                      <p class="mt-4 text-lg text-gray-900">Original Url {{ $item->original_url }}</p>
                                      <p class="mt-4 text-lg text-gray-900">Shortener Url
                                          <a href="{{ route('shortener.redirect', $item->shortener_url) }}" target="_blank">
                                              {{ route('shortener.redirect', $item->shortener_url) }}
                                          </a>
                                      </p>
                                  </div>
                              </div>
                              <hr>
                          @endforeach
                      </div>

                    

                </div>
            </div>
        </div>
                    
    </div>
</body>
</html>