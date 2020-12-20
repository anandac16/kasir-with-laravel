@extends('layouts.dashboard')
@section('custom_head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .w-90 {
            width: 90% !important;
        }

    </style>
@endsection

@section('title', $title)
@section('is_category_active', 'active')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Tables</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tables</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="#" class="btn btn-sm btn-neutral">New</a>
                        <a href="#" class="btn btn-sm btn-neutral">Filters</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0 form-inline">
                        <div class="col-lg-6">
                            <h3 class="mb-0">{{ $title }}</h3>
                        </div>
                        <div class="col-lg-6 text-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="add_btn"
                                onclick="clearForm()">Add Category</button>
                        </div>
                    </div>
                    <!-- Modal add inventory -->
                    <div class=" modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-dismissible fade" role="alert" id="message">

                                    </div>
                                    <form action="/unit/save" method="post" name="inv_form" id="inv_form">
                                        <div class="form-group form-inline">
                                            <input type="hidden" name="id_category" id="id_category" value="0">
                                            <div class="col-lg-4 text-right">Category</div>
                                            <div class="col-lg-8"><input type="text" name="category" id="category"
                                                    class="form-control w-90" required></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="save()">Save
                                        changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="id">No</th>
                                    <th scope="col" class="sort" data-sort="unit">Category</th>
                                    <th scope="col" width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($data as $key => $category)
                                    <tr>
                                        <td>
                                            {{ $key+1 }}
                                        </td>
                                        <td data-unit="{{ $category->category }}">
                                            {{ $category->category }}
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" onclick="edit({{ $category->id_category }}, '{{ $category->category }}')"
                                                        data-id="{{ $category->id_category }}">Edit</a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="deleteItem({{ $category->id_category }})"
                                                        data-id="{{ $category->id_category }}">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#message").hide();
           const csrf_token = document.querySelector('meta[name="csrf-token"]').content;

           function edit(id, category) {
               $("#id_category").val(id);
               $("#category").val(category);
               $("#exampleModal").modal('show');
            }

            function save() {
                let elements = document.getElementById("inv_form").elements;
                let xhttp = new XMLHttpRequest();
                let obj = {};
                for (let i = 0; i < elements.length; i++) {
                    let item = elements.item(i);
                    obj[item.name] = item.value;
                }

                xhttp.open("POST", "/category/save", true);
                xhttp.setRequestHeader("X-CSRF-TOKEN", csrf_token);
                xhttp.send(JSON.stringify(obj));

                xhttp.onreadystatechange = function() {
                    // If the request completed, close the extension popup
                    if (xhttp.readyState == 4) {
                        if (xhttp.status == 200) {
                            let json_data = JSON.parse(xhttp.responseText);
                            let class_type = 'alert-success'
                            if (json_data.result === false)
                                class_type = 'alert-danger'
                            $("#message").removeClass('fade alert-danger alert-success');
                            $("#message").addClass(class_type + " show");
                            $("#message").html(json_data.message);
                            $("#message").removeAttr("style");
                            $(".alert").fadeTo(3000, 0).slideUp(1000);
                            if (json_data.result === true)
                                window.open('/category', '_self')
                        }
                    }
                };
            }

            function deleteItem(id) {
                let areusure = confirm('Are you sure want to delete this Unit?');
                if (areusure === true) {
                    $.ajax({
                        type: 'POST',
                        url: 'category/delete',
                        data: {
                            id_category: id
                        },
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': csrf_token
                        },
                        success: function(res) {
                            // console.log(res)
                            alert(res.message)
                            if (res.result === true)
                                window.open('/category', '_self')
                        }
                    })
                }
            }
        </script>
    @endsection
