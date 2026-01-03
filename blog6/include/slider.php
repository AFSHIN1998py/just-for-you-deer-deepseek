<?php
$sliders=$conn->query("select * from posts_slider");
?>
<section>
                    <div id="carousel" class="carousel slide">
                        <div class="carousel-indicators">
                            <button
                                type="button"
                                data-bs-target="#carousel"
                                data-bs-slide-to="0"
                                class="active"
                            ></button>
                            <button
                                type="button"
                                data-bs-target="#carousel"
                                data-bs-slide-to="1"
                            ></button>
                            <button
                                type="button"
                                data-bs-target="#carousel"
                                data-bs-slide-to="2"
                            ></button>
                        </div>
                        <div class="carousel-inner rounded">
                            <?php foreach($sliders as $slider):?>
                            <?php
                                $post_id=$slider['post_id'];
                                $post=$conn->query("select * from posts where id=$post_id")->fetch();
                            ?>
                            <div class="carousel-item carousel-height overlay 
                            <?php 
                                if($slider['active']==1)
                                    echo" active"; 
                            ?>
                            ">
                                <img
                                    src="assets/images/<?php echo $post['image'] ?>"
                                    class="d-block w-100"
                                    alt="post-image"
                                />
                                <div class="carousel-caption d-none d-md-block">
                                    <h5> <?php echo $post['title'] ?></h5>
                                    <p>
                                    <?php echo substr($post['body'],0,250); ?>...
                                    </p>
                                </div>
                            
                            <?php endforeach ?>
                            </div>
                        </div>
                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#carousel"
                            data-bs-slide="prev"
                        >
                            <span class="carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button
                            class="carousel-control-next"
                            type="button"
                            data-bs-target="#carousel"
                            data-bs-slide="next"
                        >
                            <span class="carousel-control-next-icon"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </section>