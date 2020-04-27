<form class="addProduct editProduct" enctype="multipart/form-data">
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
        <span class="image-to-edit"></span>
        <span class="image-error-info text-danger" style="display: none;"></span>
    </div>

    <div class="d-flex justify-content-around m-3">
        <a href="#products">{{ __('view.pageName.products') }}</a>
        <button type="submit" class="btn btn-success btn-sm save-update-product add-product-btn">{{ __('view.save') }}</button>
    </div>
</form>
