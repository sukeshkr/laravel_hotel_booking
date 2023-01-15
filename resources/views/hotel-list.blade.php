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

                    @foreach ($datas as $data)
					<div class="col-md-12">
						<div class="booking-form">
							<form>
								<div class="form-group">
									<span class="form-label">{{$data->name}}</span>
								</div>
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<img height="100" width="150" src="{{asset('hotel/'.$data->file_name)}}" class="form-label">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<span class="form-label">{{Str::of($data->description)->limit(120)}}</span>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<span class="form-label">Room Details</span>
                                            <p>Starting Price:100</p>
										</div>
									</div>
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <a href="{{route('see.room',Crypt::encryptString($data->id))}}" class="btn btn-primary btn-m">See Details</a>
                                    </div>
                                    </div>
								</div>
							</form>
						</div>
					</div>
                    @endforeach

				</div>
			</div>
		</div>
	</div>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
