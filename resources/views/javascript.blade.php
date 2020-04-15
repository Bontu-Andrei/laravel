<html>
<head>
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>

    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">
        $(document).ready(function () {
            function renderList(products) {
                html = [
                    '<tr>',
                    '<th>Nr. Crt.</th>',
                    '<th>Title</th>',
                    '<th>Description</th>',
                    '<th>Price</th>',
                    '</tr>'
                ].join('');
                var index = 0;
                $.each(products, function (key, product) {
                    index = index + 1;
                    html += [
                        '<tr>',
                        '<td>' + index + '</td>',
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>',
                        '</tr>'
                    ].join('');
                });
                return html;
            }
            function renderOrdersList(orders) {
                html = [
                    '<tr>',
                    '<th>Customer Name</th>',
                    '<th>Customer Details</th>',
                    '<th>Customer Comments</th>',
                    '<th>Product Price Sum</th>',
                    '<th>Order Details</th>',
                    '</tr>'
                ].join('');
                $.each(orders, function (key, order) {
                    html += [
                        '<tr>',
                        '<td>' + order.customer_name + '</td>',
                        '<td>' + order.customer_details + '</td>',
                        '<td>' + order.customer_comments + '</td>',
                        '<td>' + order.product_price_sum + '</td>',
                        '<td> <a href="#order/' + order.id + '"></a></td>',
                        '</tr>'
                    ].join('');
                });
                return html;
            }
            /**
             * URL hash change handler
             */
            window.onhashchange = function () {
                // First hide all the pages
                $('.page').hide();
                switch(window.location.hash) {
                    case '#cart':
                        // Show the cart page
                        $('.cart').show();
                        // Load the cart products from the server
                        $.ajax('/cart', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderList(response));
                            }
                        });
                        break;
                    case '#orders':
                        // Show the orders page
                        $('.orders').show();
                        // Load the orders from the server
                        $.ajax('/orders', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the orders
                                $('.orders .list').html(renderOrdersList(response));
                            }
                        });
                        break;
                    default:
                        // If all else fails, always default to index
                        // Show the index page
                        $('.index').show();
                        // Load the index products from the server
                        $.ajax('/index', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the index list
                                $('.index .list').html(renderList(response));
                            }
                        });
                        break;
                }
            }
            window.onhashchange();
        });
    </script>
</head>
<body>
<!-- The index page -->
<div class="page index" style="width: 80%; margin: 0 auto;">
    <div class="nav" style="margin: 20px; text-align: right">
        <a href="#cart" class="button">Go to cart</a>
        <a href="#orders" class="button">Go to orders</a>
    </div>

    <h1 style="text-align: center; margin-bottom: 30px;">Index Page</h1>
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>
</div>

<!-- The cart page -->
<div class="page cart">
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>
</div>

<!-- The orders page -->
<div class="page orders">
    <table class="list"></table>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>
</div>
</body>
</html>
