
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Thank you</title>
<meta name="csrf-token" content="{{ csrf_token()}}" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/donor.css')}}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>                
        
	<div class="crd-login col-md-4">
		
		<h3 style="margin-left:1em;">PAYMENT RECEIVED</h3>
		<div class="card-login card ">
            <div class="row-fluid">
            <div class="span6">
                <b></b>
                <blockquote>
                    <b>Merchant reference: </b> {{$MerchantReference}}<br/>
                    <b>Pesapal Tracking ID: </b> {{$TrackingId}}<br/>
                    <b>Status: </b> {{$status}}<br />
                </blockquote>
            </div>
        </div> 

		</div>
	</div>
	{{-- <div class="col-md-4">

	</div> --}}
</body>
</html>