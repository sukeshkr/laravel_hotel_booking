<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Booking Form HTML Template</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{asset('web-assets/css/bootstrap.min.css')}}" />

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="{{asset('web-assets/css/style.css')}}" />

</head>

<body>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12">
						<div class="booking-form">
							<form method="POST" action="{{route('stripe.payment')}}" data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                                @csrf
								<div class="form-group">
									<span class="form-label">Hotel Name</span>
								</div>
                                @foreach ($datas as $data)
								<div class="row">
                                    <div class="col-sm-3">
										<div class="form-group">
											<span class="form-label"><img height="100" width="150" src="{{asset('room/'.$data->file)}}" class="form-label"></span>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<span class="form-label">{{$data->price}}</span>
                                            <input type="hidden" name="price" value="{{$data->price}}">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<span class="form-label">Room Specification</span>
                                            <ul>
                                                @foreach ($data->specifications as $specification)
                                                    <li>{{$specification->specification}}</li>
                                                @endforeach
                                            </ul>

										</div>
									</div>
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <button  class="btn btn-primary btn-m">Book Now</button>
                                    </div>
                                    </div>
								</div>
                                @endforeach
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

