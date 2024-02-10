<?php

/** @var yii\web\View $this */
use yii\bootstrap5\Html;

$this->title = 'My Yii Application';
?>
<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div class="owl-carousel header-carousel position-relative">
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="img/carousel-1.jpg" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-8">
                            <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Kuicly</h5>
                            <h1 class="display-3 text-white animated slideInDown">The Best Online Learning Platform</h1>
                            <p class="fs-5 text-white mb-4 pb-2">Be Better Than Yesterday.</p>
                            <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="img/carousel-2.jpg" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-8">
                            <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Kuicly</h5>
                            <h1 class="display-3 text-white animated slideInDown">Get Educated Online From Your Home</h1>
                            <p class="fs-5 text-white mb-4 pb-2">The best courses just one step away.</p>
                            <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->


<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                        <h5 class="mb-3">Skilled Instructors</h5>
                        <p>Specialized, experienced instructors dedicated to your learning</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                        <h5 class="mb-3">Online Classes</h5>
                        <p>Diverse, flexible online courses to fit your schedule</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-home text-primary mb-4"></i>
                        <h5 class="mb-3">Home Projects</h5>
                        <p>Practical projects to creatively apply your knowledge at home</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                        <h5 class="mb-3">Book Library</h5>
                        <p>Digital library full of complementary resources to enhance your learning</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->



<!-- Categories Start -->
<div class="container-xxl py-5 category">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Categories</h6>
            <h1 class="mb-5">Courses Categories</h1>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <div class="col">
                <div class="card h-100">
                    <img src="img/creativity.png" class="img-categorias card-img-top " alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::a('Design', ['site/courses'], ['class'=> ' stretched-link']) ?></h5>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="img/digital-marketing.png" class="img-categorias card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::a('Marketing', ['site/courses'], ['class'=> ' stretched-link']) ?></h5>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="img/guitar.png" class="img-categorias card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::a('Music', ['site/courses'], ['class'=> ' stretched-link']) ?></h5>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="img/handshake.png" class="img-categorias card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::a('Business', ['site/courses'], ['class'=> ' stretched-link']) ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Categories end -->








