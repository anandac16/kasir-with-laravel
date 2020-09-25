@extends('layouts.dashboard')
@section('custom_head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .w-90 {
            width: 90% !important;
        }
    
    </style>
@endsection

@section('title', 'AChan - Inventory')
@section('is_product_active', 'active')

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
                            <h3 class="mb-0">Inventory</h3>
                        </div>
                        <div class="col-lg-6 text-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="add_btn">Add Item</button>
                            </div>
                        </div>
                        <!-- Modal add inventory -->
                        <div class=" modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-dismissible fade" role="alert" id="message">
                                                
                                            </div>
                                            <form action="/inventory/add" method="post" name="add_form" id="add_form">
                                                <div class="form-group form-inline">
                                                    <input type="hidden" name="id_inventory" id="id_inventory" value="0">
                                                    <div class="col-lg-4 text-right">Item Code / Barcode</div>
                                                    <div class="col-lg-8"><input type="text" name="item_code" id="item_code"
                                                            class="form-control w-90" required></div>
                                                </div>
                                                <div class="form-group form-inline">
                                                    <div class="col-lg-4 text-right">Item Name</div>
                                                    <div class="col-lg-8"><input type="text" name="item_name" id="item_name"
                                                            class="form-control w-90" required></div>
                                                </div>
                                                <div class="form-group form-inline">
                                                    <div class="col-lg-4 text-right">Price</div>
                                                    <div class="col-lg-8"><input type="number" name="price" id="price"
                                                            class="form-control w-90 text-right" value="0" min="0"></div>
                                                </div>
                                                <div class="form-group form-inline">
                                                    <div class="col-lg-4 text-right">Unit</div>
                                                    <div class="col-lg-8">
                                                        <select name="id_unit" id="id_unit" class="form-control">
                                                            @foreach ($unit as $val)
                                                                <option value="{{ $val->id_unit }}">{{ $val->unit }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group form-inline">
                                                    <div class="col-lg-4 text-right">Category</div>
                                                    <div class="col-lg-8">
                                                        <select name="id_category" id="id_category" class="form-control">
                                                            @foreach ($category as $val)
                                                                <option value="{{ $val->id_category }}">{{ $val->category }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
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
                                        <th scope="col" class="sort" data-sort="item_code">Item Code / Barcode</th>
                                        <th scope="col" class="sort" data-sort="item_name">Item Name</th>
                                        <th scope="col" class="sort text-center" data-sort="stock">Stock</th>
                                        <th scope="col" class="sort text-center" data-sort="unit">Unit</th>
                                        <th scope="col" class="sort text-center" data-sort="price">Price</th>
                                        <th scope="col" class="sort text-center" data-sort="category">Category</th>
                                        <th scope="col" width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>
                                                {{ $item->item_code }}
                                            </td>
                                            <td>
                                                {{ $item->item_name }}
                                            </td>
                                            <td align="right">
                                                0
                                            </td>
                                            <td align="center">
                                                {{ $item->unit }}
                                            </td>
                                            <td align="right">
                                                {{ number_format($item->price, 2) }}
                                            </td>
                                            <td align="center">
                                                {{ $item->category }}
                                            </td>
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
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
            <script type="text/javascript">
            $(document).ready(function(){
                $("#message").hide();
            })
                function save() {
                    var elements = document.getElementById("add_form").elements;
                    var xhttp = new XMLHttpRequest();
                    var obj = {};
                    for (var i = 0; i < elements.length; i++) {
                        var item = elements.item(i);
                        obj[item.name] = item.value;
                    }
                    
                    xhttp.open("POST", "/inventory/add", true);
                    xhttp.setRequestHeader("X-CSRF-TOKEN",document.querySelector('meta[name="csrf-token"]').content);
                    xhttp.send(JSON.stringify(obj));

                    xhttp.onreadystatechange = function() { 
                        // If the request completed, close the extension popup
                        if (xhttp.readyState == 4){
                            if (xhttp.status == 200){
                                var json_data = JSON.parse(xhttp.responseText);
                                let class_type = 'alert-success'
                                if(json_data.result === false)
                                    class_type = 'alert-danger'
                                $("#message").removeClass('fade alert-danger alert-success');
                                $("#message").addClass(class_type + " show"); 
                                $("#message").html(json_data.message);
                                $("#message").removeAttr("style");
                                $(".alert").fadeTo(3000, 0).slideUp(1000);
                                if(json_data.result === true)
                                    window.open('/inventory', '_self')
                            }
                        }
                    };
                }

            </script>
        @endsection
