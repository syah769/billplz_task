<!DOCTYPE html>
<html>
<head>
    <title>Order Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>Order Bill</h2>
                            </td>
                            <td>
                                Order #: PZ-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}<br>
                                Created: {{ $order->created_at }}<br>
                                Status: {{ $order->status }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Customer Name: {{ $order->customer_name }}<br>
                                Total Amount: RM {{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Pizza</td>
                <td>Price</td>
            </tr>
            @foreach ($order->pizzas as $pizza)
            <tr class="item">
                <td>
                    {{ ucfirst($pizza->size) }} Pizza
                </td>
                <td>RM {{ number_format($pizza->base_price, 2) }}</td>
            </tr>
            <tr class="item">
                <td>
                    Add On:
                    @if (!$pizza->pepperoni && !$pizza->extra_cheese)
                        None
                    @else
                        @if ($pizza->pepperoni)
                            <br>- Pepperoni
                        @endif
                        @if ($pizza->extra_cheese)
                            <br>- Extra Cheese
                        @endif
                    @endif
                </td>
                <td>
                    @if (!$pizza->pepperoni && !$pizza->extra_cheese)
                        RM 0.00
                    @else
                        @if ($pizza->pepperoni)
                            RM {{ number_format($pizza->pepperoni_price, 2) }}
                        @endif
                        @if ($pizza->extra_cheese)
                            <br>RM {{ number_format($pizza->extra_cheese_price, 2) }}
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
            <tr class="total">
                <td>Total:</td>
                <td>RM {{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
