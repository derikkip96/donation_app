
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Donation</title>
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
		
		<h3 style="margin-left:1em;"> Make Donation</h3>
		<div class="card-login card ">

<form id="rightcol" action="{{route('iframe_pay')}}" method="post">
    @csrf
    <div class="form-group">
        <label>First Name</label>
        <input type="text" name="first_name" class="form-control" value="" size="40"/>           
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name" class="form-control" value="" size="40"/>           
    </div>
    <div class="form-group">
        <label>Email Address</label>
        <input class="form-control"  size="40" type="email" name="email" value="" />          
    </div>
    <div class="form-group">
        <label>Phone Number</label>
        <input type="text"  class="form-control" value="" size="40" name="phone_number" value="" />           
    </div>
    <div class="form-group">
        <label>Amount</label>
        <select name="currency" id="currency">
                    <option value="KES">Kenya shillings</option>  
                    <option value="UGX">Ugandan Shillings</option> 
                    <option value="TZS">Tanzanian shillings</option>  
                    <option value="USD">US Dollars</option>  
                </select>
                <input type="text" class="form-control" name="amount" value="" size="40"/>
    </div>
    <div class="form-group">
       <input type="hidden" name="description" value="Payments for donation" />         
    </div>
    <button type="submit" class="btn btn-login pull-right">
                <strong>Make Payments</strong>
            </button>
   
</form>

		</div>
	</div>
	{{-- <div class="col-md-4">

	</div> --}}
</body>
</html>