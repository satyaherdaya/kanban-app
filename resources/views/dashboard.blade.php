<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            scroll-behavior: smooth;
            transition: 0.5s;
        }

        .category {
            min-width: 280px;
            min-height: 450px;
        }

        .task {
            min-width: 220px;
        }

        .navbar {
            flex-shrink: 0;
            width: 100%;
        }

        main {
            overflow: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar sticky-top bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Kanban App</a>
            <a class="btn btn-danger" href="/logout">logout</a>
        </div>
    </nav>
    <div class="mt-3 mx-3">
        <a class="btn btn-primary" href="/category/create">Create New Category</a>
    </div>
    <main class="d-flex flex-wrap py-2">
        <div class="d-flex justify-content-center flex-nowrap">
            @foreach($categories as $index => $category)
            <div class="card m-3 category">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="ms-2 d-flex flex-wrap">
                            <h2>{{ $category->title }}</h2>
                            <a href="/category/update/{{ Illuminate\Support\Facades\Crypt::encryptString($category->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                            </a>
                        </div>
                        <div class="d-flex flex-wrap">
                            <a class="m-1" href="/task/create/{{ Illuminate\Support\Facades\Crypt::encryptString($category->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                    <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z" />
                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
                                </svg>
                            </a>
                            <a class="m-1" href="/category/delete/{{ Illuminate\Support\Facades\Crypt::encryptString($category->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    @foreach($category->task as $tasks)
                    <div class="card m-3 task">
                        <div class="card-body" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{$tasks->id}}" style="cursor: pointer;">
                            <h3 class="text-nowrap">{{ $tasks->title }}</h3>
                            <p>{{ $tasks->description }}</p>
                        </div>
                        @if($index+1 == count($categories) )
                        <div class="card-footer d-flex flex-wrap justify-content-start bg-white">
                            <form action="/task/update/category" method="post">
                                @csrf
                                <input type="hidden" name="prev" id="prev" value="{{ Illuminate\Support\Facades\Crypt::encryptString($categories[$index-1]->id) }}">
                                <input type="hidden" name="id" id="id" value="  {{ Illuminate\Support\Facades\Crypt::encryptString($tasks->id) }}">
                                <button type="submit" class="btn p-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @elseif($index-1 == -1)
                        <div class="card-footer d-flex flex-wrap justify-content-end bg-white">
                            <form action="/task/update/category" method="post">
                                @csrf
                                <input type="hidden" name="next" id="next" value="{{ Illuminate\Support\Facades\Crypt::encryptString($categories[$index+1]->id) }}">
                                <input type="hidden" name="id" id="id" value="{{ Illuminate\Support\Facades\Crypt::encryptString($tasks->id) }}">
                                <button type="submit" class="btn p-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="card-footer d-flex flex-wrap justify-content-between bg-white">
                            <form action="/task/update/category" method="post">
                                @csrf
                                <input type="hidden" name="prev" id="prev" value="{{ Illuminate\Support\Facades\Crypt::encryptString($categories[$index-1]->id) }}">
                                <input type="hidden" name="id" id="id" value="{{ Illuminate\Support\Facades\Crypt::encryptString($tasks->id) }}">
                                <button type="submit" class="btn p-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                                    </svg>
                                </button>
                            </form>
                            <form action="/task/update/category" method="post">
                                @csrf
                                <input type="hidden" name="next" id="next" value="{{ Illuminate\Support\Facades\Crypt::encryptString($categories[$index+1]->id) }}">
                                <input type="hidden" name="id" id="id" value="{{ Illuminate\Support\Facades\Crypt::encryptString($tasks->id) }}">
                                <button type="submit" class="btn p-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endif

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop-{{$tasks->id}}" data-bs-backdrop="static" data-bs-indexboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $category->title }}</h5>
                                        <h2 class="modal-title" id="staticBackdropLabel">{{ $tasks->title }}</h2>
                                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                                            <a href="/task/update/{{ Illuminate\Support\Facades\Crypt::encryptString($tasks->id)}}" class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                            </a>
                                            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ $tasks->description }}</p>
                                    </div>
                                    <div class="modal-footer d-flex justify-cnotent-center align-items-center">
                                        <a href="/task/delete/{{ Illuminate\Support\Facades\Crypt::encryptString($tasks->id) }}">
                                            <button class="btn btn-danger">delete task</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </main>
</body>

</html>