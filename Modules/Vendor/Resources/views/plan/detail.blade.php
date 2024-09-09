 <div class="row">
     <div class="col-md-8">
         <div class="modal-header">
             <h5 class="modal-title" id="singleproductLabel">Gallery edit</h5>
         </div>
         <div class="modal-body">
             <div class="create-gallery">
                 <div class="js-grid my-shuffle">
                     <?php
                        if (isset($vendor_plan->plan_image) && !empty($vendor_plan->plan_image)) {
                            foreach ($vendor_plan->plan_image as $plan_image) {
                        ?>
                     <figure class="js-item column">
                         <div class="aspect aspect--16x9">
                             <div class="img-option">
                                 <button type="button" class="btn btn-remove-plan-image" data-id="<?php echo my_encrypt($plan_image->id); ?>"
                                     data-url="{{ route('deletePlanImage') }}"><i class="las la-times"></i>
                                     Remove</button>
                                 <button type="button" class="btn d-none"><i class="las la-retweet"></i> Change
                                     Image</button>
                             </div>
                             <div class="aspect__inner">
                                 <img src="<?php echo $plan_image->image_url; ?>" alt="Image" />
                             </div>
                         </div>
                     </figure>
                     <?php
                            }
                        }
                        ?>

                     <figure class="js-item column selected">
                            
                     </figure>

                     <figure class="js-item column upload">
                         <div class="upload-img">
                             <div class="file">
                                 Add Files
                                 <input type="file" name="plan_image[]" class="attribute-image-input"
                                     accept="image/*" multiple />
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
                 <button type="button" class="btn-dlt btn-delete-plan" data-id="<?php echo my_encrypt($vendor_plan->id); ?>"
                     data-url="<?php echo route('deletePlan'); ?>"><i class="las la-trash-alt"></i></button>
                 <button type="button" class="btn-close refresh-page" data-bs-dismiss="modal"
                     aria-label="Close"></button>
             </div>
         </div>
         <div class="modal-body gallery-form">
             <div class="select-user">
                 <ul class="list-unstyled">
                     <?php
                        if (isset($vendor_plan->is_enable) && $vendor_plan->is_enable == 1) {
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
                     <li data-value="2" style="display: none;" class=""><span class="inactive"></span> Inactive
                     </li>
                 </ul>
                 <i class="las la-angle-down arrows"></i>
             </div>
             <input type="hidden" name="id" value="<?php echo isset($vendor_plan->id) ? my_encrypt($vendor_plan->id) : ''; ?>">
             <input type="hidden" name="is_enable" value="<?php echo isset($vendor_plan->is_enable) ? $vendor_plan->is_enable : 1; ?>">
             <input type="text" name="plan_name" class="form-control mb-0 mt-2" name="plan_name"
                 value="<?php echo isset($vendor_plan->plan_name) ? $vendor_plan->plan_name : ''; ?>" placeholder="Title">
             <textarea name="plan_description" class="form-control mb-0 mt-2" placeholder="Description" name="placeholder"
                 rows="6"><?php echo isset($vendor_plan->plan_description) ? $vendor_plan->plan_description : ''; ?></textarea>
             <input type="text" name="plan_amount" class="form-control mb-0 mt-2 allow-numeric-with-decimal"
                 value="<?php echo isset($vendor_plan->plan_amount) ? $vendor_plan->plan_amount : ''; ?>" placeholder="Price">
             <div class="form-check d-none">
                 <input class="form-check-input" type="checkbox" value="" id="remember">
                 <label class="form-check-label text-start" for="remember">
                     Charge tax on this plan
                 </label>
             </div>
         </div>
         <div class="modal-footer">
             <button class="btn btn-secondary refresh-page" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
             <button type="submit" class="btn btn-success">Submit</button>
         </div>
     </div>
 </div>
