<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap/bootstrap.css') }}">
<style>
    @media print {
        @page {
            size: 75mm 65mm potrait;
        }
        .hidden {
            display: none !important;
        }
    }

    .data {
        font-size: 12px;
    }

    #invoice-POS {
        border: 1px #ccc solid;
        padding: 2mm;
        margin: 0 auto;
        width: 75mm;
        background: #FFF;
        font-size: 12px;
    }

    .footer {
       text-align: center;
    }

    small {
        font-size: 10px;
    }

</style>
<title>AChan Mart</title>
<div id="invoice-POS">

    <center id="top">
        <div class="info">
            <h2>AChan Mart</h2>
        </div>
        <!--End Info-->
    </center>
    <!--End InvoiceTop-->

    <div id="mid">
        <div class="info">
            <center>
                Perum Bukit tiara Blok A1 no. 25 Cikupa
            </center>
        </div>
        <div class="form-inline">
            <div class="col-sm-6">
                No. Trx: {{ $detail->no_transaksi }}
            </div>
            <div class="col-sm-6">
                Kasir : {{ $detail->cashier }}
                {{ $detail->date }}
            </div>
        </div>
    </div>
    <hr>
    <!--End Invoice Mid-->

    <div id="bot">
        <div id="table">
            <table width="100%">
                @php
                $tqty = 0;
                @endphp
                @foreach ($subdetail as $subdt)
                    @php
                    $tqty += $subdt->qty;
                    @endphp
                    <tr class="data">
                        <td>
                            {{ substr($subdt->item_name, 0, 10) }}
                        </td>
                        <td align="right">
                            {{ number_format($subdt->qty) }}
                        </td>
                        <td align="right">
                            {{ number_format($subdt->price) }}
                        </td>
                        <td align="right">
                            {{ number_format($subdt->total_item) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2">Sub Total</td>
                    <td>{{ number_format($tqty) }}</td>
                    <td align="right">
                        {{ number_format($detail->sub_total) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Total Disc.</td>
                    <td align="right">
                        {{ number_format($detail->discount) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td align="right">
                        {{ number_format($detail->total) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Tunai</td>
                    <td align="right">
                        {{ number_format($detail->bayar) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Kembalian</td>
                    <td align="right">
                        {{ number_format($detail->kembalian) }}
                    </td>
                </tr>
                @if ($member != null)
                <tr>
                    <td colspan="4">
                        <small>Anda mendapat tambahan point sebesar Rp.{{ number_format($detail->bonus_points) }}</small>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <!--End Table-->
        <br>
        <div id="footer" class="footer">
            <p>
                <strong>Terima kasih telah belanja di AChan Mart!</strong>
            </p>
        </div>
    </div>
    <!--End InvoiceBot-->
</div>
<!--End Invoice-->
<div class="hidden">
    <br>
    <div class="row">
        <div class="col-sm-12 text-center">
            <button class="btn btn-primary" id="print" onclick="window.print()">Print</button>
            <button class="btn btn-success" id="back" onclick="window.location.href = '/transaction'">Back</button>
        </div>
    </div>
</div>