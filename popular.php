
 

    <section class="section-popular-products padding-tb-100" data-aos="fade-up" data-aos-duration="2000"
        data-aos-delay="400">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-30">
                        <div class="cr-banner">
                            <h2>Popular Products</h2>
                        </div>
                        <div class="cr-banner-sub-title">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et viverra maecenas accumsan lacus vel facilisis. </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="cr-popular-product">
                        <div class="slick-slide">
                         <?php if ($products->num_rows > 0): ?>
                            <?php while ($row = $products->fetch_assoc()): ?>
                            <div class="cr-product-card">
                                <div class="cr-product-image">
                                    <div class="cr-image-inner zoom-image-hover">
                                    <img src="<?= $row["p_image"] ?>" alt="<?= $row["p_name"] ?>">
                                    </div>
                                    <div class="cr-side-view">
                                        <a href="javascript:void(0)" class="wishlist">
                                            <i class="ri-heart-line"></i>
                                        </a>
                                        <a class="model-oraganic-product" data-bs-toggle="modal" href="#quickview"
                                            role="button">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </div>
                                    <a class="cr-shopping-bag" href="javascript:void(0)">
                                        <i class="ri-shopping-bag-line"></i>
                                    </a>
                                </div>
                                <div class="cr-product-details">
                                    <div class="cr-brand">
                                        <a href="shop-left-sidebar.html"><?php echo $row['cat_name']; ?></a>
                                        <div class="cr-star">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-line"></i>
                                            <p>(4.5)</p>
                                        </div>
                                    </div>
                                    <a href="product-left-sidebar.html" class="title"><?php echo $row['p_name']; ?></a>
                                    <p class="cr-price"><span class="new-price">$<?php echo number_format($row['p_price'], 2); ?></span>                                    </p>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No products available.</p>
                            <?php endif; ?>
                        </div>
                </div>
            </div>
        </div>
    </section>
    
