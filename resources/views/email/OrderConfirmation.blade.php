<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Notification</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin-bottom: 20px;
        }
        h2 {
            margin: 10px 0;
        }
        p {
            line-height: 1.5;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            margin: 15px 0;
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            color: #fff;
            background-color: #AC0121;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }
        .lead {
            font-size: 12px;
            opacity: 0.7;
        }
        .order-summary {
            text-align: left;
            margin-top: 20px;
            background-color: #111;
            padding: 15px;
            border-radius: 8px;
        }
        .order-summary p {
            margin: 5px 0;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li {
            margin: 10px 0;
            display: flex;
            align-items: center;
        }
        .item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 5px;
        }
        .highlight{
            color: #AC0121;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://afriktastybites.com/Afrik-logo.PNG" alt="Afrik-TastyBites" class="logo">

    @if($recipientType === 'customer')
        <h2>Thank You for Your Order</h2>
        <p>Hi <strong>{{ $order->customer_name }}</strong>, your order <strong>{{ $order->Ref }}</strong> has been received! We're working to get it packed and out the door. Expect a dispatch confirmation email soon.</p>
        <a href="" class="btn">Track Your Order</a>
        <p class="lead">Please allow a 24-hour interval before tracking your order.</p>

        <div class="order-summary">
            <p class="highlight"><strong>Order Details:</strong></p>
            <ul>
                @foreach($order->items as $item)
                    <li>
                        <img src="{{ asset('food-image/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="item-image">
                        {{ $item->quantity }} x {{ $item->product->name }} - ₦{{ number_format($item->price, 2) }}
                    </li>
                @endforeach
            </ul>
            <p><strong>Total:</strong> ₦{{ number_format($order->total, 2) }}</p>
        </div>
    @elseif($recipientType === 'vendor')
        <h2>You Have a New Order</h2>
        <p>Hi <strong>{{ $order->vendor->name }}</strong>, a new order <strong>{{ $order->Ref }}</strong> has been placed that requires your attention.</p>
        <a href="{{ route('vendor.order.view', $order->Ref) }}" class="btn">View Order</a>

        <div class="order-summary">
            <p class="highlight"><strong>Customer Details:</strong></p>
            <p>Name: {{ $order->customer_name }}<br>
               Phone: {{ $order->customer_phone }}<br>
               Address: {{ $order->address }}</p>
            <p class="highlight"><strong>Order Details:</strong></p>
            <ul>
                @foreach($order->items as $item)
                    <li>
                        <img src="{{ asset('food-image/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="item-image">
                        {{ $item->quantity }} x {{ $item->product->name }} - ₦{{ number_format($item->price, 2) }}
                    </li>
                @endforeach
            </ul>
            <p class="highlight"><strong>Total:</strong> ₦{{ number_format($order->total, 2) }}</p>
        </div>
    @endif
</div>

</body>
</html>
