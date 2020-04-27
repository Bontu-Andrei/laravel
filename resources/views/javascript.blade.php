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

            $(document).on('click','.add-to-cart', function (event) {
                event.preventDefault();

               var id = $(event.target).data('id');

               $.ajax('/cart/' + id, {
                   type: 'post',
                   dataType: 'json',
                   success: function () {
                       $(e.target).parent().parent().remove();
                   }
               })
            });

            $(document).on('click', '.delete-from-cart', function (event) {
                event.preventDefault();
                var id = $(event.target).data('id');

                $.ajax('/cart/' + id, {
                    type: 'delete',
                    dataType: 'json',
                    contentType:'application/json',
                    success: function () {
                        $(e.target).parent().parent().remove();
                    }
                })
            });

            $('#checkout').on('submit', function (event) {
                event.preventDefault();

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

            $('#loginForm').on('submit', function (event) {
                event.preventDefault();

                clearError('email-error-info');
                clearError('password-error-info');

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
                        var errors = JSON.parse(xhr.responseText).errors;

                        hasError(errors, 'email', 'email-error-info');
                        hasError(errors, 'password', 'password-error-info');
                    }
                })
            });

            $(document).on('click', '.delete-product', function (event) {
                event.preventDefault();
                var id = $(event.target).data('id');

                $.ajax('/products/' + id, {
                    type: 'delete',
                    dataType: 'json',
                    contentType:'application/json',
                    success: function () {
                        $(event.target).parent().parent().remove();
                    }
                })
            });

            $('#addProduct').on('submit', function (event) {
                event.preventDefault();

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

            $(document).on('click', '.edit-product', function (event) {
                event.preventDefault();

                var id = $(e.target).data('id');

                for (var i = 0; i < products.length; i++) {
                    if (parseInt(id) === parseInt(products[i].id)) {
                        editedProduct = products[i];
                    }
                }

                window.location.href = '#edit-product';
            })

            $(document).on('click', '#save-update-product', function (event) {
                event.preventDefault();

                clearError('title-error-info');
                clearError('description-error-info');
                clearError('price-error-info');
                clearError('image-error-info');

                var imageFile = $('#image-update')[0].files;

                var updateForm = new FormData();
                updateForm.append('_method', 'put');
                updateForm.append('title', $('#title-update').val());
                updateForm.append('description', $('#description-update').val());
                updateForm.append('price', $('#price-update').val());

                if (imageFile.length > 0) {
                    updateForm.append('image_path', imageFile[0]);
                }

                $.ajax('/products/' + editedProduct.id, {
                    type: 'post',
                    dataType: 'json',
                    contentType: false,
                    data: updateForm,
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
            })

            $(document).on('click', '.order-details', function (event) {

                window.location.href = '#order';

                event.preventDefault();

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
                    error: function () {
                        window.location.href = '#orders';
                    }
                })
            })

            $(document).on('click', '.review', function (event) {
                event.preventDefault();

                window.location.href = '#reviews';

                var id = $(event.target).data('id');

                $.ajax('/reviews?id='+id+'&type=product', {
                    dataType: 'json',
                    success: function (response) {
                        $('.list').html(renderReviewsList(response));
                        console.log(response)
                    }
                });
            })

            function renderList(products, page) {
                html = [
                    '<tr>',
                    '<th>' + __('Title') + '</th>',
                    '<th>' + __('Description') + '</th>',
                    '<th>' + __('Price') + '</th>',
                    '<th>' + __('Product Image') + '</th>',
                    page == 'products' ? '<th>' + __('Edit') + '</th>' + '<th>' + __('Delete') + '</th>' :
                    page == 'index' ? '<th>' + __('Add to cart') + '</th>' + '<th>' + __('Reviews') + '</th>' : '<th>' + __('Delete') + '</th>',
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
                            '</td>' +
                            '<td>' +
                                '<button data-id="' + product.id + '" class="btn btn-secondary review">' + __('Add Review') + '</button>' +
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

            function renderReviewsList(reviews) {
                html = [].join('');

                $.each(reviews, function (key, review) {
                    html += [
                        '<div class="card" style="width: 80%; margin: 10px auto;">' +
                            '<div class="card-body">',
                                '<div>',
                                    '<span class="mr-1"><b>' + __('Rating') + '</b></span>',
                                    '<span>' + review.rating + '</span>',
                                '</div>',
                                '<div>',
                                    '<span class="mr-1"><b>' + __('Title') + '</b></span>',
                                    '<span>' + review.title + '</span>',
                                '</div>',
                                '<div>',
                                    '<span class="mr-1"><b>' + __('Description') + '</b></span>',
                                    '<span>' + review.description + '</span>',
                                '</div>',
                            '</div>',
                        '</div>'
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
                        $('.edit').show();

                        if ($('#show-image-edit-form').empty()) {
                            var img = $('<img style="width: 100px; height: 100px; margin: 10px;">');
                            img.attr('src', editedProduct.image_url);
                            img.appendTo('#show-image-edit-form');
                        }

                        $('#title-update').val(editedProduct.title)
                        $('#description-update').val(editedProduct.description)
                        $('#price-update').val(editedProduct.price)

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
                    case '#reviews':
                        $('.reviews').show();

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
                <span class="email-error-info text-danger" style="display: none;"></span>
            </div>

            <div class="form-group">
                <label for="password">{{ __('view.password') }}</label>
                <input type="password" name="password" class="form-control" id="password">
                <span class="password-error-info text-danger" style="display: none;"></span>
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

        <form id="addProduct" enctype="multipart/form-data">
            <div class="form-group">
                <label>{{ __('view.label.title') }}</label>
                <input type="text" name="title" class="form-control title">
                <span class="title-error-info text-danger" style="display: none;"></span>
            </div>

            <div class="form-group">
                <label>{{ __('view.label.description') }}</label>
                <input type="text" name="description" class="form-control description">
                <span class="description-error-info text-danger" style="display: none;"></span>
            </div>

            <div class="form-group">
                <label>{{ __('view.label.price') }}</label>
                <input type="text" name="price" class="form-control price">
                <span class="price-error-info text-danger" style="display: none;"></span>
            </div>

            <div class="form-group">
                <label>{{ __('view.image') }}</label>
                <input type="file" name="image_path" class="form-control-file image">
                <span class="image-error-info text-danger" style="display: none;"></span>
            </div>

            <div class="d-flex justify-content-around m-3">
                <a href="#products">{{ __('view.pageName.products') }}</a>
                <button type="submit" class="btn btn-success btn-sm">{{ __('view.save') }}</button>
            </div>
        </form>

    </div>

    <!-- The edit-product page -->
    <div class="page edit container">
        @include('partials.js-navbar')

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.edit') }}</h1>

        <form enctype="multipart/form-data">
            <div class="form-group">
                <label>{{ __('view.label.title') }}</label>
                <input type="text" name="title" class="form-control" id="title-update">
                <span class="title-error-info text-danger" style="display: none;"></span>
            </div>

            <div class="form-group">
                <label>{{ __('view.label.description') }}</label>
                <input type="text" name="description" class="form-control" id="description-update">
                <span class="description-error-info text-danger" style="display: none;"></span>
            </div>

            <div class="form-group">
                <label>{{ __('view.label.price') }}</label>
                <input type="text" name="price" class="form-control" id="price-update">
                <span class="price-error-info text-danger" style="display: none;"></span>
            </div>

            <div class="form-group">
                <label>{{ __('view.image') }}</label>
                <input type="file" name="image_path" class="form-control-file" id="image-update">
                <span id="show-image-edit-form"></span>
                <span class="image-error-info text-danger" style="display: none;"></span>
            </div>

            <div class="d-flex justify-content-around m-3">
                <a href="#products">{{ __('view.pageName.products') }}</a>
                <button type="submit" class="btn btn-success btn-sm" id="save-update-product">{{ __('view.save') }}</button>
            </div>
        </form>
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

    <!-- The reviews page -->
    <div class="page reviews container">
        @include('partials.js-navbar')

        <h1 class="m-3 d-flex justify-content-center">{{ __('view.review') }}</h1>

        <div class="list"></div>

        <div class="d-flex justify-content-center">
            <form id="addReview">
                <div>
                    <div>
                        <label for="rating"><b>{{ __('view.rating') }}</b></label>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="rating" id="rating" value="5" {{ old('rating') == "5" ? 'checked' : '' }}/> 5
                            </div>

                            <div class="input-group-text">
                                <input type="radio" name="rating" id="rating" value="4" {{ old('rating') == "4" ? 'checked' : '' }}/> 4
                            </div>

                            <div class="input-group-text">
                                <input type="radio" name="rating" id="rating" value="3" {{ old('rating') == "3" ? 'checked' : '' }}/> 3
                            </div>

                            <div class="input-group-text">
                                <input type="radio" name="rating" id="rating" value="2" {{ old('rating') == "2" ? 'checked' : '' }}/> 2
                            </div>

                            <div class="input-group-text">
                                <input type="radio" name="rating" id="rating" value="1" {{ old('rating') == "1" ? 'checked' : '' }}/> 1
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="title"><b>{{ __('view.label.title') }}</b></label>
                    </div>

                    <input type="text"
                           class="form-control"
                           id="title"
                           name="title"
                           value="{{ old('title') }}"
                           placeholder="{{ __('view.label.title') }}">

                </div>

                <div class="form-group">
                    <div>
                        <label for="description"><b>{{ __('view.label.description') }}</b></label>
                    </div>

                    <input name="description"
                           class="form-control"
                           id="description"
                           value="{{ old('description') }}"
                           placeholder="{{ __('view.label.description') }}">
                </div>

                <div class="text-center mb-5">
                    <button class="btn btn-primary btn-sm" type="submit" name="review">{{ __('view.addReview') }}</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
