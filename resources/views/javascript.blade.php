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
                    '<th>Title</th>',
                    '<th>Description</th>',
                    '<th>Price</th>',
                    '<th>Product Image</th>',
                    '<th>Add to cart</th>',
                    '</tr>'
                ].join('');

                $.each(products, function (key, product) {
                    html += [
                        '<tr>',
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>',
                        '<td><img src="' + product.image_url + '" alt="product_image" width="100px;" height="100px;"></td>',
                        '<td><button id="add">Add</button></td>',
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
        </div>

        <h1 style="text-align: center; margin-bottom: 30px;">Index Page</h1>
        <!-- The index element where the products list is rendered -->
        <table class="list"></table>
    </div>

    <!-- The cart page -->
    <div class="page cart">
        <div class="nav" style="margin: 20px; text-align: right">
            <a href="#" class="button">Go to index</a>
        </div>

        <h1 style="text-align: center; margin-bottom: 30px;">Cart Page</h1>
        <!-- The cart element where the products list is rendered -->
        <table class="list"></table>
    </div>
</body>
</html>
