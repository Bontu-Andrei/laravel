<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">
        function __(name) {
            return name;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $(document).on('click','.add-to-cart',function (e) {
                e.preventDefault();
               var id = $(e.target).data('id');

               $.ajax('/cart/' + id, {
                   type: 'post',
                   dataType: 'json',
                   success: function () {
                       $(e.target).parent().parent().remove();
                   }
               })
            });

            $(document).on('click', '.delete-from-cart', function (e) {
                e.preventDefault();
                var id = $(e.target).data('id');

                $.ajax('/cart/' + id, {
                    type: 'delete',
                    dataType: 'json',
                    contentType:'application/json',
                    success: function () {
                        $(e.target).parent().parent().remove();
                    }
                })
            });

            $('#checkout').on('submit', function (e) {
                e.preventDefault();
                $.ajax('/checkout', {
                    type: 'post',
                    data:{
                        customer_name: $('.name').val(),
                        contact_details: $('.contact-details').val(),
                        customer_comments: $('.comments').val(),
                    },
                    dataType: 'json',
                    success: function () {
                        alert('Checkout success!');
                    }
                })
            })

            function renderList(products, page) {
                html = [
                    '<tr>',
                    '<th>' + __('Title') + '</th>',
                    '<th>' + __('Description') + '</th>',
                    '<th>' + __('Price') + '</th>',
                    '<th>' + __('Product Image') + '</th>',
                    page == 'index' ? '<th>' + __('Add to cart') + '</th>' : '<th>' + __('Delete') + '</th>',
                    '</tr>'
                ].join('');

                $.each(products, function (key, product) {
                    html += [
                        '<tr>',
                        '<td>' + __(product.title) + '</td>',
                        '<td>' + __(product.description) + '</td>',
                        '<td>' + __(product.price) + '</td>',
                        '<td><img src="' + __(product.image_url) + '" alt="' + __('product_image') + '" width="100px;" height="100px;"></td>',
                        page == 'index' ?
                            '<td>' +
                                '<button class="btn btn-secondary add-to-cart" data-id="' + product.id + '">' + __('Add') + '</button>' +
                            '</td>' :
                            '<td>' +
                                '<button class="btn btn-secondary delete-from-cart" data-id="' + product.id + '">' + __('Delete') + '</button>' +
                            '</td>',
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
                                $('.cart .list').html(renderList(response, 'cart'));
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
                                $('.index .list').html(renderList(response, 'index'));
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
    <div class="page index container">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#cart">{{ __('view.pageName.cart') }}</a>
        </nav>

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.pageName.index') }}</h1>

        <table class="table list"></table>
    </div>

    <!-- The cart page -->
    <div class="page cart container">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#">{{ __('view.pageName.index') }}</a>
        </nav>

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.pageName.cart') }}</h1>

        <div class="card">
            <div class="card-body">
                <table class="table list"></table>
            </div>

            <div class="card-footer">
                <form id="checkout">
                    <div class="form-group">
                        <input type="text" name="customer_name"
                               placeholder="{{ __('view.placeholder.name') }}"
                               class="name form-control form-control-sm m-2">

                        <input type="text" name="contact_details"
                               placeholder="{{ __('view.placeholder.contact') }}"
                               class="contact-details form-control m-2">

                        <input type="text" name="customer_comments"
                               placeholder="{{ __('view.placeholder.comments') }}"
                               class="comments form-control form-control-lg m-2">
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-sm">{{ __('view.pageName.index') }}</a>
                        <button class="btn btn-secondary btn-sm">{{ __('view.checkout') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
