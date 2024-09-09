<div class="modal fade product-add" id="singleproduct" tabindex="-1" aria-labelledby="singleproductLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form name="add-update-product" action="{{ route('addUpdateProduct') }}" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="modal-header">
                            <h5 class="modal-title" id="singleproductLabel">Gallery</h5>
                        </div>
                        <div class="modal-body">
                            <div class="create-gallery">
                                <div class="js-grid my-shuffle">
                                    <figure class="js-item column d-none" style="width:100%">
                                        <div class="aspect aspect--32x9">
                                            <div class="img-option">
                                                <button class="btn"><i class="las la-times"></i> Remove</button>
                                                <button class="btn"><i class="las la-retweet"></i> Change Image</button>
                                            </div>
                                            <div class="aspect__inner">
                                                <img src="<?php echo url('vendor-assets/') ?>/images/gallery-4.png" alt="Image" />
                                            </div>
                                        </div>
                                    </figure>
                                    <figure class="js-item column d-none">
                                        <div class="aspect aspect--16x9">
                                            <div class="img-option">
                                                <button class="btn"><i class="las la-times"></i> Remove</button>
                                                <button class="btn"><i class="las la-retweet"></i> Change Image</button>
                                            </div>
                                            <div class="aspect__inner">
                                                <img src="<?php echo url('vendor-assets/') ?>/images/gallery-5.png" alt="Image" />
                                            </div>
                                        </div>
                                    </figure>
                                    <figure class="js-item column upload">
                                        <div class="upload-img">
                                            <div class="file">
                                                Add Files
                                                <input type="file" name="product_image[]" class="attribute-image-input" accept="image/*" multiple/>
                                            </div>
                                            <p>Select file to upload.</p>
                                        </div>
                                    </figure>
                                    <div class="column my-sizer-element js-sizer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="modal-header">
                            <h5 class="modal-title" id="singleproductLabel">Description</h5>
                            <div class="rig">
                                <button type="button" class="btn-dlt d-none"><i class="las la-trash-alt"></i></button>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="modal-body gallery-form">
                            <form>
                                <div class="select-user">
                                    <ul class="list-unstyled">
                                        <li class="init"><span class="active"></span> Active</li>
                                        <li data-value="1" style="display: none;" class=""><span class="active"></span> Active</li>
                                        <li data-value="2" style="display: none;" class=""><span class="inactive"></span> Inactive</li>
                                    </ul>
                                    <i class="las la-angle-down arrows"></i>
                                </div>
                                <input type="hidden" name="product_status" value="1">
                                <input type="text" name="title" class="form-control mb-0 mt-2" name="title" value="" placeholder="Title">
                                <input type="text" name="quantity" class="form-control mb-0 mt-2 accept-number" value="" placeholder="Quantity">
                                <textarea name="description" class="form-control mb-0 mt-2" placeholder="Description" name="placeholder" rows="6"></textarea>
                                <input type="text" name="price" class="form-control mb-0 mt-2 allow-numeric-with-decimal" value="" placeholder="Price">
                                <div class="form-check d-none">
                                    <input class="form-check-input" type="checkbox" value="" id="remember">
                                    <label class="form-check-label text-start" for="remember">
                                        Charge tax on this plan
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>