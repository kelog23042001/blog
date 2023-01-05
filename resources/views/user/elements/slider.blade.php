<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div id="slider-carousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<?php $i = 0; ?>

					@foreach($slider as $key=> $slide)
				
					<?php $i++; ?>
					<div class="item {{$i==1 ? 'active':''}}">
						<div class="col-sm-12" style="padding: 0;">
						@if($slide->slider_status == '1')
							<img width="100%" height ="700px" src="{{$slide->slider_image }}">
						@endif
						</div>
					</div>
					@endforeach
				</div>
<!-- 
				<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
					<i class="fa fa-angle-left"></i>
				</a>
				<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
					<i class="fa fa-angle-right"></i>
				</a> -->
			</div>

		</div>
	</div>
</div>