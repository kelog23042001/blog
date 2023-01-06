<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($slider as $key=> $slide)
                    <div class="item {{$key==1 ? 'active':''}}">
                        <img width="100%" height="390" src="{{$slide->slider_image }}">
                    </div>
                    @endforeach
                </div>

                <!-- <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a> -->
            </div>

        </div>
    </div>
</div>