@extends('layouts.dashboard')
@section('custom_head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ URL::asset('assets/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ URL::asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
    <style>
        .w-90 {
            width: 90% !important;
        }
        .select2.select2-container {
            width: 90% !important;
        }
    </style>
@endsection

@section('title', $title)
@section('is_unit_active', 'active')

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
                                onclick="clearForm()">Add Stock</button>
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
                                            <input type="hidden" name="id_stock" id="id_stock" value="0">
                                            <div class="col-lg-4 text-right">Item Name</div>
                                            <div class="col-lg-8">
                                                <select name="id_inventory" id="id_inventory" class="select2">
                                                    @foreach ($inventory as $inv)
                                                        <option value="{{ $inv->id_inventory }}">{{ $inv->item_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline">
                                            <div class="col-lg-4 text-right">Stock</div>
                                            <div class="col-lg-8"><input type="number" name="stock" id="stock" class="form-control text-right"></div>
                                        </div>
                                        <div class="form-group form-inline">
                                            <div class="col-lg-4 text-right">Unit</div>
                                            <div class="col-lg-8">
                                                <select name="id_unit" id="id_unit" class="select2">
                                                    @foreach ($unit as $unit)
                                                        <option value="{{ $unit->id_unit }}">{{ $unit->unit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline">
                                          <div class="col-lg-4 text-right">Supplier</div>
                                          <div class="col-lg-8">
                                              <select name="id_supplier" id="id_supplier" class="select2">
                                                  @foreach ($supplier as $sup)
                                                      <option value="{{ $sup->id_supplier }}">{{ $sup->nama }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
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
                                    <th scope="col" class="sort" data-sort="supplier">Supplier</th>
                                    <th scope="col" class="sort" data-sort="item_name">Item Name</th>
                                    <th scope="col" class="sort" data-sort="stock">Stock</th>
                                    <th scope="col" class="sort" data-sort="unit">Unit</th>
                                    <th scope="col" width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($data as $key => $list)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $list->nama }}
                                        </td>
                                        <td>
                                            {{ $list->item_name }}
                                        </td>
                                        <td>
                                            {{ number_format($list->stock) }}
                                        </td>
                                        <td>
                                            {{ $list->unit }}
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item"
                                                        onclick="edit({{ $list->id_stock }}, '{{ $list->id_supplier }}', '{{ $list->id_inventory }}', '{{ $list->stock }}', '{{ $list->id_unit }}')"
                                                        data-id="{{ $list->id_stock }}">Edit</a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="deleteStock({{ $list->id_stock }})"
                                                        data-id="{{ $list->id_stock }}">Delete</a>
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
            $(document).ready(function() {
                $('.select2').select2();
            });
            $("#message").hide();
            const csrf_token = document.querySelector('meta[name="csrf-token"]').content;

            function edit(id, id_supplier, id_inventory, stock, id_unit) {
                $("#id_stock").val(id);
                $("#id_supplier").val(id_supplier);
                $("#id_inventory").val(id_inventory);
                $("#stock").val(stock);
                $("#id_unit").val(id_unit);
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

                xhttp.open("POST", "/stock/save", true);
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
                                window.open('/stock', '_self')
                        }
                    }
                };
            }

            function deleteStock(id) {
                let areusure = confirm('Are you sure want to delete this?');
                if (areusure === true) {
                    $.ajax({
                        type: 'POST',
                        url: 'stock/delete',
                        data: {
                            id_stock: id
                        },
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': csrf_token
                        },
                        success: function(res) {
                            // console.log(res)
                            alert(res.message)
                            if (res.result === true)
                                window.open('/stock', '_self')
                        }
                    })
                }
            }

        </script>
    @endsection
