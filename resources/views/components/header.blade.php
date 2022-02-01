<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <div class="container-fluid">

        {{-- Brand --}}
        <a class="navbar-brand" href="#">
            Laravel Batching and Queues
        </a>

        {{-- Burger Bar Menu --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Links --}}
        <div class="collapse navbar-collapse" id="navbarColor03">

            <ul class="navbar-nav me-auto">

                {{-- Home --}}
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/') }}">Home
                        <span class="visually-hidden">(current)</span>
                    </a>
                </li>

                {{-- Progress --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/progress') }}">Progress</a>
                </li>

                {{-- Upload --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/upload') }}">Upload</a>
                </li>

            </ul>

        </div>

    </div>

</nav>
