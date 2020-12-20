@extends('layouts.dashboard')
@section('custom_head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ URL::asset('assets/js/qrcodelib.js') }}"></script>
    <script src="{{ URL::asset('assets/js/webcodecamjs.js') }}"></script>
    <script src="{{ URL::asset('assets/js/webcodecamjquery.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.min.js') }}"></script>
    <style>
        .w-90 {
            width: 90% !important;
        }
        canvas {
            display: none;
        }
        .table>tfoot>tr {
           line-height: 10px !important;
           height: 10px !important;
           margin: 0 !important;
           padding: 0 !important;
        }
    </style>
@endsection

@section('title', 'AChan - Transaction')
@section('is_transaction_active', 'active')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                   <form id="myForm" onkeypress="return event.keyCode != 13;">
                     <!-- Card header -->
                     <div class="card-header border-0 form-inline">
                           <div class="col-lg-12 mb-4">
                              <h3 class="mb-0">Transaction</h3>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-inline">
                                 <label for="date" class="col-sm-2">No.Trx</label>
                                 <div class="col-sm-10"><input type="text" name="no_transaksi" id="no_transaksi" class="form-control" value="{{ $no_transaksi }}" readonly></div>
                              </div>
                              <div class="form-group form-inline">
                                 <label for="date" class="col-sm-2">Date</label>
                                 <div class="col-sm-10"><input type="text" name="date" id="date" class="form-control" value="{{ date('Y-m-d H:i:s') }}" readonly></div>
                              </div>
                              <div class="form-group form-inline">
                                 <label for="cashier" class="col-sm-2">Cashier</label>
                                 <div class="col-sm-10"><input type="text" name="cashier" id="cashier" class="form-control" value="{{ Session()->get('username') }}" readonly></div>
                              </div>
                              <div class="form-group form-inline">
                                 <label for="member" class="col-sm-2">Member</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="no_member" id="no_member" class="form-control">
                                    <input type="text" name="nama_member" id="nama_member" class="form-control" style="display: none" readonly>
                                    <button class="btn btn-primary" type="button" id="check_member" onclick="checkMember()"><li class="fas fa-check"></li></button>
                                    <button class="btn btn-danger" type="button" id="clear_member" onclick="clearMember()"><li class="fas fa-times"></li></button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">&nbsp;</div>
                           <div class="col-md-4 float-right">
                              <div class="form-group form-inline">
                                 <label for="" class="col-sm-4 text-right">Barcode</label>
                                 <div class="col-sm-8">
                                    <input type="text" id="item_code" class="form-control">
                                    <button class="btn btn-primary" type="button" id="add"><li class="fas fa-plus"></li></button>
                                    <canvas></canvas>
                                 </div>
                              </div>
                              <div class="form-group form-inline">
                                 <label for="" class="col-sm-4 text-right">&nbsp;</label>
                                 <div class="col-sm-8">
                                    <input type="text" name="item_name" id="item_name" class="form-control" disabled>
                                 </div>
                              </div>
                           </div>
                     </div>
                     <!-- Light table -->
                     <div class="table-responsive"> 
                           <table class="table align-items-center table-flush" id="myTable">
                              <thead class="thead-light">
                                 <tr>
                                    <th scope="col" class="sort" data-sort="item_name" width="40%">Item Name</th>
                                    <th scope="col" class="sort text-center" data-sort="qty" width="8%">Qty</th>
                                    <th scope="col" class="sort text-center" data-sort="price" width="15%">Price</th>
                                    <th scope="col" class="sort text-center" data-sort="discount_item" width="15%">Discount</th>
                                    <th scope="col" class="sort text-center" data-sort="sub_total" width="15%">Sub Total</th>
                                    <th scope="col" width="5%">Action</th>
                                 </tr>
                              </thead>
                              <tbody class="list">
                                    <tr style="display: none" id="template">
                                       <td>
                                          <input type="hidden" name="id_inventory[]" id="id_inventory[]" value="0">
                                          <input type="text" name="item_name[]" id="item_name[]" class="form-control" readonly>
                                       </td>
                                       <td>
                                          <input type="text" name="qty[]" id="qty[]" class="form-control text-right" min="1">
                                       </td>
                                       <td>
                                          <input type="text" name="price[]" id="price[]" class="form-control text-right" readonly>
                                       </td>
                                       <td>
                                          <input type="text" name="discount_item[]" id="discount_item[]" class="form-control text-right">
                                       </td>
                                       <td>
                                          <input type="text" name="total_item[]" id="total_item[]" class="form-control text-right" readonly>
                                       </td>
                                       <td align="center">
                                          <i class="fas fa-trash-alt" id="delete[]"></i>
                                       </td>
                                    </tr>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <td colspan="4" align="right">Sub Total</td>
                                    <td><input type="text" name="sub_total" id="sub_total" class="form-control text-right" value="0" readonly></td>
                                 </tr>
                                 <tr>
                                    <td colspan="4" align="right">Total Discount</td>
                                    <td><input type="text" name="discount" id="discount" class="form-control text-right" value="0" readonly></td>
                                 </tr>
                                 <tr>
                                    <td colspan="4" align="right">Total</td>
                                    <td><input type="text" name="total" id="total" class="form-control text-right" value="0" readonly></td>
                                 </tr>
                                 <tr>
                                    <td colspan="4" align="right">Payment Member</td>
                                    <td><input type="text" name="bayar_member" id="bayar_member" class="form-control text-right" value="0" readonly></td>
                                 </tr>
                                 <tr>
                                    <td colspan="4" align="right">Payment Cash</td>
                                    <td><input type="text" name="bayar" id="bayar" class="form-control text-right" value="0"></td>
                                 </tr>
                                 <tr>
                                    <td colspan="4" align="right">Change</td>
                                    <td><input type="text" name="kembalian" id="kembalian" class="form-control text-right" value="0" readonly></td>
                                 </tr>
                                 <td colspan="4">&nbsp;</td>
                                 <td>
                                    <button class="btn btn-primary" type="button" id="save" name="save">Proccess</button>
                                    <button class="btn btn-danger" type="button" id="clear" name="clear" onclick="clearForm()">Clear</button>
                                 </td>
                              </tfoot>
                           </table>
                     </div>
                   </form>
                </div>
            </div>
        </div>
        <script>
           $(document).ready(function() {
              $("#item_code").change(function() {
                  $.ajax({
                     type: "POST",
                     url: "/inventory/find-from-code",
                     data: {item_code : $(this).val()},
                     dataType: "JSON",
                     headers : {'X-CSRF-TOKEN': csrf_token},
                     success: function(res) {
                        $("#item_name").val(res.item_name);
                     }
                  });
               });

               $("#add").click(function() {
                  addRow();
               });
               
               document.getElementById("item_code").addEventListener("keyup", function(event) {
                  if (event.keyCode === 13) {
                     event.preventDefault();
                     $.ajax({
                        type: "POST",
                        url: "/inventory/find-from-code",
                        data: {item_code : $("#item_code").val()},
                        dataType: "JSON",
                        headers : {'X-CSRF-TOKEN': csrf_token},
                        success: function(res) {
                           $("#item_name").val(res.item_name);
                        }
                     });
                     addRow();
                  }
               });

               $("#save").click(function() {
                  let aData = $("#myForm").serialize();
                  $.ajax({
                     type: "POST",
                     url: "/transaction/proccess",
                     data: aData,
                     headers : {'X-CSRF-TOKEN': csrf_token},
                     success: function(res) {
                        if(res.success == true){
                           // alert('a')
                           // window.open(`/transaction/print/${res.id}`)
                           window.location.href = `/transaction/print/${res.id}`;
                        }else{
                           window.alert(res.message);
                        }
                     },
                     error: function(err) {
                        console.error(err);
                        if(err.responseJSON.message)
                           window.alert(err.responseJSON.message);
                     }
                  })
               })
           });

           $(document).on("change", "#myTable input[id='qty[]']", function() {
               var tr = $(this).closest("tr");
               var qty = floatval($(this).val());
               if(qty <= 0) {
                  alert('Minimal Qty 1!!');
                  $(this).val(1);
                  qty = 1;
               }
               var price = floatval(tr.find("input[id='price[]']").val());
               var discount_item = floatval(tr.find("input[id='discount_item[]']").val());
               tr.find("input[id='total_item[]']").val(numberFormat((price * qty) - discount_item));
               hitungTotal();
            });

           $(document).on("change", "#myTable input[id='discount_item[]']", function() {
               var tr = $(this).closest("tr");
               var discount_item = floatval($(this).val());
               var price = floatval(tr.find("input[id='price[]']").val());
               var qty = floatval(tr.find("input[id='qty[]']").val());
               tr.find("input[id='total_item[]']").val(numberFormat((price * qty) - discount_item));
               hitungTotal();
            });

           $(document).on("click", "#myTable tr [id='delete[]']", function() {
               $($(this)).closest("tr").remove();
               hitungTotal();
           });

           $(document).on("change", "#bayar", function() {
               let bayar = floatval($(this).val());
               let total = floatval($("#total").val());
               $(this).val(numberFormat(bayar));
               hitungTotal();
               // $("#kembalian").val(numberFormat(bayar - total))
           })

           const csrf_token = document.querySelector('meta[name="csrf-token"]').content;

            $("canvas").removeAttr('style');
            var txt = "innerText" in HTMLElement.prototype ? "innerText" : "textContent";
            var arg = {
               resultFunction: function(result) {
                  $("#item_code").val(result.code);
                  $.ajax({
                     type: "POST",
                     url: "/inventory/find-from-code",
                     data: {item_code : result.code},
                     dataType: "JSON",
                     headers : {'X-CSRF-TOKEN': csrf_token},
                     success: function(res) {
                        $("#item_name").val("");
                        if(res.item_name != '')
                           $("#item_name").val(res.item_name)
                     }
                  });
                  $("canvas").css("display: none");
               }
            };
            new WebCodeCamJS("canvas").init(arg).play();

            function hitungTotal() {
               var sub_total = 0;
               var discount = 0;
               var total = 0;
               $("#myTable").find("input[id='item_name[]']").each(function() {
                  var tr = $(this).closest('tr');
                  console.log(tr)
                  var item_name = tr.find("input[id='item_name[]']").val();
                  var qty = floatval(tr.find("input[id='qty[]']").val());
                  var price = floatval(tr.find("input[id='price[]']").val());
                  var discount_item = floatval(tr.find("input[id='discount_item[]']").val());
                  if(qty > 0) {
                     sub_total += price * qty;
                     discount += discount_item;
                     total += (price * qty) - discount_item;
                  }
               });
               var bayar_member = floatval($("#bayar_member").val());
               var bayar_cash = floatval($("#bayar").val());
               $("#sub_total").val(numberFormat(sub_total));
               $("#discount").val(numberFormat(discount));
               $("#total").val(numberFormat(total));
                  $("#kembalian").val(numberFormat(bayar_member + bayar_cash - total));
               
            }

            function addRow()
            {
               let item_code = $("#item_code").val();
               if(item_code != ''){
                  $.ajax({
                     type: "POST",
                     url: "/inventory/find-from-code",
                     data: {item_code : item_code},
                     dataType: "JSON",
                     headers : {'X-CSRF-TOKEN': csrf_token},
                     success: function(res) {
                        var tr = $("#myTable tr:eq(1)").clone();
                        $("#myTable").append(tr);
                        tr.addClass('list_data');
                        tr.find("input[id='id_inventory[]']").val(res.id_inventory);
                        tr.find("input[id='item_name[]']").val(res.item_name);
                        tr.find("input[id='qty[]']").val(1);
                        tr.find("input[id='price[]']").val(numberFormat(res.price_sell));
                        tr.find("input[id='discount_item[]']").val(0);
                        tr.find("input[id='total_item[]']").val(numberFormat(res.price));
                        tr.show();
                        hitungTotal();
                     }
                  });
                  
               }
            }

            function clearForm() {
               let ask = confirm("Are you sure you want to clear this transaction?");
               if(ask == true) {
                  const list = ['sub_total', 'discount', 'total', 'bayar', 'kembalian'];
                  list.forEach(e => document.getElementById(e).value = 0)
                  $("#myTable .list_data").remove();
               }
            }

            function checkMember() {
               let no_member = document.getElementById("no_member").value;
               $.ajax({
                  type: "POST",
                  url: "/member/find",
                  data: {no_member : no_member},
                  dataType: "JSON",
                  headers : {'X-CSRF-TOKEN': csrf_token},
                  success: function(res) {
                     if(res.result) {
                        $("#no_member").hide();
                        $("#nama_member").show();
                        $("#nama_member").val(res.data.nama_lengkap);
                        $("#bayar_member").val(numberFormat(res.data.points));
                        hitungTotal();
                     }
                  }
               })
            }

            function clearMember() {
               $("#no_member").show().val("");
               $("#nama_member").hide();
               $("#bayar_member").val(0);
               hitungTotal();
            }
        </script>
    @endsection
