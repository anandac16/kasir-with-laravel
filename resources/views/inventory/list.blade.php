@extends('layouts.dashboard')

@section('title', 'AChan - Profile')

@section('content')
    <style>
        .header-container {
            display: flex;
            align-items: center;
            justify-content: between;
        }

    </style>
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
                            <button class="btn btn-primary" style="margin-left: 50px;" onclick="">Add Item</button>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="item_code">Item Code</th>
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
                                        <td>
                                            {{ $item->stock }}
                                        </td>
                                        <td>
                                            {{ $item->unit }}
                                        </td>
                                        <td align="right">
                                            {{ number_format($item->price, 2) }}
                                        </td>
                                        <td>
                                            {{ $item->category }}
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
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
    @endsection
