<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="{{ asset('frontend/img/sliders/slider1.jpg') }}" />
        </div>

        <div class="item">
            <img src="{{ asset('frontend/img/sliders/slider2.png') }}" />
        </div>

        <div class="item">
            <img src="{{ asset('frontend/img/sliders/slider3.jpg') }}" />
        </div>

        <div class="item">
            <img src="{{ asset('frontend/img/sliders/slider4.jpg') }}" />
        </div>
    </div>

    <!--  Left and right controls -->
    <a
        class="left carousel-control"
        href="#myCarousel"
        role="button"
        data-slide="prev"
    >
        <span
            class="glyphicon glyphicon-chevron-left"
            aria-hidden="true"
        ></span>
        <span class="sr-only">Trước</span>
    </a>
    <a
        class="right carousel-control"
        href="#myCarousel"
        role="button"
        data-slide="next"
    >
        <span
            class="glyphicon glyphicon-chevron-right"
            aria-hidden="true"
        ></span>
        <span class="sr-only">Tiếp</span>
    </a>
</div>
