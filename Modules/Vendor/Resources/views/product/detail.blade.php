 <div class="row">
     <div class="col-md-8">
         <div class="modal-header">
             <h5 class="modal-title" id="singleproductLabel">Gallery</h5>
         </div>
         <div class="modal-body">
             <div class="create-gallery">
                 <div class="js-grid my-shuffle">
                     <?php
                        if (isset($vendor_product->product_image) && !empty($vendor_product->product_image)) {
                            foreach ($vendor_product->product_image as $product_image) {
                        ?>
                             <figure class="js-item column">
                                 <div class="aspect aspect--16x9">
                                     <div class="img-option">
                                         <button type="button" class="btn btn-remove-product-image" data-id="<?php echo my_encrypt($product_image->id); ?>" data-url="{{ route('deleteProductImage') }}"><i class="las la-times"></i> Remove</button>
                                         <button type="button" class="btn d-none"><i class="las la-retweet"></i> Change Image</button>
                                     </div>
                                     <div class="aspect__inner">
                                         <img src="<?php echo $product_image->image_url ?>" alt="Image" />
                                     </div>
                                 </div>
                             </figure>
                     <?php
                            }
                        }
                        ?>

                     <figure class="js-item column upload">
                         <div class="upload-img">
                             <div class="file">
                                 Add Files
                                 <input type="file" name="product_image[]" class="attribute-image-input" accept="image/*" multiple />
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
                 <button type="button" class="btn-dlt btn-delete-product" data-id="<?php echo my_encrypt($vendor_product->id); ?>" data-url="<?php echo route('deleteProduct'); ?>"><i class="las la-trash-alt"></i></button>
                 <button type="button" class="btn-close refresh-page" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
         </div>
         <div class="modal-body gallery-form">
             <form>
                 <div class="select-user">
                     <ul class="list-unstyled">
                         <?php
                            if (isset($vendor_product->product_status) && $vendor_product->product_status == 1) {
                            ?>
                             <li class="init"><span class="active"></span> Active</li>
                         <?php
                            } else {
                            ?>
                             <li class="init"><span class="inactive"></span> Inactive</li>
                         <?php
                            }
                            ?>
                         <li data-value="1" style="display: none;" class=""><span class="active"></span> Active</li>
                         <li data-value="2" style="display: none;" class=""><span class="inactive"></span> Inactive</li>
                     </ul>
                     <i class="las la-angle-down arrows"></i>
                 </div>
                 <input type="hidden" name="id" value="<?php echo isset($vendor_product->id) ? my_encrypt($vendor_product->id) : ''; ?>">
                 <input type="hidden" name="product_status" value="<?php echo isset($vendor_product->product_status) ? $vendor_product->product_status : 1; ?>">
                 <input type="text" name="title" class="form-control mb-0 mt-2" name="title" value="<?php echo isset($vendor_product->title) ? $vendor_product->title : ''; ?>" placeholder="Title">
                 <input type="text" name="quantity" class="form-control mb-0 mt-2 accept-number" value="<?php echo isset($vendor_product->quantity) ? $vendor_product->quantity : ''; ?>" placeholder="Quantity">
                 <textarea name="description" class="form-control mb-0 mt-2" placeholder="Description" name="placeholder" rows="6"><?php echo isset($vendor_product->description) ? $vendor_product->description : ''; ?></textarea>
                 <input type="text" name="price" class="form-control mb-0 mt-2 allow-numeric-with-decimal" value="<?php echo isset($vendor_product->price) ? $vendor_product->price : ''; ?>" placeholder="Price">
                 <div class="form-check d-none">
                     <input class="form-check-input" type="checkbox" value="" id="remember">
                     <label class="form-check-label text-start" for="remember">
                         Charge tax on this plan
                     </label>
                 </div>
             </form>
         </div>
         <div class="modal-footer">
             <button class="btn btn-secondary refresh-page" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
             <button type="submit" class="btn btn-success">Submit</button>
         </div>
     </div>
 </div>