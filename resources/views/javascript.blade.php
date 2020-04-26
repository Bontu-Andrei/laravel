<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">
        function __(name) {
            return name;
        }

        var editedProduct = {};
        var products = [];
        var orders = [];
        var loggedIn = {{ auth()->check() ? '1' : '0' }};

        function hasError(errors, property, elementClassName) {
            if (errors.hasOwnProperty(property)) {
                var $element = $('.' + elementClassName);

                $element.text(errors[property][0]);
                $element.show();
            }
        }

        function clearError(elementClassName) {
            var $element = $('.' + elementClassName);

            $element.text('');
            $element.hide();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            if (loggedIn === 1) {
                $('.logout').show();
            } else {
                $('.login').show();
            }

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

                clearError('customer-name-error-info');
                clearError('contact-details-error-info');
                clearError('customer-comments-error-info');

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
                    },
                    error: function (xhr) {
                        var errors = JSON.parse(xhr.responseText).errors;

                        hasError(errors, 'customer_name', 'customer-name-error-info');
                        hasError(errors, 'contact_details', 'contact-details-error-info');
                        hasError(errors, 'customer_comments', 'customer-comments-error-info');
                    }
                })
            })

            $('#loginForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax('/login', {
                    type: 'post',
                    dataType: 'json',
                    data:{
                        email: $('#email').val(),
                        password: $('#password').val(),
                    },
                    success: function () {
                        window.location.reload();
                    },
                    error: function (xhr) {
                        alert(Object.values(JSON.parse(xhr.responseText).errors));
                    }
                })
            });

            $(document).on('click', '.delete-product', function (e) {
                e.preventDefault();
                var id = $(e.target).data('id');

                $.ajax('/products/' + id, {
                    type: 'delete',
                    dataType: 'json',
                    contentType:'application/json',
                    success: function () {
                        $(e.target).parent().parent().remove();
                    }
                })
            });

            $('.addProduct').on('submit', function (e) {
                e.preventDefault();

                clearError('title-error-info');
                clearError('description-error-info');
                clearError('price-error-info');
                clearError('image-error-info');

                $.ajax('/products', {
                    type: 'post',
                    dataType: 'json',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function () {
                        window.location.href = '#products';
                    },
                    error: function (xhr) {
                        var errors = JSON.parse(xhr.responseText).errors;

                        hasError(errors, 'title', 'title-error-info');
                        hasError(errors, 'description', 'description-error-info');
                        hasError(errors, 'price', 'price-error-info');
                        hasError(errors, 'image_path', 'image-error-info');
                    }
                })
            });

            $(document).on('click', '.edit-product', function (e) {
                e.preventDefault();

                var id = $(e.target).data('id');

                for (var i = 0; i < products.length; i++) {
                    if (parseInt(id) === parseInt(products[i].id)) {
                        editedProduct = products[i];
                    }
                }

                window.location.href = '#edit-product';
            })

            $(document).on('click', '.save-update-product', function (e) {
                e.preventDefault();

                var editPage = $('.edit');
                var $title = editPage.find('.title');
                var $description = editPage.find('.description');
                var $price = editPage.find('.price');
                var imageFile = editPage.find('.image')[0].files;

                var form = new FormData();
                form.append('_method', 'put');
                form.append('title', $title.val());
                form.append('description', $description.val());
                form.append('price', $price.val());

                if (imageFile.length > 0) {
                    form.append('image_path', imageFile[0]);
                }

                $.ajax('/products/' + editedProduct.id, {
                    type: 'post',
                    dataType: 'json',
                    contentType: false,
                    data: form,
                    processData: false,
                    success: function () {
                        window.location.href = '#products';
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                })
            })

            $(document).on('click', '.order-details', function (e) {

                window.location.href = '#order';

                e.preventDefault();

                var id = $(e.target).data('id');

                for (var i = 0; i < orders.length; i++) {
                    if (parseInt(id) === parseInt(orders[i].id)) {
                        order = orders[i];
                    }
                }

                $.ajax('/order/' + order.id, {
                    dataType: 'json',
                    contentType:'application/json',
                    success: function (response) {
                        $('.list').html(renderOrderDetails(response));
                    },
                    error: function (xhr) {
                        alert(xhr.responseText);
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
                    page == 'products' ? '<th>' + __('Edit') + '</th>' + '<th>' + __('Delete') + '</th>' :
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
                        page == 'products' ?
                            '<td>' +
                                '<button class="btn btn-success btn-sm edit-product" data-id="' + product.id + '">' + __('Edit') + '</button>' +
                            '</td>' +
                            '<td>' +
                                '<button class="btn btn-danger btn-sm delete-product" data-id="' + product.id + '">' + __('Delete') + '</button>' +
                            '</td>' :
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

            function renderOrdersList(orders) {
                html = [
                    '<tr>',
                    '<th>' + __('Customer Name') + '</th>',
                    '<th>' + __('Customer Details') + '</th>',
                    '<th>' + __('Customer Comments') + '</th>',
                    '<th>' + __('Product Price Sum') + '</th>',
                    '<th>' + __('Order Details') + '</th>',
                    '</tr>'
                ].join('');

                $.each(orders, function (key, order) {
                    html += [
                        '<tr>',
                        '<td>' + __(order.customer_name) + '</td>',
                        '<td>' + __(order.customer_details) + '</td>',
                        '<td>' + __(order.customer_comments) + '</td>',
                        '<td>' + __(order.product_price_sum) + '</td>',
                        '<td>' +
                            '<button class="btn btn-success btn-sm order-details" data-id="' + order.id + '">' + __('Order Details') + '</button>' +
                        '</td>',
                        '</tr>'
                    ].join('');
                });
                return html;
            }

            function renderOrderDetails(order) {
                html = [
                    '<tr>',
                        '<th>' + __('Customer Name') + '</th>',
                        '<td colspan="4">' + __(order.customer_name) + '</td>',
                    '</tr>',

                    '<tr>',
                        '<th>' + __('Customer Details') + '</th>',
                        '<td colspan="4">' + __(order.customer_details) + '</td>',
                    '</tr>',

                    '<tr>',
                        '<th>' + __('Customer Comments') + '</th>',
                        '<td colspan="4">' + __(order.customer_comments) + '</td>',
                    '</tr>',

                    '<tr>',
                        '<th>' + __('Order Date') + '</th>',
                        '<td colspan="4">' + __(order.created_at) + '</td>',
                    '</tr>',

                    '<tr>',
                        '<th>' + __('Total Price') + '</th>',
                        '<td colspan="4">' + __(order.product_price_sum) + '</td>',
                    '</tr>',

                    '<tr>',
                        '<th rowspan="' + order.products.length + '1' + '">' + __('Products') + '</th>',
                        '<th>' + __('Title') + '</th>',
                        '<th>' + __('Description') + '</th>',
                        '<th>' + __('Price') + '</th>',
                        '<th>' + __('Image') + '</th>',
                    '</tr>',
                ].join('');

                $.each(order.products, function (key, orderProduct) {
                    html += [
                        '<tr>',
                            '<td>' + __(orderProduct.title) + '</td>',
                            '<td>' + __(orderProduct.description) + '</td>',
                            '<td>' + __(orderProduct.price) + '</td>',
                            '<td><img src="' + __(orderProduct.image_url) + '" alt="' + __('product_image') + '" width="100px;" height="100px;"></td>',
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
                                $('.cart .list').html(renderList(response, 'cart'));
                            }
                        });
                        break;
                    case '#login':
                        // User is logged in then redirect.
                        if (loggedIn === 1) {
                            window.location.href = '#index';
                            return;
                        }

                        $('.login').show();
                        break;
                    case '#logout':
                        // User is guest then redirect.
                        if (loggedIn === 0) {
                            window.location.href = '#index';
                            return;
                        }

                        $.ajax('/logout', {
                            type: 'post',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                            success: function () {
                                window.location.reload();
                            }
                        });
                        break;
                    case '#products':
                        $('.products').show();

                        $.ajax('/products', {
                            dataType: 'json',
                            contentType:'application/json',
                            success: function (response) {
                                products = response;

                                $('.products .list').html(renderList(response, 'products'));
                            },
                            error: function () {
                                window.location.href = '#index';
                            }
                        });
                        break;
                    case '#add-product':
                        $('.add').show();
                        break;
                    case '#edit-product':
                        var editPage = $('.edit');

                        editPage.show();

                        var $title = editPage.find('.title');
                        var $description = editPage.find('.description');
                        var $price = editPage.find('.price');

                        var img = $('<img style="width: 100px; height: 100px; margin: 10px;">');
                        img.attr('src', editedProduct.image_url);
                        img.appendTo('.image-to-edit');

                        $title.val(editedProduct.title)
                        $description.val(editedProduct.description)
                        $price.val(editedProduct.price)

                        break;
                    case '#orders':
                        $('.orders').show();

                        $.ajax('/orders', {
                            dataType: 'json',
                            contentType:'application/json',
                            success: function (response) {
                                orders = response;
                                $('.orders .list').html(renderOrdersList(response));
                            },
                            error: function () {
                                window.location.href = '#index';
                            }
                        });
                        break;
                    case '#order':
                        $('.order').show();
                        break;
                    default:
                        // If all else fails, always default to index
                        // Show the index page
                        $('.index').show();
                        // Load the index products from the server
                        $.ajax('/index', {
                            dataType: 'json',
                            success: function (response) {
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
       @include('partials.js-navbar')

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.pageName.index') }}</h1>

        <table class="table list"></table>
    </div>

    <!-- The cart page -->
    <div class="page cart container">
        @include('partials.js-navbar')

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

                        <span class="customer-name-error-info text-danger" style="display: none;"></span>

                        <input type="text" name="contact_details"
                               placeholder="{{ __('view.placeholder.contact') }}"
                               class="contact-details form-control m-2">

                        <span class="contact-details-error-info text-danger" style="display: none;"></span>

                        <input type="text" name="customer_comments"
                               placeholder="{{ __('view.placeholder.comments') }}"
                               class="comments form-control form-control-lg m-2">

                        <span class="customer-comments-error-info text-danger" style="display: none;"></span>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-sm">{{ __('view.pageName.index') }}</a>
                        <button class="btn btn-secondary btn-sm">{{ __('view.checkout') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- The login page -->
    <div class="page login container">
        @include('partials.js-navbar')

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.login') }}</h1>

        <form id="loginForm">
            <div class="form-group">
                <label for="email">{{ __('view.email') }}</label>
                <input type="email" name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="password">{{ __('view.password') }}</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>

            <button type="submit" class="btn btn-primary">{{ __('view.login') }}</button>
        </form>
    </div>

    <!-- The products page -->
    <div class="page products container">
        @include('partials.js-navbar')

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.pageName.products') }}</h1>

        <div>
            <table class="table list"></table>
            <div class="d-flex justify-content-around m-3">
                <a class="btn btn-sm btn-primary" href="#add-product">{{ __('view.add') }}</a>

                <span class="logout" style="display: none;">
                    <a class="btn btn-sm btn-danger" href="#logout">{{ __('view.logout') }}</a>
                </span>
            </div>
        </div>
    </div>

    <!-- The add-product page -->
    <div class="page add container">
        @include('partials.js-navbar')

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.add') }}</h1>

        @include('partials.js-add-edit-form')
    </div>

    <!-- The edit-product page -->
    <div class="page edit container">
        @include('partials.js-navbar')

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.edit') }}</h1>

        @include('partials.js-add-edit-form')
    </div>

    <!-- The orders page -->
    <div class="page orders container">
        @include('partials.js-navbar')

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.pageName.orders') }}</h1>

        <table class="table list"></table>
    </div>

    <!-- The order-details page -->
    <div class="page order container">
        @include('partials.js-navbar')

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.orderDetails') }}</h1>

        <table class="list table"></table>

    </div>
</body>
</html>
